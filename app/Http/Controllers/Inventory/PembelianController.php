<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Mail\MailSupplier;
use App\Models\Inventory\Pembelian;
use App\Models\Master\Produk;
use App\Models\Master\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembelian = Pembelian::orderBy('tanggal_pembelian','DESC')->get();
        $count = Pembelian::where('tanggal_pembelian', Carbon::now()->format('Y-m-d'))->count();

        return view('pages.inventory.pembelian.index', compact('pembelian','count'));
    }
    
    public function kirim($id)
    {
        $pembelian = Pembelian::find($id);
        $pembelian->status = 'Dikirim';
        $pembelian->save();

        Alert::success('Sukses', 'Data Pembelian Berhasil Dikirim Ke Supplier, Mohon Tunggu Pengiriman');
        return redirect()->back();
    }

    public function pembelian_pdf($id)
    {
        $pembelian = Pembelian::with('Detail','Supplier','Pegawai')->find($id);
        $pdf = Pdf::loadview('pdf.pembelian.pembelian_pdf',['pembelian'=>$pembelian]);
    	return $pdf->download('Pembelian.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = Supplier::get();
        $produk = Produk::with('Kategori')->get();

        $id = Pembelian::getId();
        foreach($id as $value);
        $idlama = $value->id_pembelian;
        $idbaru = $idlama + 1;
        $blt = date('y-m');
        $kode_pembelian = 'PO'.$blt.'-'.$idbaru;

        return view('pages.inventory.pembelian.create', compact('supplier','kode_pembelian','idbaru','produk'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $item = new Pembelian;
        $item->id = Auth::user()->id;
        $item->kode_pembelian = $request->kode_pembelian;
        $item->tanggal_pembelian = $request->tanggal_pembelian;
        $item->supplier_id = $request->id_supplier;
        $item->status = 'Pending';
        $temp = 0;
        foreach($request->detail as $key=>$tes){
            $temp = $temp + $tes['total_order'];
        }
        $item->grand_total = $temp;
        $item->save();
        $item->Detail()->sync($request->detail);

        Alert::success('Sukses', 'Data Pembelian Berhasil Ditambahkan');
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
        $transaksi = Pembelian::with('Detail','Supplier','Pegawai')->find($id);
        return view('pages.inventory.pembelian.detail', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Pembelian::with('Detail','Supplier','Pegawai')->find($id);
        $supplier = Supplier::get();
        $produk = Produk::with('Kategori')->get();

        return view('pages.inventory.pembelian.edit', compact('item','supplier','produk'));
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
        $item = Pembelian::find($id);
        $item->tanggal_pembelian = $request->tanggal_pembelian;
        $item->supplier_id = $request->id_supplier;
        $item->status = 'Pending';
        $temp = 0;
        foreach($request->detail as $key=>$tes){
            $temp = $temp + $tes['total_order'];
        }
        $item->grand_total = $temp;
        $item->save();
        $item->Detail()->sync($request->detail);

        Alert::success('Sukses', 'Data Pembelian Berhasil Diedit');
        return $request;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $item = Pembelian::find($request->pembelian_id);
        $item->delete();

        Alert::success('Sukses', 'Data Pembelian Berhasil Dihapus');
        return redirect()->back();
    }

    public function mail($id)
    {
       $item = Pembelian::find($id);
        Mail::to($item->Supplier->email_supplier)->send(new MailSupplier($item));
    }
}
