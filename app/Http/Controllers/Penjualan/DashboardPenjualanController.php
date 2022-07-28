<?php

namespace App\Http\Controllers\Penjualan;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Penjualan\Penjualan;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardPenjualanController extends Controller
{
    public function pegawai()
    {
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal_tahun = Carbon::now()->format('j F Y');
        $hari = Carbon::now()->format('Y-m-d');

        $total_hari_ini = Penjualan::where('id', Auth::user()->id)->where('tanggal_penjualan', Carbon::now()->format('Y-m-d'))->sum('grand_total');
        $total_hari_ini_count = Penjualan::where('id', Auth::user()->id)->where('tanggal_penjualan', Carbon::now()->format('Y-m-d'))->count();
        $total_bulan_ini = Penjualan::where('id', Auth::user()->id)->whereMonth('tanggal_penjualan', Carbon::now()->month)->sum('grand_total');
        $total_bulan_ini_count = Penjualan::where('id', Auth::user()->id)->whereMonth('tanggal_penjualan', Carbon::now()->month)->count();

        return view('pages.penjualan.dashboard.dashboardpegawai', compact(
            'today','tanggal_tahun','total_hari_ini','total_hari_ini_count',
            'total_bulan_ini','total_bulan_ini_count','hari'
        ));
    }

    public function penjualan_bulan(Request $request,$id)
    {
        $penjualan = Penjualan::with([
            'detail'
        ])->where('id', $id);
        if($request->from){
            $penjualan->where('tanggal_penjualan', '>=', $request->from);
        }
        if($request->to){
            $penjualan->where('tanggal_penjualan', '<=', $request->to);
        }
        $penjualan = $penjualan->get();
        $total = $penjualan->sum('grand_total');
        $jumlah = $penjualan->count();
        
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');

        return view('pages.penjualan.laporan.pegawai.bulanan', compact('penjualan','jumlah','total','today','tanggal'));
    }
}
