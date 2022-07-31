<?php

namespace App\Http\Controllers\Inventory;

use App\Exports\ExcelPembelian;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Pembelian;
use App\Models\Inventory\Penerimaan;
use App\Models\Master\Category;
use App\Models\Master\JenisSupplier;
use App\Models\Master\Produk;
use App\Models\Master\Supplier;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

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

        $supplier = Supplier::get();
        $pegawai = User::get();
        $jenis = JenisSupplier::get();
        $produk = Produk::select('nama_produk')->groupBy('nama_produk')->get();
        $kategori = Category::get();


        return view('pages.inventory.laporan.seluruh.seluruhpembelian', 
        compact('pembelian','jumlah','total','today','tanggal',
            'supplier','pegawai','jenis','produk','kategori'
        ));
    }

    public function reset()
    {
        return redirect()->route('laporan-pembelian.index');
    }

    public function pembelian_seluruh_Pdf(Request $request)
    {
        $pembelian = Pembelian::where('status','Diterima')->join('tb_detail_pembelian','tb_pembelian.id_pembelian','tb_detail_pembelian.id_pembelian')
        ->join('tb_master_produk', 'tb_detail_pembelian.id_produk','tb_master_produk.id_produk')
        ->join('tb_master_supplier','tb_pembelian.supplier_id','tb_master_supplier.id_supplier')
        ->leftjoin('tb_master_jenis_supplier', 'tb_master_supplier.jenis_id','tb_master_jenis_supplier.id_jenis_supplier')
        ->leftjoin('tb_master_kategori', 'tb_master_produk.kategori_id','tb_master_kategori.id_kategori');
        if($request->from){
            $pembelian->where('tanggal_pembelian', '>=', $request->from);
        }
        if($request->to){
            $pembelian->where('tanggal_pembelian', '<=', $request->to);
        }
        if($request->id_supplier){
            $pembelian->where('supplier_id', '=', $request->id_supplier);
        }
        if($request->jenis_id){
            $pembelian->where('jenis_id', $request->jenis_id);
        }
        if($request->id_produk){
            $pembelian->where('nama_produk', $request->id_produk);
        }
        if($request->id_pegawai){
            $pembelian->where('id', $request->id_pegawai);
        }
        if($request->id_kategori){
            $pembelian->where('id_kategori', $request->id_kategori);
        }
        $pembelian = $pembelian->get();
        $total = $pembelian->sum('grand_total');
        $jumlah = $pembelian->count('id_produk');


        if(count($pembelian) == 0){
            Alert::warning('Tidak Ditemukan Data', 'Data yang Anda Cari Tidak Ditemukan');
            return redirect()->back();
        }else{
            $pdf = Pdf::loadview('pdf.pembelian.seluruh.pembelian_seluruh_pdf',['pembelian'=>$pembelian, 'total' =>$total,'jumlah' => $jumlah]);
    	    return $pdf->download('Pembelian-Keseluruhan.pdf');
        }
    }

    public function excel(Request $request)
    {
        $pembelian = Pembelian::where('status','Diterima')->join('tb_detail_pembelian','tb_pembelian.id_pembelian','tb_detail_pembelian.id_pembelian')
        ->join('tb_master_produk', 'tb_detail_pembelian.id_produk','tb_master_produk.id_produk')
        ->join('tb_master_supplier','tb_pembelian.supplier_id','tb_master_supplier.id_supplier')
        ->leftjoin('tb_master_jenis_supplier', 'tb_master_supplier.jenis_id','tb_master_jenis_supplier.id_jenis_supplier')
        ->leftjoin('tb_master_kategori', 'tb_master_produk.kategori_id','tb_master_kategori.id_kategori');
        if($request->from){
            $pembelian->where('tanggal_pembelian', '>=', $request->from);
        }
        if($request->to){
            $pembelian->where('tanggal_pembelian', '<=', $request->to);
        }
        if($request->id_supplier){
            $pembelian->where('supplier_id', '=', $request->id_supplier);
        }
        if($request->jenis_id){
            $pembelian->where('jenis_id', $request->jenis_id);
        }
        if($request->id_produk){
            $pembelian->where('nama_produk', $request->id_produk);
        }
        if($request->id_pegawai){
            $pembelian->where('id', $request->id_pegawai);
        }
        if($request->id_kategori){
            $pembelian->where('id_kategori', $request->id_kategori);
        }
        $pembelian = $pembelian->get();
        $grand_total = $pembelian->sum('grand_total');
        $total_produk = $pembelian->count('id_produk');


        if(count($pembelian) == 0){
            Alert::warning('Tidak Ditemukan Data', 'Data yang Anda Cari Tidak Ditemukan');
            return redirect()->back();
        }else{
            return new ExcelPembelian($pembelian, $grand_total);
        }
  
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
