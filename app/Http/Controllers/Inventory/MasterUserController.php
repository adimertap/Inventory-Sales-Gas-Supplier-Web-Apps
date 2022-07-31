<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MasterUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = User::get();
        $count_owner = User::where('role','Owner')->count();
        $count_pegawai = User::where('role','Pegawai')->count();
        $count_admin = User::where('role','Admin')->count();


        return view('pages.inventory.master.user.index', compact('pegawai','count_owner','count_pegawai','count_admin'));
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

        $id = User::getId();
        foreach($id as $value);
        $idlama = $value->id;
        $idbaru = $idlama + 1;
      
        $pegawai = new User;
        $pegawai->name = $request->name;
        $pegawai->nama_panggilan = $request->nama_panggilan;
        $pegawai->no_telephone = $request->no_telephone;
        $pegawai->alamat = $request->alamat;
        $pegawai->role = $request->role;
        $pegawai->email = $request->email;
        $pegawai->password = bcrypt($request->password);
        $pegawai->email_verified_at = Carbon::now();
        if($request->role == 'Pegawai'){
            $pegawai->kode_pegawai = 'Sales'.$request->alamat.'-'.$idbaru;
        }else{
            $pegawai->kode_pegawai = $request->role.$request->alamat.'-'.$idbaru;
        }

        
        $pegawai->save();

        event(new Registered($pegawai));

        Alert::success('Sukses', 'Data Pegawai Berhasil Ditambahkan');
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->nama_panggilan = $request->nama_panggilan;
        $user->no_telephone = $request->no_telephone;
        $user->role = $request->role;
        $user->email = $request->email;
        if($request->alamat){
            $user->kode_pegawai = $user->role.$request->alamat.'-'.$user->id;
            $user->alamat = $request->alamat;
        }

        $user->update();
        Alert::success('Sukses', 'Data Pegawai Berhasil Diedit');
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
        $user = User::find($id);
        $user->delete();

        Alert::success('Sukses', 'Data Pegawai Berhasil Dihapus');
        return redirect()->back();
    }

   
}
