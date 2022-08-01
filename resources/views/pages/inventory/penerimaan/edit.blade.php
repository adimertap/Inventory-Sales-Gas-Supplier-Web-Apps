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
                            Proses Penerimaan Pembelian Kode {{ $penerimaan->Pembelian->kode_pembelian }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid mt-4">
        <form action="{{ route('penerimaan.update', $penerimaan->id_penerimaan) }}" id="form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-xl-6 mt-2">
                    <div class="card h-100">
                        <div class="card-header">Detail Formulir Penerimaan</div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-xxl-12 col-xl-8">
                                    <div class="form-row">
                                        <input type="hidden" name="id_pembelian" value="{{ $penerimaan->Pembelian->id_pembelian }}">
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1" for="kode_penerimaan">Kode Penerimaan</label>
                                            <input class="form-control" id="kode_penerimaan" type="text" name="kode_penerimaan"
                                                value="{{ $penerimaan->kode_penerimaan }}" readonly />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1" for="id_pegawai">Pegawai</label>
                                            <input class="form-control" id="id_pegawai" type="text" name="id_pegawai"
                                                value="{{ $penerimaan->Pegawai->name }}" readonly />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1 mr-1" for="tanggal_penerimaan">Tanggal
                                                Penerimaan</label><span class="mr-4 mb-3" style="color: red">*</span>
                                            <input class="form-control" id="tanggal_penerimaan" type="date"
                                                name="tanggal_penerimaan" placeholder="Input Tanggal Penerimaan"
                                                value="{{ $penerimaan->tanggal_penerimaan }}">
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('penerimaan.index') }}" class="btn btn-sm btn-light"
                                            type="button">Kembali</a>
                                        <button class="btn btn-primary btn-sm" type="button" id="buttonsimpan"
                                            onclick="SimpanData(event, {{ $penerimaan->id_penerimaan }})">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mt-2">
                    <div class="card h-100">
                        <div class="card-header">Pilih Produk yang diterima</div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-xxl-12 col-xl-8">
                                    <h6 class="card-title">Total Produk Pembelian: <span class="text-primary">{{ $total_produk }} Produk</span> </h6>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1 mr-1" for="id_supplier">Supplier</label><span
                                            class="mr-4 mb-3" style="color: red">*</span>
                                            <input class="form-control" id="id_supplier" type="text" name="id_supplier"
                                                placeholder="Auto Generate" value="{{ $penerimaan->Pembelian->Supplier->nama_supplier }}" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1 mr-1" for="status_pembayaran">Status Pelunasan</label>
                                            <select class="form-control" name="status_pembayaran" class="form-control" id="status_pembayaran">
                                                <option value="{{ $penerimaan->status_pembayaran }}">{{ $penerimaan->status_pembayaran }}</option>
                                                <option value="Dibayar">Lunas</option>
                                                <option value="Pending">Pending</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="small mb-1 mr-1" for="id_produk">Pilih Produk Diterima</label><span
                                            class="mr-4 mb-3" style="color: red">*</span>
                                            <select class="form-control" name="id_produk" class="form-control"
                                                id="id_produk">
                                                <option>Pilih Produk Diterima</option>
                                                @foreach ($penerimaan->Pembelian->detail as $produks)
                                                <option id="{{ $produks->pivot->qty_sementara }}/{{ $produks->pivot->harga_beli }}" value="{{ $produks->id_produk }}">{{ $produks->nama_produk }},
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
        <div class="alert alert-primary" role="alert"><strong>Check Kembali</strong> Seluruh Produk Yang Anda Terima Saat Penerimaan Ini</div>
        <div class="card">
            <div class="card-header">Detail Penerimaan</div>
            <div class="card-body p-1">
                <div class="table-responsive table-billing-history">
                    <table class="table mb-0" id="table_detail">
                        <thead>
                            <tr>
                                <th scope="col">Produk Diterima</th>
                                <th scope="col">Jumlah/Harga</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="konfirmasi">
                            @forelse ($penerimaan->Detail as $tes)
                            <tr id="item-{{ $tes->id_detail_penerimaan }}" role="row" class="odd">
                                <td><span id="{{ $tes->id_produk }}">{{ $tes->nama_produk }}, {{ $tes->Kategori->nama_kategori }}</span></td>
                                <td><span id="{{ $tes->pivot->harga_diterima }}">{{ $tes->pivot->jumlah_diterima }}/{{ number_format($tes->pivot->harga_diterima) }}</span></td>
                                <td><span id="{{ $tes->pivot->jumlah_diterima }}/{{ $tes->pivot->jumlah_order }}">{{ number_format($tes->pivot->total_diterima) }}</span></td>
                                <td>

                                </td>
                            </tr>
                                
                            @empty
                                
                            @endforelse
                        </tbody>
                        <tr>
                            <td class="text-left  pb-0" colspan="2">
                                <div class="text-uppercase small font-weight-600 text-muted">Grand Total Penerimaan:</div>
                            </td>
                            <td class="text-primary" colspan="1">Rp. <span id="grand_total_table">{{ number_format($penerimaan->grand_total) }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

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
                        <label class="small mr-1">Jumlah</label>
                        <input class="form-control" id="jumlah_produk_modal" type="number" name="jumlah_produk_modal"
                            placeholder="Input Jumlah Produk" value="{{ old('jumlah_produk_modal') }}">
                    </div>
                    <div class="small text-primary ">
                        <p>Jumlah Pembelian Awal <span id="jumlah_awal" class="jumlah_awal"></span></p>
                    </div>
                    <input type="hidden" id="jumlah_order" name="jumlah_order">
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
        var jumlah = get_harga.split('/')[0]

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
            $('#harga_produk_modal').val(harga)
            $('.detail_harga_produk_modal').html(new Intl.NumberFormat('id', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
            }).format(harga))

            $('#jumlah_produk_modal').val(jumlah)
            $('#jumlah_order').val(jumlah)
            $('#jumlah_awal').html(jumlah)
        }
    });

    function TambahProduk(event) {
        var form = $('#form1')
        var id = form.find('input[name="id_produk_modal"]').val()
        var nama = $('#nama_produk_modal').text().replace(/^\s+|\s+$/gm, '');
        var harga = form.find('input[name="harga_produk_modal"]').val()
        var jumlah = form.find('input[name="jumlah_produk_modal"]').val()
        var jumlah_order = form.find('input[name="jumlah_order"]').val()
        var harga_produk = new Intl.NumberFormat('locale').format(harga)
        var total = new Intl.NumberFormat('locale').format(jumlah * harga)

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
        }else {
            var table = $('#table_detail').DataTable()
            var row = $(`#${$.escapeSelector(id.trim())}`).parent().parent()
            table.row(row).remove().draw();

            $('#table_detail').DataTable().row.add([
                `<span id=${id}>${nama}</span>`, `<span id=${harga}>${jumlah + "/"+ harga_produk}</span>`,
                `<span id=${jumlah + "/" + jumlah_order}>${total}</span>`, total
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
                    var td_table_total = td_tot.replace(',', '').replace(',', '').trim()
                    var grand2 = parseInt(grand2) + parseInt(td_table_total)
                    
                }
            $('#grand_total_table').html(new Intl.NumberFormat('locale').format(grand2))

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
                var total = td_total.replace(',', '').replace(',', '').trim()
                var grand = $('#grand_total_table').html()
                var grand_total_table = grand.replace(',', '').replace(',', '').trim()
                var total_perhitungan = total.replace(',', '').replace(',', '').trim()
                var perhitungan = parseInt(grand_total_table) - parseInt(total_perhitungan)
                $('#grand_total_table').html(new Intl.NumberFormat('locale').format(perhitungan))
                $('#grand_total').val(new Intl.NumberFormat('locale').format(perhitungan))

            }
        })
    }

    function SimpanData(event, id_penerimaan) {
        Swal.fire({
            title: 'Do you want to save the changes?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Save',
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $('#form')
                var _token = form.find('input[name="_token"]').val()
                var kode_penerimaan = form.find('input[name="kode_penerimaan"]').val()
                var tanggal_penerimaan = form.find('input[name="tanggal_penerimaan"]').val()
                var id_pembelian = form.find('input[name="id_pembelian"]').val()
                var grand_total = $('#grand_total_table').text()
                var status_pembayaran =  $('#status_pembayaran').find("option:selected").val();
                var dataform2 = []

                if (tanggal_penerimaan == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Input Tanggal Terlebih Dahulu',
                    })
                } else if(status_pembayaran == '' || status_pembayaran == "Pilih Status Pembayaran"){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pilih Status Bayar Terlebih Dahulu',
                    })
                } else if (grand_total == 0 || grand_total == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Belum Ada Produk, Tambahkan Produk Dahulu',
                    })
                } else {
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
                        var get_jumlah = $(span_jumlah).attr('id')
                        var jumlah_diterima = get_jumlah.split('/')[0]
                        var jumlah_order = get_jumlah.split('/')[1]

                        var td_harga = children[1]
                        var span_harga = $(td_harga).children()[0]
                        var harga_diterima = $(span_harga).attr('id')

                        var td_total = children[2]
                        var td_tot = $(td_total).text()
                        var total_diterima = td_tot.replace(',', '').replace(',', '').trim()

                        var obj = {
                            id_produk: id_produk,
                            id_penerimaan: id_penerimaan,
                            id_produk: id_produk,
                            jumlah_order: jumlah_order,
                            jumlah_diterima: jumlah_diterima,
                            harga_diterima: harga_diterima,
                            total_diterima: total_diterima,
                        }
                        dataform2.push(obj)
                    }

                    if (dataform2.length == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Produk Order Kosong!, Isi Transaksi Terlebih Dahulu',
                        })
                    } else {
                        var data = {
                            _token: _token,
                            kode_penerimaan: kode_penerimaan,
                            tanggal_penerimaan: tanggal_penerimaan,
                            id_pembelian: id_pembelian,
                            status_pembayaran: status_pembayaran,
                            detail: dataform2
                        }

                        console.log(data)
                        $('#buttonsimpan').prop('disabled', true);

                        $.ajax({
                            method: 'put',
                            url: '/penerimaan/' + id_penerimaan,
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
                                $('#buttonsimpan').prop('disabled', false);
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
