@extends('layouts.app_penjualan')

@section('content')
<main>
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
            <div class="mr-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Laporan Penjualan Hari Ini</h1>
                <div class="small">
                    <span class="font-weight-500 text-primary">{{ $today }}</span>
                    {{ $tanggal }} · <span id="clock"></span>
                </div>

            </div>
            <div class="col-12 col-xl-auto mb-3 mb-sm-0  mr-4">
                

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
                                                style="width: 40px;">Kode Penjualan</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 30px;">Tanggal Penjualan</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 80px;">Pegawai</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 120px;">Customer</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 120px;">Grand Total</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 90px;">Action</th>
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
                                                <a href="{{ route('laporan-penjualan-harian.show', $item->id_penjualan) }}"
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
                                        <td colspan="4" class="text-center"> Grand Total Keseluruhan</td>
                                        <td colspan="1" class="text-center">{{ $jumlah }} Transaksi</td>
                                        <td colspan="1" class="text-center">Rp. {{ number_format($total) }}</td>
                                        <td colspan="1" class="text-center">
                                            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal"
                                            data-target="#ModalFilterPDF">Download Laporan Hari Ini</button>
                                            {{-- <a href="{{ route('penjualan-harian-pdf') }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Download PDF"> .pdf
                                            </a> --}}
                                            
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
                <h5 class="modal-title text-white">Download Laporan Harian</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('penjualan-harian-pdf') }}" id="form_pdf" method="GET">
                    <div class="col-12 border p-2 mr-1">
                        <h5 class="text-primary">Filter Laporan Pembelian Hari Ini!</h5>
                        <p class="small">Filter Laporan Pembelian Sesuai dengan Kriteria Inputan</p>
                        
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
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Download</button>
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

</script>

@endsection
