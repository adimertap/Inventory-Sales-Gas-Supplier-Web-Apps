<?php

use App\Http\Controllers\Inventory\JenisSupplierController;
use App\Http\Controllers\Inventory\KartuGudangController;
use App\Http\Controllers\Inventory\MasterCategoryController;
use App\Http\Controllers\Inventory\MasterProdukController;
use App\Http\Controllers\Inventory\MasterSupplierController;
use App\Http\Controllers\Inventory\MasterUserController;
use App\Http\Controllers\Inventory\PembelianController;
use App\Http\Controllers\Inventory\PenerimaanController;
use App\Http\Controllers\Inventory\ReportBulananPembelianController;
use App\Http\Controllers\Inventory\ReportHarianPembelianController;
use App\Http\Controllers\Inventory\ReportPembelianController;
use App\Http\Controllers\Penjualan\MasterCustomerController;
use App\Http\Controllers\Penjualan\PenjualanController;
use App\Http\Controllers\Penjualan\ReportPenjualanBulananController;
use App\Http\Controllers\Penjualan\ReportPenjualanController;
use App\Http\Controllers\Penjualan\ReportPenjualanHarianController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\Inventory\DashboardController::class, 'index'])->middleware(['AksesOwner'])->name('dashboard');
    Route::get('/dashboard/penjualan', [App\Http\Controllers\Inventory\DashboardController::class, 'dashboard_penjualan'])->middleware(['AksesOwner'])->name('dashboard-penjualan-owner');

    Route::prefix('Master')
    ->middleware(['AksesOwner'])
    ->group(function () {
        // MASTER DATA
        Route::resource('master-user', MasterUserController::class);
        Route::resource('master-supplier', MasterSupplierController::class);
        Route::resource('master-kategori', MasterCategoryController::class);
        Route::resource('master-produk', MasterProdukController::class);
        Route::resource('master-jenis-supplier', JenisSupplierController::class);
    });

    // INVENTORY
    // PEMBELIAN
    Route::resource('pembelian', PembelianController::class)->middleware('AksesOwner');
    Route::get('/mail/supplier/{id}', [App\Http\Controllers\Inventory\PembelianController::class, 'mail'])->middleware(['AksesOwner'])->name('pembelian-email');
    Route::post('/pembelian/kirim/{id}', [App\Http\Controllers\Inventory\PembelianController::class, 'kirim'])->middleware(['AksesOwner'])->name('pembelian-kirim');
    Route::get('/pembelian/download/pdf/{id}', [App\Http\Controllers\Inventory\PembelianController::class, 'pembelian_pdf'])->middleware(['AksesOwner'])->name('pembelian-pdf');
    
    // PENERIMAAN
    Route::resource('penerimaan', PenerimaanController::class)->middleware('AksesOwner');
    Route::get('penerimaan/proses/{id_pembelian}', [App\Http\Controllers\Inventory\PenerimaanController::class, 'proses'])->middleware(['AksesOwner'])->name('penerimaan-proses');
    Route::post('/penerimaan/lengkap/{id}', [App\Http\Controllers\Inventory\PenerimaanController::class, 'lengkap'])->middleware(['AksesOwner'])->name('penerimaan-lengkap');
    Route::post('/penerimaan/bayar/{id}', [App\Http\Controllers\Inventory\PenerimaanController::class, 'bayar'])->middleware(['AksesOwner'])->name('penerimaan-bayar');

    // KARTU GUDANG
    Route::resource('kartu-gudang', KartuGudangController::class)->middleware('AksesOwner');
    Route::get('/kartu-gudang/penerimaan/{id}', [App\Http\Controllers\Inventory\KartuGudangController::class, 'penerimaan'])->middleware(['AksesOwner'])->name('kartu-gudang-penerimaan');
    Route::get('/kartu-gudang/penjualan/{id}', [App\Http\Controllers\Inventory\KartuGudangController::class, 'penjualan'])->middleware(['AksesOwner'])->name('kartu-gudang-penjualan');
    Route::get('/kartu-gudang/download/pdf', [App\Http\Controllers\Inventory\KartuGudangController::class, 'cetak_pdf'])->middleware(['AksesOwner'])->name('cetak-kartu-pdf');
    Route::get('/kartu-gudang/download/pdf/{id}', [App\Http\Controllers\Inventory\KartuGudangController::class, 'cetak_detail_pdf'])->middleware(['AksesOwner'])->name('cetak-kartu-detail-pdf');
    Route::get('/kartu-penerimaan/download/pdf/{id}', [App\Http\Controllers\Inventory\KartuGudangController::class, 'cetak_kartu_penerimaan_pdf'])->middleware(['AksesOwner'])->name('cetak-kartu-penerimaan-pdf');
    Route::get('/kartu-penjualan/download/pdf/{id}', [App\Http\Controllers\Inventory\KartuGudangController::class, 'cetak_kartu_penjualan_pdf'])->middleware(['AksesOwner'])->name('cetak-kartu-penjualan-pdf');


    // PENJUALAN
    Route::prefix('Penjualan')
    ->group(function () {
        Route::resource('master-customer', MasterCustomerController::class);
        Route::get('/dashbord/pegawai', [App\Http\Controllers\Penjualan\DashboardPenjualanController::class, 'pegawai'])->name('dashboard-penjualan-pegawai');
        Route::get('/penjualan/bulan/{id}', [App\Http\Controllers\Penjualan\DashboardPenjualanController::class, 'penjualan_bulan'])->name('penjualan-bulan-pegawai');
    });

    // TRANSAKSI PENJUALAN
    Route::resource('penjualan', PenjualanController::class);
    Route::get('/penjualan/pegawai/harian', [App\Http\Controllers\Penjualan\PenjualanController::class, 'penjualan_harian_pegawai'])->name('penjualan-harian-pegawai');
    Route::post('/penjualan/bayar/{id}', [App\Http\Controllers\Penjualan\PenjualanController::class, 'bayar'])->name('penjualan-bayar');
    Route::get('/penjualan/download/pdf/{id}', [App\Http\Controllers\Penjualan\PenjualanController::class, 'penjualan_pdf'])->name('penjualan-pdf');

  

     Route::middleware(['AksesOwner'])
    ->group(function () {
         // LAPORAN PEMBELIAN
        Route::resource('laporan-pembelian', ReportPembelianController::class)->middleware('AksesOwner');
        Route::resource('laporan-pembelian-harian', ReportHarianPembelianController::class)->middleware('AksesOwner');
        Route::resource('laporan-pembelian-bulanan', ReportBulananPembelianController::class)->middleware('AksesOwner');
        // Route::get('/laporan-pembelian/harian', [App\Http\Controllers\Inventory\ReportPembelianController::class, 'pembelian_harian'])->middleware(['AksesOwner'])->name('laporan-pembelian-harian');
        Route::get('/laporan-pembelian/reset/tanggal', [App\Http\Controllers\Inventory\ReportPembelianController::class, 'reset'])->name('laporan-pembelian-reset');
        Route::get('/laporan-pembelian/reset/{bulan}', [App\Http\Controllers\Inventory\ReportBulananPembelianController::class, 'reset'])->name('laporan-pembelian-bulanan-reset');

        // PDF LAPORAN PEMBELIAN
        Route::get('/pembelian-harian/download/pdf', [App\Http\Controllers\Inventory\ReportHarianPembelianController::class, 'pembelian_harian_Pdf'])->name('pembelian-harian-pdf');
        Route::get('/pembelian-bulanan/download/pdf', [App\Http\Controllers\Inventory\ReportBulananPembelianController::class, 'pembelian_bulanan_Pdf'])->name('pembelian-bulanan-pdf');
        Route::get('/pembelian-bulanan/download/pdf/{bulan}', [App\Http\Controllers\Inventory\ReportBulananPembelianController::class, 'pembelian_detail_bulanan_Pdf'])->name('pembelian-detail-bulanan-pdf');

        // LAPORAN PENJUALAN
        Route::resource('laporan-penjualan', ReportPenjualanController::class);
        Route::get('/laporan-penjualan/reset/tanggal', [App\Http\Controllers\Penjualan\ReportPenjualanController::class, 'reset_tanggal'])->name('laporan-penjualan-reset');
        Route::get('/laporan-penjualan/pegawai/{id}', [App\Http\Controllers\Penjualan\ReportPenjualanHarianController::class, 'report_pegawai'])->name('laporan-pegawai');
        Route::resource('laporan-penjualan-harian', ReportPenjualanHarianController::class);
        Route::resource('laporan-penjualan-bulanan', ReportPenjualanBulananController::class);
        Route::get('/laporan-penjualan/reset/{bulan}', [App\Http\Controllers\Penjualan\ReportPenjualanBulananController::class, 'reset_bulan'])->name('laporan-penjualan-bulanan-reset');

        // PDF LAPORAN PENJUALAN
        Route::get('/penjualan-harian/download/pdf', [App\Http\Controllers\Penjualan\ReportPenjualanHarianController::class, 'penjualan_harian_Pdf'])->name('penjualan-harian-pdf');
        Route::get('/penjualan-seluruh/download/pdf', [App\Http\Controllers\Penjualan\ReportPenjualanController::class, 'penjualan_seluruh_Pdf'])->name('penjualan-seluruh-pdf');
        Route::get('/penjualan-bulanan/download/pdf', [App\Http\Controllers\Penjualan\ReportPenjualanBulananController::class, 'penjualan_bulanan_Pdf'])->name('penjualan-bulanan-pdf');
        Route::get('/penjualan-bulanan/download/pdf/{bulan}', [App\Http\Controllers\Penjualan\ReportPenjualanBulananController::class, 'penjualan_detail_bulanan_Pdf'])->name('penjualan-detail-bulanan-pdf');


        // EXCEL
        Route::get('/pembelian/download/excel', [App\Http\Controllers\Inventory\ReportPembelianController::class, 'excel'])->name('pembelian-excel');
        Route::get('/penjualan/download/excel', [App\Http\Controllers\Penjualan\ReportPenjualanController::class, 'excel'])->name('penjualan-excel');
        Route::get('/kartu/download/excel', [App\Http\Controllers\Inventory\KartuGudangController::class, 'excel'])->name('kartu-excel');
    });
});


