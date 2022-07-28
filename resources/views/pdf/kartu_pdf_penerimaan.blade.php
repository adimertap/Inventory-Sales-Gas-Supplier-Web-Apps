<!DOCTYPE html>
<html>
<head>
	<title>Laporan Kartu Gudang</title>
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
		<h5>Laporan Penerimaan {{ $produk->nama_produk }}, {{ $produk->Kategori->nama_kategori }}</h4>
        <p>Sukses Berkah Bertumbuh - Inventory</h4>
	</center>
 
	<table class='table table-bordered'>
		<thead>
            <tr>
                <th colspan="5">Transaksi</th>
                <th colspan="1">Jumlah</th>
                <th colspan="1">Saldo</th>
                <th colspan="1">Harga</th>
            </tr>
			<tr>
				<th>No</th>
                <th>Nama Produk</th>
				<th>Supplier</th>
				<th>Tanggal Transaksi</th>
				<th>Kode Transaksi</th>
				<th>Masuk</th>
                <th>Saldo</th>
                <th>Harga Beli</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($kartu as $p)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$p->Produk->nama_produk}}, {{ $p->Produk->Kategori->nama_kategori }}</td>
				<td>{{$p->Supplier->nama_supplier}}</td>
				<td>{{$p->tanggal_transaksi}}</td>
				<td>{{$p->kode_transaksi}}</td>
                <td>{{$p->jumlah_masuk}}</td>
                <td>{{$p->saldo_akhir}}</td>
                <td>{{$p->harga_beli}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>