<?php

namespace App\Http\Controllers\Penjualan;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Master\Produk;
use App\Exports\ExcelPenjualan;
use App\Models\Master\Category;
use App\Models\Master\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Penjualan\Penjualan;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

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

        $customer = Customer::get();
        $produk = Produk::select('nama_produk')->groupBy('nama_produk')->get();
        $kategori = Category::get();
        $pegawai = User::get();

        return view('pages.penjualan.laporan.seluruh.index', compact('penjualan','jumlah','total','today','tanggal',
            'customer','produk','kategori','pegawai'
    
        ));
    }
    
    public function reset_tanggal()
    {
        return redirect()->route('laporan-penjualan.index');
    }

    public function penjualan_seluruh_Pdf(Request $request)
    {
        $penjualan = Penjualan::join('tb_detail_penjualan','tb_penjualan.id_penjualan','tb_detail_penjualan.id_penjualan')
        ->join('tb_master_produk', 'tb_detail_penjualan.id_produk','tb_master_produk.id_produk')
        ->join('tb_master_customer','tb_penjualan.customer_id','tb_master_customer.id_customer')
        ->leftjoin('tb_master_kategori', 'tb_master_produk.kategori_id','tb_master_kategori.id_kategori');
        if($request->from){
            $penjualan->where('tanggal_pembelian', '>=', $request->from);
        }
        if($request->to){
            $penjualan->where('tanggal_pembelian', '<=', $request->to);
        }
        if($request->id_customer){
            $penjualan->where('customer_id', '=', $request->id_customer);
        }
        if($request->kode){
            $penjualan->where('code', $request->kode);
        }
        if($request->id_produk){
            $penjualan->where('nama_produk', $request->id_produk);
        }
        if($request->id_pegawai){
            $penjualan->where('id', $request->id_pegawai);
        }
        if($request->id_kategori){
            $penjualan->where('id_kategori', $request->id_kategori);
        }
        $penjualan = $penjualan->get();
        $jumlah = $penjualan->sum('grand_total');
        $total = $penjualan->count('id_produk');

        if(count($penjualan) == 0){
            Alert::warning('Tidak Ditemukan Data', 'Data yang Anda Cari Tidak Ditemukan');
            return redirect()->back();
        }else{
            $pdf = Pdf::loadview('pdf.penjualan.seluruh.penjualan_seluruh_pdf',['penjualan'=>$penjualan, 'total' =>$total,'jumlah' => $jumlah]);
            return $pdf->download('Penjualan-Keseluruhan.pdf');
        }

       
    }

    public function excel(Request $request)
    {
        $penjualan = Penjualan::join('tb_detail_penjualan','tb_penjualan.id_penjualan','tb_detail_penjualan.id_penjualan')
        ->join('tb_master_produk', 'tb_detail_penjualan.id_produk','tb_master_produk.id_produk')
        ->join('tb_master_customer','tb_penjualan.customer_id','tb_master_customer.id_customer')
        ->leftjoin('tb_master_kategori', 'tb_master_produk.kategori_id','tb_master_kategori.id_kategori');
        if($request->from_date_export){
            $penjualan->where('tanggal_penjualan', '>=', $request->from_date_export);
        }
        if($request->to_date_export){
            $penjualan->where('tanggal_penjualan', '<=', $request->to_date_export);
        }
        if($request->id_customer){
            $penjualan->where('customer_id', '=', $request->id_customer);
        }
        if($request->kode){
            $penjualan->where('code', $request->kode);
        }
        if($request->id_produk){
            $penjualan->where('nama_produk', $request->id_produk);
        }
        if($request->id_pegawai){
            $penjualan->where('id', $request->id_pegawai);
        }
        if($request->id_kategori){
            $penjualan->where('id_kategori', $request->id_kategori);
        }
        $penjualan = $penjualan->get();

        $produk = Penjualan::join('tb_detail_penjualan','tb_penjualan.id_penjualan','tb_detail_penjualan.id_penjualan')
        ->join('tb_master_produk', 'tb_detail_penjualan.id_produk','tb_master_produk.id_produk')
        ->join('tb_master_customer','tb_penjualan.customer_id','tb_master_customer.id_customer')
        ->leftjoin('tb_master_kategori', 'tb_master_produk.kategori_id','tb_master_kategori.id_kategori')
        ->selectRaw('nama_produk as nama, SUM(jumlah_jual) as jumlah')
        ->groupBy('nama_produk');
        if($request->from_date_export){
            $produk->where('tanggal_penjualan', '>=', $request->from_date_export);
        }
        if($request->to_date_export){
            $produk->where('tanggal_penjualan', '<=', $request->to_date_export);
        }
        if($request->id_customer){
            $produk->where('customer_id', '=', $request->id_customer);
        }
        if($request->kode){
            $produk->where('code', $request->kode);
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
        $produk = $produk->get();
        
        if(count($penjualan) == 0 && count($produk) == 0){
            Alert::warning('Tidak Ditemukan Data', 'Data yang Anda Cari Tidak Ditemukan');
            return redirect()->back();
        }else{
            if($request->radio_input == 'pdf'){
                $pdf = Pdf::loadview('pdf.penjualan.seluruh.penjualan_seluruh_pdf',['penjualan'=>$penjualan, 'produk' =>$produk]);
               
                if($request->from_date_export && $request->to_date_export){
                    return $pdf->download('Laporan-Penjualan '.$request->from_date_export.' - '.$request->to_date_export.' .pdf');
                }else{
                    return $pdf->download('Laporan-Penjualan-Keseluruhan.pdf');
                }
               
                Alert::success('Berhasil', 'Laporan Penjualan Berhasil Didownload');
            }else{
                if($request->from_date_export && $request->to_date_export){
                    return Excel::download(new ExcelPenjualan($penjualan, $produk), 'Laporan-Penjualan '.$request->from_date_export.' - '.$request->to_date_export.' .xlsx');
                }else{
                    return Excel::download(new ExcelPenjualan($penjualan, $produk), 'Laporan-Penjualan-Keseluruhan.xlsx');
                }
            }
            Alert::success('Berhasil', 'Laporan Penjualan Berhasil Didownload');
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
