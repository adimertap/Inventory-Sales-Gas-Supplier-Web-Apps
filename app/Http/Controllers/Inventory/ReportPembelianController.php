<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Pembelian;
use App\Models\Inventory\Penerimaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pembelian = Pembelian::with([
            'detail'
        ])->where('status','Diterima');

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

        return view('pages.inventory.laporan.seluruh.seluruhpembelian', compact('pembelian','jumlah','total','today','tanggal'));
    }

    public function reset()
    {
        return redirect()->route('laporan-pembelian.index');
    }

    public function pembelian_seluruh_Pdf(Request $request)
    {
        $pembelian = Pembelian::with([
            'detail'
        ])->where('status','Diterima');

        if($request->from){
            $pembelian->where('tanggal_pembelian', '>=', $request->from);
        }
        if($request->to){
            $pembelian->where('tanggal_pembelian', '<=', $request->to);
        }
        $pembelian = $pembelian->get();
        $total = $pembelian->sum('grand_total');
        $jumlah = $pembelian->count();
        
    	$pdf = Pdf::loadview('pdf.pembelian.seluruh.pembelian_seluruh_pdf',['pembelian'=>$pembelian, 'total' =>$total,'jumlah' => $jumlah]);
    	return $pdf->download('Pembelian-Keseluruhan.pdf');
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
        $item = Pembelian::find($id);
        $penerimaan = Penerimaan::with('Pembelian','Detail')->where('id_pembelian', $id)->get();
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');

        return view('pages.inventory.laporan.seluruh.detail', compact('item','penerimaan','today','tanggal'));
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
