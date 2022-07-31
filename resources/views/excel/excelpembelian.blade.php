<table>
    <thead>
      
        <tr>
            <th>No</th>
            <th>Kode Pembelian</th>
            <th>Tanggal Pembelian</th>
            <th>Supplier</th>
            <th>Jenis Supplier</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Jumlah Order</th>
            <th>Harga Order</th>
            <th>Total Order</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1 @endphp
        @foreach($pembelian as $p)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{$p->kode_pembelian}}</td>
            <td>{{$p->tanggal_pembelian }}</td>
            <td>{{$p->nama_supplier}}</td>
            <td>{{$p->nama_jenis }}</td>
            <td>{{$p->nama_produk }}</td>
            <td>{{$p->nama_kategori }}</td>
            <td>{{$p->jumlah_order }}</td>
            <td>Rp. {{ number_format($p->harga_beli)}}</td>
            <td>Rp. {{ number_format($p->total_order)}}</td>
        </tr>
        @endforeach
    </tbody>
    <tr>
        <th colspan="8">Transaksi</th>
        <th colspan="1">{{ $total_produk }} Transaksi</th>
        <th colspan="1">Rp. {{ number_format($grand_total) }}</th>
    </tr>
</table>