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
                            Penerimaan Pembelian Produk Dari Supplier
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
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-primary mb-1">Pembelian Belum Diproses</div>
                                <div class="h5">{{ $count_proses }} Data</div>
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
            <div class="card-header">Pembelian Aktif</div>
            <div class="card-body p-0">
                <div class="table-responsive table-billing-history">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Kode Pembelian</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pembelian as $tes)
                            <tr>
                                <td>{{ $tes->kode_pembelian }}</td>
                                <td>{{ $tes->tanggal_pembelian }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm prosesBtn small p-0"
                                        value="{{ $tes->id_pembelian }}" type="button" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Proses Pembelian"> Proses
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
                                                style="width: 80px;">Pegawai</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Kode Pembelian</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 90px;">Kode Penerimaan</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Tanggal Penerimaan</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 40px;">Total Penerimaan</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 40px;">Status</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 60px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($penerimaan as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td>{{ $item->Pegawai->name }}</td>
                                            <td>{{ $item->Pembelian->kode_pembelian }}</td>
                                            <td>{{ $item->kode_penerimaan }}</td>
                                            <td>{{ $item->tanggal_penerimaan }}</td>
                                            <td>Rp. {{ number_format($item->grand_total) }}</td>
                                            <td class="text-center">
                                                @if($item->status_pembayaran == 'Dibayar')
                                                <span class="badge badge-success">Lunas</span>
                                                @elseif($item->status_pembayaran == 'Pending')
                                                <button class="btn btn-primary btn-datatable bayarBtn"
                                                    value="{{ $item->id_penerimaan }}" type="button"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Bayar Penerimaan"> <i class="fas fa-credit-card"></i>
                                                </button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('penerimaan.show', $item->id_penerimaan) }}"
                                                    class="btn btn-secondary btn-datatable" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Detail Penerimaan"> <i
                                                        class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('penerimaan.edit', $item->id_penerimaan) }}"
                                                    class="btn btn-primary btn-datatable" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit Penerimaan"> <i
                                                        class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-danger btn-datatable deleteBtn"
                                                    value="{{ $item->id_penerimaan }}" type="button"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Delete Penerimaan"> <i class="fas fa-trash"></i>
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

{{-- BAYAR MODAL --}}
<div class="modal fade" id="ModalBayar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Konfirmasi Bayar Penerimaan</h5>
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
                                        <input type="hidden" name="penerimaan_bayar_id" id="penerimaan_bayar_id">
                                        <h5 class="mb-2 fs-0">Confirmation</h5>
                                        <p class="text-word-break fs--1">Apakah Anda Yakin Membayar Data Penerimaan
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
                <button class="btn btn-primary" type="submit">Yes! Bayar </button>
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
                <form action="{{ url('/penerimaan') }}" id="deleteForm" method="POST">
                    @method('delete')
                    @csrf
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <input type="hidden" name="penerimaan_id" id="penerimaan_id">
                                        <h5 class="mb-2 fs-0">Confirmation</h5>
                                        <p class="text-word-break fs--1">Apakah Anda Yakin Menghapus Data Penerimaan
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

<div class="modal fade" id="ModalProses" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Konfirmasi Kelengkapan Produk</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body p-0">
                <form id="prosesForm">
                    @csrf
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <input type="hidden" name="pembelian_id" id="pembelian_id">
                                        <h5 class="mb-2 fs-0">Confirmation</h5>
                                        <p class="text-word-break fs--1">Apakah Produk yang dibeli Sudah Lengkap dan
                                            Sesuai dengan Formulir Pembelian?
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="submit">Tidak Lengkap</button>
                <button href="#" onclick="lengkap(event)" class="btn btn-success" type="button">
                    <span style="display: none" id="pembelian_id2"></span> Ya! Lengkap</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    function lengkap(event) {
        var form = $('#prosesForm')
        var _token = form.find('input[name="_token"]').val()
        var id = $('#pembelian_id2').html();

        var data = {
            _token: _token,
            id: id,
        }

        console.log(data)

        $.ajax({
            method: 'post',
            url: '/penerimaan/lengkap/' + id,
            data: data,
            success: function (response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal
                            .stopTimer)
                        toast.addEventListener('mouseleave', Swal
                            .resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: 'Data Masih Diproses Mohon Tunggu'
                })
                window.location.href = '/penerimaan'
            },
            error: function (response) {
                console.log(response)
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error! Data Tidak dapat disimpan',
                })
            }
        });

    }


    $(document).ready(function () {
        $('.deleteBtn').click(function (e) {
            e.preventDefault();

            var id = $(this).val();
            $('#penerimaan_id').val(id)
            $('#ModalDelete').modal('show');

            $('#deleteForm').attr('action', '/penerimaan/' + id)
        })

        $('.prosesBtn').click(function (e) {
            e.preventDefault();

            var id_pembelian = $(this).val();
            $('#pembelian_id').val(id_pembelian)
            $('#pembelian_id2').html(id_pembelian)
            $('#ModalProses').modal('show');

            $('#prosesForm').attr('action', '/penerimaan/proses/' + id_pembelian)
        })

        $('.bayarBtn').click(function (e) {
            e.preventDefault();

            var penerimaan_bayar_id = $(this).val();
            $('#penerimaan_bayar_id').val(penerimaan_bayar_id)
            $('#ModalBayar').modal('show');

            $('#bayarForm').attr('action', '/penerimaan/bayar/' + penerimaan_bayar_id)
        })

        var table = $('#dataTable').DataTable();
    })

</script>

@endsection
