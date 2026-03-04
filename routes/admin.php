<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

// Login (tidak perlu middleware admin)
Route::get('/login',  [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');

// Protected routes
Route::middleware('admin')->group(function () {
    Route::post('/logout',            [AuthController::class,    'logout'])->name('admin.logout');
    Route::get('/dashboard',          [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/pendaftaran',        [DashboardController::class, 'list'])->name('admin.pendaftaran.index');
    Route::get('/pendaftaran/{id}',   [DashboardController::class, 'show'])->name('admin.pendaftaran.show');
});
