<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\BukuEksemplarController;
use App\Http\Controllers\Admin\PaketPemindahanController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\PaketController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/search-buku', [CatalogController::class, 'searchAjax'])->name('search.buku');

Route::prefix('katalog')->name('katalog.')->group(function () {
    Route::get('/',      [CatalogController::class, 'index'])->name('index');
    Route::get('/cari',  [CatalogController::class, 'search'])->name('cari');
    Route::get('/{book}',[CatalogController::class, 'show'])->name('show');
});

Route::get('/admin/login',  [AdminAuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('auth.login.post')->middleware('throttle:5,1');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('auth.logout');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Member
    Route::get('/member',                         [MemberController::class, 'index'])->name('member.index');
    Route::get('/member/export',                  [MemberController::class, 'export'])->name('member.export');
    Route::post('/member',                        [MemberController::class, 'store'])->name('member.store')->middleware('has.permission:member.create');
    Route::get('/member/{member}/edit',           [MemberController::class, 'edit'])->name('member.edit')->middleware('has.permission:member.edit');
    Route::put('/member/{member}',                [MemberController::class, 'update'])->name('member.update')->middleware('has.permission:member.edit');
    Route::patch('/member/{member}/toggle-aktif', [MemberController::class, 'toggleAktif'])->name('member.toggle-aktif')->middleware('has.permission:member.edit');

    // Lokasi
    Route::get('/lokasi',                  [LokasiController::class, 'index'])->name('lokasi.index');
    Route::post('/lokasi',                 [LokasiController::class, 'store'])->name('lokasi.store')->middleware('has.permission:lokasi.create');
    Route::get('/lokasi/{lokasi}/edit',    [LokasiController::class, 'edit'])->name('lokasi.edit')->middleware('has.permission:lokasi.edit');
    Route::put('/lokasi/{lokasi}',         [LokasiController::class, 'update'])->name('lokasi.update')->middleware('has.permission:lokasi.edit');
    Route::delete('/lokasi/{lokasi}',      [LokasiController::class, 'destroy'])->name('lokasi.destroy')->middleware('has.permission:lokasi.delete');

    // Kegiatan
    Route::get('/kegiatan',                [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::post('/kegiatan',               [KegiatanController::class, 'store'])->name('kegiatan.store')->middleware('has.permission:kegiatan.create');
    Route::get('/kegiatan/{kegiatan}',     [KegiatanController::class, 'edit'])->name('kegiatan.edit')->middleware('has.permission:kegiatan.edit');
    Route::put('/kegiatan/{kegiatan}',     [KegiatanController::class, 'update'])->name('kegiatan.update')->middleware('has.permission:kegiatan.edit');
    Route::delete('/kegiatan/{kegiatan}',  [KegiatanController::class, 'destroy'])->name('kegiatan.destroy')->middleware('has.permission:kegiatan.delete');

    // Buku
    Route::prefix('buku')->name('buku.')->group(function () {
        Route::get('/',            [BukuController::class, 'index'])->name('index');
        Route::get('/export',      [BukuController::class, 'export'])->name('export');
        Route::get('/create',      [BukuController::class, 'create'])->name('create')->middleware('has.permission:buku.create');
        Route::post('/',           [BukuController::class, 'store'])->name('store')->middleware('has.permission:buku.create');
        Route::get('/{buku}',      [BukuController::class, 'show'])->name('show');
        Route::get('/{buku}/edit', [BukuController::class, 'edit'])->name('edit')->middleware('has.permission:buku.edit');
        Route::put('/{buku}',      [BukuController::class, 'update'])->name('update')->middleware('has.permission:buku.edit');
        Route::delete('/{buku}',   [BukuController::class, 'destroy'])->name('destroy')->middleware('has.permission:buku.delete');
        Route::patch('/{buku}/toggle-visibility', [BukuController::class, 'toggleVisibility'])->name('toggle-visibility')->middleware('has.permission:buku.edit');

        // Eksemplar
        Route::get('/{buku}/eksemplar',               [BukuEksemplarController::class, 'index'])->name('eksemplar.index');
        Route::post('/{buku}/eksemplar',              [BukuEksemplarController::class, 'store'])->name('eksemplar.store')->middleware('has.permission:buku.edit');
        Route::patch('/{buku}/eksemplar/{eksemplar}', [BukuEksemplarController::class, 'update'])->name('eksemplar.update')->middleware('has.permission:buku.edit');
        Route::delete('/{buku}/eksemplar/{eksemplar}',[BukuEksemplarController::class, 'destroy'])->name('eksemplar.destroy')->middleware('has.permission:buku.delete');
    });

    // Transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/',                  [TransaksiController::class, 'index'])->name('index');
        Route::post('/',                 [TransaksiController::class, 'store'])->name('store')->middleware('has.permission:transaksi.create');
        Route::get('/export',            [TransaksiController::class, 'export'])->name('export');
        Route::get('/cari-member',       [TransaksiController::class, 'cariMember'])->name('cari-member');
        Route::post('/simpan-member',    [TransaksiController::class, 'simpanMember'])->name('simpan-member');
        Route::get('/cari-buku-isbn',    [TransaksiController::class, 'cariBukuIsbn'])->name('cari-buku-isbn');
        Route::get('/cari-buku-judul',   [TransaksiController::class, 'cariBukuJudul'])->name('cari-buku-judul');
        Route::get('/buku-by-paket',     [TransaksiController::class, 'bukuByPaket'])->name('buku-by-paket');
        Route::get('/{id}',              [TransaksiController::class, 'show'])->name('show');
        Route::put('/{id}',              [TransaksiController::class, 'update'])->name('update')->middleware('has.permission:transaksi.edit');
        Route::delete('/{id}',           [TransaksiController::class, 'destroy'])->name('destroy')->middleware('has.permission:transaksi.delete');
    });

    // Paket
    Route::prefix('paket')->name('paket.')->group(function () {
        Route::get('/',                         [PaketController::class, 'index'])->name('index');
        Route::post('/',                        [PaketController::class, 'store'])->name('store')->middleware('has.permission:buku.create');
        Route::put('/{paket}',                  [PaketController::class, 'update'])->name('update')->middleware('has.permission:buku.edit');
        Route::delete('/{paket}',               [PaketController::class, 'destroy'])->name('destroy')->middleware('has.permission:buku.delete');
        Route::post('/{paket}/aktifkan',        [PaketController::class, 'aktifkan'])->name('aktifkan')->middleware('has.permission:buku.edit');
        Route::post('/{paket}/nonaktifkan',     [PaketController::class, 'nonaktifkan'])->name('nonaktifkan')->middleware('has.permission:buku.edit');

        // Pemindahan
        Route::get('/{paket}/pemindahan',       [PaketPemindahanController::class, 'index'])->name('pemindahan.index');
        Route::post('/{paket}/pemindahan',      [PaketPemindahanController::class, 'store'])->name('pemindahan.store')->middleware('has.permission:buku.edit');
    });

    // Pengaturan
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::get('/profil-saya', [PengaturanController::class, 'profilPage'])->name('profil.page');
        Route::put('/password',    [PengaturanController::class, 'updatePassword'])->name('password');
        Route::put('/profil',      [PengaturanController::class, 'updateProfil'])->name('profil');
    });

    Route::prefix('pengaturan')->name('pengaturan.')->middleware('superadmin')->group(function () {
        Route::get('/',                         [PengaturanController::class, 'index'])->name('index');
        Route::get('/backup',                   [PengaturanController::class, 'backup'])->name('backup');
        Route::get('/user/create',              [PengaturanController::class, 'createUser'])->name('create');
        Route::post('/user',                    [PengaturanController::class, 'storeUser'])->name('user');
        Route::get('/user/{user}/edit',         [PengaturanController::class, 'editUser'])->name('edit');
        Route::put('/user/{user}',              [PengaturanController::class, 'updateUser'])->name('user.update');
        Route::post('/user/{user}/permissions', [PengaturanController::class, 'updatePermissions'])->name('user.permissions');
        Route::get('/user/{user}/destroy',      [PengaturanController::class, 'confirmDestroyUser'])->name('destroy');
        Route::delete('/user/{user}',           [PengaturanController::class, 'destroyUser'])->name('user.destroy');
    });
});