<!DOCTYPE html>
<html>
<head>
	<title>Laporan Penjualan</title>
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
		<h5>Laporan Penjualan</h4>
        <p>Sukses Berkah Bertumbuh - Penjualan</h4>
	</center>
 
	<table class='table table-bordered'>
		<thead>
          
			<tr>
				<th>No</th>
                <th>Kode Penjualan</th>
                <th>Tanggal</th>
                <th>Customer</th>
				<th>Pegawai</th>
				<th>Nama Produk</th>
				<th>Kategori</th>
				<th>Jumlah Jual</th>
				<th>Harga Jual</th>
				<th>Total Jual</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($penjualan as $p)
			<tr>
				<td>{{ $i++ }}</td>
                <td>{{$p->kode_penjualan}}</td>
				<td>{{$p->tanggal_penjualan}}</td>
				<td>{{$p->nama_customer}}</td>
				<td>{{$p->Pegawai->name }}</td>
                <td>{{$p->nama_produk }}</td>
				<td>{{$p->nama_kategori }}</td>
				<td>{{$p->jumlah_jual }}</td>
				<td>Rp. {{ number_format($p->harga_jual)}}</td>
				<td>Rp. {{ number_format($p->total_jual)}}</td>
			</tr>
			@endforeach
		</tbody>
        <tr>
            <th colspan="8">Transaksi</th>
            <th colspan="1">{{ $total }} Transaksi</th>
            <th colspan="1">Rp. {{ number_format($jumlah) }}</th>
        </tr>
	</table>
 
</body>
</html>