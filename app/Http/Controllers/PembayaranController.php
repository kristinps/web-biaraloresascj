<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPernikahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Notification;
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

        // Jika sudah lunas, langsung ke halaman sukses
        if ($pendaftaran->status_pembayaran === 'lunas') {
            return redirect()->route('kursus-pernikahan.sukses', $id);
        }

        // Generate QRIS jika belum ada atau sudah expired
        $needsNewQris = ! $pendaftaran->qris_url
            || ! $pendaftaran->qris_expired_at
            || now()->greaterThan($pendaftaran->qris_expired_at);

        if ($needsNewQris) {
            $this->setupMidtrans();

            $orderId = 'KURSUS-' . $pendaftaran->id . '-' . time();

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

            try {
                $response = CoreApi::charge($params);

                $qrisUrl   = $response->actions[0]->url ?? null;

                // Coba ambil dari generate_qr_code action jika ada
                if (isset($response->actions)) {
                    foreach ($response->actions as $action) {
                        if ($action->name === 'generate-qr-code' || $action->name === 'generate_qr_code') {
                            $qrisUrl = $action->url;
                            break;
                        }
                    }
                }

                $pendaftaran->update([
                    'midtrans_order_id'    => $orderId,
                    'midtrans_transaction_id' => $response->transaction_id ?? null,
                    'qris_url'             => $qrisUrl,
                    'qris_expired_at'      => now()->addHours(24),
                    'status_pembayaran'    => 'menunggu',
                ]);
            } catch (\Exception $e) {
                Log::error('Midtrans QRIS error: ' . $e->getMessage());
                return back()->with('error', 'Gagal menghubungi gateway pembayaran. Silakan coba lagi.');
            }
        }

        // Cek status terkini dari Midtrans jika masih menunggu
        $midtransStatus = null;
        if ($pendaftaran->midtrans_order_id && $pendaftaran->status_pembayaran === 'menunggu') {
            try {
                $this->setupMidtrans();
                $statusResponse = Transaction::status($pendaftaran->midtrans_order_id);
                $midtransStatus = $statusResponse->transaction_status ?? null;

                if (in_array($midtransStatus, ['settlement', 'capture'])) {
                    $pendaftaran->update(['status_pembayaran' => 'lunas']);
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
                return response()->json([
                    'status'      => 'lunas',
                    'redirect_url' => route('kursus-pernikahan.sukses', $id),
                ]);
            }

            if (in_array($status, ['cancel', 'deny', 'expire'])) {
                $pendaftaran->update(['status_pembayaran' => 'gagal']);
            }

            return response()->json(['status' => $status]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function qrImage($id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);

        if (! $pendaftaran->qris_url) {
            abort(404);
        }

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)
                ->get($pendaftaran->qris_url);

            if ($response->successful()) {
                return response($response->body(), 200)
                    ->header('Content-Type', 'image/png')
                    ->header('Cache-Control', 'public, max-age=3600');
            }
        } catch (\Exception $e) {
            // fallback: redirect ke URL asli
        }

        return redirect($pendaftaran->qris_url);
    }

    public function finish(Request $request, $id)
    {
        $pendaftaran = PendaftaranPernikahan::findOrFail($id);
        $transactionStatus = $request->query('transaction_status');

        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            $pendaftaran->update(['status_pembayaran' => 'lunas']);
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
