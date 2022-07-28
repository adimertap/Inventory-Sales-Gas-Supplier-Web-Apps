<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Master\Customer;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MasterCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::get();
        $count_customer = Customer::count();

        return view('pages.inventory.master.customer.index', compact('customer','count_customer'));
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
        $id = Customer::getId();
        foreach ($id as $value);
        $idlama = $value->id_customer;
        $idbaru = $idlama + 1;
        $blt = date('ym');
        $kode_customer = 'CS' . $blt . '-' . $idbaru;

        $item = new Customer();
        $item->nama_customer = $request->nama_customer;
        $item->kode_customer = $kode_customer;
        $item->no_hp_customer = $request->no_hp_customer;
        $item->email_customer = $request->email_customer;
        $item->kota_customer = $request->kota_customer;
        $item->alamat_customer = $request->alamat_customer;
        $item->save();

        Alert::success('Sukses', 'Data Customer Berhasil Ditambahkan');
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
        $item = Customer::find($id);
        $item->nama_customer = $request->nama_customer;
        $item->no_hp_customer = $request->no_hp_customer;
        $item->email_customer = $request->email_customer;
        $item->kota_customer = $request->kota_customer;
        $item->alamat_customer = $request->alamat_customer;
        $item->update();

        Alert::success('Sukses', 'Data Customer Berhasil Diedit');
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
        $item = Customer::find($id);
        $item->delete();

        Alert::success('Sukses', 'Data Customer Berhasil Dihapus');
        return redirect()->back();
    }
}
