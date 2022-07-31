<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Mail\MailCustomer;
use App\Models\Inventory\KartuGudang;
use App\Models\Master\Customer;
use App\Models\Master\Produk;
use App\Models\Penjualan\DetailPenjualan;
use App\Models\Penjualan\Penjualan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = Penjualan::where('id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        $penjualan_hari = Penjualan::where('id', Auth::user()->id)->where('tanggal_penjualan', Carbon::now()->format('Y-m-d'))->count();
        $total = Penjualan::where('id', Auth::user()->id)->sum('grand_total');

        return view('pages.penjualan.penjualan.index', compact('penjualan','penjualan_hari','total'));
    }

    public function penjualan_pdf($id)
    {
        $penjualan = Penjualan::with('Detail','Customer')->find($id);
        $pdf = Pdf::loadview('pdf.penjualan.penjualan_pdf',['penjualan'=>$penjualan]);
    	return $pdf->download('Penjualan.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = Customer::get();
        $produk = Produk::with('Kategori','Kartugudangterakhir')->get();
        $pegawai = User::where('role','!=','Owner')->get();

        $id = Penjualan::getId();
        foreach($id as $value);
        $idlama = $value->id_penjualan;
        $idbaru = $idlama + 1;
        $blt = date('y-m');
        $kode_penjualan = 'PJ'.$blt.'-'.$idbaru;

        return view('pages.penjualan.penjualan.create', compact('customer','kode_penjualan','idbaru','produk','pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $penjualan = new Penjualan();
        $penjualan->id = $request->id;
        $penjualan->kode_penjualan = $request->kode_penjualan;
        $penjualan->tanggal_penjualan = $request->tanggal_penjualan;
        $penjualan->id_penjualan = $request->id_penjualan;
        $penjualan->customer_id = $request->id_customer;
        $penjualan->status_bayar = $request->status_bayar;
        $total_keseluruhan = 0;
        $penjualan->save();

        foreach($request->detail as $key=>$item){
            $total_keseluruhan = $total_keseluruhan + $item['total_jual'];
            $produk = Produk::where('id_produk', $item['id_produk'])->first();
            $produk->stok = $produk->stok - $item['jumlah_jual'];
            if($produk->stok >= $produk->jumlah_minimal){
                $produk->status_jumlah = 'Cukup';
            }else if($produk->stok == 0){
                $produk->status_jumlah = 'Habis';
            }else if($produk->stok < 0){
                $produk->status_jumlah = 'Min';
            }else{
                $produk->status_jumlah = 'Kurang';
            }
            $produk->save();

            $kartu = new KartuGudang();
            $kartugudangterakhir = $produk->Kartugudangsaldoakhir;
            if($kartugudangterakhir != null){
                $kartu->saldo_akhir = $kartugudangterakhir->saldo_akhir + $item['jumlah_jual'];
            }
            if($kartugudangterakhir == null)
                $kartu->saldo_akhir = $item['jumlah_jual'];
            $kartu->kode_transaksi = $penjualan->kode_penjualan;
            $kartu->tanggal_transaksi = $penjualan->tanggal_penjualan;
            $kartu->jumlah_keluar = $kartu->jumlah_keluar + $item['jumlah_jual'];
            $kartu->harga_jual = $kartu->harga_jual + $item['harga_jual'];
            $kartu->id_customer = $penjualan->Customer->id_customer;
            $kartu->id_produk = $item['id_produk'];
            $kartu->jenis_kartu = 'Penjualan';
            $kartu->save();
        }

        $penjualan = Penjualan::find($penjualan->id_penjualan);
        $penjualan->grand_total = $total_keseluruhan;
        $penjualan->update();
        $penjualan->Detail()->sync($request->detail);

        Alert::success('Sukses', 'Data Penjualan Berhasil Ditambahkan dan Dikirim Via Email');
        return $request;
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaksi = Penjualan::with('Detail','Customer')->find($id);
        return view('pages.penjualan.penjualan.detail', compact('transaksi'));
    }

    public function bayar($id)
    {
        $item = Penjualan::find($id);
        $item->status_bayar = "Dibayar";
        $item->save();
        Alert::success('Sukses', 'Data Penjualan Lunas, Terima Kasih');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Penjualan::with('Detail','Customer','Pegawai')->find($id);
        $customer = Customer::get();
        $produk = Produk::with('Kategori','Kartugudangterakhir')->get();
        $pegawai = User::where('role','!=','Owner')->get();

        return view('pages.penjualan.penjualan.edit', compact('pegawai','item','customer','produk'));
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
        $penjualan = Penjualan::find($id);
        $penjualan->tanggal_penjualan = $request->tanggal_penjualan;
        $penjualan->status_bayar = $request->status_bayar;
        $penjualan->id = $request->id;
        $total_penjualan = 0;

        foreach($request->detail as $key=>$item){
            $total_penjualan = $total_penjualan + $item['total_jual'];
            // MASTER PRODUK
            $detail_jual = DetailPenjualan::where('id_penjualan', $penjualan->id_penjualan)->where('id_produk', $item['id_produk'])->first();

            $produk = Produk::where('id_produk', $item['id_produk'])->first();
            $hitung_produk = $detail_jual['jumlah_jual'] - $produk->stok;
            $hitung_tes = $hitung_produk + $item['jumlah_jual'];
            $produk->stok = $produk->stok + $hitung_tes;

            if($produk->stok >= $produk->jumlah_minimal){
                $produk->status_jumlah = 'Cukup';
            }else if($produk->stok == 0){
                $produk->status_jumlah = 'Habis';
            }else{
                $produk->status_jumlah = 'Kurang';
            }
            $produk->save();

            // KARTU GUDANG
            $kartu = KartuGudang::where('id_produk', $item['id_produk'])->where('kode_transaksi', $penjualan->kode_penjualan)->first();
       
            $pengurangan = $detail_jual['jumlah_jual'] - $kartu->saldo_akhir;
            $hitung_jumlah = $pengurangan + $item['jumlah_jual'];
            $kartu->saldo_akhir = $kartu->saldo_akhir + $hitung_jumlah;
           
            $kartu->tanggal_transaksi = $penjualan->tanggal_penjualan;
            $kartu->jumlah_keluar = $item['jumlah_jual'];
            $kartu->harga_jual = $item['harga_jual'];
            $kartu->update();
        }

        $penjualan->grand_total = $total_penjualan;
        $penjualan->update();
        $penjualan->Detail()->sync($request->detail);

        if($request->status_bayar == 'Pending'){
            Alert::success('Sukses', 'Data Pembelian Berhasil Diupdate, Mohon Pembayaran Segera Diproses');
        }else{
            Alert::success('Sukses', 'Data Pembelian Berhasil Diupdate dan Lunas');
        }
        
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);

        foreach($penjualan->detail as $key=>$item){
            $produk = Produk::where('id_produk', $item['id_produk'])->first();
            $produk->stok = $produk->stok - $item->pivot['jumlah_jual'];
            
            if($produk->stok >= $produk->jumlah_minimal){
                $produk->status_jumlah = 'Cukup';
            }else if($produk->stok == 0){
                $produk->status_jumlah = 'Habis';
            }else{
                $produk->status_jumlah = 'Kurang';
            }
            $produk->save();

            // KARTU GUDANG
            $kartu = KartuGudang::where('id_produk', $item['id_produk'])->where('kode_transaksi', $penjualan->kode_penjualan)->first();
            $kartugudangterakhir = $produk->Kartugudangsaldoakhir;
            $kartugudangterakhir->saldo_akhir = $kartugudangterakhir->saldo_akhir - $item['jumlah_jual'];
            $kartugudangterakhir->save();
            $kartu->delete();
            
            $detail_penjualan = DetailPenjualan::where('id_penjualan', $penjualan->id_penjualan)->where('id_produk', $item['id_produk'])->first();
            $detail_penjualan->delete();    
        }
        $penjualan->delete();
        Alert::success('Sukses', 'Data Penjualan Berhasil Dihapu, Stok Anda Terlihat Terkendali');
        return redirect()->back();
    }
}
