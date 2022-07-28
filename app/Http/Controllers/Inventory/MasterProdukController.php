<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Master\Category;
use App\Models\Master\Produk;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MasterProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::with('Kategori')->get();
        $count_produk = Produk::count();
        $kategori = Category::get();

        return view('pages.inventory.master.produk.index', compact('produk','count_produk','kategori'));
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
        if(Produk::where('nama_produk',$request->nama_produk)->where('id_kategori',$request->id_kategori)->exists()){
            Alert::warning('Gagal', 'Produk dengan Kategori Tersebut Sudah Ada');
            return redirect()->back();    
        }else{
            $item = new Produk();
            $item->id_kategori = $request->id_kategori;
            $item->nama_produk = $request->nama_produk;
            $item->jumlah_minimal = $request->jumlah_minimal;
            $item->save();
    
            Alert::success('Sukses', 'Data Produk Berhasil Ditambahkan');
            return redirect()->back();
        }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        if(Produk::where('nama_produk',$request->nama_produk)->where('id_kategori',$request->id_kategori)->exists()){
            Alert::warning('Gagal', 'Produk dengan Kategori Tersebut Sudah Ada');
            return redirect()->back();    
        }else{
            $item = Produk::find($id);
            $item->id_kategori = $request->id_kategori;
            $item->nama_produk = $request->nama_produk;
            $item->jumlah_minimal = $request->jumlah_minimal;
            $item->save();
    
            Alert::success('Sukses', 'Data Produk Berhasil Diedit');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Produk::find($id);
        $item->delete();

        Alert::success('Sukses', 'Data Produk Berhasil Dihapus');
        return redirect()->back();
    }
}
