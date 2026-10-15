<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/berita', [FrontendController::class, 'berita'])->name('frontend.berita');
Route::get('/berita/{id}', [FrontendController::class, 'beritaDetail'])->name('frontend.berita.show');
Route::get('/prestasi', [FrontendController::class, 'prestasi'])->name('frontend.prestasi');
Route::get('/guru', [FrontendController::class, 'guru'])->name('frontend.guru');
Route::get('/halaman/{id}', [FrontendController::class, 'halaman'])->name('frontend.halaman');
Route::get('/pengumuman', [FrontendController::class, 'pengumuman'])->name('frontend.pengumuman');
Route::get('/ekstrakurikuler', [FrontendController::class, 'ekstrakurikuler'])->name('frontend.ekstrakurikuler');
Route::get('/ekstrakurikuler/{id}', [FrontendController::class, 'ekstrakurikulerDetail'])->name('frontend.ekstrakurikuler.show');
Route::get('/sarana-prasarana', [FrontendController::class, 'sarpras'])->name('frontend.sarpras');
Route::get('/alumni', [FrontendController::class, 'alumni'])->name('frontend.alumni');
Route::post('/alumni', [FrontendController::class, 'storeAlumni'])->name('frontend.alumni.store');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:superadmin,admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    
    // Modul Data (dengan hak akses / permission)
    Route::resource('berita', \App\Http\Controllers\Admin\BeritaController::class)->middleware('permission:berita');
    Route::resource('prestasi', \App\Http\Controllers\Admin\PrestasiController::class)->middleware('permission:prestasi');
    Route::resource('pengumuman', \App\Http\Controllers\Admin\PengumumanController::class)->middleware('permission:pengumuman');
    Route::resource('guru', \App\Http\Controllers\Admin\GuruController::class)->middleware('permission:guru');
    Route::resource('galeri', \App\Http\Controllers\Admin\GaleriController::class)->middleware('permission:galeri');
    Route::resource('halaman', \App\Http\Controllers\Admin\HalamanController::class)->middleware('permission:halaman');
    Route::resource('statistik', \App\Http\Controllers\Admin\StatistikController::class)->middleware('permission:statistik');
    Route::resource('ekstrakurikuler', \App\Http\Controllers\Admin\EkstrakurikulerController::class)->middleware('permission:ekstrakurikuler');
    Route::resource('prasarana', \App\Http\Controllers\Admin\PrasaranaController::class)->middleware('permission:prasarana');
    Route::resource('sarana', \App\Http\Controllers\Admin\SaranaController::class)->middleware('permission:sarana');
    Route::resource('alumni', \App\Http\Controllers\Admin\AlumniController::class)->parameters(['alumni' => 'alumni'])->middleware('permission:alumni');
    
    // Menu & Pengaturan Website (dengan hak akses / permission)
    Route::resource('menu', \App\Http\Controllers\Admin\MenuController::class)->middleware('permission:menu');
    Route::resource('sub-menu', \App\Http\Controllers\Admin\SubMenuController::class)->middleware('permission:sub-menu');
    Route::get('/pengaturan-website', [\App\Http\Controllers\Admin\PengaturanWebsiteController::class, 'index'])->name('pengaturan-website.index')->middleware('permission:pengaturan-website');
    Route::post('/pengaturan-website', [\App\Http\Controllers\Admin\PengaturanWebsiteController::class, 'update'])->name('pengaturan-website.update')->middleware('permission:pengaturan-website');
    
    // Manajemen Pengguna (Khusus Superadmin)
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class)->middleware('role:superadmin');
});

require __DIR__.'/auth.php';
