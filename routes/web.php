<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\KursusPendaftaranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\MateriKursusController;
use App\Http\Controllers\Admin\KehadiranController;
use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\Admin\KursusController;
use App\Http\Controllers\Admin\SuratKelulusanController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\UserProfileController;

// ─── Login & Logout (domain utama: biaraloresa.my.id)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Dashboard (domain utama) — butuh auth, redirect by role
Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // Super Admin & Admin: dashboard grafik, pendaftaran, peserta, materi
    Route::middleware('role:super_admin,admin')->group(function () {
        Route::get('/admin', [DashboardController::class, 'admin'])->name('admin');
        Route::get('/pendaftaran', [AdminDashboardController::class, 'list'])->name('pendaftaran.index');
        Route::get('/pendaftaran-masuk', [AdminDashboardController::class, 'listMasuk'])->name('pendaftaran.masuk');
        Route::get('/pendaftaran/{id}', [AdminDashboardController::class, 'show'])->name('pendaftaran.show');
        Route::get('/pendaftaran/{id}/setuju', [AdminDashboardController::class, 'showSetuju'])->name('pendaftaran.setuju');
        Route::post('/pendaftaran/{id}/setuju', [AdminDashboardController::class, 'setuju'])->name('pendaftaran.setuju.store');
        Route::post('/pendaftaran/{id}/assign-periode', [AdminDashboardController::class, 'assignPeriode'])->name('pendaftaran.assign-periode');
        Route::get('/pendaftaran-dokumen', [DokumenController::class, 'listDokumen'])->name('pendaftaran.dokumen-list');
        Route::match(['GET', 'POST'], '/pendaftaran/{id}/dokumen-setuju', [DokumenController::class, 'setuju'])->name('pendaftaran.dokumen-setuju');
        Route::match(['GET', 'POST'], '/pendaftaran/{id}/dokumen-tolak', [DokumenController::class, 'tolak'])->name('pendaftaran.dokumen-tolak');
        Route::post('/pendaftaran/{pendaftaran}/dokumen/{field}/setuju-item', [DokumenController::class, 'setujuPerDokumen'])->name('pendaftaran.dokumen-item-setuju');
        Route::post('/pendaftaran/{pendaftaran}/dokumen/{field}/tolak-item', [DokumenController::class, 'tolakPerDokumen'])->name('pendaftaran.dokumen-item-tolak');
        Route::get('/pendaftaran/{id}/dokumen', fn (int $id) => redirect()->route('dashboard.pendaftaran.show', $id))->name('pendaftaran.dokumen.redirect');
        Route::get('/periode', [PeriodeController::class, 'index'])->name('periode.index');
        Route::get('/periode/create', [PeriodeController::class, 'create'])->name('periode.create');
        Route::post('/periode', [PeriodeController::class, 'store'])->name('periode.store');
        Route::get('/periode/{periode}', [PeriodeController::class, 'show'])->name('periode.show');
        Route::get('/periode/{periode}/edit', [PeriodeController::class, 'edit'])->name('periode.edit');
        Route::put('/periode/{periode}', [PeriodeController::class, 'update'])->name('periode.update');
        Route::get('/materi', [DashboardController::class, 'materiPilihPeriode'])->name('materi.periode-list');
        Route::get('/kehadiran', [DashboardController::class, 'kehadiranPilihPeriode'])->name('kehadiran.periode-list');
        Route::get('/periode/{periode}/materi', [MateriKursusController::class, 'index'])->name('materi.index');
        Route::post('/periode/{periode}/materi', [MateriKursusController::class, 'store'])->name('materi.store');
        Route::put('/materi/{materi}', [MateriKursusController::class, 'update'])->name('materi.update');
        Route::get('/periode/{periode}/kehadiran', [KehadiranController::class, 'index'])->name('kehadiran.index');
        Route::put('/pendaftaran/{id}/dokumen', [DokumenController::class, 'updateStatus'])->name('pendaftaran.dokumen');
        Route::put('/pendaftaran/{id}/dokumen-status', [DokumenController::class, 'updateStatusPerDokumen'])->name('pendaftaran.dokumen-status');
        Route::put('/pendaftaran/{pendaftaran}/status-kursus', [KehadiranController::class, 'updateStatusKursus'])->name('pendaftaran.status-kursus');
        Route::post('/materi/{materi}/kirim-materi', [MateriKursusController::class, 'kirimMateri'])->name('materi.kirim');
        Route::post('/materi/{materi}/kirim-zoom', [MateriKursusController::class, 'kirimZoom'])->name('materi.kirim-zoom');
        Route::delete('/materi/{materi}', [MateriKursusController::class, 'destroy'])->name('materi.destroy');
        Route::post('/periode/{periode}/kehadiran', [KehadiranController::class, 'updateBulk'])->name('kehadiran.update');
        Route::post('/periode/{periode}/tutup', [PeriodeController::class, 'tutup'])->name('periode.tutup');
        Route::post('/periode/{periode}/buka', [PeriodeController::class, 'buka'])->name('periode.buka');
        Route::delete('/periode/{periode}', [PeriodeController::class, 'destroy'])->name('periode.destroy');
        Route::post('/periode/{periode}/kirim-jadwal', [KursusController::class, 'kirimJadwal'])->name('kursus.kirim-jadwal');
        Route::post('/periode/{periode}/kirim-sertifikat', [KursusController::class, 'kirimSertifikat'])->name('kursus.kirim-sertifikat');
        Route::post('/periode/{periode}/kirim-jadwal-selanjutnya', [KursusController::class, 'kirimJadwalSelanjutnya'])->name('kursus.kirim-jadwal-selanjutnya');
        Route::put('/pendaftaran/{pendaftaran}/pindah-jadwal', [KursusController::class, 'pindahJadwal'])->name('kursus.pindah-jadwal');

        // Biaya tambahan per periode
        Route::get('/biaya', [\App\Http\Controllers\Admin\BiayaController::class, 'index'])->name('biaya.index');
        Route::get('/biaya/create', [\App\Http\Controllers\Admin\BiayaController::class, 'create'])->name('biaya.create');
        Route::post('/biaya', [\App\Http\Controllers\Admin\BiayaController::class, 'store'])->name('biaya.store');

        // Sertifikat kelulusan
        Route::prefix('sertifikat')->name('sertifikat.')->group(function () {
            Route::get('/', [SuratKelulusanController::class, 'index'])->name('index');
            Route::get('/create', [SuratKelulusanController::class, 'create'])->name('create');
            Route::post('/', [SuratKelulusanController::class, 'store'])->name('store');
            Route::get('/{surat}', [SuratKelulusanController::class, 'show'])->name('show');
            Route::get('/{surat}/edit', [SuratKelulusanController::class, 'edit'])->name('edit');
            Route::put('/{surat}', [SuratKelulusanController::class, 'update'])->name('update');
            Route::delete('/{surat}', [SuratKelulusanController::class, 'destroy'])->name('destroy');
        });
    });

    // Hanya Super Admin: CRUD admin
    Route::middleware('role:super_admin')->prefix('admin-crud')->name('admin-crud.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminCrudController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminCrudController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\AdminCrudController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [\App\Http\Controllers\Admin\AdminCrudController::class, 'edit'])->name('edit');
        Route::put('/{user}', [\App\Http\Controllers\Admin\AdminCrudController::class, 'update'])->name('update');
        Route::delete('/{user}', [\App\Http\Controllers\Admin\AdminCrudController::class, 'destroy'])->name('destroy');
    });

    // User (peserta): hanya halaman dashboard
    Route::middleware('role:user')->group(function () {
        Route::get('/user', [DashboardController::class, 'user'])->name('user');
        Route::post('/user/pesan/{pesan}/selesai', [DashboardController::class, 'markPesanSelesai'])
            ->name('user.pesan.selesai');
    });
});

