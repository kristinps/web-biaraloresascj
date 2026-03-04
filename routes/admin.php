<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

// Login (publik — tidak perlu middleware)
Route::get('/login',  [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');

// Protected — wajib login sebagai admin
Route::middleware('admin')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // Dashboard
    Route::get('/',          fn() => redirect()->to('https://admin.biaraloresa.my.id/dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Kursus Pernikahan
    Route::get('/pendaftaran',      [DashboardController::class, 'list'])->name('admin.pendaftaran.index');
    Route::get('/pendaftaran/{id}', [DashboardController::class, 'show'])->name('admin.pendaftaran.show');

    // Manajemen Pengguna
    Route::get('/users',              [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create',       [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users',             [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{id}/edit',    [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{id}',         [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}',      [UserController::class, 'destroy'])->name('admin.users.destroy');
});
