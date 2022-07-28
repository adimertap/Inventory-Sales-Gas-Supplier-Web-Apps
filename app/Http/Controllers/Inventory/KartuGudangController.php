<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\KartuGudang;
use App\Models\Master\Produk;
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
        return view('pages.inventory.kartugudang.index', compact('produk','today','tanggal'));
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
        $kartu_keseluruhan = KartuGudang::with('Produk','Supplier')->where('id_produk', $id)->get();
        $tanggal = Carbon::now()->format('F Y');

        return view('pages.inventory.kartugudang.detail', compact('kartu_keseluruhan', 'tanggal','produk'));
    }

    public function penerimaan($id)
    {
        $produk = Produk::with('Kategori')->find($id);
        $kartu_penerimaan = KartuGudang::with('Produk','Supplier')->where('id_produk', $id)->where('jenis_kartu','Penerimaan')->get();

        return view('pages.inventory.kartugudang.kartu-penerimaan', compact('produk','kartu_penerimaan'));
    }

    public function penjualan($id)
    {
        $produk = Produk::with('Kategori')->find($id);
        $kartu_penjualan = KartuGudang::with('Produk','Supplier')->where('id_produk', $id)->where('jenis_kartu','Penjualan')->get();

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
