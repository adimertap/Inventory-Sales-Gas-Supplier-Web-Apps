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
		<h5>Laporan Penjualan Bulan {{ $bulan }}</h4>
        <p>Sukses Berkah Bertumbuh - Inventory</h4>
	</center>
 
	<table class='table table-bordered'>
		<thead>
          
			<tr>
				<th>No</th>
                <th>Kode Penjualan</th>
				<th>Customer</th>
				<th>Tanggal Penjualan</th>
                <th>Pegawai</th>
				<th>Grand Total</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($penjualan as $p)
			<tr>
				<td>{{ $i++ }}</td>
                <td>{{$p->kode_penjualan}}</td>
				<td>{{$p->Customer->nama_customer }}</td>
				<td>{{$p->tanggal_penjualan}}</td>
                <td>{{$p->Pegawai->name}}</td>
				<td>Rp. {{ number_format($p->grand_total)}}</td>
			</tr>
			@endforeach
		</tbody>
        <tr>
            <th colspan="4">Transaksi</th>
            <th colspan="1">{{ $jumlah }} Transaksi</th>
            <th colspan="1">Rp. {{ number_format($total) }}</th>
        </tr>
	</table>
 
</body>
</html>