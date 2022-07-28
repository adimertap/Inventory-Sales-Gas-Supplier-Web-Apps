@extends('layouts.app')

@section('content')

<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-box"></i></div>
                            Kartu Gudang
                        </h1>
                        <div class="page-header-subtitle">{{ $today }} · {{ $tanggal }} · <span id="clock"></span></div>
                                </div> <div class="col-12 col-xl-auto mt-4">
                                <div class="small">
                                    <i class="fa fa-cogs" aria-hidden="true"></i>
                                    <span class="font-weight-500">Sukses Berkah Bertumbuh</span>
                                    <hr>
                                    </hr>
                                </div>
                        </div>
                    </div>
                </div>
    </header>
    <div class="container-fluid mt-n10">
        <div class="card card-waves mb-4">
            <div class="card-body p-5">
                <div class="row align-items-center justify-content-between">
                    <div class="col">
                        <h2 class="text-primary">Selamat Datang, {{ Auth::user()->name }}!</h2>
                        <p class="text-gray-700">Halaman ini menampilkan seluruh laporan produk pada Perusahaan Anda!,
                            mulai dari jumlah masuk hingga jumlah keluar</p>
                        <hr>
                        <a class="btn btn-primary btn-sm px-3 py-2" href="{{ route('cetak-kartu-pdf') }}">
                            Download Laporan Stok
                            <i class="fas fa-print ml-3"></i>
                        </a>
                    </div>
                    <div class="col d-none d-lg-block mt-xxl-n4"><img class="img-fluid px-xl-2 mt-xxl-n5" width="250"
                            src="{{ asset('assets/inventory2.png') }}"></div>
                </div>
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
                                                style="width: 80px;">Nama Produk</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 90px;">Kategori</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 70px;">Stok Produk</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Jumlah Minimal</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 40px;">Status Jumlah</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 60px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($produk as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td>{{ $item->nama_produk }}</td>
                                            <td>{{ $item->Kategori->nama_kategori }}</td>
                                            <td class="text-center">{{ $item->stok }}</td>
                                            <td class="text-center">{{ $item->jumlah_minimal }}</td>
                                            <td class="text-center">
                                                @if($item->status_jumlah == 'Cukup')
                                                <span class="badge badge-success">Cukup</span>
                                                @elseif($item->status_jumlah == 'Habis')
                                                <span class="badge badge-danger">Habis</span>
                                                @elseif ($item->status_jumlah == 'Min')
                                                <span class="badge badge-danger">Min</span>
                                                @else
                                                <span class="badge badge-warning">Kurang</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('kartu-gudang.show', $item->id_produk) }}"
                                                    class="btn btn-secondary btn-datatable" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Detail Kartu Gudang"> <i
                                                        class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-danger btn-datatable resetBtn"
                                                    value="{{ $item->id_produk }}" type="button"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Reset Stok"><i class="fas fa-sync"></i>
                                                </button>
                                            </td>
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

<div class="modal fade" id="ModalReset" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Konfirmasi Reset Stok dan Kartu Gudang</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body p-0">
                <form action="{{ url('/penerimaan') }}" id="resetForm" method="POST">
                    @method('delete')
                    @csrf
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <input type="hidden" name="produk_id" id="produk_id">
                                        <h5 class="mb-2 fs-0">Aktivitas Membahayakan</h5>
                                        <p class="text-word-break fs--1">Apakah Anda Yakin Melakukan Reset Terhadap Stok
                                            Produk Ini?
                                            Reset Stok adalah tindakan permanen dan tidak dapat dibatalkan. Reset akan
                                            melibatkan reset stok dan
                                            penghapusan kartu gudang produk ini.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button class="btn btn-light" type="button" data-dismiss="modal">Kembali</button>
                <button class="btn btn-danger-soft text-danger" type="submit">Saya Mengerti, Reset Stok</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('.resetBtn').click(function (e) {
            e.preventDefault();
            var id_produk = $(this).val();
            $('#produk_id').val(id_produk)
            $('#ModalReset').modal('show');

            $('#resetForm').attr('action', '/kartu-gudang/' + id_produk);
        })

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
    })

</script>

@endsection