// ─── Dashboard Peserta (user.*) dengan layout khusus
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/status-pendaftaran', [UserDashboardController::class, 'statusPendaftaran'])->name('status-pendaftaran');
        Route::get('/dokumen', [UserDashboardController::class, 'dokumen'])->name('dokumen');
        Route::get('/jadwal-materi', [UserDashboardController::class, 'jadwalMateri'])->name('jadwal-materi');
        Route::get('/pembayaran', [UserDashboardController::class, 'pembayaran'])->name('pembayaran');
        Route::get('/biaya', [UserDashboardController::class, 'biaya'])->name('biaya');
        Route::get('/sertifikat', [UserDashboardController::class, 'sertifikat'])->name('sertifikat');

        // Profil & password user
        Route::get('/profil', [UserProfileController::class, 'show'])->name('profil');
        Route::post('/profil', [UserProfileController::class, 'update'])->name('profil.update');
        Route::get('/password', [UserProfileController::class, 'showPassword'])->name('password');
        Route::post('/password', [UserProfileController::class, 'updatePassword'])->name('password.update');

        // Aksi pengguna terkait pendaftaran
        Route::post('/pendaftaran/{pendaftaran}/perbaikan-dokumen', [UserDashboardController::class, 'submitPerbaikanDokumen'])
            ->name('pendaftaran.perbaikan-dokumen');
        Route::put('/pendaftaran/{pendaftaran}/dokumen-status', [UserDashboardController::class, 'updateDokumenStatus'])
            ->name('pendaftaran.dokumen-status');
        Route::get('/pendaftaran/{pendaftaran}/upload-dokumen', fn () => redirect()->route('user.dokumen'));
        Route::post('/pendaftaran/{pendaftaran}/upload-dokumen', [UserDashboardController::class, 'uploadDokumen'])
            ->name('pendaftaran.upload-dokumen');
        Route::get('/pendaftaran/{pendaftaran}/sertifikat', [UserDashboardController::class, 'downloadSertifikat'])
            ->name('pendaftaran.sertifikat');

        // Logout khusus layout user
        Route::post('/logout', function () {
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('home');
        })->name('logout');
    });

