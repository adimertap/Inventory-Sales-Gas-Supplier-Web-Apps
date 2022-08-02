@extends('layouts.app')

@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-warehouse"></i></div>
                            Detail Kartu Gudang Penjualan
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a href="{{ route('kartu-gudang.index') }}"
                            class="btn btn-sm btn-light text-primary mr-2">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="container-fluid">
            <div class="card h-100 mb-4">
                <div class="card-body h-100 py-5 py-xl-4">
                    <div class="row align-items-center">
                        <div class="col-xl-8 col-xxl-12">
                            <nav class="nav nav-borders">
                                <a class="nav-link" href="{{ route('kartu-gudang.show', $produk->id_produk) }}">Keseluruhan</a>
                                <a class="nav-link" href="{{ route('kartu-gudang-penerimaan', $produk->id_produk) }}">Kartu Penerimaan</a>
                                <a class="nav-link active ml-0" href="{{ route('kartu-gudang-penjualan', $produk->id_produk) }}">Kartu Penjualan</a>
                            </nav>
                            <hr>
                            <div class="row align-items-center justify-content-between">
                                <div class="col">
                                    <h4 class="text-primary">Produk {{ $produk->nama_produk }}, Kategori {{ $produk->Kategori->nama_kategori }}</h4>
                                    <p class="text-gray-700">Jumlah Stok: {{ $produk->stok }}</p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    

        


        <div class="card mb-4">
            <div class="card card-header-actions">
                <div class="card-header ">List Transaksi Produk</div>
            </div>
            <div class="card-body ">
                <div class="datatable">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover dataTable" id="dataTable" width="100%"
                                    cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="text-center">Transaksi</th>
                                            <th colspan="1" class="text-center">Jumlah</th>
                                            <th colspan="1" class="text-center">Saldo</th>
                                            <th colspan="1" class="text-center">Harga</th>
                                        </tr>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 20px;">
                                                No</th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1"
                                                aria-label="Position: activate to sort column ascending"
                                                style="width: 100px;">Customer</th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1"
                                                aria-label="Position: activate to sort column ascending"
                                                style="width: 60px;">Tanggal Transaksi</th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1"
                                                aria-label="Position: activate to sort column ascending"
                                                style="width: 6px;">Kode Transaksi</th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1"
                                                aria-label="Office: activate to sort column ascending"
                                                style="width: 30px;">Keluar</th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1"
                                                aria-label="Salary: activate to sort column ascending"
                                                style="width: 50px;">
                                                Saldo</th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="dataTable"
                                                rowspan="1" colspan="1"
                                                aria-label="Salary: activate to sort column ascending"
                                                style="width: 100px;">Harga Beli</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($kartu_penjualan as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td class="text-center">{{ $item->Customer->nama_customer }}</td>
                                            <td class="text-center">{{ $item->tanggal_transaksi }}</td>
                                            <td class="text-center">{{ $item->kode_transaksi }}</td>
                                            <td class="text-center">{{ $item->jumlah_keluar }}</td>
                                            <td class="text-center">{{ $item->saldo_akhir }}</td>
                                            <td class="text-center">Rp.{{ number_format($item->harga_jual)}}</td>
                                        </tr>
                                        @empty

                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection
