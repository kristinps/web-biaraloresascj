<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\BiayaController as AdminBiayaController;
use App\Models\BiayaTagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Transaction;

class BiayaPembayaranController extends Controller
{
    private function setupMidtrans(): void
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = config('services.midtrans.is_sanitized');
        Config::$is3ds        = config('services.midtrans.is_3ds');
    }

    private function authorizeTagihan(BiayaTagihan $tagihan): void
    {
        $user = auth()->user();
        $pendaftaran = $tagihan->pendaftaran;

        if (! $user || ! $pendaftaran || $pendaftaran->email !== $user->email) {
            abort(404);
        }
    }

    public function show($id)
    {
        $tagihan = BiayaTagihan::with(['biaya.periode', 'pendaftaran'])->findOrFail($id);
        $this->authorizeTagihan($tagihan);

        if ($tagihan->status === 'lunas') {
            return redirect()
                ->route('dashboard.user')
                ->with('success', 'Biaya tambahan ini sudah lunas.');
        }

        $needsNewQris = ! $tagihan->qris_url
            || ! $tagihan->qris_expired_at
            || now()->greaterThan($tagihan->qris_expired_at);

        if ($needsNewQris) {
            try {
                $this->generateQris($tagihan);
                $tagihan->refresh();
            } catch (\Exception $e) {
                Log::error('Midtrans QRIS biaya tambahan error: ' . $e->getMessage());
                return back()->with('error', 'Gagal menghubungi gateway pembayaran. Silakan coba lagi.');
            }
        }

        if ($tagihan->midtrans_order_id && $tagihan->status === 'menunggu') {
            try {
                $this->setupMidtrans();
                $statusResponse = Transaction::status($tagihan->midtrans_order_id);
                $midtransStatus = $statusResponse->transaction_status ?? null;

                if (in_array($midtransStatus, ['settlement', 'capture'], true)) {
                    $tagihan->update(['status' => 'lunas']);
                    AdminBiayaController::notifyAdminsBiayaLunas($tagihan);

                    return redirect()->route('dashboard.user')
                        ->with('success', 'Pembayaran biaya tambahan berhasil dikonfirmasi.');
                }
            } catch (\Exception $e) {
                // Abaikan error cek status — tetap tampilkan QR
            }
        }

        return view('biaya.pembayaran', compact('tagihan'));
    }

    public function checkStatus(Request $request, $id)
    {
        $tagihan = BiayaTagihan::with('biaya')->findOrFail($id);
        $this->authorizeTagihan($tagihan);

        if (! $tagihan->midtrans_order_id) {
            return response()->json(['status' => 'unknown']);
        }

        try {
            $this->setupMidtrans();
            $response = Transaction::status($tagihan->midtrans_order_id);
            $status   = $response->transaction_status ?? 'unknown';

            if (in_array($status, ['settlement', 'capture'], true)) {
                if ($tagihan->status !== 'lunas') {
                    $tagihan->update(['status' => 'lunas']);
                    AdminBiayaController::notifyAdminsBiayaLunas($tagihan);
                }

                return response()->json([
                    'status'       => 'lunas',
                    'redirect_url' => route('dashboard.user'),
                ]);
            }

            if (in_array($status, ['cancel', 'deny', 'expire'], true)) {
                $tagihan->update(['status' => 'gagal']);
            } elseif ($status === 'pending') {
                $tagihan->update(['status' => 'menunggu']);
            }

            return response()->json([
                'status'     => $status,
                'expired_at' => $tagihan->qris_expired_at?->toIso8601String(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function newQr($id)
    {
        $tagihan = BiayaTagihan::with('biaya')->findOrFail($id);
        $this->authorizeTagihan($tagihan);

        if ($tagihan->status === 'lunas') {
            return response()->json([
                'status'       => 'lunas',
                'redirect_url' => route('dashboard.user'),
            ]);
        }

        try {
            $this->generateQris($tagihan);
            $tagihan->refresh();

            return response()->json([
                'success'       => true,
                'qr_image_url'  => url('/'), // Halaman biaya dihapus
                'expired_at'    => $tagihan->qris_expired_at?->toIso8601String(),
                'expired_label' => $tagihan->qris_expired_at?->locale('id')->isoFormat('D MMM YYYY, HH:mm'),
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans new QRIS biaya tambahan error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal membuat QR baru.'], 500);
        }
    }

    private function generateQris(BiayaTagihan $tagihan): void
    {
        $this->setupMidtrans();

        $biaya = $tagihan->biaya()->with('periode')->firstOrFail();
        $pendaftaran = $tagihan->pendaftaran()->firstOrFail();

        $orderId = 'BIAYA-' . $tagihan->id . '-' . time();

        $params = [
            'payment_type'         => 'qris',
            'transaction_details'  => [
                'order_id'     => $orderId,
                'gross_amount' => $biaya->nominal,
            ],
            'qris'                 => [
                'acquirer' => 'gopay',
            ],
            'customer_details'     => [
                'first_name' => $pendaftaran->nama_pria,
                'last_name'  => '& ' . $pendaftaran->nama_wanita,
                'email'      => $pendaftaran->email,
                'phone'      => $pendaftaran->nomor_hp,
            ],
            'item_details'         => [
                [
                    'id'       => 'biaya-tambahan-' . $biaya->id,
                    'price'    => $biaya->nominal,
                    'quantity' => 1,
                    'name'     => 'Biaya Tambahan: ' . ($biaya->nama ?: 'Biaya Tambahan'),
                ],
            ],
        ];

        $response = CoreApi::charge($params);

        $qrisUrl = $response->actions[0]->url ?? null;
        if (isset($response->actions)) {
            foreach ($response->actions as $action) {
                if ($action->name === 'generate-qr-code' || $action->name === 'generate_qr_code') {
                    $qrisUrl = $action->url;
                    break;
                }
            }
        }

        $tagihan->update([
            'midtrans_order_id'       => $orderId,
            'midtrans_transaction_id' => $response->transaction_id ?? null,
            'qris_url'                => $qrisUrl,
            'qris_expired_at'         => now()->addHours(24),
            'status'                  => 'menunggu',
        ]);
    }

    public function qrImage($id)
    {
        $tagihan = BiayaTagihan::findOrFail($id);
        $this->authorizeTagihan($tagihan);

        if (! $tagihan->qris_url) {
            abort(404);
        }

        try {
            $response = Http::timeout(10)->get($tagihan->qris_url);

            if ($response->successful()) {
                return response($response->body(), 200)
                    ->header('Content-Type', 'image/png')
                    ->header('Cache-Control', 'public, max-age=3600');
            }
        } catch (\Exception $e) {
            // Fallback di bawah
        }

        return redirect($tagihan->qris_url);
    }
}

