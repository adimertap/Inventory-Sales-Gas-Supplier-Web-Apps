<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Penjualan</th>
            <th>Customer</th>
            <th>Tanggal Penjualan</th>
            <th>Pegawai</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Jumlah Jual</th>
            <th>Harga Jual</th>
            <th>Grand Total</th>
        </tr>
    </thead>
    <tbody>
        @php
        $i=1;

        $grand = 0;

        foreach ($penjualan as $key => $item) {
        $grand = $grand + $item->total_jual;
        }

        @endphp
        @foreach($penjualan as $p)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{$p->kode_penjualan}}</td>
            <td>{{$p->Customer->nama_customer}}</td>
            <td>{{$p->tanggal_penjualan }}</td>
            <td>{{$p->Pegawai->name }}</td>
            <td>{{$p->nama_produk }}</td>
            <td>{{$p->nama_kategori }}</td>
            <td>{{$p->jumlah_jual }}</td>
            <td>Rp. {{ number_format($p->harga_jual)}}</td>
            <td>Rp. {{ number_format($p->grand_total)}}</td>
        </tr>
        @endforeach
    </tbody>
    <tr>
        <th colspan="1"></th>
        <th colspan="8">Total Penjualan Anda Hari Ini Sebesar</th>
        <th colspan="1">Rp. {{ number_format($grand) }}</th>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th colspan="3">Total Quantity Produk Yang Dijual</th>
        </tr>
        <tr>
            <th>No.</th>
            <th>Nama Produk</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @php
        $i=1;

        @endphp
        @foreach ($produk as $item)
        <tr>
            <th>{{ $i++ }}.</th>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->jumlah }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
