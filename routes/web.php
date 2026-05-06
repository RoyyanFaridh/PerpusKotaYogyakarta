<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
// use App\Http\Controllers\Admin\BookPerpusController;
// use App\Http\Controllers\Admin\BookTukarController;
// use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', fn () => view('welcome'));

Route::prefix('katalog')->name('katalog.')->group(function () {
    Route::get('/', [CatalogController::class, 'index'])->name('index');
    Route::get('/cari', [CatalogController::class, 'search'])->name('cari');
    Route::get('/{book}', [CatalogController::class, 'show'])->name('show');
});

Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('auth.login');

Route::prefix('admin')->group(function () { //middleware(['auth'])->

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('member', MemberController::class);
    Route::resource('lokasi', LokasiController::class);

    // Route::resource('buku-perpus', BookPerpusController::class);

    // Route::resource('buku-tukar', BookTukarController::class);

    // Route::resource('transaksi', TransaksiController::class)->only([
    //     'index', 'show', 'update', 'destroy'
    // ]);
});

