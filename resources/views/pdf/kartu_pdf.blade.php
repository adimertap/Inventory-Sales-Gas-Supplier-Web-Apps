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
		<h5>Laporan Kartu Gudang</h4>
        <p>Sukses Berkah Bertumbuh - Inventory</h4>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Produk</th>
				<th>Stok Produk</th>
				<th>Jumlah Minimal</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($produk as $p)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$p->nama_produk}}, {{ $p->Kategori->nama_kategori }}</td>
				<td>{{$p->stok}}</td>
				<td>{{$p->jumlah_minimal}}</td>
				<td>{{$p->status_jumlah}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>