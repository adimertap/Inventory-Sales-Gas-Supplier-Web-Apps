<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Pembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportBulananPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembelian = Pembelian::where('status','Diterima')->selectRaw('SUM(grand_total) as grand_totals, DATE_FORMAT(tanggal_pembelian, "%M") as bulan, YEAR(tanggal_pembelian) as tahun, COUNT(id_pembelian) as jumlah_pembelian')
        ->groupBy('bulan','tahun')
        ->get();
        $total = Pembelian::where('status','Diterima')->sum('grand_total');
        $jumlah = Pembelian::where('status','Diterima')->count();
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');

        return view('pages.inventory.laporan.bulanan.index', compact('pembelian','total','today','tanggal','jumlah'));
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
    public function show(Request $request,$bulan)
    {

        $pembelian = Pembelian::with([
            'detail','penerimaan'
        ])->where('status','Diterima')
        ->where(DB::raw("(DATE_FORMAT(tanggal_pembelian,'%M'))"),'=', $bulan);

        if($request->from){
            $pembelian->where('tanggal_pembelian', '>=', $request->from);
        }
        if($request->to){
            $pembelian->where('tanggal_pembelian', '<=', $request->to);
        }
        $pembelian = $pembelian->get();
        $total = $pembelian->sum('grand_total');
        $jumlah = $pembelian->count();

        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');

        return view('pages.inventory.laporan.bulanan.detailtanggal', compact('bulan','pembelian','total','jumlah','today','tanggal'));
    }

    public function reset($bulan)
    {
        return redirect()->route('laporan-pembelian-bulanan.show', $bulan);
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
