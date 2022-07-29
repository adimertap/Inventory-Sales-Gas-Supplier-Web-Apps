<?php

namespace App\Http\Controllers\Penjualan;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Penjualan\Penjualan;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $penjualan = Penjualan::with([
            'detail','customer'
        ]);

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

        return view('pages.penjualan.laporan.seluruh.index', compact('penjualan','jumlah','total','today','tanggal'));
    }
    
    public function reset_tanggal()
    {
        return redirect()->route('laporan-penjualan.index');
    }

    public function penjualan_seluruh_Pdf(Request $request)
    {
        $penjualan = Penjualan::with([
            'detail','customer'
        ]);

        if($request->from){
            $penjualan->where('tanggal_penjualan', '>=', $request->from);
        }
        if($request->to){
            $penjualan->where('tanggal_penjualan', '<=', $request->to);
        }
        $penjualan = $penjualan->get();
        $total = $penjualan->sum('grand_total');
        $jumlah = $penjualan->count();

        $pdf = Pdf::loadview('pdf.penjualan.seluruh.penjualan_seluruh_pdf',['penjualan'=>$penjualan, 'total' =>$total,'jumlah' => $jumlah]);
    	return $pdf->download('Penjualan-Keseluruhan.pdf');
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

        return view('pages.penjualan.laporan.seluruh.detail', compact('item','today','tanggal'));
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
