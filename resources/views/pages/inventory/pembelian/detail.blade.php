@extends('layouts.app')

@section('content')

<main>
    <!-- Main page content-->
    <div class="container mt-4">
        <!-- Invoice-->
        <div class="card invoice">
            <div class="card-header p-4 p-md-5 border-bottom-0 bg-gray-300 text-black-50">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-left">
                        <!-- Invoice branding-->
                        <img class="mb-4" src="{{ asset('logo.png') }}" width="60" alt="">
                        <div class="h2 text-black font-weight-bold mb-0">Sukses Berkah Bertumbuh</div>
                        Detail Transaksi Pembelian
                    </div>
                    <div class="col-12 col-lg-auto text-center text-lg-right">
                        <!-- Invoice details-->
                        <div class="h3 text-black">Invoice Pembelian</div>
                        Kode #{{ $transaksi->kode_pembelian }}
                        <br>
                        {{ date('d-M-Y', strtotime($transaksi->tanggal_pembelian)) }}
                    </div>
                </div>
            </div>
            <div class="card-body p-4 p-md-5">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <!-- Invoice - sent to info-->
                        <div class="small text-muted text-uppercase font-weight-700 mb-2">To</div>
                        <div class="h6 mb-1">{{ $transaksi->Supplier->nama_supplier }}</div>
                        <div class="small">{{ $transaksi->Supplier->email_supplier }}/{{ $transaksi->Supplier->no_hp_supplier }}</div>
                        <div class="small">{{ $transaksi->Supplier->alamat_supplier }}</div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <!-- Invoice - sent from info-->
                        <div class="small text-muted text-uppercase font-weight-700 mb-2">From</div>
                        <div class="h6 mb-0">Sukses Berkah Bertumbuh</div>
                        <div class="small">info@suksesberkahbertumbuh.com/{{ Auth::user()->no_telephone }}</div>
                        <div class="small">Pejeng Gianyar</div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Invoice - additional notes-->
                        <div class="small text-muted text-uppercase font-weight-700 mb-2">Note</div>
                        <div class="small mb-0">Payment is due 15 days after receipt of this invoice. Please make checks or money orders out to Company Name, and include the invoice number in the memo. We appreciate your business, and hope to be working with you again very soon!</div>
                    </div>
                </div>
                <hr>
                <!-- Invoice table-->
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead class="border-bottom">
                            <tr class="small text-uppercase text-muted">
                                <th scope="col">Produk</th>
                                <th class="text-center" scope="col">Jumlah</th>
                                <th class="text-center" scope="col">Harga (IDR)</th>
                                <th class="text-right" scope="col">Total (IDR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksi->Detail as $item)
                            <tr class="border-bottom">
                                <td>
                                    <div class="font-weight-bold">{{ $item->nama_produk }}</div>
                                    <div class="small text-muted d-none d-md-block">Kategori Produk{{ $item->Kategori->nama_kategori }}</div>
                                </td>
                                <td class="text-center font-weight-bold">{{ $item->pivot->jumlah_order }}</td>
                                <td class="text-center font-weight-bold">{{ number_format($item->pivot->harga_beli) }}</td>
                                <td class="text-right font-weight-bold">{{ number_format($item->pivot->total_order) }}</td>
                            </tr>
                            @empty
                                
                            @endforelse
                            <!-- Invoice total-->
                            <tr>
                                <td class="text-right pb-0" colspan="3"><div class="text-uppercase small font-weight-700 text-muted">Grand Total Pembelian (IDR):</div></td>
                                <td class="text-right pb-0"><div class="h5 mb-0 font-weight-700 text-green">{{ number_format($transaksi->grand_total) }}</div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection