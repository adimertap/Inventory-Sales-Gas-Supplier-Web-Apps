<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Master\Supplier;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MasterSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::get();
        $count_supplier = Supplier::count();

        return view('pages.inventory.master.supplier.index', compact('supplier','count_supplier'));
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
        $item = new Supplier;
        $item->nama_supplier = $request->nama_supplier;
        $item->email_supplier = $request->email_supplier;
        $item->no_hp_supplier = $request->no_hp_supplier;
        $item->kota_supplier = $request->kota_supplier;
        $item->alamat_supplier = $request->alamat_supplier;
        $item->save();

        Alert::success('Sukses', 'Data Supplier Berhasil Ditambahkan');
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
        $item = Supplier::find($id);
        $item->nama_supplier = $request->nama_supplier;
        $item->email_supplier = $request->email_supplier;
        $item->no_hp_supplier = $request->no_hp_supplier;
        $item->kota_supplier = $request->kota_supplier;
        $item->alamat_supplier = $request->alamat_supplier;
        $item->save();

        Alert::success('Sukses', 'Data Supplier Berhasil Diedit');
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
        $item = Supplier::find($id);
        $item->delete();

        Alert::success('Sukses', 'Data Supplier Berhasil Dihapus');
        return redirect()->back();
    }
}
