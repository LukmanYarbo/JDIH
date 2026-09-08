<?php

use App\Http\Controllers\Admin\AgendaController as AdminAgendaController;
use App\Http\Controllers\Admin\AlatKelengkapanController;
use App\Http\Controllers\Admin\AnggotaDprdController;
use App\Http\Controllers\Admin\BeritaHukumController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DokumenHukumController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\JenisDokumenController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\RanperdaController as AdminRanperdaController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\TimPengelolaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

// ==========================================
// PUBLIC PORTAL ROUTES (JDIH Structure)
// ==========================================

// 1. Beranda
Route::get('/', [PortalController::class, 'home'])->name('portal.home');

// 2. Pencarian & Dokumen Hukum (Multi-kriteria)
Route::get('/cari', [PortalController::class, 'search'])->name('portal.search');
Route::get('/produk-hukum', [PortalController::class, 'search'])->name('portal.documents');
Route::get('/api/jenis-dokumen-by-tipe', [PortalController::class, 'getJenisDokumenByTipe'])->name('portal.api.jenis-by-tipe');
Route::get('/dokumen/{document}', [PortalController::class, 'showDocument'])->name('portal.document.show');
Route::get('/dokumen/{document}/preview', [PortalController::class, 'previewDocument'])->name('portal.document.preview');
Route::get('/dokumen/{document}/abstrak', [PortalController::class, 'previewAbstract'])->name('portal.document.abstrak');
Route::get('/dokumen/{document}/download', [PortalController::class, 'downloadDocument'])->name('portal.document.download');

// 3. Tentang Kami (Dasar Hukum, SK Tim, Struktur Organisasi, SOP, Visi Misi)
Route::get('/tentang-kami/{slug?}', [PortalController::class, 'about'])->name('portal.about');
Route::get('/profil', [PortalController::class, 'about'])->name('portal.profile');

// 4. Informasi (Berita, Galeri, Video, Agenda)
Route::get('/berita', [PortalController::class, 'newsList'])->name('portal.news.list');
Route::get('/berita/{slug}', [PortalController::class, 'newsDetail'])->name('portal.news.show');
Route::get('/galeri', [PortalController::class, 'gallery'])->name('portal.gallery');
Route::get('/video', [PortalController::class, 'video'])->name('portal.video');
Route::get('/agenda', [PortalController::class, 'agenda'])->name('portal.agenda');

// 5. Alur Ranperda / Propemperda
Route::get('/alur-ranperda', [PortalController::class, 'ranperda'])->name('portal.ranperda');

// 6. Buletin JDIH
Route::get('/buletin', [PortalController::class, 'buletin'])->name('portal.buletin');
Route::get('/buletin/{buletin}/download', [PortalController::class, 'downloadBuletin'])->name('portal.buletin.download');

// 7. Statistik Interaktif
Route::get('/statistik', [PortalController::class, 'statistics'])->name('portal.statistics');

// 8. Hubungi Kami & IKM Polling
Route::get('/hubungi-kami', [PortalController::class, 'contact'])->name('portal.contact');
Route::post('/ikm/vote', [PortalController::class, 'voteIkm'])->name('portal.ikm.vote');
Route::get('/ikm/result', [PortalController::class, 'getIkmResult'])->name('portal.ikm.result');

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// ADMIN PANEL ROUTES
// ==========================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin-Only Routes (User, Role & Permission Management)
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class)->only(['index', 'store', 'destroy']);
    });

    // Admin & Operator Routes
    Route::middleware(['role:Admin|Operator'])->group(function () {
        Route::resource('categories', JenisDokumenController::class);
        Route::resource('documents', DokumenHukumController::class);
        Route::resource('ranperda', AdminRanperdaController::class);
        Route::resource('agendas', AdminAgendaController::class);
        Route::post('agendas/{agenda}/toggle-ticker', [AdminAgendaController::class, 'toggleTicker'])->name('agendas.toggle-ticker');
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
        Route::post('profile/remove-image/{type}', [ProfilController::class, 'removeImage'])->name('profile.remove-image');
        Route::resource('tim-pengelola', TimPengelolaController::class);
        Route::post('tim-pengelola/{tim_pengelola}/toggle-active', [TimPengelolaController::class, 'toggleActive'])->name('tim-pengelola.toggle-active');
    });
});
