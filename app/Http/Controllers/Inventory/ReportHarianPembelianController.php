<?php

namespace App\Http\Controllers\Inventory;

use App\Exports\ExcelPembelianHarian;
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

class ReportHarianPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembelian = Pembelian::where('tanggal_pembelian', Carbon::now()->format('Y-m-d'))->where('status','Diterima')->OrderBy('updated_at','DESC')->get();
        $total = Pembelian::where('tanggal_pembelian', Carbon::now()->format('Y-m-d'))->where('status','Diterima')->sum('grand_total');
        $jumlah = Pembelian::where('tanggal_pembelian', Carbon::now()->format('Y-m-d'))->where('status','Diterima')->count();
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');

        $jenis = JenisSupplier::get();
        $supplier = Supplier::get();
        $pegawai = User::get();
        $produk = Produk::get();
        $kategori = Category::get();

        return view('pages.inventory.laporan.harian.harianpembelian', compact('pembelian','total',
            'jumlah','today','tanggal','jenis','supplier','pegawai','produk','kategori'));
    }

    public function pembelian_harian_Pdf(Request $request)
    {

        $pembelian = Pembelian::with('Pegawai')->where('status','Diterima')->join('tb_detail_pembelian','tb_pembelian.id_pembelian','tb_detail_pembelian.id_pembelian')
        ->join('tb_master_produk', 'tb_detail_pembelian.id_produk','tb_master_produk.id_produk')
        ->join('tb_master_supplier','tb_pembelian.supplier_id','tb_master_supplier.id_supplier')
        ->leftjoin('tb_master_jenis_supplier', 'tb_master_supplier.jenis_id','tb_master_jenis_supplier.id_jenis_supplier')
        ->leftjoin('tb_master_kategori', 'tb_master_produk.kategori_id','tb_master_kategori.id_kategori');
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
        $pembelian = $pembelian->where('tanggal_pembelian', Carbon::now()->format('Y-m-d'))->orderBy('tanggal_pembelian','DESC')->get();
      


        $produk = Pembelian::with('Pegawai')->where('status','Diterima')->join('tb_detail_pembelian','tb_pembelian.id_pembelian','tb_detail_pembelian.id_pembelian')
        ->join('tb_master_produk', 'tb_detail_pembelian.id_produk','tb_master_produk.id_produk')
        ->join('tb_master_supplier','tb_pembelian.supplier_id','tb_master_supplier.id_supplier')
        ->leftjoin('tb_master_jenis_supplier', 'tb_master_supplier.jenis_id','tb_master_jenis_supplier.id_jenis_supplier')
        ->leftjoin('tb_master_kategori', 'tb_master_produk.kategori_id','tb_master_kategori.id_kategori')
        ->selectRaw('nama_produk as nama, SUM(jumlah_order) as jumlah')
        ->groupBy('nama_produk');
        if($request->id_supplier){
            $produk->where('supplier_id', '=', $request->id_supplier);
        }
        if($request->jenis_id){
            $produk->where('jenis_id', $request->jenis_id);
        }
        if($request->id_produk){
            $produk->where('nama_produk', $request->id_produk);
        }
        if($request->id_pegawai){
            $produk->where('id', $request->id_pegawai);
        }
        if($request->id_kategori){
            $produk->where('id_kategori', $request->id_kategori);
        }
        $produk = $produk->where('tanggal_pembelian', Carbon::now()->format('Y-m-d'))->get();
      
        $hari = Carbon::now()->format('d-M-Y');
            
        if(count($pembelian) == 0 && count($produk) == 0){
            Alert::warning('Tidak Ditemukan Data', 'Data yang Anda Cari Tidak Ditemukan');
            return redirect()->back();
        }else{
            if($request->radio_input == 'pdf'){
                $pdf = Pdf::loadview('pdf.pembelian.harian.pembelian_harian_pdf',['pembelian'=>$pembelian, 'produk' =>$produk, 'hari' => $hari]);
                return $pdf->download('pembelian-tanggal '.$hari.'.pdf');
               
                Alert::success('Berhasil', 'Data Transaksi Berhasil Didownload');
            }else{
                return Excel::download(new ExcelPembelianHarian($pembelian, $produk ,$hari), 'pembelian-tanggal'.$hari.'.xlsx');
                // return new ExcelPembelianHarian($pembelian, $produk ,$hari);
            }
            Alert::success('Berhasil', 'Data Pembelian Hari Ini Berhasil Didownload');
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

        return view('pages.inventory.laporan.harian.detail', compact('item','penerimaan','today','tanggal'));
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
