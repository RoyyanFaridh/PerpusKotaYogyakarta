<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\BookPerpusController;
// use App\Http\Controllers\Admin\BookTukarController;
use App\Http\Controllers\Admin\TransaksiController;
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

Route::get('/admin/login',  [AdminAuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('auth.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('auth.logout');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('member', MemberController::class);
    Route::resource('lokasi', LokasiController::class);

    Route::resource('buku-perpus', BookPerpusController::class);

    // Route::resource('buku-tukar', BookTukarController::class);

    Route::resource('transaksi', TransaksiController::class);
});

// Route::get('/', function () {
//     return view('welcome', [
//         'totalBuku'    => \App\Models\Buku::count(),
//         'totalAnggota' => \App\Models\User::count(),
//         'totalTukar'   => \App\Models\Transaksi::where('status', 'selesai')->count(),
//         'kegiatan'     => \App\Models\Kegiatan::orderBy('tanggal')->get(),
//     ]);
// });
