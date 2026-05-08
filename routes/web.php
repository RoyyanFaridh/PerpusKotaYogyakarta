<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengaturanController;

Route::get('/', fn () => view('welcome'));

Route::prefix('katalog')->name('katalog.')->group(function () {
    Route::get('/', [CatalogController::class, 'index'])->name('index');
    Route::get('/cari', [CatalogController::class, 'search'])->name('cari');
    Route::get('/{book}', [CatalogController::class, 'show'])->name('show');
});

Route::get('/admin/login',  [AdminAuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('auth.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('auth.logout');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('member', MemberController::class);
    Route::resource('lokasi', LokasiController::class);

    Route::prefix('buku')->name('buku.')->group(function () {
        Route::get('/',          [BukuController::class, 'index'])->name('index');
        Route::get('/create',    [BukuController::class, 'create'])->name('create');
        Route::post('/',         [BukuController::class, 'store'])->name('store');
        Route::put('/{buku}',    [BukuController::class, 'update'])->name('update');
        Route::delete('/{buku}', [BukuController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/',               [TransaksiController::class, 'index'])->name('index');
        Route::get('/create',         [TransaksiController::class, 'create'])->name('create');
        Route::post('/',              [TransaksiController::class, 'store'])->name('store');
        Route::get('/cari-member',    [TransaksiController::class, 'cariMember'])->name('cari-member');
        Route::post('/simpan-member', [TransaksiController::class, 'simpanMember'])->name('simpan-member');
        Route::get('/cari-buku-isbn', [TransaksiController::class, 'cariBukuIsbn'])->name('cari-buku-isbn');
    });

    // Pengaturan
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::get('/',               [PengaturanController::class, 'index'])->name('index');
        Route::put('/profil',         [PengaturanController::class, 'updateProfil'])->name('profil');
        Route::put('/password',       [PengaturanController::class, 'updatePassword'])->name('password');
        Route::post('/user',          [PengaturanController::class, 'storeUser'])->name('user');
        Route::delete('/user/{user}', [PengaturanController::class, 'destroyUser'])->name('user.destroy');
        Route::get('/backup',         [PengaturanController::class, 'backup'])->name('backup');
    });
});