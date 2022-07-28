@extends('layouts.app')

@section('content')

<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            Dashboard Inventory
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
                                    Anda untuk memonitor persediaan produk Anda selama 7x24 jam.
                                </p>
                                <a class="btn btn-primary btn-sm px-3 py-2" href="{{ route('pembelian.index') }}">
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
                                    style="width: 16rem;" src="{{ asset('template/src/assets/img/freepik/logistic5.png') }}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 mb-4">
                <a class="card lift" href="{{ route('pembelian.index') }}">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mr-3">
                                
                                <h5>Pembelian Produk</h5>
                                <div class="text-muted">Beli Produk Pada Supplier Dapat Dilakukan Disini, <b class="text-primary">Klik Disini!</b></div>
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

        {{-- STATUS STOK PRODUK --}}
        @if (count($cek_habis) > 0)
        <div class="alert alert-warning" role="alert">
            Terdapat Produk dengan jumlah stok sudah Habis, Yuk cek pada kartu gudang!
        </div>
        @endif
        @if (count($cek_min) > 0)
        <div class="alert alert-danger" role="alert">
            Terdapat Produk dengan jumlah stok dibawah 0 atau Min, Yuk cek pada kartu gudang!
        </div>
        @endif

        
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-success h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-primary mb-1">Produk Cukup</div>
                                <div class="small font-weight-bold">{{ $cukup }} Produk</div>
                            </div>
                            <div class="ml-2"><i class="fas fa-dollar-sign fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-secondary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-secondary mb-1">Produk Hampir Habis</div>
                                <div class="small font-weight-bold">{{ $kurang }} Produk</div>
                            </div>
                            <div class="ml-2"><i class="fas fa-tag fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-success mb-1">Produk Habis</div>
                                <div class="small font-weight-bold">{{ $habis }} Produk</div>
                            </div>
                            <div class="ml-2"><i class="fas fa-mouse-pointer fa-2x text-gray-200"></i> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-info mb-1">Produk Min</div>
                                <div class="small font-weight-bold">{{ $min }} Produk</div>
                            </div>
                            <div class="ml-2"><i class="fas fa-percentage fa-2x text-gray-200"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- LAPORAN PEMBELIAN --}}
        <div class="row">
            <div class="col-xxl-6 col-xl-6 mt-2">
                <div class="card p-2">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mr-3">
                                <h5>Laporan Pembelian Produk Hari Ini</h5>
                                <div class="small"><b class="text-primary">Rp. {{ number_format($total_hari_ini) }}</b></div>
                            </div>
                            <a class="btn btn-primary btn-sm px-3 py-2" href="{{ route('laporan-pembelian-harian.index') }}">
                                Lihat Laporan
                             </a>
                        </div>
                        <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                            {{ $total_hari_ini_count }} Transaksi Pembelian
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 mt-2">
                <div class="card p-2">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="mr-3">
                                <h5>Laporan Pembelian Produk Bulan Ini</h5>
                                <div class="text-muted"><b class="text-primary">Rp. {{ number_format($total_bulan_ini) }}</b></div>
                            </div>
                            <a class="btn btn-primary btn-sm px-3 py-2" href="{{ route('laporan-pembelian-bulanan.index') }}">
                                Lihat Laporan
                             </a>
                        </div>
                        <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                            {{ $total_bulan_ini_count }} Transaksi Pembelian
                        </div>
                      
                    </div>
                    
                </div>
            </div>
        </div>


       
    </div>

</main>

@endsection