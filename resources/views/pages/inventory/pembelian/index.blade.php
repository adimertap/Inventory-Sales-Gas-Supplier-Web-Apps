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
                            Pembelian Dari Supplier
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-primary mb-1">Tambah Data Pembelian</div>
                                <a href="{{ route('pembelian.create') }}" class="btn btn-sm btn-primary"
                                    type="button">Tambah Data</a><br>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Klik Button untuk menambah Data Pembelian
                                </div>
                            </div>
                            <div class="ml-2">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-primary mb-1">Total Pembelian Hari Ini</div>
                                <div class="h5">{{ $count }} Data</div>
                            </div>
                            <div class="ml-2">
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Today
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                style="width: 20px;">No</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 120px;">Pegawai</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Kode Pembelian</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 90px;">Nama Supplier</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Tanggal Pembelian</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 40px;">Total Pembelian</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 40px;">Status</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pembelian as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td>{{ $item->Pegawai->name }}</td>
                                            <td>{{ $item->kode_pembelian }}</td>
                                            <td>{{ $item->Supplier->nama_supplier }}</td>
                                            <td>{{ $item->tanggal_pembelian }}</td>
                                            <td>Rp. {{ number_format($item->grand_total) }}</td>
                                            <td class="text-center">
                                                @if($item->status == 'Dikirim')
                                                    <span class="badge badge-info">Diproses Terkirim</span>
                                                @elseif($item->status == 'Diterima')
                                                    <span class="badge badge-success">Diterima, Lengkap</span>
                                                @else
                                                <button class="btn btn-dark btn-datatable kirimBtn"
                                                    value="{{ $item->id_pembelian }}" type="button"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Delete Pembelian"> <i class="fas fa-share-square"></i>
                                                </button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('pembelian-pdf', $item->id_pembelian) }}" class="btn btn-info btn-datatable"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Download PDF"> <i class="fas fa-print"></i>
                                                </a>
                                                <a href="{{ route('pembelian.show', $item->id_pembelian) }}" class="btn btn-secondary btn-datatable"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Detail Pembelian"> <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('pembelian.edit', $item->id_pembelian) }}" class="btn btn-primary btn-datatable"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Edit Pembelian"> <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-danger btn-datatable deleteBtn"
                                                    value="{{ $item->id_pembelian }}" type="button"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Delete Pembelian"> <i class="fas fa-trash"></i>
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

<div class="modal fade" id="ModalKirim" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Konfirmasi Kirim Data Ke Supplier</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body p-0">
                <form id="kirimForm" method="POST">
                    @csrf
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <input type="hidden" name="kirim_id" id="kirim_id">
                                        <h5 class="mb-2 fs-0">Confirmation</h5>
                                        <p class="text-word-break fs--1">Apakah Anda Yakin Mengirim Data Pembelian Ini Ke Supplier?
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Yes! Kirim </button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- DELETE MODAL --}}
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Konfirmasi Hapus Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body p-0">
                <form action="{{ url('/pembelian') }}" id="deleteForm" method="POST">
                    @method('delete')
                    @csrf
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <input type="hidden" name="pembelian_id" id="pembelian_id">
                                        <h5 class="mb-2 fs-0">Confirmation</h5>
                                        <p class="text-word-break fs--1">Apakah Anda Yakin Menghapus Data Pembelian ini?
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-danger" type="submit">Yes! Delete </button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.deleteBtn').click(function (e) {
            e.preventDefault();

            var id = $(this).val();
            $('#pembelian_id').val(id)
            $('#ModalDelete').modal('show');

            $('#deleteForm').attr('action', '/pembelian/' + id)
        })

        $('.kirimBtn').click(function (e) {
            e.preventDefault();

            var id = $(this).val();
            $('#kirim_id').val(id)
            $('#ModalKirim').modal('show');

            $('#kirimForm').attr('action', '/pembelian/kirim/' + id)
        })

        var table = $('#dataTable').DataTable();
    })

</script>

@endsection