// ─── Admin — hanya aktif di admin.biaraloresa.my.id (harus di atas agar prioritas lebih tinggi)
Route::domain('admin.biaraloresa.my.id')->group(function () {
    Route::get('/', function () {
        return auth()->check() && auth()->user()->is_admin
            ? redirect()->route('admin.pendaftaran.index')
            : redirect()->route('admin.register');
    });
    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
    Route::post('/register',[AdminAuthController::class, 'register'])->name('admin.register.post');

    // ─── Verifikasi email
    Route::get('/email/verify',             [AdminAuthController::class, 'showVerifyEmail'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AdminAuthController::class, 'verifyEmail'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/resend',            [AdminAuthController::class, 'resendVerificationEmail'])->middleware('throttle:6,1')->name('verification.send');

    Route::post('/logout',  [AdminAuthController::class, 'logout'])->middleware('admin')->name('admin.logout');
    Route::get('/pendaftaran', [AdminDashboardController::class, 'list'])->middleware('admin')->name('admin.pendaftaran.index');
    Route::get('/pendaftaran-masuk', [AdminDashboardController::class, 'listMasuk'])->middleware('admin')->name('admin.pendaftaran.masuk');
    Route::get('/pendaftaran/{id}', [AdminDashboardController::class, 'show'])->middleware('admin')->name('admin.pendaftaran.show');
    Route::get('/pendaftaran-dokumen', [DokumenController::class, 'listDokumen'])->middleware('admin')->name('admin.pendaftaran.dokumen-list');
    Route::match(['GET', 'POST'], '/pendaftaran/{id}/dokumen-setuju', [DokumenController::class, 'setuju'])->middleware('admin')->name('admin.pendaftaran.dokumen-setuju');
    Route::match(['GET', 'POST'], '/pendaftaran/{id}/dokumen-tolak', [DokumenController::class, 'tolak'])->middleware('admin')->name('admin.pendaftaran.dokumen-tolak');
    Route::get('/pendaftaran/{id}/setuju', [AdminDashboardController::class, 'showSetuju'])->middleware('admin')->name('admin.pendaftaran.setuju');
    Route::post('/pendaftaran/{id}/setuju', [AdminDashboardController::class, 'setuju'])->middleware('admin')->name('admin.pendaftaran.setuju.store');
    Route::post('/pendaftaran/{id}/assign-periode', [AdminDashboardController::class, 'assignPeriode'])->middleware('admin')->name('admin.pendaftaran.assign-periode');
    Route::put('/pendaftaran/{id}/dokumen', [DokumenController::class, 'updateStatus'])->middleware('admin')->name('admin.dokumen.update');
    Route::post('/pendaftaran/{pendaftaran}/dokumen/{field}/setuju-item', [DokumenController::class, 'setujuPerDokumen'])->middleware('admin')->name('admin.pendaftaran.dokumen-item-setuju');
    Route::post('/pendaftaran/{pendaftaran}/dokumen/{field}/tolak-item', [DokumenController::class, 'tolakPerDokumen'])->middleware('admin')->name('admin.pendaftaran.dokumen-item-tolak');
});

// ─── Halaman Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

Route::get('/session/keepalive', function () {
    return response()->noContent(204);
})->name('session.keepalive');

Route::get('/kursus-pernikahan', [KursusPendaftaranController::class, 'index'])->name('kursus-pernikahan');
Route::post('/kursus-pernikahan', [KursusPendaftaranController::class, 'store'])->name('kursus-pernikahan.store');
Route::get('/kursus-pernikahan/sukses/{id}', [KursusPendaftaranController::class, 'sukses'])->name('kursus-pernikahan.sukses');

// ─── Pembayaran QRIS via Midtrans
Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
Route::get('/pembayaran/{id}/selesai', [PembayaranController::class, 'finish'])->name('pembayaran.finish');
Route::get('/pembayaran/{id}/status', [PembayaranController::class, 'checkStatus'])->name('pembayaran.status');
Route::post('/pembayaran/{id}/new-qr', [PembayaranController::class, 'newQr'])->name('pembayaran.new-qr');
Route::get('/pembayaran/{id}/qr-image', [PembayaranController::class, 'qrImage'])->name('pembayaran.qr-image');
Route::post('/pembayaran/callback', [PembayaranController::class, 'callback'])->name('pembayaran.callback');
