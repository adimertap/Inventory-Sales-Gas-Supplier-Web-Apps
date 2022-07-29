<!DOCTYPE html>
<html>
<head>
	<title>Pembelian</title>
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
		<h5>Sukses Berkah Bertumbuh</h5>
		<h4>Pembelian Kode {{ $pembelian->kode_pembelian }}, {{ $pembelian->tanggal_pembelian }}</h4>
        <p>Kepada : {{ $pembelian->Supplier->nama_supplier }}, {{ $pembelian->Supplier->no_hp_supplier }}</h4>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
                <th>Produk</th>
				<th>Jumlah</th>
				<th>Harga</th>
                <th>Total</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($pembelian->Detail as $p)
			<tr>
				<td>{{ $i++ }}</td>
                <td>{{$p->nama_produk}}</td>
				<td>{{$p->pivot->jumlah_order}}</td>
                <td>Rp. {{ number_format($p->pivot->harga_beli)}}</td>
                <td>Rp. {{ number_format($p->pivot->total_order)}}</td>
			</tr>
			@endforeach
		</tbody> 
        <tr>
            <th colspan="4">Grand Total Pembelian</th>
            <th colspan="1">Rp. {{ number_format($pembelian->grand_total) }}</th>
        </tr>
	</table>
 
</body>
</html>