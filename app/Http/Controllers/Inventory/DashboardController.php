<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Pembelian;
use App\Models\Master\Produk;
use App\Models\Penjualan\Penjualan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal_tahun = Carbon::now()->format('j F Y');
        $status_produk = Produk::get();
        $habis = Produk::where('status_jumlah', 'Habis')->count();
        $min = Produk::where('status_jumlah', 'Min')->count();
        $cek_habis = Produk::where('status_jumlah', 'Habis')->get();
        $cek_min = Produk::where('status_jumlah', 'Min')->get();
        $cukup = Produk::where('status_jumlah','Cukup')->count();
        $kurang = Produk::where('status_jumlah','Kurang')->count();
        
        $total_hari_ini = Pembelian::where('tanggal_pembelian', Carbon::now()->format('Y-m-d'))->sum('grand_total');
        $total_hari_ini_count = Pembelian::where('tanggal_pembelian', Carbon::now()->format('Y-m-d'))->count();
        $total_bulan_ini = Pembelian::where('status','Diterima')->whereMonth('tanggal_pembelian', Carbon::now()->month)->sum('grand_total');
        $total_bulan_ini_count = Pembelian::where('status','Diterima')->whereMonth('tanggal_pembelian', Carbon::now()->month)->count();
        
        return view('pages.inventory.dashboard.dashboardinventory', compact(
            'habis','today','tanggal_tahun','status_produk','min',
            'cukup','kurang','total_hari_ini','total_bulan_ini',
            'total_hari_ini_count','total_bulan_ini_count','cek_habis','cek_min'
        
        ));
    }

    public function dashboard_penjualan()
    {
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal_tahun = Carbon::now()->format('j F Y');
        $hari = Carbon::now()->format('Y-m-d');

        $total_hari_ini = Penjualan::where('tanggal_penjualan', Carbon::now()->format('Y-m-d'))->sum('grand_total');
        $total_hari_ini_count = Penjualan::where('tanggal_penjualan', Carbon::now()->format('Y-m-d'))->count();
        $total_bulan_ini = Penjualan::whereMonth('tanggal_penjualan', Carbon::now()->month)->sum('grand_total');
        $total_bulan_ini_count = Penjualan::whereMonth('tanggal_penjualan', Carbon::now()->month)->count();

        $pegawai = User::with('Penjualan.Customer')->where('role', 'Pegawai')->get();

        return view('pages.penjualan.dashboard.dashboardpenjualan', compact(
            'today','tanggal_tahun','total_hari_ini','total_hari_ini_count',
            'total_bulan_ini','total_bulan_ini_count','pegawai','hari'
        ));
    }
}
