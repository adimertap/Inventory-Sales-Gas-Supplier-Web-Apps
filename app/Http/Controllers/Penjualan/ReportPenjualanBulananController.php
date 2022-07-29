<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportPenjualanBulananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = Penjualan::selectRaw('SUM(grand_total) as grand_totals, DATE_FORMAT(tanggal_penjualan, "%M") as bulan, YEAR(tanggal_penjualan) as tahun, COUNT(id_penjualan) as jumlah_penjualan')
        ->groupBy('bulan','tahun')
        ->get();
        $total = Penjualan::sum('grand_total');
        $jumlah = Penjualan::count();
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');

        return view('pages.penjualan.laporan.bulanan.index', compact('penjualan','total','today','tanggal','jumlah'));
    }

    public function penjualan_bulanan_Pdf()
    {
        $penjualan = Penjualan::selectRaw('SUM(grand_total) as grand_totals, DATE_FORMAT(tanggal_penjualan, "%M") as bulan, YEAR(tanggal_penjualan) as tahun, COUNT(id_penjualan) as jumlah_penjualan')
        ->groupBy('bulan','tahun')
        ->get();
        $total = Penjualan::sum('grand_total');
        $jumlah = Penjualan::count();

        $pdf = Pdf::loadview('pdf.penjualan.bulanan.penjualan_bulanan_pdf',['penjualan'=>$penjualan, 'total' =>$total,'jumlah' => $jumlah]);
    	return $pdf->download('Penjualan-Seluruh-Bulan.pdf');
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
        $penjualan = Penjualan::with([
            'detail'
        ])->where(DB::raw("(DATE_FORMAT(tanggal_penjualan,'%M'))"),'=', $bulan);

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

        return view('pages.penjualan.laporan.bulanan.detail', compact('bulan','penjualan','total','jumlah','today','tanggal'));
    }

    public function penjualan_detail_bulanan_Pdf(Request $request,$bulan)
    {
        $penjualan = Penjualan::with([
            'detail'
        ])->where(DB::raw("(DATE_FORMAT(tanggal_penjualan,'%M'))"),'=', $bulan);

        if($request->from){
            $penjualan->where('tanggal_penjualan', '>=', $request->from);
        }
        if($request->to){
            $penjualan->where('tanggal_penjualan', '<=', $request->to);
        }
        $penjualan = $penjualan->get();
        $total = $penjualan->sum('grand_total');
        $jumlah = $penjualan->count();

        $pdf = Pdf::loadview('pdf.penjualan.bulanan.penjualan_bulanan_detail_pdf',['penjualan'=>$penjualan, 'total' =>$total,'jumlah' => $jumlah, 'bulan' => $bulan]);
    	return $pdf->download('Penjualan-Bulan.pdf');
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

    public function reset_bulan($bulan)
    {
        return redirect()->route('laporan-penjualan-bulanan.show', $bulan);
    }
}
