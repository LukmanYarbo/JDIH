<?php

use App\Http\Controllers\Admin\AlatKelengkapanController;
use App\Http\Controllers\Admin\AnggotaDprdController;
use App\Http\Controllers\Admin\BeritaHukumController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DokumenHukumController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\JenisDokumenController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

// Public Portal Routes
Route::get('/', [PortalController::class, 'home'])->name('portal.home');
Route::get('/cari', [PortalController::class, 'search'])->name('portal.search');
Route::get('/dokumen/{document}', [PortalController::class, 'showDocument'])->name('portal.document.show');
Route::get('/dokumen/{document}/download', [PortalController::class, 'downloadDocument'])->name('portal.document.download');
Route::get('/berita', [PortalController::class, 'newsList'])->name('portal.news.list');
Route::get('/berita/{slug}', [PortalController::class, 'newsDetail'])->name('portal.news.show');
Route::get('/profil', [PortalController::class, 'profile'])->name('portal.profile');
Route::get('/galeri', [PortalController::class, 'gallery'])->name('portal.gallery');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Panel (Protected by Auth)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin-Only Routes (User Management)
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Admin & Operator Routes (Document & News Management)
    Route::middleware(['role:Admin|Operator'])->group(function () {
        Route::resource('categories', JenisDokumenController::class);
        Route::resource('documents', DokumenHukumController::class);
        Route::resource('news', BeritaHukumController::class);
        Route::resource('gallery', GaleriController::class);
        Route::resource('anggota', AnggotaDprdController::class)->parameters(['anggota' => 'anggota_dprd']);
        Route::resource('alat-kelengkapan', AlatKelengkapanController::class)
            ->parameters(['alat-kelengkapan' => 'alat_kelengkapan'])
            ->except(['show']);
        Route::get('alat-kelengkapan/{alat_kelengkapan}', [AlatKelengkapanController::class, 'show'])->name('alat-kelengkapan.show');
        Route::post('alat-kelengkapan/{alat_kelengkapan}/anggota', [AlatKelengkapanController::class, 'storeAnggota'])->name('alat-kelengkapan.anggota.store');
        Route::put('alat-kelengkapan/{alat_kelengkapan}/anggota/{keanggotaan}', [AlatKelengkapanController::class, 'updateAnggota'])->name('alat-kelengkapan.anggota.update');
        Route::delete('alat-kelengkapan/{alat_kelengkapan}/anggota/{keanggotaan}', [AlatKelengkapanController::class, 'destroyAnggota'])->name('alat-kelengkapan.anggota.destroy');
        Route::get('profile', [ProfilController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfilController::class, 'update'])->name('profile.update');
    });
});
