@extends('layouts.app_penjualan')

@section('content')
<main>
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
            <div class="mr-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Laporan Penjualan Keseluruhan</h1>
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
                                <input type="date" name="from_date" id="from_date"
                                    class="form-control form-control-sm" placeholder="From Date" />
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
                                <input type="date" name="to_date" id="to_date"
                                    class="form-control form-control-sm" placeholder="To Date" />
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <button type="button" name="filter" onclick="filter_tanggal(event)"
                                class="btn btn-sm btn-primary px-4 mt-4">Filter</button>
                                <a href="{{ route('laporan-penjualan-reset') }}" type="button"
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
                                                style="width: 80px;">Kode Penjualan</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 70px;">Tanggal Penjualan</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 80px;">Pegawai</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 40px;">Customer</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 40px;">Total Penjualan</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 50px;">Action</th>
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
                                                <a href="{{ route('laporan-penjualan.show', $item->id_penjualan) }}"
                                                    class="btn btn-secondary btn-datatable" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Detail Penjualan"> 
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                    <tr> 
                                        <td colspan="4" class="text-center"> Grand Total Keseluruhan</td>
                                        <td colspan="1" class="text-center">{{ $jumlah }} Transaksi</td>
                                        <td colspan="1" class="text-center">Rp. {{ number_format($total) }}</td>
                                        <td colspan="1" class="text-center">
                                            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal"
                                            data-target="#ModalFilter">Download Laporan </button>
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
                <form action="{{ route('penjualan-excel') }}" id="form_excel" method="GET">
                    <div class="col-12 border p-2 mr-1">
                        <h5 class="text-primary">Filter Laporan Penjualan!</h5>
                        <p class="small">Filter Laporan Penjualan Sesuai dengan Kriteria Inputan</p>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" id="flexRadioDefault1" type="radio" value="excel"
                                        name="radio_input" checked />
                                    <label class="small" for="flexRadioDefault1">Export Excel</label>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" id="flexRadioDefault2" type="radio" value="pdf"
                                        name="radio_input" />
                                    <label class="small" for="flexRadioDefault2">Export PDF</label>
                                </div>
                            </div>
                        </div>
                        
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
                                <label class="small mb-1 mr-1" for="kode">Kode Customer</label><span class="mr-4 mb-3"
                                    style="color: red">*</span>
                                <select class="form-control" name="kode" class="form-control" id="kode">
                                    <option value="">Pilih Kode</option>
                                    <option value="S">S</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label class="small mb-1 mr-1" for="id_customer">Spesific Customer</label><span class="mr-4 mb-3"
                                    style="color: red">*</span>
                                <select class="form-control" name="id_customer" class="form-control" id="id_customer">
                                    <option value="">Pilih Customer</option>
                                    @foreach ($customer as $cust)
                                    <option value="{{ $cust->id_customer }}">{{ $cust->nama_customer }}</option>
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
        $('#kode').change(function () {
            var option = $(this).find("option:selected").val();
            if(option == '' || option == null){
                $('#id_customer').attr("disabled", false);
            }else{
                $('#id_customer').attr("disabled", true);
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
        window.location.href = '/penjualan-seluruh/download/pdf?from=' + tanggal_mulai + '&to=' + tanggal_selesai
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
        window.location.href = '/laporan-penjualan?from=' + tanggal_mulai + '&to=' + tanggal_selesai
    }
</script>

@endsection