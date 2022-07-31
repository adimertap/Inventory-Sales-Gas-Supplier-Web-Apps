@extends('layouts.app')

@section('content')
<main>
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
            <div class="mr-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Laporan Pembelian Keseluruhan</h1>
                <div class="small">
                    <span class="font-weight-500 text-primary">{{ $today }}</span>
                    {{ $tanggal }} · <span id="clock"></span>
                </div>

            </div>
            <div class="col-12 col-xl-auto mb-3 mb-sm-0  mr-4">
                <span id="total_records"></span>
                <p></p>
                <form id="form1">
                    <div class="row input-daterange">
                        <div class="col-md-4">
                            <label class="small">Start Date</label>
                            <div class="input-group input-group-joined">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i data-feather="search"></i>
                                    </span>
                                </div>
                                <input type="date" name="from_date" id="from_date" class="form-control form-control-sm"
                                    placeholder="From Date" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="small">End Date</label>
                            <div class="input-group input-group-joined">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i data-feather="search"></i>
                                    </span>
                                </div>
                                <input type="date" name="to_date" id="to_date" class="form-control form-control-sm"
                                    placeholder="To Date" />
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <button type="button" name="filter" onclick="filter_tanggal(event)"
                                class="btn btn-sm btn-primary px-4 mt-4">Filter</button>
                            <a href="{{ route('laporan-pembelian-reset') }}" type="button"
                                class="btn btn-sm btn-warning px-4 mt-4">Reset</a>
                        </div>
                    </div>
                </form>
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
                                                style="width: 20px;">
                                                No</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 80px;">Kode Pembelian</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 70px;">Tanggal Pembelian</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Supplier</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 40px;">Grand Total</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 60px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pembelian as $item)
                                        <tr role="row" class="odd">
                                            <th scope="row" class="small" class="sorting_1">{{ $loop->iteration}}</th>
                                            <td>{{ $item->kode_pembelian }}</td>
                                            <td>{{ $item->tanggal_pembelian }}</td>
                                            <td>{{ $item->Supplier->nama_supplier }}</td>
                                            <td class="text-center">Rp. {{ number_format($item->grand_total) }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('laporan-pembelian.show', $item->id_pembelian) }}"
                                                    class="btn btn-secondary btn-datatable" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Detail Laporan"> <i
                                                        class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse


                                    </tbody>
                                    <tr>
                                        <td colspan="3" class="text-center"> Grand Total Keseluruhan</td>
                                        <td colspan="1" class="text-center">{{ $jumlah }} Transaksi</td>
                                        <td colspan="1" class="text-center">Rp. {{ number_format($total) }}</td>
                                        <td colspan="1" class="text-center">
                                            <button class="btn btn-sm btn-info" type="button" data-toggle="modal"
                                            data-target="#ModalFilterPDF">.Pdf</button>
                                            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal"
                                                data-target="#ModalFilter">.Excel</button><br>
                                        </td>
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
<div class="modal fade" id="ModalFilterPDF" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Filter Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pembelian-seluruh-pdf') }}" id="form_pdf" method="GET">
                    <div class="col-12 border p-2 mr-1">
                        <h5 class="text-primary">Filter Laporan Pembelian!</h5>
                        <p class="small">Filter Laporan Pembelian Sesuai dengan Kriteria Inputan</p>
                        <div class="row input-daterange">
                            <div class="form-group col-6">
                                <label class="small">Start Date</label>
                                <div class="input-group input-group-joined">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i data-feather="search"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="from_date_export" id="from_date_export"
                                        class="form-control" placeholder="From Date" />
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label class="small">End Date</label>
                                <div class="input-group input-group-joined">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i data-feather="search"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="to_date_export" id="to_date_export" class="form-control"
                                        placeholder="To Date" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label class="small mb-1 mr-1" for="id_jenis_supplier">Jenis Supplier</label><span
                                    class="mr-4 mb-3" style="color: red">*</span>
                                <select class="form-control" name="id_jenis_supplier" class="form-control"
                                    id="id_jenis_supplier">
                                    <option value="">Pilih Jenis Supplier</option>
                                    @foreach ($jenis as $jeniz)
                                    <option value="{{ $jeniz->id_jenis_supplier }}">{{ $jeniz->nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label class="small mb-1 mr-1" for="id_supplier">Supplier</label><span class="mr-4 mb-3"
                                    style="color: red">*</span>
                                <select class="form-control" name="id_supplier" class="form-control" id="id_supplier">
                                    <option value="">Pilih Supplier</option>
                                    @foreach ($supplier as $sup)
                                    <option value="{{ $sup->id_supplier }}">{{ $sup->nama_supplier }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label class="small mb-1 mr-1" for="id_produk">Produk</label><span class="mr-4 mb-3"
                                    style="color: red">*</span>
                                <select class="form-control" name="id_produk" class="form-control" id="id_produk">
                                    <option value="">Pilih Produk</option>
                                    @foreach ($produk as $pro)
                                    <option value="{{ $pro->nama_produk }}">{{ $pro->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label class="small mb-1 mr-1" for="id_kategori">Kategori</label><span class="mr-4 mb-3"
                                    style="color: red">*</span>
                                <select class="form-control" name="id_kategori" class="form-control" id="id_kategori">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="id_pegawai">Pegawai</label><span class="mr-4 mb-3"
                                style="color: red">*</span>
                            <select class="form-control" name="id_pegawai" class="form-control" id="id_pegawai">
                                <option value="">Pilih Pegawai</option>
                                @foreach ($pegawai as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalFilter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Filter Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pembelian-excel') }}" id="form_excel" method="GET">
                    <div class="col-12 border p-2 mr-1">
                        <h5 class="text-primary">Filter Laporan Pembelian!</h5>
                        <p class="small">Filter Laporan Pembelian Sesuai dengan Kriteria Inputan</p>
                        <div class="row input-daterange">
                            <div class="form-group col-6">
                                <label class="small">Start Date</label>
                                <div class="input-group input-group-joined">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i data-feather="search"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="from_date_export" id="from_date_export"
                                        class="form-control" placeholder="From Date" />
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label class="small">End Date</label>
                                <div class="input-group input-group-joined">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i data-feather="search"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="to_date_export" id="to_date_export" class="form-control"
                                        placeholder="To Date" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label class="small mb-1 mr-1" for="id_jenis_supplier">Jenis Supplier</label><span
                                    class="mr-4 mb-3" style="color: red">*</span>
                                <select class="form-control" name="id_jenis_supplier" class="form-control"
                                    id="id_jenis_supplier">
                                    <option value="">Pilih Jenis Supplier</option>
                                    @foreach ($jenis as $jeniz)
                                    <option value="{{ $jeniz->id_jenis_supplier }}">{{ $jeniz->nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label class="small mb-1 mr-1" for="id_supplier">Supplier</label><span class="mr-4 mb-3"
                                    style="color: red">*</span>
                                <select class="form-control" name="id_supplier" class="form-control" id="id_supplier">
                                    <option value="">Pilih Supplier</option>
                                    @foreach ($supplier as $sup)
                                    <option value="{{ $sup->id_supplier }}">{{ $sup->nama_supplier }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label class="small mb-1 mr-1" for="id_produk">Produk</label><span class="mr-4 mb-3"
                                    style="color: red">*</span>
                                <select class="form-control" name="id_produk" class="form-control" id="id_produk">
                                    <option value="">Pilih Produk</option>
                                    @foreach ($produk as $pro)
                                    <option value="{{ $pro->nama_produk }}">{{ $pro->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label class="small mb-1 mr-1" for="id_kategori">Kategori</label><span class="mr-4 mb-3"
                                    style="color: red">*</span>
                                <select class="form-control" name="id_kategori" class="form-control" id="id_kategori">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1 mr-1" for="id_pegawai">Pegawai</label><span class="mr-4 mb-3"
                                style="color: red">*</span>
                            <select class="form-control" name="id_pegawai" class="form-control" id="id_pegawai">
                                <option value="">Pilih Pegawai</option>
                                @foreach ($pegawai as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        var table = $('#dataTable').DataTable();
        $('#id_jenis_supplier').change(function () {
            var option = $(this).find("option:selected").val();
            if(option == '' || option == null){
                $('#id_supplier').attr("disabled", false);
            }else{
                $('#id_supplier').attr("disabled", true);
            }
        }); 



        setInterval(displayclock, 500);

        function displayclock() {
            var time = new Date()
            var hrs = time.getHours()
            var min = time.getMinutes()
            var sec = time.getSeconds()
            var en = 'AM';

            if (hrs > 12) {
                en = 'PM'
            }

            if (hrs > 12) {
                hrs = hrs - 12;
            }

            if (hrs == 0) {
                hrs = 12;
            }

            if (hrs < 10) {
                hrs = '0' + hrs;
            }

            if (min < 10) {
                min = '0' + min;
            }

            if (sec < 10) {
                sec = '0' + sec;
            }

            document.getElementById('clock').innerHTML = hrs + ':' + min + ':' + sec + ' ' + en;
        }
    });

    function gas(event) {
        event.preventDefault()
        var form1 = $('#form1')
        var tanggal_mulai = form1.find('input[name="from_date"]').val()
        var tanggal_selesai = form1.find('input[name="to_date"]').val()
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
            icon: 'info',
            title: 'Mohon Tunggu, Data Sedang diproses ...'
        })
        window.location.href = '/pembelian-seluruh/download/pdf?from=' + tanggal_mulai + '&to=' + tanggal_selesai
    }

    function filter_tanggal(event) {
        event.preventDefault()
        var form1 = $('#form1')
        var tanggal_mulai = form1.find('input[name="from_date"]').val()
        var tanggal_selesai = form1.find('input[name="to_date"]').val()
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
            icon: 'info',
            title: 'Mohon Tunggu, Data Sedang diproses ...'
        })
        window.location.href = '/laporan-pembelian?from=' + tanggal_mulai + '&to=' + tanggal_selesai
    }

    // function filter_excel(event) {
    //     event.preventDefault()
    //     var form = $('#form_excel')
    //     var _token = 
    //     var tanggal_mulai = form.find('input[name="from_date_export"]').val()
    //     var tanggal_selesai = form.find('input[name="to_date_export"]').val()
    //     var id_supplier = $('#id_supplier').find("option:selected").val();
    //     var id_jenis_supplier = $('#id_jenis_supplier').find("option:selected").val();
    //     var id_produk = $('#id_produk').find("option:selected").val();
    //     var id_kategori = $('#id_kategori').find("option:selected").val();
    //     var id_pegawai = $('#id_pegawai').find("option:selected").val();

    //     var data = {
    //         _token: _token,
    //         kode_penjualan: kode_penjualan,
    //         tanggal_penjualan: tanggal_penjualan,
    //         id_customer: id_customer,
    //         status_bayar: status_bayar,
    //         id: id_pegawai,
    //         detail: dataform2
    //     }

    //     $.ajax({
    //         method: 'get',
    //         url: '/pembelian/download/excel',
    //         data: data,
    //         success: function (response) {
    //             const Toast = Swal.mixin({
    //                 toast: true,
    //                 position: 'top-end',
    //                 showConfirmButton: false,
    //                 timer: 3000,
    //                 timerProgressBar: true,
    //                 didOpen: (toast) => {
    //                     toast.addEventListener('mouseenter', Swal
    //                         .stopTimer)
    //                     toast.addEventListener('mouseleave', Swal
    //                         .resumeTimer)
    //                 }
    //             })

    //             Toast.fire({
    //                 icon: 'success',
    //                 title: 'Data Masih Diproses Mohon Tunggu'
    //             })
    //             window.location.href = '/laporan-pembelian'
    //         },
    //         error: function (response) {
    //             console.log(response)
    //             Swal.fire({
    //                 icon: 'error',
    //                 title: 'Oops...',
    //                 text: 'Error! Data Tidak dapat disimpan',
    //             })
    //         }
    //     });


    //     console.log(tanggal_mulai, tanggal_selesai)
    //     console.log(id_supplier, id_jenis_supplier, id_produk, id_kategori, id_pegawai)
    // }

</script>

@endsection
