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
                            Master Data Produk
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
                                <div class="small font-weight-bold text-primary mb-1">Tambah Data Produk</div>
                                <button class="btn btn-sm btn-primary" type="button" data-toggle="modal"
                                    data-target="#ModalTambah">Tambah Data</button><br>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Klik Button untuk menambah Produk
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
                                <div class="small font-weight-bold text-primary mb-1">Total Produk</div>
                                <div class="h5">{{ $count_produk }} Produk</div>
                                <div class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                    Count Produk
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
                                                style="width: 120px;">Nama Produk</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Kategori</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 40px;">Jumlah Minimal</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 20px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($produk as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td>{{ $item->nama_produk }}</td>
                                            <td>
                                                <span id="{{ $item->Kategori->id_kategori }}">{{ $item->Kategori->nama_kategori }}</span>
                                            </td>
                                            <td class="text-center">{{ $item->jumlah_minimal }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-primary btn-datatable editProdukBtn"
                                                    value="{{ $item->id_produk }}" type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit Produk"> <i
                                                        class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger btn-datatable deleteProdukBtn"
                                                    value="{{ $item->id_produk }}" type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Delete Produk"> <i
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
                <h5 class="modal-title text-white">Tambah Produk</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('master-produk.store') }}" method="POST">
                    @csrf
                    <div class="col-12 border p-2 mr-1">
                        <h5 class="text-primary">Informasi Produk!</h5>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="nama_produk">Nama Produk</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <input class="form-control" name="nama_produk" type="text"
                                placeholder="Input Nama Produk" value="{{ old('nama_produk') }}"
                                class="form-control @error('nama_produk') is-invalid @enderror" required>
                            @error('nama_produk')<div class="text-danger small mb-1">{{ $message }}
                            </div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="id_kategori">Kategori</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <select class="form-control" name="id_kategori"
                                class="form-control @error('id_kategori') is-invalid @enderror">
                                <option>Pilih Kategori</option>
                                @foreach ($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_kategori')<div class="text-danger small mb-1">{{ $message }}
                            </div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="jumlah_minimal">Jumlah Minimal</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <input class="form-control" name="jumlah_minimal" type="number"
                                placeholder="Input Jumlah Minimal" value="{{ old('jumlah_minimal') }}"
                                class="form-control @error('jumlah_minimal') is-invalid @enderror" required>
                            @error('jumlah_minimal')<div class="text-danger small mb-1">{{ $message }}
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
                <h5 class="modal-title text-white">Edit Produk</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/Master/master-produk/') }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="produk_edit_id" id="produk_edit_id">
                    <div class="col-12 border p-2 mr-1">
                        <h5 class="text-primary">Informasi Produk!</h5>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="nama_produk">Nama Produk</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <input class="form-control" name="nama_produk" type="text" id="fnama"
                                placeholder="Input Nama Produk" value="{{ old('nama_produk') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="id_kategori">Kategori</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <select class="form-control" name="id_kategori" >
                                <option value="" id="fkategori"></option>
                                @foreach ($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="jumlah_minimal">Jumlah Minimal</label><span
                                class="mr-4 mb-3" style="color: red">*</span>
                            <input class="form-control" name="jumlah_minimal" type="number" id="fjumlah"
                                placeholder="Input Jumlah Minimal" value="{{ old('jumlah_minimal') }}">
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
                <form action="{{ url('Master/master-produk') }}" id="deleteForm" method="POST">
                    @method('delete')
                    @csrf
                    <div class="p-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex">
                                    <div class="flex-1">
                                        <input type="hidden" name="produk_delete_id" id="produk_delete_id">
                                        <h5 class="mb-2 fs-0">Confirmation</h5>
                                        <p class="text-word-break fs--1">Apakah Anda Yakin Menghapus Data Produk ini?
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
        $('.deleteProdukBtn').click(function (e) {
            e.preventDefault();

            var id = $(this).val();
            $('#produk_delete_id').val(id)
            $('#ModalDelete').modal('show');

            $('#deleteForm').attr('action', '/Master/master-produk/' + id)
        })

        var table = $('#dataTable').DataTable();

        table.on('click', '.editProdukBtn', function () {
            var id = $(this).val();
            $('#produk_edit_id').val(id)

            $tr = $(this).closest('tr');
            if ($($tr).hasClass('clid')) {
                $tr = $tr.prev('.parent')
            }

            var data = table.row($tr).data();
            console.log(data)

            $('#fnama').val(data[1])
            $('#fjumlah').val(data[3])
            $('#fkategori').html("Pilihan Awal " + data[2])
            
            var span = data[2]
            var id_kategori = $(span).attr('id')
            $('#fkategori').val(id_kategori)

            $('#editForm').attr('action', '/Master/master-produk/' + id)
            $('#ModalEdit').modal('show');

        })

    })

</script>

@endsection
