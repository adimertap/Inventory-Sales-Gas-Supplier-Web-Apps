<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\DetailPembelian;
use App\Models\Inventory\DetailPenerimaan;
use App\Models\Inventory\KartuGudang;
use App\Models\Inventory\Pembelian;
use App\Models\Inventory\Penerimaan;
use App\Models\Master\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PenerimaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penerimaan = Penerimaan::orderBy('tanggal_penerimaan','DESC')->get();
        $pembelian = Pembelian::where('status','Dikirim')->orderBy('tanggal_pembelian','DESC')->get();
        $count = Penerimaan::where('tanggal_penerimaan', Carbon::now()->format('Y-m-d'))->count();
        $count_proses = Pembelian::where('status','Dikirim')->count();

        return view('pages.inventory.penerimaan.index', compact('penerimaan','pembelian','count','count_proses'));
    }

    
    public function bayar($id)
    {
        $item = Penerimaan::find($id);
        $item->status_pembayaran = "Dibayar";
        $item->save();
        Alert::success('Sukses', 'Data Penerimaan Berhasil Dibayarkan, Terima Kasih');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Code
    }

    public function proses($id_pembelian)
    {
        $pembelian = Pembelian::with('Detail','Supplier','Pegawai')->find($id_pembelian);
        $id = Penerimaan::getId();
        foreach($id as $value);
        $idlama = $value->id_penerimaan;
        $idbaru = $idlama + 1;
        $blt = date('y-m');
        $kode_penerimaan = 'RCV'.$blt.'-'.$idbaru;

        return view('pages.inventory.penerimaan.create', compact('pembelian','idbaru','kode_penerimaan'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pembelian = Pembelian::find($request->id_pembelian);
        $penerimaan = new Penerimaan();
        $penerimaan->id = Auth::user()->id;
        $penerimaan->kode_penerimaan = $request->kode_penerimaan;
        $penerimaan->tanggal_penerimaan = $request->tanggal_penerimaan;
        $penerimaan->id_pembelian = $request->id_pembelian;
        $penerimaan->status_pembayaran = $request->status_pembayaran;
        $total_penerimaan = 0;
        $total_pembelian = $pembelian->grand_total;
        $qtyrcv = 0;
        $qtypo = 0;

        foreach($request->detail as $key=>$item){
            $total_penerimaan = $total_penerimaan + $item['total_diterima'];
            $total_pembelian = $total_pembelian + $item['total_diterima'];
            
            // MASTER PRODUK
            $produk = Produk::where('id_produk', $item['id_produk'])->first();
            $produk->stok = $produk->stok + $item['jumlah_diterima'];
            if($produk->stok >= $produk->jumlah_minimal){
                $produk->status_jumlah = 'Cukup';
            }else if($produk->stok == 0){
                $produk->status_jumlah = 'Habis';
            }else{
                $produk->status_jumlah = 'Kurang';
            }
            $produk->save();

            // KARTU GUDANG
            $kartu = new KartuGudang();
            $kartugudangterakhir = $produk->Kartugudangsaldoakhir;
            if($kartugudangterakhir != null){
                $kartu->saldo_akhir = $kartugudangterakhir->saldo_akhir + $item['jumlah_diterima'];
            }
            if($kartugudangterakhir == null)
                $kartu->saldo_akhir = $item['jumlah_diterima'];
            $kartu->kode_transaksi = $penerimaan->kode_penerimaan;
            $kartu->tanggal_transaksi = $penerimaan->tanggal_penerimaan;
            $kartu->jumlah_masuk = $kartu->jumlah_masuk + $item['jumlah_diterima'];
            $kartu->harga_beli = $kartu->harga_beli + $item['harga_diterima'];
            $kartu->id_supplier = $pembelian->Supplier->id_supplier;
            $kartu->id_produk = $item['id_produk'];
            $kartu->jenis_kartu = 'Penerimaan';
            $kartu->save();

            // DETAIL PEMBELIAN
            $detailpembelian = DetailPembelian::where('id_pembelian', $pembelian->id_pembelian)->where('id_produk', $item['id_produk'])->first();
            $detailpembelian->qty_sementara = $detailpembelian->qty_sementara - $item['jumlah_diterima'];
            $detailpembelian->save();
            
            // CHECK AMOUNT QTY PEMBELIAN DAN QTY PENERIMAAN UNTUK STATUS
            $qtyrcv = $qtyrcv + $item['jumlah_diterima'];
            $qtypo = $qtypo + $item['jumlah_order'];
        }

        if($qtyrcv != $qtypo){
            $pembelian->status ='Dikirim';
        }else{
            $pembelian->status ='Diterima';
        }
        $pembelian->grand_total = $total_pembelian;
        $pembelian->save();

        $penerimaan->grand_total = $total_penerimaan;
        $penerimaan->save();
        $penerimaan->Detail()->sync($request->detail);

        if($request->status_pembayaran == 'Pending'){
            Alert::success('Sukses', 'Data Pembelian Berhasil Diproses, Mohon Segera Melakukan Pembayaran');
        }else{
            Alert::success('Sukses', 'Data Pembelian Berhasil Diproses dan Lunas');
        }
        
        return $request;
    }


    public function lengkap(Request $request, $id)
    {
        $id = Penerimaan::getId();
        foreach($id as $value);
        $idlama = $value->id_penerimaan;
        $idbaru = $idlama + 1;
        $blt = date('y-m');
        $kode_penerimaan = 'RCV'.$blt.'-'.$idbaru;

        $pembelian = Pembelian::with('Detail')->find($request->id);
        $penerimaan = new Penerimaan();
        $penerimaan->id = Auth::user()->id;
        $penerimaan->kode_penerimaan = $kode_penerimaan;
        $penerimaan->tanggal_penerimaan = Carbon::now();
        $penerimaan->id_pembelian = $request->id;
        $penerimaan->status_pembayaran ='Pending';
        $total_penerimaan = 0;
        $penerimaan->save();

            foreach($pembelian->detail as $key=>$item){
                $det = DetailPenerimaan::where('kode_pembelian', $pembelian->kode_pembelian)->where('id_produk', $item['id_produk'])->first();
                if(empty($det)){
                    $total_penerimaan = $total_penerimaan + $item->pivot['total_order'];
                    // MASTER PRODUK
                    $produk = Produk::where('id_produk', $item['id_produk'])->first();
                    $produk->stok = $produk->stok + $item->pivot['jumlah_order'];
                    if($produk->stok >= $produk->jumlah_minimal){
                        $produk->status_jumlah = 'Cukup';
                    }else if($produk->stok == 0){
                        $produk->status_jumlah = 'Habis';
                    }else{
                        $produk->status_jumlah = 'Kurang';
                    }
                    $produk->save();
        
                    // KARTU GUDANG
                    $kartu = new KartuGudang();
                    $kartugudangterakhir = $produk->Kartugudangsaldoakhir;
                    if($kartugudangterakhir != null){
                        $kartu->saldo_akhir = $kartugudangterakhir->saldo_akhir + $item->pivot['jumlah_order'];
                    }
                    if($kartugudangterakhir == null)
                        $kartu->saldo_akhir = $item->pivot['jumlah_order'];
                    $kartu->kode_transaksi = $penerimaan->kode_penerimaan;
                    $kartu->tanggal_transaksi = $penerimaan->tanggal_penerimaan;
                    $kartu->jumlah_masuk = $kartu->jumlah_masuk + $item->pivot['jumlah_order'];
                    $kartu->harga_beli = $kartu->harga_beli + $item->pivot['harga_beli'];
                    $kartu->id_supplier = $pembelian->Supplier->id_supplier;
                    $kartu->id_produk = $item['id_produk'];
                    $kartu->jenis_kartu = 'Penerimaan';
                    $kartu->save();
        
                    // DETAIL PEMBELIAN
                    $detailpembelian = DetailPembelian::where('id_pembelian', $pembelian->id_pembelian)->where('id_produk', $item['id_produk'])->first();
                    $detailpembelian->qty_sementara = $detailpembelian->qty_sementara - $item->pivot['jumlah_order'];
                    $detailpembelian->save();
        
                    $detail = new DetailPenerimaan;
                    $detail->id_penerimaan = $penerimaan->id_penerimaan;
                    $detail->id_produk = $item['id_produk'];
                    $detail->jumlah_order = $item->pivot['jumlah_order'];
                    $detail->jumlah_diterima = $item->pivot['jumlah_order'];
                    $detail->harga_diterima = $item->pivot['harga_beli'];
                    $detail->total_diterima = $item->pivot['total_order'];
                    $detail->kode_pembelian = $pembelian->kode_pembelian;
                    $detail->save();
                }else{
                    $tes123 = $item->pivot['total_order'] - $det['total_diterima'];
                    $total_penerimaan = $total_penerimaan + $tes123;
                    // MASTER PRODUK
                    $produk = Produk::where('id_produk', $det['id_produk'])->first();
                    $produk->stok = $produk->stok + $item->pivot['qty_sementara'];
                    if($produk->stok >= $produk->jumlah_minimal){
                        $produk->status_jumlah = 'Cukup';
                    }else if($produk->stok == 0){
                        $produk->status_jumlah = 'Habis';
                    }else{
                        $produk->status_jumlah = 'Kurang';
                    }
                    $produk->save();
        
                    // KARTU GUDANG
                    $kartu = new KartuGudang();
                    $kartugudangterakhir = $produk->Kartugudangsaldoakhir;
                    if($kartugudangterakhir != null){
                        $kartu->saldo_akhir = $kartugudangterakhir->saldo_akhir + $item->pivot['qty_sementara'];
                    }
                    if($kartugudangterakhir == null)
                        $kartu->saldo_akhir = $item->pivot['qty_sementara'];
                    $kartu->kode_transaksi = $penerimaan->kode_penerimaan;
                    $kartu->tanggal_transaksi = $penerimaan->tanggal_penerimaan;
                    $kartu->jumlah_masuk = $kartu->jumlah_masuk + $item->pivot['qty_sementara'];
                    $kartu->harga_beli = $kartu->harga_beli + $item->pivot['harga_beli'];
                    $kartu->id_supplier = $pembelian->Supplier->id_supplier;
                    $kartu->id_produk = $det['id_produk'];
                    $kartu->jenis_kartu = 'Penerimaan';
                    $kartu->save();
        
                    // DETAIL PEMBELIAN
                    $detailpembelian = DetailPembelian::where('id_pembelian', $pembelian->id_pembelian)->where('id_produk', $det['id_produk'])->first();
                    $detailpembelian->qty_sementara = $detailpembelian->qty_sementara - $item->pivot['qty_sementara'];
                    $detailpembelian->save();
        
                    $detail = new DetailPenerimaan;
                    $detail->id_penerimaan = $penerimaan->id_penerimaan;
                    $detail->id_produk = $det['id_produk'];
                    $detail->jumlah_order = $item->pivot['qty_sementara'];
                    $detail->jumlah_diterima = $item->pivot['qty_sementara'];
                    $detail->harga_diterima = $item->pivot['harga_beli'];
                    $detail->total_diterima = $item->pivot['total_order'] - $det['total_diterima'];
                    $detail->kode_pembelian = $pembelian->kode_pembelian;
                    $detail->save();
                }
            }
        

        $pembelian->status ='Diterima';
        $pembelian->save();

        $tes = Penerimaan::find($penerimaan->id_penerimaan);
        $tes->grand_total = $total_penerimaan;
        $tes->save();

        Alert::success('Sukses', 'Data Pembelian Berhasil Diproses dan Lunas');
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
        $transaksi = Penerimaan::with('Detail','Pembelian')->find($id);
        return view('pages.inventory.penerimaan.detail', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penerimaan = Penerimaan::with('Detail','Pembelian')->find($id);
        $total_produk = Pembelian::join('tb_detail_pembelian','tb_pembelian.id_pembelian','tb_detail_pembelian.id_pembelian')->count();
        

        return view('pages.inventory.penerimaan.edit', compact('penerimaan','total_produk'));
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
        $pembelian = Pembelian::find($request->id_pembelian);
        $penerimaan = Penerimaan::find($id);
        $penerimaan->tanggal_penerimaan = $request->tanggal_penerimaan;
        $penerimaan->status_pembayaran = $request->status_pembayaran;
        $total_penerimaan = 0;
        $total_pembelian = $pembelian->grand_total;
        $qtyrcv = 0;
        $qtypo = 0;

        foreach($request->detail as $key=>$item){
            $total_penerimaan = $total_penerimaan + $item['total_diterima'];
            $total_pembelian = $total_pembelian + $item['total_diterima'];
            // MASTER PRODUK
            $detail = DetailPenerimaan::where('id_penerimaan', $penerimaan->id_penerimaan)->where('id_produk', $item['id_produk'])->first();

            $produk = Produk::where('id_produk', $item['id_produk'])->first();
            $hitung_produk = $detail['jumlah_diterima'] - $produk->stok;
            $hitung_tes = $hitung_produk + $item['jumlah_diterima'];
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
            $kartu = KartuGudang::where('id_produk', $item['id_produk'])->where('kode_transaksi', $penerimaan->kode_penerimaan)->first();
            $pengurangan = $detail['jumlah_diterima'] - $kartu->saldo_akhir;
            $hitung_jumlah = $pengurangan + $item['jumlah_diterima'];
            $kartu->saldo_akhir = $kartu->saldo_akhir + $hitung_jumlah;

            $kartu->tanggal_transaksi = $penerimaan->tanggal_penerimaan;
            $kartu->jumlah_masuk = $item['jumlah_diterima'];
            $kartu->harga_beli = $item['harga_diterima'];
            $kartu->update();

            // DETAIL PEMBELIAN
            $detailpembelian = DetailPembelian::where('id_pembelian', $pembelian->id_pembelian)->where('id_produk', $item['id_produk'])->first();
            // $detailpembelian->qty_sementara = $detailpembelian->qty_sementara - $item['jumlah_diterima'];
            $kurang_rcv = $detail['jumlah_diterima'] - $detailpembelian->qty_sementara;
            $hitung_rcv = $kurang_rcv + $item['jumlah_diterima'];
            $detailpembelian->qty_sementara = $detailpembelian->qty_sementara + $hitung_rcv;
            $detailpembelian->save();
            
            // CHECK AMOUNT QTY PEMBELIAN DAN QTY PENERIMAAN UNTUK STATUS
            $qtyrcv = $qtyrcv + $item['jumlah_diterima'];
            $qtypo = $qtypo + $item['jumlah_order'];
        }

        if($qtyrcv != $qtypo){
            $pembelian->status ='Dikirim';
        }else{
            $pembelian->status ='Diterima';
        }
        $pembelian->grand_total = $total_pembelian;
        $pembelian->save();

        $penerimaan->grand_total = $total_penerimaan;
        $penerimaan->save();
        $penerimaan->Detail()->sync($request->detail);

        if($request->status_pembayaran == 'Pending'){
            Alert::success('Sukses', 'Data Pembelian Berhasil Diproses, Mohon Segera Melakukan Pembayaran');
        }else{
            Alert::success('Sukses', 'Data Pembelian Berhasil Diproses dan Lunas');
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
        $penerimaan = Penerimaan::find($id);
        $pembelian = Pembelian::where('kode_pembelian', $penerimaan->Pembelian->kode_pembelian)->first();
        $qtyrcv = 0;
        $qtypo = 0;

        foreach($penerimaan->detail as $key=>$item){
            $produk = Produk::where('id_produk', $item['id_produk'])->first();
            $produk->stok = $produk->stok - $item->pivot['jumlah_diterima'];
            
            if($produk->stok >= $produk->jumlah_minimal){
                $produk->status_jumlah = 'Cukup';
            }else if($produk->stok == 0){
                $produk->status_jumlah = 'Habis';
            }else{
                $produk->status_jumlah = 'Kurang';
            }
            $produk->save();

            // KARTU GUDANG
            $kartu = KartuGudang::where('id_produk', $item['id_produk'])->where('kode_transaksi', $penerimaan->kode_penerimaan)->first();
            $kartugudangterakhir = $produk->Kartugudangsaldoakhir;
            $kartugudangterakhir->saldo_akhir = $kartugudangterakhir->saldo_akhir - $item['jumlah_diterima'];
            $kartugudangterakhir->save();
            $kartu->delete();
            
            // DETAIL PEMBELIAN
            $detailpembelian = DetailPembelian::where('id_pembelian', $penerimaan->Pembelian->id_pembelian)->where('id_produk', $item['id_produk'])->first();
            $detailpembelian->qty_sementara = $detailpembelian->qty_sementara + $item->pivot['jumlah_diterima'];
            $detailpembelian->save();

            $detailpenerimaan = DetailPenerimaan::where('id_penerimaan', $penerimaan->id_penerimaan)->where('id_produk', $item['id_produk'])->first();
            $detailpenerimaan->delete();
            
            // CHECK AMOUNT QTY PEMBELIAN DAN QTY PENERIMAAN UNTUK STATUS
            $qtyrcv = $qtyrcv + $item->pivot['jumlah_diterima'];
            $qtypo = $qtypo + $item->pivot['jumlah_order'];
        }

        if($qtyrcv != $qtypo){
            $pembelian->status ='Dikirim';
            $pembelian->save();
        }else{
            $pembelian->status ='Diterima';
            $pembelian->save();
        }

        $penerimaan->delete();
        Alert::success('Sukses', 'Data Penerimaan Berhasil Diproses, Stok Anda Terlihat Terkendali');
        return redirect()->back();
    }

}
