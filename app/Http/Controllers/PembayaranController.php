<?php

namespace App\Http\Controllers;

use App\Mail\PembayaranDanPendaftaranBerhasil;
use App\Models\PendaftaranPernikahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;

class PembayaranController extends Controller
{
    private function setupMidtrans(): void
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = config('services.midtrans.is_sanitized');
        Config::$is3ds        = config('services.midtrans.is_3ds');
    }

    public function show($id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);

        if ($pendaftaran->status_pembayaran === 'lunas') {
            return redirect()->route('kursus-pernikahan.sukses', $id);
        }

        $needsNewQris = ! $pendaftaran->qris_url
            || ! $pendaftaran->qris_expired_at
            || now()->greaterThan($pendaftaran->qris_expired_at);

        if ($needsNewQris) {
            $serverKey = config('services.midtrans.server_key');
            $clientKey = config('services.midtrans.client_key');
            if (empty($serverKey) || empty($clientKey)) {
                return view('pembayaran.index', [
                    'pendaftaran' => $pendaftaran,
                    'qris_error'  => 'Konfigurasi Midtrans belum diisi. Isi MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY di file .env dari dashboard Midtrans (API Keys), lalu jalankan: php artisan config:clear',
                ]);
            }

            try {
                $this->generateQris($pendaftaran);
            } catch (\Exception $e) {
                Log::error('Midtrans QRIS error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                // Fallback: coba Midtrans Snap (endpoint berbeda, mungkin berhasil)
                try {
                    $snapToken = $this->generateSnapToken($pendaftaran);
                    if ($snapToken) {
                        return view('pembayaran.index', [
                            'pendaftaran'       => $pendaftaran,
                            'snap_token'        => $snapToken,
                            'snap_client_key'   => $clientKey,
                        ]);
                    }
                } catch (\Exception $snapEx) {
                    Log::error('Midtrans Snap fallback error: ' . $snapEx->getMessage(), ['trace' => $snapEx->getTraceAsString()]);
                }

                $message = 'Gagal menghubungi gateway pembayaran. Klik tombol di bawah untuk mencoba lagi.';
                if (config('app.debug')) {
                    $message .= ' (Debug: ' . $e->getMessage() . ')';
                }

                return view('pembayaran.index', [
                    'pendaftaran' => $pendaftaran,
                    'qris_error'  => $message,
                ]);
            }
        }

        if ($pendaftaran->midtrans_order_id && $pendaftaran->status_pembayaran === 'menunggu') {
            try {
                $this->setupMidtrans();
                $statusResponse = Transaction::status($pendaftaran->midtrans_order_id);
                $midtransStatus = $statusResponse->transaction_status ?? null;

                if (in_array($midtransStatus, ['settlement', 'capture'])) {
                    $pendaftaran->update(['status_pembayaran' => 'lunas']);
                    $this->sendKonfirmasiPembayaranEmailIfNeeded($pendaftaran);
                    return redirect()->route('kursus-pernikahan.sukses', $id)
                        ->with('success', 'Pembayaran berhasil dikonfirmasi!');
                }
            } catch (\Exception $e) {
                // Abaikan error cek status — tampilkan QR saja
            }
        }

        return view('pembayaran.index', compact('pendaftaran'));
    }

    public function checkStatus(Request $request, $id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);

        if (! $pendaftaran->midtrans_order_id) {
            return response()->json(['status' => 'unknown']);
        }

        try {
            $this->setupMidtrans();
            $response = Transaction::status($pendaftaran->midtrans_order_id);
            $status   = $response->transaction_status ?? 'unknown';

            if (in_array($status, ['settlement', 'capture'])) {
                $pendaftaran->update(['status_pembayaran' => 'lunas']);
                $this->sendKonfirmasiPembayaranEmailIfNeeded($pendaftaran);
                return response()->json([
                    'status'       => 'lunas',
                    'redirect_url' => route('kursus-pernikahan.sukses', $id),
                ]);
            }

            if (in_array($status, ['cancel', 'deny', 'expire'])) {
                $pendaftaran->update(['status_pembayaran' => 'gagal']);
            }

            return response()->json([
                'status'     => $status,
                'expired_at' => $pendaftaran->qris_expired_at?->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function newQr($id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);

        if ($pendaftaran->status_pembayaran === 'lunas') {
            return response()->json([
                'status'       => 'lunas',
                'redirect_url' => route('kursus-pernikahan.sukses', $id),
            ]);
        }

        try {
            $this->generateQris($pendaftaran);
            $pendaftaran->refresh();

            return response()->json([
                'success'       => true,
                'qr_image_url'  => route('pembayaran.qr-image', $id) . '?t=' . time(),
                'expired_at'    => $pendaftaran->qris_expired_at->toIso8601String(),
                'expired_label' => $pendaftaran->qris_expired_at->locale('id')->isoFormat('D MMM YYYY, HH:mm'),
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans new QRIS error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal membuat QR baru.'], 500);
        }
    }

    /** Memastikan QRIS tersedia untuk ditampilkan (untuk halaman daftar pembayaran). */
    public function ensureQrisForDisplay(PendaftaranPernikahan $pendaftaran): void
    {
        if ($pendaftaran->status_pembayaran === 'lunas') {
            return;
        }
        $needsNew = ! $pendaftaran->qris_url
            || ! $pendaftaran->qris_expired_at
            || now()->greaterThan($pendaftaran->qris_expired_at);
        if ($needsNew) {
            $this->generateQris($pendaftaran);
        }
    }

    /** Fallback: buat transaksi via Snap API (endpoint app.sandbox) saat Core API gagal. */
    private function generateSnapToken(PendaftaranPernikahan $pendaftaran): ?string
    {
        $this->setupMidtrans();

        // Midtrans: order_id max 50 karakter
        $orderId = 'KRS' . str_pad((string) $pendaftaran->id, 6, '0', STR_PAD_LEFT) . '-' . time();

        $params = [
            'enabled_payments'    => ['qris'],
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => 350000,
            ],
            'customer_details' => [
                'first_name' => $pendaftaran->nama_pria,
                'last_name'  => '& ' . $pendaftaran->nama_wanita,
                'email'      => $pendaftaran->email,
                'phone'      => $pendaftaran->nomor_hp,
            ],
            'item_details' => [
                [
                    'id'       => 'kursus-nikah',
                    'price'    => 300000,
                    'quantity' => 1,
                    'name'     => 'Biaya Kursus Pernikahan',
                ],
                [
                    'id'       => 'administrasi',
                    'price'    => 50000,
                    'quantity' => 1,
                    'name'     => 'Biaya Administrasi',
                ],
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $pendaftaran->update([
            'midtrans_order_id'       => $orderId,
            'midtrans_snap_token'    => $snapToken,
            'qris_expired_at'         => now()->addHours(24),
            'status_pembayaran'       => 'menunggu',
        ]);

        return $snapToken;
    }

    private function generateQris(PendaftaranPernikahan $pendaftaran): void
    {
        $this->setupMidtrans();

        // Midtrans: order_id max 50 karakter
        $orderId = 'KRS' . str_pad((string) $pendaftaran->id, 6, '0', STR_PAD_LEFT) . '-' . time();

        $params = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => 350000,
            ],
            'qris' => [
                'acquirer' => 'gopay',
            ],
            'customer_details' => [
                'first_name' => $pendaftaran->nama_pria,
                'last_name'  => '& ' . $pendaftaran->nama_wanita,
                'email'      => $pendaftaran->email,
                'phone'      => $pendaftaran->nomor_hp,
            ],
            'item_details' => [
                [
                    'id'       => 'kursus-nikah',
                    'price'    => 300000,
                    'quantity' => 1,
                    'name'     => 'Biaya Kursus Pernikahan',
                ],
                [
                    'id'       => 'administrasi',
                    'price'    => 50000,
                    'quantity' => 1,
                    'name'     => 'Biaya Administrasi',
                ],
            ],
        ];

        $response = CoreApi::charge($params);

        $qrisUrl = null;
        if (isset($response->actions)) {
            foreach ($response->actions as $action) {
                $name = $action->name ?? '';
                if (in_array($name, ['generate-qr-code', 'generate_qr_code', 'generate-qr-code-v2'])) {
                    $qrisUrl = $action->url ?? null;
                    if ($qrisUrl) break;
                }
            }
            if (! $qrisUrl && isset($response->actions[0]->url)) {
                $qrisUrl = $response->actions[0]->url;
            }
        }

        $pendaftaran->update([
            'midtrans_order_id'       => $orderId,
            'midtrans_transaction_id' => $response->transaction_id ?? null,
            'qris_url'                => $qrisUrl,
            'qris_expired_at'         => now()->addHours(24),
            'status_pembayaran'       => 'menunggu',
        ]);
    }

    private function sendKonfirmasiPembayaranEmailIfNeeded(PendaftaranPernikahan $pendaftaran): void
    {
        // Hanya kirim sekali setelah status lunas
        if ($pendaftaran->email_konfirmasi_pembayaran_sent_at) {
            return;
        }

        $password = $pendaftaran->plain_password_for_email;

        try {
            Mail::to($pendaftaran->email)->send(new PembayaranDanPendaftaranBerhasil($pendaftaran, $password));
            $pendaftaran->update([
                'email_konfirmasi_pembayaran_sent_at' => now(),
                'plain_password_for_email'           => null,
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal kirim email pembayaran & pendaftaran berhasil ID ' . $pendaftaran->id . ': ' . $e->getMessage());
        }
    }

    public function qrImage($id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);

        if (! $pendaftaran->qris_url) {
            abort(404);
        }

        $serverKey = config('services.midtrans.server_key');
        $auth      = base64_encode($serverKey . ':');

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(15)
                ->withHeaders(['Authorization' => 'Basic ' . $auth])
                ->get($pendaftaran->qris_url);

            if ($response->successful()) {
                $contentType = $response->header('Content-Type') ?: 'image/png';
                return response($response->body(), 200)
                    ->header('Content-Type', $contentType)
                    ->header('Cache-Control', 'public, max-age=3600');
            }
        } catch (\Exception $e) {
            Log::warning('QR image fetch failed: ' . $e->getMessage());
        }

        return redirect($pendaftaran->qris_url);
    }

    public function finish(Request $request, $id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);
        $transactionStatus = $request->query('transaction_status');

        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            if ($pendaftaran->status_pembayaran !== 'lunas') {
                $pendaftaran->update(['status_pembayaran' => 'lunas']);
            }
            $this->sendKonfirmasiPembayaranEmailIfNeeded($pendaftaran);
        }

        return redirect()->route('kursus-pernikahan.sukses', $id);
    }

    public function callback(Request $request)
    {
        $this->setupMidtrans();

        try {
            $notification = new Notification();

            $orderId           = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status;

            $pendaftaran = PendaftaranPernikahan::where('midtrans_order_id', $orderId)->first();

            if (! $pendaftaran) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $update = ['midtrans_transaction_id' => $notification->transaction_id ?? null];

            if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
                $update['status_pembayaran'] = 'lunas';
                if ($pendaftaran->status_pembayaran !== 'lunas') {
                    $pendaftaran->update($update);
                    $this->sendKonfirmasiPembayaranEmailIfNeeded($pendaftaran);
                    return response()->json(['message' => 'OK'], 200);
                }
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $update['status_pembayaran'] = 'gagal';
            } elseif ($transactionStatus === 'pending') {
                $update['status_pembayaran'] = 'menunggu';
            }

            $pendaftaran->update($update);

            return response()->json(['message' => 'OK'], 200);
        } catch (\Exception $e) {
            Log::error('Midtrans callback error: ' . $e->getMessage());
            return response()->json(['message' => 'Error'], 500);
        }
    }
}
