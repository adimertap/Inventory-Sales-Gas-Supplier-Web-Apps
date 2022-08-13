<?php

namespace App\Http\Controllers\Inventory;

use App\Exports\ExcelKartuGabungan;
use App\Exports\ExcelKartuPenerimaan;
use App\Exports\ExcelKartuPenjualan;
use App\Exports\ExcelPenjualan;
use App\Http\Controllers\Controller;
use App\Models\Inventory\KartuGudang;
use App\Models\Master\Category;
use App\Models\Master\Produk;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KartuGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::get();
        $today = Carbon::now()->isoFormat('dddd');
        $tanggal = Carbon::now()->format('j F Y');

        $pegawai = User::get();
        $produk = Produk::get();
        $kategori = Category::get();


        return view('pages.inventory.kartugudang.index', compact('produk','today','tanggal'
            ,'produk','pegawai','kategori'
        ));
    }

    public function cetak_pdf()
    {
        $produk = Produk::all();
 
    	$pdf = Pdf::loadview('pdf.kartu_pdf',['produk'=>$produk]);
    	return $pdf->download('laporan-stok.pdf');
    }

    public function cetak_detail_pdf($id)
    {
        $kartu = KartuGudang::where('id_produk', $id)->get();
        $produk = Produk::find($id);

        $pdf = Pdf::loadview('pdf.kartu_pdf_detail',['kartu'=>$kartu], ['produk'=>$produk]);
    	return $pdf->download('laporan-kartu-stok.pdf');
    }

    public function cetak_kartu_penerimaan_pdf($id)
    {
        $kartu = KartuGudang::where('id_produk', $id)->where('jenis_kartu','Penerimaan')->get();
        $produk = Produk::find($id);

        $pdf = Pdf::loadview('pdf.kartu_pdf_penerimaan',['kartu'=>$kartu], ['produk'=>$produk]);
    	return $pdf->download('laporan-kartu-stok-penerimaan.pdf');
    }

    public function cetak_kartu_penjualan_pdf($id)
    {
        $kartu = KartuGudang::where('id_produk', $id)->where('jenis_kartu','Penjualan')->get();
        $produk = Produk::find($id);

        $pdf = Pdf::loadview('pdf.kartu_pdf_penjualan',['kartu'=>$kartu], ['produk'=>$produk]);
    	return $pdf->download('laporan-kartu-stok-penjualan.pdf');
    }

    public function excel(Request $request)
    {
      
        $kartu = KartuGudang::join('tb_master_produk', 'tb_kartu_gudang.id_produk','tb_master_produk.id_produk')
        ->leftjoin('tb_master_kategori', 'tb_master_produk.kategori_id','tb_master_kategori.id_kategori');
        if($request->from){
            $kartu->where('tanggal_transaksi', '>=', $request->from);
        }
        if($request->to){
            $kartu->where('tanggal_transaksi', '<=', $request->to);
        }
        if($request->id_produk){
            $kartu->where('nama_produk', $request->id_produk);
        }
        if($request->id_pegawai){
            $kartu->where('id', $request->id_pegawai);
        }
        if($request->id_kategori){
            $kartu->where('id_kategori', $request->id_kategori);
        }
        if($request->filter_kartu == 'Penjualan'){
            $kartu->where('jenis_kartu', '=', 'Penjualan');
        }
        if($request->filter_kartu == 'Penerimaan'){
            $kartu->where('jenis_kartu', '=', 'Penerimaan');
        } 
        $kartu = $kartu->get();
        // return $kartu;
        if(count($kartu) == 0){
            Alert::warning('Tidak Ditemukan Data', 'Data yang Anda Cari Tidak Ditemukan');
            return redirect()->back();
        }else{
            if($request->filter_kartu == 'Penjualan'){
                return new ExcelKartuPenjualan($kartu);
            }elseif($request->filter_kartu == 'Penerimaan'){
                return new ExcelKartuPenerimaan($kartu);
            }else{
                return new ExcelKartuGabungan($kartu);
            }
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
        $produk = Produk::with('Kategori')->find($id);
        $kartu_keseluruhan = KartuGudang::with('Produk','Supplier')->where('id_produk', $id)->orderBy('tanggal_transaksi','DESC')->get();
        $tanggal = Carbon::now()->format('F Y');

        return view('pages.inventory.kartugudang.detail', compact('kartu_keseluruhan', 'tanggal','produk'));
    }

    public function penerimaan($id)
    {
        $produk = Produk::with('Kategori')->find($id);
        $kartu_penerimaan = KartuGudang::with('Produk','Supplier')->where('id_produk', $id)->where('jenis_kartu','Penerimaan')->orderBy('tanggal_transaksi','DESC')->get();

        return view('pages.inventory.kartugudang.kartu-penerimaan', compact('produk','kartu_penerimaan'));
    }

    public function penjualan($id)
    {
        $produk = Produk::with('Kategori')->find($id);
        $kartu_penjualan = KartuGudang::with('Produk','Supplier')->where('id_produk', $id)->where('jenis_kartu','Penjualan')->orderBy('tanggal_transaksi','DESC')->get();

        return view('pages.inventory.kartugudang.kartu-penjualan', compact('produk','kartu_penjualan'));
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
        $produk = Produk::find($id);
        $produk->stok = 0;
        $produk->status_jumlah = "Habis";
        $produk->save();

        $kartu = KartuGudang::where('id_produk', $id)->get();
        foreach($kartu as $item){
            $item = KartuGudang::where('id_produk', $id)->first();
            $item->delete();
        }

        Alert::success('Sukses', 'Reset Stok Berhasil Dilakukan, Cek Kembali');
        return redirect()->back();
    }
}
