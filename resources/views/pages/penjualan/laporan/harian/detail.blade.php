@extends('layouts.app_penjualan')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"></div>
                            Transaksi Penjualan
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a href="{{ route('laporan-penjualan-harian.index') }}" class="btn btn-sm btn-light text-primary active mr-2">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
            <div class="mr-4 mb-3 mb-sm-0">
                <h2 class="mb-0">Penjualan Kode {{ $item->kode_penjualan }}</h2>
                <div class="small">
                    <span class="font-weight-500 text-primary">Tanggal Transaksai</span>
                    {{ $item->tanggal_penjualan }}, Customer {{ $item->Customer->nama_customer }}
                </div>

            </div>
            <div class="col-12 col-xl-auto mb-3 mb-sm-0  mr-4">
                <a href="#" class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Download Excel">Download Excel <i class="fas fa-download  ml-2"></i>
                </a>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-body ">
                <div class="datatable">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover dataTable" id="dataTable" width="100%"
                                    cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 20px;">
                                                No</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 80px;">Produk</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 70px;">Jumlah Jual</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Harga Jual</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 80px;">Total Penjualan</th>
                                        </tr>
                                    </thead>
                                    @php
                                    $jumlah = $item->Detail->count('nama_produk');
                                    @endphp
                                    <tbody>
                                        @forelse ($item->Detail as $items)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td>{{ $items->nama_produk }}, {{ $items->Kategori->nama_kategori }}</td>
                                            <td class="text-center">{{ $items->pivot->jumlah_jual }}</td>
                                            <td>Rp. {{ number_format($items->pivot->harga_jual) }}</td>
                                            <td class="text-center">Rp. {{ number_format($items->pivot->total_jual) }}</td>
                                        </tr>
                                        @empty

                                        @endforelse


                                    </tbody>
                                    <tr>
                                        <td colspan="3" class="text-center"> Grand Total Keseluruhan</td>
                                        <td colspan="1" class="text-center">{{ $jumlah }} Produk</td>
                                        <td colspan="1" class="text-center">Rp. {{ number_format($item->grand_total) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function () {
        var table = $('#dataTable').DataTable();
    });

</script>

@endsection
