<?php

/**
 * Catatan: Route login/dashboard peserta (tanpa domain) untuk biaraloresa.my.id.
 * Jangan jalankan route:cache jika menyebabkan 404 di /login. Setelah ubah route, jalankan: php artisan route:clear
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\KursusPendaftaranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\PeriodeController as AdminPeriodeController;
use App\Http\Controllers\Admin\DokumenController as AdminDokumenController;
use App\Http\Controllers\Admin\MateriKursusController as AdminMateriKursusController;
use App\Http\Controllers\Admin\KehadiranController as AdminKehadiranController;
use App\Http\Controllers\Admin\KursusController as AdminKursusController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserProfileController;

// ─── Login & Dashboard Peserta (biaraloresa.my.id/login, biaraloresa.my.id/dashboard)
Route::get('/login', [UserAuthController::class, 'showLogin'])->name('user.login');
Route::post('/login', [UserAuthController::class, 'login'])->name('user.login.post');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout')->middleware('auth');
Route::get('/lupa-password', [UserAuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/lupa-password', [UserAuthController::class, 'sendResetLink'])->middleware('throttle:5,1')->name('password.email');
Route::get('/password/reset/{token}', [UserAuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [UserAuthController::class, 'resetPassword'])->middleware('throttle:5,1')->name('password.update');

Route::middleware('auth')->prefix('dashboard')->name('user.')->group(function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/status-pendaftaran', [UserDashboardController::class, 'statusPendaftaran'])->name('status-pendaftaran');
    Route::get('/dokumen', [UserDashboardController::class, 'dokumen'])->name('dokumen');
    Route::get('/jadwal-materi', [UserDashboardController::class, 'jadwalMateri'])->name('jadwal-materi');
    Route::get('/sertifikat', [UserDashboardController::class, 'sertifikat'])->name('sertifikat');
    Route::get('/sertifikat/{pendaftaran}/download', [UserDashboardController::class, 'downloadSertifikat'])->name('sertifikat.download');
    Route::get('/pembayaran', [UserDashboardController::class, 'pembayaran'])->name('pembayaran');
    Route::get('/biaya', [UserDashboardController::class, 'biaya'])->name('biaya');
    Route::get('/profil', [UserProfileController::class, 'show'])->name('profil');
    Route::post('/profil', [UserProfileController::class, 'update'])->name('profil.update');
    Route::get('/ubah-password', [UserProfileController::class, 'showPassword'])->name('password');
    Route::post('/ubah-password', [UserProfileController::class, 'updatePassword'])->name('password.update');
});

// ─── Admin
Route::domain('admin.biaraloresa.my.id')->group(function () {
    Route::get('/', function () {
        return auth()->check() && auth()->user()->is_admin
            ? redirect()->route('admin.dashboard')
            : redirect()->route('login');
    });
    Route::get('/login',    [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AdminAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
    Route::post('/register',[AdminAuthController::class, 'register'])->name('admin.register.post');

    Route::get('/email/verify',             [AdminAuthController::class, 'showVerifyEmail'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AdminAuthController::class, 'verifyEmail'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/resend',            [AdminAuthController::class, 'resendVerificationEmail'])->middleware('throttle:6,1')->name('verification.send');

    Route::post('/logout',   [AdminAuthController::class, 'logout'])->middleware('admin')->name('admin.logout');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->middleware('admin')->name('admin.dashboard');
    Route::get('/pendaftaran',      [AdminDashboardController::class, 'list'])->middleware('admin')->name('admin.pendaftaran.index');
    Route::get('/pendaftaran/{id}', [AdminDashboardController::class, 'show'])->middleware('admin')->name('admin.pendaftaran.show');

    Route::middleware('admin')->group(function () {
        // Periode
        Route::get('/periode',                   [AdminPeriodeController::class, 'index'])->name('admin.periode.index');
        Route::get('/periode/create',            [AdminPeriodeController::class, 'create'])->name('admin.periode.create');
        Route::post('/periode',                  [AdminPeriodeController::class, 'store'])->name('admin.periode.store');
        Route::get('/periode/{periode}',         [AdminPeriodeController::class, 'show'])->name('admin.periode.show');
        Route::get('/periode/{periode}/edit',    [AdminPeriodeController::class, 'edit'])->name('admin.periode.edit');
        Route::put('/periode/{periode}',         [AdminPeriodeController::class, 'update'])->name('admin.periode.update');
        Route::patch('/periode/{periode}/tutup', [AdminPeriodeController::class, 'tutup'])->name('admin.periode.tutup');
        Route::patch('/periode/{periode}/buka',  [AdminPeriodeController::class, 'buka'])->name('admin.periode.buka');
        Route::delete('/periode/{periode}',      [AdminPeriodeController::class, 'destroy'])->name('admin.periode.destroy');
        Route::post('/periode/assign',           [AdminPeriodeController::class, 'assignPendaftaran'])->name('admin.periode.assign');

        // Dokumen
        Route::post('/pendaftaran/{id}/dokumen', [AdminDokumenController::class, 'updateStatus'])->name('admin.dokumen.update');

        // Materi Kursus
        Route::get('/periode/{periode}/materi',      [AdminMateriKursusController::class, 'index'])->name('admin.materi.index');
        Route::post('/periode/{periode}/materi',     [AdminMateriKursusController::class, 'store'])->name('admin.materi.store');
        Route::put('/materi/{materi}',               [AdminMateriKursusController::class, 'update'])->name('admin.materi.update');
        Route::delete('/materi/{materi}',            [AdminMateriKursusController::class, 'destroy'])->name('admin.materi.destroy');
        Route::post('/materi/{materi}/kirim-materi', [AdminMateriKursusController::class, 'kirimMateri'])->name('admin.materi.kirim-materi');
        Route::post('/materi/{materi}/kirim-zoom',   [AdminMateriKursusController::class, 'kirimZoom'])->name('admin.materi.kirim-zoom');

        // Kehadiran
        Route::get('/periode/{periode}/kehadiran',               [AdminKehadiranController::class, 'index'])->name('admin.kehadiran.index');
        Route::post('/periode/{periode}/kehadiran',              [AdminKehadiranController::class, 'updateBulk'])->name('admin.kehadiran.update-bulk');
        Route::patch('/pendaftaran/{pendaftaran}/status-kursus', [AdminKehadiranController::class, 'updateStatusKursus'])->name('admin.kehadiran.status-kursus');

        // Batch Kursus
        Route::post('/periode/{periode}/kirim-jadwal',              [AdminKursusController::class, 'kirimJadwal'])->name('admin.kursus.kirim-jadwal');
        Route::post('/periode/{periode}/kirim-sertifikat',          [AdminKursusController::class, 'kirimSertifikat'])->name('admin.kursus.kirim-sertifikat');
        Route::post('/periode/{periode}/kirim-jadwal-selanjutnya',  [AdminKursusController::class, 'kirimJadwalSelanjutnya'])->name('admin.kursus.kirim-jadwal-selanjutnya');
        Route::post('/pendaftaran/{pendaftaran}/pindah-jadwal',     [AdminKursusController::class, 'pindahJadwal'])->name('admin.kursus.pindah-jadwal');

        // Profil
        Route::get('/profil',          [AdminProfileController::class, 'show'])->name('admin.profile');
        Route::post('/profil/info',    [AdminProfileController::class, 'updateInfo'])->name('admin.profile.info');
        Route::post('/profil/photo',   [AdminProfileController::class, 'updatePhoto'])->name('admin.profile.photo');
        Route::delete('/profil/photo', [AdminProfileController::class, 'deletePhoto'])->name('admin.profile.photo.delete');
        Route::post('/profil/password',[AdminProfileController::class, 'updatePassword'])->name('admin.profile.password');
    });
});

// ─── Halaman Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

// Pendaftaran kursus pernikahan: tanpa login (publik)
Route::get('/kursus-pernikahan', [KursusPendaftaranController::class, 'index'])->name('kursus-pernikahan');
Route::post('/kursus-pernikahan', [KursusPendaftaranController::class, 'store'])->name('kursus-pernikahan.store');
Route::get('/kursus-pernikahan/sukses/{id}', [KursusPendaftaranController::class, 'sukses'])->name('kursus-pernikahan.sukses');

Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
Route::get('/pembayaran/{id}/selesai', [PembayaranController::class, 'finish'])->name('pembayaran.finish');
Route::get('/pembayaran/{id}/status', [PembayaranController::class, 'checkStatus'])->name('pembayaran.status');
Route::get('/pembayaran/{id}/qr-image', [PembayaranController::class, 'qrImage'])->name('pembayaran.qr-image');
Route::post('/pembayaran/{id}/new-qr', [PembayaranController::class, 'newQr'])->name('pembayaran.new-qr');
Route::post('/pembayaran/callback', [PembayaranController::class, 'callback'])->name('pembayaran.callback');
