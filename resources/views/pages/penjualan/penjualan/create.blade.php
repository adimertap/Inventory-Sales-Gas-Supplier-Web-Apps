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
                            Tambah Data Penjualan
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <form action="{{ route('penjualan.store') }}" id="form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xl-6 mt-2">
                    <div class="card h-100">
                        <div class="card-header">Detail Formulir Penjualan</div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-xxl-12 col-xl-8">
                                    <div class="form-row">
                                        <input type="hidden" name="role_pegawai" value="{{ Auth::user()->role }}">
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1" for="kode_penjualan">Kode Penjualan</label>
                                            <input class="form-control" id="kode_penjualan" type="text"
                                                name="kode_penjualan" value="{{ $kode_penjualan }}" readonly />
                                        </div>
                                        @if (Auth::user()->role == 'Owner' || Auth::user()->role == 'Admin')
                                            <div class="form-group col-md-4">
                                                <label class="small mb-1 mr-1" for="id_pegawai">Pegawai</label><span
                                                    class="mr-4 mb-3" style="color: red">*</span>
                                                <select class="form-control" name="id_pegawai" class="form-control"
                                                    id="id_pegawai">
                                                    <option>Pilih Pegawai</option>
                                                    @foreach ($pegawai as $tes)
                                                    <option value="{{ $tes->id }}">{{ $tes->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1 mr-1" for="id_pegawai">Pegawai</label><span
                                                class="mr-4 mb-3" style="color: red">*</span>
                                            <select class="form-control" name="id_pegawai" class="form-control"
                                                id="id_pegawai">
                                                <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                            </select>
                                        </div>
                                           
                                        @endif

                                        <div class="form-group col-md-4">
                                            <label class="small mb-1 mr-1" for="tanggal_penjualan">Tanggal
                                                Penjualan</label><span class="mr-4 mb-3" style="color: red">*</span>
                                            <input class="form-control" id="tanggal_penjualan" type="date"
                                                name="tanggal_penjualan" placeholder="Input Tanggal Penjualan"
                                                value="{{ old('tanggal_penjualan') }}">
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('penjualan.index') }}" class="btn btn-sm btn-light"
                                            type="button">Kembali</a>
                                        <button class="btn btn-primary btn-sm" type="button"
                                            onclick="SimpanData(event, {{ $idbaru }})">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mt-2">
                    <div class="card h-100">
                        <div class="card-header">Pilih Customer dan Produk</div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-xxl-12 col-xl-8">
                                    <h6 class="card-title">Pilih Produk yang ingin dibeli</h6>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label class="small mb-1 mr-1" for="status_bayar">Status Bayar</label><span
                                            class="mr-4 mb-3" style="color: red">*</span>
                                            <select class="form-control" name="status_bayar" class="form-control" id="status_bayar">
                                                <option value="Pilih Status Bayar">Pilih Status Bayar</option>
                                                <option value="Dibayar">Lunas</option>
                                                <option value="Pending">Pending</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label class="small mb-1 mr-1" for="id_customer">Customer</label><span
                                                class="mr-4 mb-3" style="color: red">*</span>
                                            <div class="input-group input-group-joined">
                                                <div class="input-group-prepend mr-2">
                                                    <span class="input-group-text">
                                                        <button class="btn btn-sm btn-primary" type="button" data-toggle="modal"
                                                            data-target="#ModalTambahCustomer"><i class="fas fa-plus"></i></button>
                                                    </span>
                                                </div>
                                                <select class="form-control" name="id_customer" class="form-control"
                                                    id="id_customer">
                                                    <option>Pilih Customer</option>
                                                    @foreach ($customer as $item)
                                                    <option value="{{ $item->id_customer }}">{{ $item->nama_customer }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1 mr-1" for="id_produk">Pilih Produk</label><span
                                                class="mr-4 mb-3" style="color: red">*</span>
                                            <select class="form-control" name="id_produk" class="form-control"
                                                id="id_produk">
                                                <option>Pilih Produk</option>
                                                @foreach ($produk as $produks)
                                                <option value="{{ $produks->id_produk }}" id="{{ $produks->stok }}/{{ $produks->Kartugudangterakhir->harga_jual ?? ""  }}">{{ $produks->nama_produk }},
                                                    {{ $produks->Kategori->nama_kategori }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    </div>
    <div class="container-fluid mt-3">
        <div class="alert alert-primary" role="alert"><strong>Check Kembali</strong> Seluruh Produk Yang Anda Jual</div>
        <div class="card">
            <div class="card-header">Detail Penjualan</div>
            <div class="card-body p-1">
                <div class="table-responsive table-billing-history">
                    <table class="table mb-0" id="table_detail">
                        <thead>
                            <tr>
                                <th scope="col">Produk</th>
                                <th scope="col">Jumlah/Harga</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="konfirmasi">

                        </tbody>
                        <tr>
                            <td class="text-left  pb-0" colspan="2">
                                <div class="text-uppercase small font-weight-600 text-muted">Grand Total:</div>
                            </td>
                            <td class="text-primary" colspan="1">Rp. <span id="grand_total_table"></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="ModalTambahCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
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
                                <label class="small mb-1 mr-1" for="kode">Kode</label><span class="mr-4 mb-3"
                                    style="color: red">*</span>
                                <select name="kode" id="kode" class="form-control" required>
                                    <option>Kode</option>
                                    <option value="S">S</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label class="small mb-1 mr-1" for="email_customer">Email</label>
                                <input class="form-control" name="email_customer" type="email_customer"
                                    placeholder="Input Email" value="{{ old('email_customer') }}"
                                    class="form-control @error('email_customer') is-invalid @enderror">
                                @error('email_customer')<div class="text-danger small mb-1">{{ $message }}
                                </div> @enderror
                            </div>
                            <div class="form-group col-6">
                                <label class="small mb-1 mr-1" for="no_hp_customer">Telephone</label>
                                <input class="form-control" name="no_hp_customer" type="number"
                                    placeholder="Input No. Telephone" value="{{ old('no_hp_customer') }}"
                                    class="form-control @error('no_hp_customer') is-invalid @enderror">
                                @error('no_hp_customer')<div class="text-danger small mb-1">{{ $message }}
                                </div> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="alamat_customer">Alamat Customer</label>
                            <textarea class="form-control" name="alamat_customer" type="text"
                                placeholder="Input Alamat Lengkap" value="{{ old('alamat_customer') }}"
                                class="form-control @error('alamat_customer') is-invalid @enderror"></textarea>
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


<div class="modal fade" id="TesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk <span id="nama_produk_modal"></span></h5>
                <button class="close" type="button" data-dismiss="modal" id="close_modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <form action="" method="POST" id="form1" class="d-inline">
                <div class="modal-body">
                    <input id="id_produk_modal" type="hidden" name="id_produk_modal" readonly />
                    <label class="small mb-1 mr-1">Harga Per Produk</label>
                    <div class="input-group input-group-joined mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                Rp.
                            </span>
                        </div>
                        <input class="form-control harga_produk_modal" id="harga_produk_modal" type="number"
                            name="harga_produk_modal" placeholder="Input Harga Produk"
                            value="{{ old('harga_produk_modal') }}">
                    </div>
                    <div class="small text-primary">
                        <span id="detail_harga_produk_modal" class="detail_harga_produk_modal">

                        </span>
                    </div>
                    <div class="form-group mt-1">
                        <label class="small mb-1 mr-1">Jumlah</label>
                        <input class="form-control" id="jumlah_produk_modal" type="number" name="jumlah_produk_modal"
                            placeholder="Input Jumlah Produk" value="{{ old('jumlah_produk_modal') }}">
                    </div>
                    <hr>
                    <div class="small">Harga Penjualan Terakhir Rp. 
                        <span id="harga_terakhir" class="text-primary">

                        </span>
                    </div>
                    <div class="small">Jumlah Stok Gudang :
                        <span id="stok_gudang" class="text-primary">

                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="TambahProduk(event)" type="button">Tambah Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<template id="template_delete_button">
    <button class="btn btn-datatable btn-icon btn-transparent-dark" onclick="hapusdata(this)" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-trash-2">
            <polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            <line x1="10" y1="11" x2="10" y2="17"></line>
            <line x1="14" y1="11" x2="14" y2="17"></line>
        </svg>
    </button>
</template>



<script>
    $(document).ready(function () {
        $('.harga_produk_modal').each(function () {
            $(this).on('input', function () {
                var harga = $(this).val()
                var harga_fix = new Intl.NumberFormat('id', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(harga)

                var harga_paling_fix = $(this).parent().parent().find(
                    '.detail_harga_produk_modal')
                $(harga_paling_fix).html(harga_fix);
            })
        })
        var template = $('#template_delete_button').html()
        $('#table_detail').DataTable({
            paging: false,
            ordering: false,
            info: false,
            searching: false,
            "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": template
            }, ]
        });
    });

    $('#id_produk').change(function () {
        var id = $(this).val();
        var text = $(this).find("option:selected").text();
        var get_harga = $(this).find("option:selected").attr('id')
        var harga = get_harga.split('/')[1]
        var stok = get_harga.split('/')[0]

        if (id == 'Pilih Produk' || text == 'Pilih Produk') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Pilih Produk Terlebih Dahulu!',
            })
        } else {
            $('#id_produk').prop('selectedIndex', 0);
            $('#TesModal').modal('show');
            $('#nama_produk_modal').html(text)
            $('#id_produk_modal').val(id)
            $('#harga_terakhir').html(new Intl.NumberFormat('id').format(harga))
            $('#stok_gudang').html(stok)
        }
    });

    function TambahProduk(event) {
        var form = $('#form1')
        var id = form.find('input[name="id_produk_modal"]').val()
        var nama = $('#nama_produk_modal').text().replace(/^\s+|\s+$/gm, '');
        var harga = form.find('input[name="harga_produk_modal"]').val()
        var jumlah = form.find('input[name="jumlah_produk_modal"]').val()
        var harga_produk = new Intl.NumberFormat('id').format(harga)
        var total = new Intl.NumberFormat('id').format(jumlah * harga)

        if (harga == 0 | harga == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Field Harga Kosong, Isi Field Harga!',
            })
        } else if (jumlah == 0 | jumlah == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Field Jumlah Kosong, Isi Field Jumlah!',
            })
        } else {
            var table = $('#table_detail').DataTable()
            var row = $(`#${$.escapeSelector(id.trim())}`).parent().parent()
            table.row(row).remove().draw();


            $('#table_detail').DataTable().row.add([
                `<span id=${id}>${nama}</span>`, `<span id=${harga}>${jumlah + "/"+ harga_produk}</span>`,
                `<span id=${jumlah}>${total}</span>`, total
            ]).draw();

            $('#close_modal').click()
            $('#form1').trigger("reset");
            $('#detail_harga_produk_modal').html("Rp");

            // GRAND TOTAL
            var grand2 = 0
            var data = $('#konfirmasi').children()
            for (let index = 0; index < data.length; index++) {
                var children = $(data[index]).children()
                var td_check_total = children[2]
                var td_tot = $(td_check_total).text()
                var td_table_total = td_tot.replace('.', '').replace('.', '').trim()
                var grand2 = parseInt(grand2) + parseInt(td_table_total)

            }
            $('#grand_total_table').html(new Intl.NumberFormat('id').format(grand2))
            $('#grand_total').val(new Intl.NumberFormat('id').format(grand2))

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'Berhasil Menambahkan Data Produk'
            })
        }
    }

    function hapusdata(element) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var table = $('#table_detail').DataTable()
                var row = $(element).parent().parent()
                table.row(row).remove().draw();
                var table = $('#table_detail').DataTable()

                var td_total = $(row.children()[2]).text()
                var total = td_total.replace('.', '').replace('.', '').trim()
                var grand = $('#grand_total_table').html()
                var grand_total_table = grand.replace('.', '').replace('.', '').trim()
                var total_perhitungan = total.replace('.', '').replace('.', '').trim()
                var perhitungan = parseInt(grand_total_table) - parseInt(total_perhitungan)
                $('#grand_total_table').html(new Intl.NumberFormat('id').format(perhitungan))
                $('#grand_total').val(new Intl.NumberFormat('id').format(perhitungan))

            }
        })
    }

    function SimpanData(event, id_penjualan) {
        Swal.fire({
            title: 'Do you want to save the changes?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Save',
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $('#form')
                var _token = form.find('input[name="_token"]').val()
                var kode_penjualan = form.find('input[name="kode_penjualan"]').val()
                var tanggal_penjualan = form.find('input[name="tanggal_penjualan"]').val()
                var id_customer = $('#id_customer').find("option:selected").val();
                var grand_total = $('#grand_total_table').html()
                var status_bayar =  $('#status_bayar').find("option:selected").val();
                var dataform2 = []
                var role = form.find('input[name="role_pegawai"]').val()
                if(role == 'Owner'){
                    var id_pegawai = $('#id_pegawai').find("option:selected").val();
                }else{
                    var id_pegawai = form.find('input[name="id_pegawai"]').val()
                }

                if (tanggal_penjualan == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Isi Tanggal Terlebih Dahulu',
                    })
                } else if (id_customer == 'Pilih Customer' || id_customer == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pilih Customer Terlebih Dahulu',
                    })
                } else if(status_bayar == 'Pilih Status Bayar' || status_bayar == ''){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pilih Status Bayar Terlebih Dahulu',
                    })
                }else if (grand_total == 0 || grand_total == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Belum Ada Produk, Tambahkan Produk Dahulu',
                    })
                } else if(id_pegawai == 'Pilih Pegawai' || id_pegawai == ""){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Belum Memilih Pegawai',
                    })
                }else {
                    var data = $('#konfirmasi').children()
                    for (let index = 0; index < data.length; index++) {
                        var children = $(data[index]).children()

                        // Validasi Table Kosong
                        var validasichildren = children.children()

                        // Id Produk
                        var td = children[0]
                        var span = $(td).children()[0]
                        var id_produk = $(span).attr('id')

                        var td_jumlah = children[2]
                        var span_jumlah = $(td_jumlah).children()[0]
                        var jumlah_jual = $(span_jumlah).attr('id')

                        var td_harga = children[1]
                        var span_harga = $(td_harga).children()[0]
                        var harga_jual = $(span_harga).attr('id')

                        var td_total = children[2]
                        var td_tot = $(td_total).text()
                        var total_jual = td_tot.replace('.', '').replace('.', '').trim()

                        var obj = {
                            id_produk: id_produk,
                            id_penjualan: id_penjualan,
                            id_produk: id_produk,
                            jumlah_jual: jumlah_jual,
                            harga_jual: harga_jual,
                            total_jual: total_jual,
                        }
                        dataform2.push(obj)
                    }

                    if (dataform2.length == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Produk Penjualan Kosong!, Isi Transaksi Terlebih Dahulu',
                        })
                    } else {
                        var data = {
                            _token: _token,
                            kode_penjualan: kode_penjualan,
                            tanggal_penjualan: tanggal_penjualan,
                            id_customer: id_customer,
                            status_bayar: status_bayar,
                            id: id_pegawai,
                            detail: dataform2
                        }

                        console.log(data)


                        $.ajax({
                            method: 'post',
                            url: '/penjualan',
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
                                window.location.href = '/penjualan'
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
                }
            }
        })
    }

</script>




@endsection
