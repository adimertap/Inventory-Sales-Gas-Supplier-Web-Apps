<?php

namespace App\Http\Middleware;

use App\Models\Master\Pegawai;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AksesOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $pegawai_role = User::where('id', Auth::user()->id)->first()->role;
        if($pegawai_role == 'Owner' || $pegawai_role == 'Admin'){
            return $next($request);
        }

        return redirect('/Penjualan/dashbord/pegawai');
    }
}
