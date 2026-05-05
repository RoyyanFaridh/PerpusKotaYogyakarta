<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\BookPerpusController;
use App\Http\Controllers\Admin\BookTukarController;
use App\Http\Controllers\Admin\TransaksiController;


Route::get('/', fn () => view('welcome'));

Route::prefix('katalog')->name('katalog.')->group(function () {
    Route::get('/', [CatalogController::class, 'index'])->name('index');
    Route::get('/{book}', [CatalogController::class, 'show'])->name('show');
});



Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');

    Route::resource('buku-perpus', BookPerpusController::class);

    Route::resource('buku-tukar', BookTukarController::class);

    Route::resource('transaksi', TransaksiController::class)->only([
        'index', 'show', 'update', 'destroy'
    ]);
});