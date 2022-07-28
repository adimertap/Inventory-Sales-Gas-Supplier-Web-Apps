@extends('layouts.app')

@section('content')
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"></div>
                            Transaksi Pembelian
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a href="{{ route('laporan-pembelian.index') }}" class="btn btn-sm btn-light text-primary active mr-2">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
            <div class="mr-4 mb-3 mb-sm-0">
                <h2 class="mb-0">Pembelian Kode {{ $item->kode_pembelian }}</h2>
                <div class="small">
                    <span class="font-weight-500 text-primary">Tanggal Transaksai</span>
                    {{ $item->tanggal_pembelian }}, Supplier {{ $item->Supplier->nama_supplier }}
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
                                                style="width: 70px;">Jumlah Order</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Harga Beli</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 80px;">Total Pembelian</th>
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
                                            <td class="text-center">{{ $items->pivot->jumlah_order }}</td>
                                            <td>Rp. {{ number_format($items->pivot->harga_beli) }}</td>
                                            <td class="text-center">Rp. {{ number_format($items->pivot->total_order) }}</td>
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



        @forelse ($penerimaan as $tes)
        <div class="card card-collapsable mt-3">
            <a class="card-header" href="#collapseCardExample-{{ $tes->id_penerimaan }}" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample">
                Diterima Pada {{ $tes->tanggal_penerimaan }}, Kode {{ $tes->kode_penerimaan }}
                <div class="card-collapsable-arrow">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </a>
            <div class="collapse hide" id="collapseCardExample-{{ $tes->id_penerimaan }}">
                <div class="card-body">
                    <div class="datatable">
                        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-hover dataTable" id="Tabless" width="100%"
                                        cellspacing="0" role="grid" aria-describedby="dataTable_info"
                                        style="width: 100%;">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-sort="ascending"
                                                    aria-label="Name: activate to sort column descending"
                                                    style="width: 20px;">
                                                    No</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Office: activate to sort column ascending"
                                                    style="width: 70px;">Produk</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Office: activate to sort column ascending"
                                                    style="width: 70px;">Jumlah Diterima</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1" aria-label="Office: activate to sort column ascending"
                                                    style="width: 70px;">Harga Diterima</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                    colspan="1"
                                                    aria-label="Start date: activate to sort column ascending"
                                                    style="width: 40px;">Total Diterima</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($tes->Detail as $item)
                                            <tr role="row" class="odd">
                                                <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}
                                                </th>
                                                <td>{{ $item->nama_produk }},{{ $item->Kategori->nama_kategori }}</td>
                                                <td>{{ $item->pivot->jumlah_diterima }}</td>
                                                <td class="text-center">Rp.
                                                    {{ number_format($item->pivot->harga_diterima) }}</td>
                                                <td class="text-center">Rp.
                                                    {{ number_format($item->pivot->total_diterima) }}</td>

                                            </tr>
                                            @empty

                                            @endforelse


                                        </tbody>
                                        <tr>
                                            <td colspan="4" class="text-center"> Grand Total Penerimaan</td>
                                            <td colspan="1" class="text-center">Rp.
                                                {{ number_format($tes->grand_total) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty

        @endforelse





    </div>
</main>

<script>
    $(document).ready(function () {
        var table = $('#dataTable').DataTable();

        setInterval(displayclock, 500);

        function displayclock() {
            var time = new Date()
            var hrs = time.getHours()
            var min = time.getMinutes()
            var sec = time.getSeconds()
            var en = 'AM';

            if (hrs > 12) {
                en = 'PM'
            }

            if (hrs > 12) {
                hrs = hrs - 12;
            }

            if (hrs == 0) {
                hrs = 12;
            }

            if (hrs < 10) {
                hrs = '0' + hrs;
            }

            if (min < 10) {
                min = '0' + min;
            }

            if (sec < 10) {
                sec = '0' + sec;
            }

            document.getElementById('clock').innerHTML = hrs + ':' + min + ':' + sec + ' ' + en;
        }
    });

</script>

@endsection
