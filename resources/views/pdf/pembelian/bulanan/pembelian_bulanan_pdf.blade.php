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
		<h5>Laporan Pembelian Seluruh Bulan</h4>
        <p>Sukses Berkah Bertumbuh - Inventory</h4>
	</center>
 
	<table class='table table-bordered'>
		<thead>
          
			<tr>
				<th>No</th>
                <th>Tahun</th>
				<th>Bulan</th>
                <th>Total Pembelian</th>
				<th>Grand Total</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($pembelian as $p)
			<tr>
				<td>{{ $i++ }}</td>
                <td>{{$p->tahun}}</td>
				<td>{{$p->bulan}}</td>
                <td>{{$p->jumlah_pembelian}}</td>
				<td>Rp. {{ number_format($p->grand_totals)}}</td>
			</tr>
			@endforeach
		</tbody>
        <tr>
            <th colspan="3">Transaksi</th>
            <th colspan="1">{{ $jumlah }} Transaksi</th>
            <th colspan="1">Rp. {{ number_format($total) }}</th>
        </tr>
	</table>
 
</body>
</html>