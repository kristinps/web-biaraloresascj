<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Biaya;
use App\Models\BiayaTagihan;
use App\Models\PendaftaranPernikahan;
use App\Models\PeriodePernikahan;
use App\Models\User;
use App\Notifications\BiayaTambahanNotification;
use App\Notifications\BiayaTagihanLunasNotification;
use Illuminate\Http\Request;

class BiayaController extends Controller
{
    public function index()
    {
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        $biayaTambahan = Biaya::with('periode')
            ->where('jenis', 'tambahan')
            ->orderByDesc('created_at')
            ->get();

        $tagihan = BiayaTagihan::with(['biaya.periode', 'pendaftaran'])
            ->latest()
            ->paginate(20);

        return view('admin.biaya.index', compact('biayaTambahan', 'tagihan', 'routePrefix'));
    }

    public function create()
    {
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        $periodes = PeriodePernikahan::aktif()
            ->orderByDesc('tanggal_mulai')
            ->get();

        return view('admin.biaya.create', compact('periodes', 'routePrefix'));
    }

    public function store(Request $request)
    {
        $routePrefix = request()->routeIs('dashboard.*') ? 'dashboard' : 'admin';

        $validated = $request->validate([
            'nama'        => ['required', 'string', 'max:100'],
            'nominal'     => ['required', 'integer', 'min:1000'],
            'periode_id'  => ['required', 'exists:periode_pernikahan,id'],
            'keterangan'  => ['nullable', 'string', 'max:255'],
        ], [
            'nama.required'       => 'Nama biaya wajib diisi.',
            'nominal.required'    => 'Jumlah biaya wajib diisi.',
            'nominal.integer'     => 'Jumlah biaya harus berupa angka.',
            'nominal.min'         => 'Jumlah biaya minimal Rp 1.000.',
            'periode_id.required' => 'Pilih periode terlebih dahulu.',
            'periode_id.exists'   => 'Periode tidak ditemukan.',
        ]);

        $biaya = Biaya::create([
            'jenis'       => 'tambahan',
            'nama'        => $validated['nama'],
            'nominal'     => $validated['nominal'],
            'keterangan'  => $validated['keterangan'] ?? null,
            'periode_id'  => $validated['periode_id'],
            'aktif'       => true,
        ]);

        // Buat tagihan untuk semua pendaftar pada periode tersebut
        $pendaftarans = PendaftaranPernikahan::where('periode_id', $validated['periode_id'])->get();

        foreach ($pendaftarans as $pendaftaran) {
            $tagihan = BiayaTagihan::create([
                'biaya_id'       => $biaya->id,
                'pendaftaran_id' => $pendaftaran->id,
                'status'         => 'belum_bayar',
            ]);

            // Kirim email ke peserta
            $pendaftaran->notify(new BiayaTambahanNotification($biaya, $pendaftaran));
        }

        return redirect()
            ->route($routePrefix . '.biaya.index')
            ->with('success', 'Biaya tambahan berhasil dibuat dan notifikasi telah dikirim ke peserta yang terdaftar pada periode tersebut.');
    }

    /**
     * Dipanggil dari alur pembayaran tambahan ketika tagihan dinyatakan lunas;
     * mengirim email ringkas ke semua admin.
     */
    public static function notifyAdminsBiayaLunas(BiayaTagihan $tagihan): void
    {
        $admins = User::whereIn('role', [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN])->get();
        if ($admins->isEmpty()) {
            return;
        }

        $notification = new BiayaTagihanLunasNotification($tagihan->loadMissing('biaya.periode', 'pendaftaran'));

        foreach ($admins as $admin) {
            $admin->notify($notification);
        }
    }
}

