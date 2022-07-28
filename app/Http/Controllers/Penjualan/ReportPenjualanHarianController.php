<?php

namespace App\Http\Controllers\Penjualan;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Penjualan\Penjualan;
use App\Http\Controllers\Controller;

class ReportPenjualanHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = Penjualan::where('tanggal_penjualan', Carbon::now()->format('Y-m-d'))->get();
        $total = Penjualan::where('tanggal_penjualan', Carbon::now()->format('Y-m-d'))->sum('grand_total');
        $jumlah = Penjualan::where('tanggal_penjualan', Carbon::now()->format('Y-m-d'))->count();
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');

        return view('pages.penjualan.laporan.harian.index', compact('penjualan','total','jumlah','today','tanggal'));
    }

    public function report_pegawai($id)
    {
        $penjualan = Penjualan::where('tanggal_penjualan', Carbon::now()->format('Y-m-d'))->where('id',$id)->get();
        $total = Penjualan::where('tanggal_penjualan', Carbon::now()->format('Y-m-d'))->where('id',$id)->sum('grand_total');
        $jumlah = Penjualan::where('tanggal_penjualan', Carbon::now()->format('Y-m-d'))->where('id',$id)->count();
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');

        return view('pages.penjualan.laporan.harian.pegawai', compact('penjualan','total','jumlah','today','tanggal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Penjualan::find($id);
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');

        return view('pages.penjualan.laporan.harian.detail', compact('item','today','tanggal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
