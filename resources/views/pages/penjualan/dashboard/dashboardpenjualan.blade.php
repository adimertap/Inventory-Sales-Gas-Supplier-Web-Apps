@extends('layouts.app_penjualan')

@section('content')

<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            Dashboard Penjualan
                        </h1>
                        <div class="small">
                            <span class="font-weight-500">{{ $today }}</span>
                            · Tanggal {{ $tanggal_tahun }} · <span id="clock">12:16 PM</span>
                        </div>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">
                        <div class="small">
                            <i class="fa fa-cogs" aria-hidden="true"></i>
                            <span class="font-weight-500">Sukses Berkah Bertumbuh</span>
                            <hr>
                            </hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

     <div class="container mt-n10">
        <div class="row">
            <div class="col-xxl-8 col-xl-8">
                <div class="card card-waves mb-4">
                    <div class="card-body p-5">
                        <div class="row align-items-center justify-content-between">
                            <div class="col">
                                <h4 class="text-primary">Selamat Datang, {{ Auth::user()->name}}!</h4>
                                <p class="text-gray-700 small"><b>Aplikasi </b>menggunakan teknologi web secara online yang memudahkan
                                    Anda untuk memonitor penjualan produk oleh Pegawai
                                </p>
                                <a class="btn btn-primary btn-sm px-3 py-2" href="{{ route('penjualan.index') }}">
                                    Get Started
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-arrow-right ml-1">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
        
                            </div>
                            <div class="col d-none d-lg-block mt-xxl-n5"><img class="img-fluid px-xl-4 mt-xxl-n6"
                                    style="width: 16rem;" src="{{ asset('assets/penjualan.png') }}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 mb-4">
                <a class="card lift" href="{{ route('pembelian.index') }}">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mr-3">
                                
                                <h5>Penjualan Produk</h5>
                                <div class="text-muted">Catat Penjualan Produk Anda Secara Cepat dan Tepat, <b class="text-primary">Klik Disini!</b></div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package feather-xl text-primary mb-3"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        </div>
                    </div>
                </a>
                <a class="card lift mt-4" href="{{ route('kartu-gudang.index') }}">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mr-3">
                                
                                <h5>Kartu Gudang</h5>
                                <div class="text-muted">Cek Stok Produk yang terdapat pada Gudang Anda, <b class="text-primary">Klik Disini!</b></div>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package feather-xl text-primary mb-3"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- LAPORAN PENJUALAN --}}
        <div class="row">
            <div class="col-xxl-6 col-xl-6 mt-2">
                <div class="card p-2">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mr-3">
                                <h5>Laporan Penjualan Produk Hari Ini</h5>
                                <div class="small"><b class="text-primary">Rp. {{ number_format($total_hari_ini) }}</b></div>
                            </div>
                            <a class="btn btn-primary btn-sm px-3 py-2" href="{{ route('laporan-penjualan-harian.index') }}">
                                Lihat Laporan
                             </a>
                        </div>
                        <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                            {{ $total_hari_ini_count }} Transaksi Penjualan
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 mt-2">
                <div class="card p-2">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mr-3">
                                <h5>Laporan Penjualan Produk Bulan Ini</h5>
                                <div class="text-muted"><b class="text-primary">Rp. {{ number_format($total_bulan_ini) }}</b></div>
                            </div>
                            <a class="btn btn-primary btn-sm px-3 py-2" href="{{ route('laporan-penjualan-bulanan.index') }}">
                                Lihat Laporan
                             </a>
                        </div>
                        <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                            {{ $total_bulan_ini_count }} Transaksi Penjualan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            @forelse ($pegawai as $item)
            <div class="col-xxl-3 col-lg-6">
                <div class="card card-collapsable bg-primary text-white mb-4">
                    <a class="card-header small text-white" href="#collapseCardExample" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        {{ $item->name }}
                        <div class="card-collapsable-arrow text-white">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </a>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-3">
                                {{-- <div class="text-white-75 small">{{ $item->name }}</div> --}}
                                <p class="small mb-0 m-0">Penjualan Hari Ini</p>
                                @php
                                    $total_penjualan =$item->Penjualan->where('tanggal_penjualan', $hari )->sum('grand_total');
                                @endphp
                                <div class="text-l font-weight-bold">Rp. {{ number_format($total_penjualan) }}</div>
                            </div>
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="collapse" id="collapseCardExample">
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white" href="{{ route('laporan-pegawai', $item->id) }}">View Report</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                
            @endforelse

           
        </div>

    </div>

</main>

@endsection