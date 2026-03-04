<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\KursusPendaftaranController;
use App\Http\Controllers\PembayaranController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

Route::get('/kursus-pernikahan', [KursusPendaftaranController::class, 'index'])->name('kursus-pernikahan');
Route::post('/kursus-pernikahan', [KursusPendaftaranController::class, 'store'])->name('kursus-pernikahan.store');
Route::get('/kursus-pernikahan/sukses/{id}', [KursusPendaftaranController::class, 'sukses'])->name('kursus-pernikahan.sukses');

// Pembayaran QRIS via Midtrans
Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
Route::get('/pembayaran/{id}/selesai', [PembayaranController::class, 'finish'])->name('pembayaran.finish');
Route::get('/pembayaran/{id}/status', [PembayaranController::class, 'checkStatus'])->name('pembayaran.status');
Route::post('/pembayaran/callback', [PembayaranController::class, 'callback'])->name('pembayaran.callback');
