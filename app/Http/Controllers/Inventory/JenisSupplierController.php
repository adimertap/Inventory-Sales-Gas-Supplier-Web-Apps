<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Master\JenisSupplier;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class JenisSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenis = JenisSupplier::get();
        $count = JenisSupplier::count();
        return view('pages.inventory.master.jenis-supplier.index', compact('jenis','count'));
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
        $jenis = new JenisSupplier;
        $jenis->nama_jenis = $request->nama_jenis;
        $jenis->save();
  
        Alert::success('Sukses', 'Data Jenis Supplier Berhasil Ditambahkan');
        return redirect()->back();
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
        $jenis = JenisSupplier::find($id);
        $jenis->nama_jenis = $request->nama_jenis;
        $jenis->update();

        Alert::success('Sukses', 'Data Jenis Supplier Berhasil Ditambahkan');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jenis = JenisSupplier::find($id);
        $jenis->delete();

        Alert::success('Sukses', 'Data Jenis Supplier Berhasil Dihapus');
        return redirect()->back();
    }
}
