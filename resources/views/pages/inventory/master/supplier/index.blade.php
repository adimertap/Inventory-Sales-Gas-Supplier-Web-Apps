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
                            Master Data Supplier
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
                                <div class="small font-weight-bold text-primary mb-1">Tambah Data Supplier</div>
                                <button class="btn btn-sm btn-primary" type="button" data-toggle="modal"
                                    data-target="#ModalTambah">Tambah Data</button><br>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Klik Button untuk menambah Supplier
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
                                <div class="small font-weight-bold text-primary mb-1">Total Supplier</div>
                                <div class="h5">{{ $count_supplier }} Supplier</div>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Count Supplier
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
                                                style="width: 120px;">Nama Supplier</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 40px;">No. Telephone</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 40px;">Jenis Supplier</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 200px;">Alamat</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 20px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($supplier as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td>{{ $item->nama_supplier }}</td>
                                            <td>{{ $item->email_supplier }}</td>
                                            <td>{{ $item->no_hp_supplier }}</td>
                                            <td><span id="{{ $item->Jenis->id_jenis_supplier }}">{{ $item->Jenis->nama_jenis }}</span></td>
                                            <td>{{ $item->alamat_supplier }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-primary btn-datatable editSupplierBtn"
                                                    value="{{ $item->id_supplier }}" type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit Supplier"> <i
                                                        class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger btn-datatable deleteSupplierBtn"
                                                    value="{{ $item->id_supplier }}" type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Delete Supplier"> <i
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
                <h5 class="modal-title text-white">Tambah Supplier</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('master-supplier.store') }}" method="POST">
                    @csrf
                    <div class="col-12 border p-2 mr-1">
                        <h5 class="text-primary">Informasi Supplier!</h5>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="nama_supplier">Nama Supplier</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <input class="form-control" name="nama_supplier" type="text"
                                placeholder="Input Nama Supplier" value="{{ old('nama_supplier') }}"
                                class="form-control @error('nama_supplier') is-invalid @enderror" required>
                            @error('nama_supplier')<div class="text-danger small mb-1">{{ $message }}
                            </div> @enderror
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="email_supplier">Email</label>
                                    <input class="form-control" name="email_supplier" type="email_supplier"
                                        placeholder="Input Email" value="{{ old('email_supplier') }}"
                                        class="form-control @error('email_supplier') is-invalid @enderror">
                                    @error('email_supplier')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="no_hp_supplier">Nomor Telephone</label>
                                    <input class="form-control" name="no_hp_supplier" type="number"
                                        placeholder="Input No. Telephone" value="{{ old('no_hp_supplier') }}"
                                        class="form-control @error('no_hp_supplier') is-invalid @enderror">
                                    @error('no_hp_supplier')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="id_jenis_supplier">Pilih Jenis Supplier</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <select class="form-control" name="id_jenis_supplier" class="form-control"
                                id="id_jenis_supplier" required>
                                <option>Pilih Jenis</option>
                                @foreach ($jenis as $tes)
                                <option value="{{ $tes->id_jenis_supplier }}">{{ $tes->nama_jenis }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="alamat_supplier">Alamat Supplier</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <textarea class="form-control" name="alamat_supplier" type="text"
                                placeholder="Input Alamat Lengkap" value="{{ old('alamat_supplier') }}"
                                class="form-control @error('alamat_supplier') is-invalid @enderror"
                                required></textarea>
                            @error('alamat_supplier')<div class="text-danger small mb-1">{{ $message }}
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
                <h5 class="modal-title text-white">Edit Supplier</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/Master/master-supplier/') }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')

                    <div class="col-12 border p-2 mr-1">
                        <h5 class="text-primary">Informasi Supplier!</h5>
                        <input type="hidden" name="supplier_edit_id" id="supplier_edit_id">
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="nama_supplier">Nama Supplier</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <input class="form-control" name="nama_supplier" type="text" id="fnama"
                                placeholder="Input Nama Supplier" value="{{ old('nama_supplier') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="email_supplier">Email</label>
                                    <input class="form-control" name="email_supplier" type="email_supplier" id="femail"
                                        placeholder="Input Email Supplier" value="{{ old('email_supplier') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="no_hp_supplier">Nomor Telephone</label>
                                    <input class="form-control" name="no_hp_supplier" type="number" id="fphone"
                                        placeholder="Input No. Telephone" value="{{ old('no_hp_supplier') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="id_jenis_supplier">Pilih Jenis Supplier</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <select class="form-control" name="id_jenis_supplier" class="form-control"
                                id="fjenis" required>
                                <option value="" id="tes">Pilih Jenis</option>
                                @foreach ($jenis as $tes)
                                <option value="{{ $tes->id_jenis_supplier }}">{{ $tes->nama_jenis }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="alamat_supplier">Alamat Supplier</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <textarea class="form-control" name="alamat_supplier" type="text" id="falamat"
                                placeholder="Input Alamat Lengkap" value="{{ old('alamat_supplier') }}"
                                class="form-control @error('alamat_supplier') is-invalid @enderror" required></textarea>
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
                <form action="{{ url('Master/master-supplier') }}" id="deleteForm" method="POST">
                    @method('delete')
                    @csrf
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <input type="hidden" name="supplier_delete_id" id="supplier_delete_id">
                                        <h5 class="mb-2 fs-0">Confirmation</h5>
                                        <p class="text-word-break fs--1">Apakah Anda Yakin Menghapus Data Supplier ini?
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
        $('.deleteSupplierBtn').click(function (e) {
            e.preventDefault();

            var id = $(this).val();
            $('#supplier_delete_id').val(id)
            $('#ModalDelete').modal('show');

            $('#deleteForm').attr('action', '/Master/master-supplier/' + id)
        })

        var table = $('#dataTable').DataTable();

        table.on('click', '.editSupplierBtn', function () {
            var id = $(this).val();
            $('#supplier_edit_id').val(id)

            $tr = $(this).closest('tr');
            if ($($tr).hasClass('clid')) {
                $tr = $tr.prev('.parent')
            }

            var data = table.row($tr).data();
            var id_jenis = $(data[4]).attr('id')
            console.log(data, id_jenis)
          
            $('#fnama').val(data[1])
            $('#femail').val(data[2])
            $('#fphone').val(data[3])
            // $('#tes').text(data[4])
            $('#fjenis').val(id_jenis)
            $('#falamat').val(data[5])

            $('#editForm').attr('action', '/Master/master-supplier/' + id)
            $('#ModalEdit').modal('show');

        })

    })

</script>

@endsection
