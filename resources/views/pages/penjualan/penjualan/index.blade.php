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
                            @if (Auth::user()->role == 'Owner')
                            Penjualan Perusahaan
                            @else
                            Penjualan Saya Keseluruhan
                            @endif
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
                                <div class="small font-weight-bold text-primary mb-1">Tambah Data Penjualan</div>
                                <a href="{{ route('penjualan.create') }}" class="btn btn-sm btn-primary" type="button">Tambah Data</a><br>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Klik Button untuk menambah Penjualan
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
                                @if (Auth::user()->role == 'Owner')
                                <div class="small font-weight-bold text-primary mb-1">Total Penjualan Perusahaan</div>
                                @else
                                <div class="small font-weight-bold text-primary mb-1">Total Penjualan Anda Hari Ini</div>
                                @endif
                              
                                <div class="h5">{{ $penjualan_hari }} Penjualan</div>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Count Penjualan
                                </div>
                            </div>
                            <div class="ml-2">
                                <i class="fa-solid fa-users"></i>
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
                                                style="width: 40px;">Kode Penjualan</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Tanggal</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Pegawai</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 120px;">Nama Customer</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 80px;">Grand Total</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 40px;">Status</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 20px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($penjualan as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td>{{ $item->kode_penjualan }}</td>
                                            <td>{{ date('d-M-Y', strtotime($item->tanggal_penjualan)) }}</td>
                                            <td>{{ $item->Pegawai->name }}</td>
                                            <td>{{ $item->Customer->nama_customer }}</td>
                                            <td class="text-center">Rp. {{ number_format($item->grand_total) }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('penjualan-pdf', $item->id_penjualan) }}"
                                                    class="btn btn-info btn-datatable" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Download PDF"><i class="fas fa-print"></i>
                                                </a>
                                                @if($item->status_bayar == 'Dibayar')
                                                <span class="badge badge-success">Lunas</span>
                                                @elseif($item->status_bayar == 'Pending')
                                                <button class="btn btn-primary btn-datatable bayarBtn"
                                                    value="{{ $item->id_penjualan }}" type="button"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Ubah Status Lunas"> <i class="fas fa-credit-card"></i>
                                                </button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('penjualan.show', $item->id_penjualan) }}"
                                                    class="btn btn-secondary btn-datatable" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Detail Penjualan"> <i
                                                        class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('penjualan.edit', $item->id_penjualan) }}"
                                                    class="btn btn-primary btn-datatable" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit Penjualan"> <i
                                                        class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-danger btn-datatable deleteBtn"
                                                    value="{{ $item->id_penjualan }}" type="button"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Delete Penjualan"> <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                    <tr> 
                                        <td colspan="5" class="text-center"> Grand Total Keseluruhan</td>
                                        <td colspan="1" class="text-center">Rp. {{ number_format($total) }}</td>
                                        <td colspan="2"></td>
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

{{-- BAYAR MODAL --}}
<div class="modal fade" id="ModalBayar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Konfirmasi Pelunasan Penjualan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body p-0">
                <form id="bayarForm" method="POST">
                    @csrf
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <input type="hidden" name="penjualan_bayar_id" id="penjualan_bayar_id">
                                        <h5 class="mb-2 fs-0">Confirmation</h5>
                                        <p class="text-word-break fs--1">Apakah Data Penjualan Ini Sudah Dilunasi Customer?
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Ya! Sudah </button>
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
                <form action="{{ url('/penjualan') }}" id="deleteForm" method="POST">
                    @method('delete')
                    @csrf
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <input type="hidden" name="penjualan_id" id="penjualan_id">
                                        <h5 class="mb-2 fs-0">Confirmation</h5>
                                        <p class="text-word-break fs--1">Apakah Anda Yakin Menghapus Data Penjualan
                                            ini?
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
            $('#penjualan_id').val(id)
            $('#ModalDelete').modal('show');

            $('#deleteForm').attr('action', '/penjualan/' + id)
        })

        $('.bayarBtn').click(function (e) {
            e.preventDefault();

            var id = $(this).val();
            $('#penjualan_bayar_id').val(id)
            $('#ModalBayar').modal('show');

            $('#bayarForm').attr('action', '/penjualan/bayar/' + id)
        })

        
    })

</script>

@endsection
