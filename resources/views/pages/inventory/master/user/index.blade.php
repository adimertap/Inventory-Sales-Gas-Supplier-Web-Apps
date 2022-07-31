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
                            Master Data Pegawai
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-primary mb-1">Tambah Data Pegawai</div>
                                <button class="btn btn-sm btn-primary" type="button" data-toggle="modal"
                                    data-target="#ModalTambah">Tambah Data</button><br>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Klik Button untuk menambah Pegawai
                                </div>
                            </div>
                            <div class="ml-2">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-primary mb-1">Total Owner</div>
                                <div class="h5">{{ $count_owner }} Orang</div>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Role Owner
                                </div>
                            </div>
                            <div class="ml-2">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-info mb-1">Total Admin</div>
                                <div class="h5">{{ $count_admin }} Orang</div>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Role Admin
                                </div>
                            </div>
                            <div class="ml-2">
                                <i class="fa-solid fa-user-gear"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-secondary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold text-secondary mb-1">Total Pegawai</div>
                                <div class="h5">{{ $count_pegawai }} Orang</div>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Role Pegawai
                                </div>
                            </div>
                            <div class="ml-2">
                                <i class="fa-solid fa-user-gear"></i>
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
                                                style="width: 30px;">Kode</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 140px;">Nama</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Nama Panggilan</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 40px;">No. Telephone</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 20px;">Email</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 30px;">Role</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 70px;">Alamat</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 20px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pegawai as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td>{{ $item->kode_pegawai }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->nama_panggilan }}</td>
                                            <td>{{ $item->no_telephone }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->role }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-primary btn-datatable editUserBtn"
                                                    value="{{ $item->id }}" type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Delete"> <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger btn-datatable deleteUserBtn"
                                                    value="{{ $item->id }}" type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Delete"> <i class="fas fa-trash"></i>
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
                <h5 class="modal-title text-white">Edit Pegawai</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('master-user.store') }}" method="POST">
                    @csrf

                    <div class="col-12 border p-2 mr-1">
                        <h5 class="text-primary">Informasi Pegawai!</h5>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="name">Nama Lengkap</label><span class="mr-4 mb-3"
                                style="color: red">*</span>
                            <input class="form-control" name="name" type="text"
                                placeholder="Input Nama Lengkap Pegawai" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')<div class="text-danger small mb-1">{{ $message }}
                            </div> @enderror
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="nama_panggilan">Nama Panggilan</label><span
                                        class="mr-4 mb-3" style="color: red">*</span>
                                    <input class="form-control" name="nama_panggilan" type="text"
                                        placeholder="Input Nama Panggilan" value="{{ old('nama_panggilan') }}"
                                        class="form-control @error('nama_panggilan') is-invalid @enderror" required>
                                    @error('nama_panggilan')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="no_telephone">Nomor Telephone</label><span
                                        class="mr-4 mb-3" style="color: red">*</span>
                                    <input class="form-control" name="no_telephone" type="number"
                                        placeholder="Input No. Telephone" value="{{ old('no_telephone') }}"
                                        class="form-control @error('no_telephone') is-invalid @enderror" required>
                                    @error('no_telephone')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="alamat">Alamat</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <input class="form-control" name="alamat" type="text" id="alamat"
                                placeholder="Input Alamat" value="{{ old('alamat') }}" required>
                        </div>
                        <hr>
                        <h5 class="text-primary">Akun Pegawai!</h5>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="role">Role</label><span class="mr-4 mb-3"
                                        style="color: red">*</span>
                                    <select name="role" class="form-control"
                                        class="form-control @error('role') is-invalid @enderror" required>
                                        <option value="{{ old('role')}}"> Pilih Role</option>
                                        <option value="Owner">Owner</option>
                                        <option value="Pegawai">Pegawai</option>
                                         <option value="Admin">Admin</option>
                                    </select>
                                    @error('role')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="email">Email</label><span class="mr-4 mb-3"
                                        style="color: red">*</span>
                                    <input class="form-control" name="email" type="email"
                                        placeholder="Input Email Akun Pegawai" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror" required
                                        autocomplete="email">
                                    @error('email')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="password">Password</label><span
                                        class="mr-4 mb-3" style="color: red">*</span>
                                    <input class="form-control" name="password" type="password"
                                        placeholder="Input Password Akun" value="{{ old('password') }}"
                                        class="form-control @error('password') is-invalid @enderror" required
                                        autocomplete="new-password">
                                    @error('password')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="password_confirmation">Password</label><span
                                        class="mr-4 mb-3" style="color: red">*</span>
                                    <input class="form-control" name="password_confirmation" type="password"
                                        id="password-confirm" placeholder="Input Password Akun"
                                        value="{{ old('password') }}"
                                        class="form-control @error('password') is-invalid @enderror" required
                                        autocomplete="new-password">
                                    @error('password')<div class="text-danger small mb-1">{{ $message }}
                                    </div> @enderror
                                </div>
                            </div>
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
                <h5 class="modal-title text-white">Tambah Pegawai</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/Master/master-user/') }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')

                    <div class="col-12 border p-2 mr-1">
                        <h5 class="text-primary">Informasi Pegawai!</h5>
                        <input type="hidden" name="pegawai_edit_id" id="pegawai_edit_id">
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="name">Nama Lengkap</label><span class="mr-4 mb-3"
                                style="color: red">*</span>
                            <input class="form-control" name="name" type="text" id="fname"
                                placeholder="Input Nama Lengkap Pegawai" value="{{ old('name') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="nama_panggilan">Nama Panggilan</label><span
                                        class="mr-4 mb-3" style="color: red">*</span>
                                    <input class="form-control" name="nama_panggilan" type="text" id="fnama_panggilan"
                                        placeholder="Input Nama Panggilan" value="{{ old('nama_panggilan') }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="no_telephone">Nomor Telephone</label><span
                                        class="mr-4 mb-3" style="color: red">*</span>
                                    <input class="form-control" name="no_telephone" type="number" id="fno_telephone"
                                        placeholder="Input No. Telephone" value="{{ old('no_telephone') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="alamat">Alamat</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <input class="form-control" name="alamat" type="text" id="falamat"
                                placeholder="Input Alamat" value="{{ old('alamat') }}" required>
                        </div>
                        <hr>
                        <h5 class="text-primary">Akun Pegawai!</h5>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="role">Role</label><span class="mr-4 mb-3"
                                        style="color: red">*</span>
                                    <select name="role" id="frole" class="form-control" required>
                                        <option value="" id="roless"> Pilih Role</option>
                                        <option value="Owner">Owner</option>
                                        <option value="Pegawai">Pegawai</option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label class="small mb-1 mr-1" for="email">Email</label><span class="mr-4 mb-3"
                                        style="color: red">*</span>
                                    <input class="form-control" name="email" type="email" id="femail"
                                        placeholder="Input Email Akun Pegawai" value="{{ old('email') }}"required
                                        autocomplete="email">
                                </div>
                            </div>
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
                <form action="{{ url('Master/master-user') }}" id="deleteForm" method="POST">
                @method('delete')
                @csrf
                <div class="p-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex">
                                <div class="flex-1">
                                    <input type="hidden" name="pegawai_delete_id" id="id_user">
                                    <h5 class="mb-2 fs-0">Confirmation</h5>
                                    <p class="text-word-break fs--1">Apakah Anda Yakin Menghapus Data Pegawai ini?
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
        $('.deleteUserBtn').click(function (e) {
            e.preventDefault();

            var id = $(this).val();
            $('#id_user').val(id)
            $('#ModalDelete').modal('show');

            $('#deleteForm').attr('action','/Master/master-user/'+id)
        })

        var table = $('#dataTable').DataTable();

        table.on('click','.editUserBtn', function(){
            var id = $(this).val();
            $('#pegawai_edit_id').val(id)

            $tr = $(this).closest('tr');
            if($($tr).hasClass('clid')){
                $tr = $tr.prev('.parent')
            }

            var data = table.row($tr).data();
         

            $('#fname').val(data[2])
            $('#fnama_panggilan').val(data[3])
            $('#fno_telephone').val(data[4])
            $('#femail').val(data[5])
            $('#frole').val(data[6])
            $('#roless').val(data[6])
            $('#roless').text(data[6])
            $('#falamat').val(data[7])
            
            $('#editForm').attr('action','/Master/master-user/'+id)
            $('#ModalEdit').modal('show');

        })

    })

</script>

@endsection
