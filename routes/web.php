<?php

use App\Http\Controllers\BomController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ConvertController;
use App\Http\Controllers\PerbandinganController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(ItemController::class)->group(function () {
    Route::get('items', 'index');
    Route::get('items-export', 'export')->name('items.export');
});
Route::controller(OutletController::class)->group(function () {
    Route::get('outlets', 'index');
    Route::get('outlets-export', 'export')->name('outlets.export');
});

Route::controller(ConvertController::class)->group(function () {
    Route::get('/',  'index')->name('login');
    Route::post('post-login', 'postLogin')->name('login.post');
    Route::get('registration', 'registration')->name('register');
    Route::post('post-registration', 'postRegistration')->name('register.post');
    Route::get('dashboard', 'dashboard');
    Route::get('logout', 'logout')->name('logout');
    Route::get('pembelian', 'pembeliantes');
    Route::get('penerimaan', 'penerimaantes');
    Route::get('pengiriman', 'pengirimantes');
    Route::get('penjualan', 'penjualan');
    Route::get('pembelians-cari', 'cariPembelian')->name('pembelians.cari');
    Route::get('pembelians-filter', 'FilterPembelian')->name('pembelians.filter');
    Route::get('pembelians-export', 'exportPembelian')->name('pembelians.export');
    Route::get('penerimaans-export', 'exportPenerimaan')->name('penerimaans.export');
    Route::post('pembelians-import', 'importPembelian')->name('pembelians.import');
    Route::post('penerimaans-import', 'importPenerimaan')->name('penerimaans.import');
    Route::post('penjualans-import', 'importPenjualan')->name('penjualans.import');
    Route::get('delete-database', 'deletedata')->name('delete.database');
});

Route::controller(BomController::class)->group(function () {
    Route::get('boms', 'index');
    Route::get('laporan', 'laporan');
    Route::get('laporandua', 'laporandua');
    Route::get('Laporanhpps', 'Laporanhpps');
    Route::get('boms-cari', 'caribom')->name('boms.cari');
    Route::get('laporans-cari', 'carilaporan')->name('laporans.cari');
    Route::get('boms1-export', 'export')->name('boms1.export');
    Route::get('hpp-export', 'laporanhppexport')->name('hpp.export');
    Route::get('transaksiboms', 'pengirimantes');
    Route::get('laporans-tanggal', 'LaporanTanggal')->name('laporans.tanggal');
    Route::get('laporans-tanggaldua', 'LaporanTanggaldua')->name('laporans.tanggaldua');
    Route::get('Laporanhpps-tanggal', 'Laporanhppstanggal')->name('Laporanhpps.tanggal');
});

Route::controller(PerbandinganController::class)->group(function () {
    Route::get('laporanperbandingan', 'index');
    Route::get('laporanpengiriman', 'laporanpengiriman');
    Route::get('laporanpengirimans-export', 'LaporanPerbandinganexport')->name('laporanpengirimans.export');
    Route::post('laporanpenerimaans-import', 'importPenerimaan')->name('laporanpenerimaans.import');
    Route::post('laporanpengirimans-import', 'importPengiriman')->name('laporanpengirimans.import');
    Route::get('laporans-perbandingan', 'Hasillaporanpengiriman')->name('laporans.perbandingan');
    Route::get('deleteperbandingan-database', 'deleteperbandingandata')->name('deleteperbandingan.database');
    Route::get('perbandingan-cari', 'perbandingancari')->name('perbandingan.cari');
});
