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
                            Master Data Customer
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
                                <div class="small font-weight-bold text-primary mb-1">Tambah Data Customer</div>
                                <button class="btn btn-sm btn-primary" type="button" data-toggle="modal"
                                    data-target="#ModalTambah">Tambah Data</button><br>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Klik Button untuk menambah Customer
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
                                <div class="small font-weight-bold text-primary mb-1">Total Customer</div>
                                <div class="h5">{{ $count_customer }} Customer</div>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Count Customer
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
                                                style="width: 40px;">Kode</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 120px;">Nama Customer</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 40px;">No. Telephone</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 40px;">Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 140px;">Alamat</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 20px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($customer as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td><span id="{{ $item->code }}">{{ $item->kode_customer }}</span></td>
                                            <td>{{ $item->nama_customer }}</td>
                                            <td>{{ $item->no_hp_customer }}</td>
                                            <td>{{ $item->email_customer }}</td>
                                            <td>{{ $item->alamat_customer }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-primary btn-datatable editCustomerBtn"
                                                    value="{{ $item->id_customer }}" type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit Customer"> <i
                                                        class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger btn-datatable deleteCustomerBtn"
                                                    value="{{ $item->id_customer }}" type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Delete Customer"> <i
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
                <h5 class="modal-title text-white">Tambah Customer</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('master-customer.store') }}" method="POST">
                    @csrf
                    <div class="col-12 border p-2 mr-1">
                        <h5 class="text-primary">Informasi Customer!</h5>
                        <div class="form-row">
                            <div class="form-group col-9">
                                <label class="small mb-1 mr-1" for="nama_customer">Nama Customer</label><span
                                    class="mr-4 mb-3" style="color: red">*</span>
                                <input class="form-control" name="nama_customer" type="text"
                                    placeholder="Input Nama Customer" value="{{ old('nama_customer') }}"
                                    class="form-control @error('nama_customer') is-invalid @enderror" required>
                                @error('nama_customer')<div class="text-danger small mb-1">{{ $message }}
                                </div> @enderror
                            </div>
                         
                            <div class="form-group col-3">
                                <label class="small mb-1 mr-1" for="code">Kode</label><span class="mr-4 mb-3"
                                    style="color: red">*</span>
                                <select name="code" id="code" class="form-control" required>
                                    <option>Kode</option>
                                    <option value="S">S</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="email_customer">Email</label>
                                    <input class="form-control" name="email_customer" type="email_customer"
                                        placeholder="Input Email" value="{{ old('email_customer') }}"
                                        class="form-control @error('email_customer') is-invalid @enderror">
                                    @error('email_customer')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="no_hp_customer">Nomor Telephone</label>
                                    <input class="form-control" name="no_hp_customer" type="number"
                                        placeholder="Input No. Telephone" value="{{ old('no_hp_customer') }}"
                                        class="form-control @error('no_hp_customer') is-invalid @enderror">
                                    @error('no_hp_customer')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="alamat_customer">Alamat Customer</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <textarea class="form-control" name="alamat_customer" type="text"
                                placeholder="Input Alamat Lengkap" value="{{ old('alamat_customer') }}"
                                class="form-control @error('alamat_customer') is-invalid @enderror"
                                required></textarea>
                            @error('alamat_customer')<div class="text-danger small mb-1">{{ $message }}
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
                <h5 class="modal-title text-white">Edit Customer</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/Penjualan/master-customer/') }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')

                    <div class="col-12 border p-2 mr-1">
                        <h5 class="text-primary">Informasi Customer!</h5>
                        <input type="hidden" name="customer_edit_id" id="customer_edit_id">
                        <div class="form-row">
                            <div class="form-group col-9">
                                <label class="small mb-1 mr-1" for="nama_customer">Nama Customer</label><span
                                    class="mr-4 mb-3" style="color: red">*</span>
                                <input class="form-control" name="nama_customer" type="text" id="fnama"
                                    placeholder="Input Nama Supplier" value="{{ old('nama_customer') }}" required>
                            </div>
                            <div class="form-group col-3">
                                <label class="small mb-1 mr-1" for="kode">Kode</label><span class="mr-4 mb-3"
                                    style="color: red">*</span>
                                <select name="kode" id="fkode" class="form-control" required>
                                    <option value="" id="code">Kode</option>
                                    <option value="S">S</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="email_customer">Email</label>
                                    <input class="form-control" name="email_customer" type="email_customer" id="femail"
                                        placeholder="Input Email Supplier" value="{{ old('email_customer') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="no_hp_customer">Nomor Telephone</label>
                                    <input class="form-control" name="no_hp_customer" type="number" id="fphone"
                                        placeholder="Input No. Telephone" value="{{ old('no_hp_customer') }}" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="alamat_customer">Alamat Customer</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <textarea class="form-control" name="alamat_customer" type="text" id="falamat"
                                placeholder="Input Alamat Lengkap" value="{{ old('alamat_customer') }}"
                                class="form-control @error('alamat_customer') is-invalid @enderror" required></textarea>
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
                <form action="{{ url('/Penjualan/master-customer') }}" id="deleteForm" method="POST">
                    @method('delete')
                    @csrf
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <input type="hidden" name="customer_delete_id" id="customer_delete_id">
                                        <h5 class="mb-2 fs-0">Confirmation</h5>
                                        <p class="text-word-break fs--1">Apakah Anda Yakin Menghapus Data Customer ini?
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
        $('.deleteCustomerBtn').click(function (e) {
            e.preventDefault();

            var id = $(this).val();
            $('#customer_delete_id').val(id)
            $('#ModalDelete').modal('show');

            $('#deleteForm').attr('action', '/Penjualan/master-customer/' + id)
        })

        var table = $('#dataTable').DataTable();

        table.on('click', '.editCustomerBtn', function () {
            var id = $(this).val();
            $('#customer_edit_id').val(id)

            $tr = $(this).closest('tr');
            if ($($tr).hasClass('clid')) {
                $tr = $tr.prev('.parent')
            }

            var data = table.row($tr).data();
            var span_kode = data[1]
            var code = $(span_kode).attr('id')

            $('#fnama').val(data[2])
            $('#femail').val(data[4])
            $('#fphone').val(data[3])
            $('#falamat').val(data[5])
            $('#code').val(code)
            $('#code').text(code)
            $('#fkode').val(code)
            
            $('#editForm').attr('action', '/Penjualan/master-customer/' + id)
            $('#ModalEdit').modal('show');
        })

    })

</script>

@endsection
