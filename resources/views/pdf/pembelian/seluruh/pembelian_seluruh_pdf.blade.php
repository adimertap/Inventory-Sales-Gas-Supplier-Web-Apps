<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pembelian</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Laporan Pembelian</h4>
        <p>Sukses Berkah Bertumbuh - Inventory</h4>
	</center>
 
	<table class='table table-bordered'>
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
            <th colspan="1">{{ $jumlah }} Transaksi</th>
            <th colspan="1">Rp. {{ number_format($total) }}</th>
        </tr>
	</table>
 
</body>
</html>