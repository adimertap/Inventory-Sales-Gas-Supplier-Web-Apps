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
                            Master Data Jenis Supplier
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
                                <div class="small font-weight-bold text-primary mb-1">Tambah Data Jenis</div>
                                <button class="btn btn-sm btn-primary" type="button" data-toggle="modal"
                                    data-target="#ModalTambah">Tambah Data</button><br>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Klik Button untuk menambah Jenis
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
                                <div class="small font-weight-bold text-primary mb-1">Total Jenis Supplier</div>
                                <div class="h5">{{ $count }} Jenis</div>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Count Jenis
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
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 200px;">Nama Jenis</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 20px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($jenis as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td>{{ $item->nama_jenis }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-primary btn-datatable editKategoriBtn"
                                                    value="{{ $item->id_jenis_supplier }}" type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit Jenis"> <i
                                                        class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger btn-datatable deleteKategoriBtn"
                                                    value="{{ $item->id_jenis_supplier }}" type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Delete Jenis"> <i
                                                        class="fas fa-trash"></i>
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


{{-- ADD MODAL --}}
<div class="modal fade" id="ModalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Tambah Jenis Supplier</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('master-jenis-supplier.store') }}" method="POST">
                    @csrf
                    <div class="col-12 border p-2 mr-1">
                        <h5 class="text-primary">Lengkapi Form Berikut!</h5>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="nama_jenis">Nama Jenis Supplier</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <input class="form-control" name="nama_jenis" type="text"
                                placeholder="Input Nama Jenis Supplier" value="{{ old('nama_jenis') }}"
                                class="form-control @error('nama_jenis') is-invalid @enderror" required>
                            @error('nama_jenis')<div class="text-danger small mb-1">{{ $message }}
                            </div> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Jenis Supplier</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/Master/master-jenis-supplier/') }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="col-12 border p-2 mr-1">
                        <input type="hidden" name="jenis_edit_id" id="jenis_edit_id">
                        <h5 class="text-primary">Lengkapi Form Berikut!</h5>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="nama_jenis">Nama Jenis Supplier</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <input class="form-control" name="nama_jenis" type="text" id="fjenis"
                                placeholder="Input Nama Jenis Supplier" value="{{ old('nama_jenis') }}" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Update Data</button>
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
                <form action="{{ url('Master/master-jenis-supplier') }}" id="deleteForm" method="POST">
                    @method('delete')
                    @csrf
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <input type="hidden" name="jenis_delete_id" id="jenis_delete_id">
                                        <h5 class="mb-2 fs-0">Confirmation</h5>
                                        <p class="text-word-break fs--1">Apakah Anda Yakin Menghapus Data Jenis ini?
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
        $('.deleteKategoriBtn').click(function (e) {
            e.preventDefault();

            var id = $(this).val();
            $('#jenis_delete_id').val(id)
            $('#ModalDelete').modal('show');

            $('#deleteForm').attr('action', '/Master/master-jenis-supplier/' + id)
        })

        var table = $('#dataTable').DataTable();

        table.on('click', '.editKategoriBtn', function () {
            var id = $(this).val();
            $('#jenis_edit_id').val(id)

            $tr = $(this).closest('tr');
            if ($($tr).hasClass('clid')) {
                $tr = $tr.prev('.parent')
            }

            var data = table.row($tr).data();
            console.log(data)

            $('#fjenis').val(data[1])

            $('#editForm').attr('action', '/Master/master-jenis-supplier/' + id)
            $('#ModalEdit').modal('show');

        })

    })

</script>

@endsection
