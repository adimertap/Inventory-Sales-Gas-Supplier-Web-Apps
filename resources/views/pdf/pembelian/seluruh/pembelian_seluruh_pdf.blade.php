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
        <p>Sukses Berkah Bertumbuh</h4>
	</center>
 
	<table class='table table-bordered'>
    <thead>
        <tr>
            <th>No.</th>
			<th>Kode Beli</th>
            <th>Tanggal Beli</th>
            <th>Pegawai</th>
            <th>Supplier</th>
            <th>Produk</th>
			<th>Kategori</th>
            <th>Jumlah Order</th>
            <th>Harga Beli</th>
			<th>Total</th>
        </tr>
    </thead>
    <tbody>
        @php 
            $i=1;
            $grand_total = 0; 
         
            foreach ($pembelian as $key => $item) {
                $grand_total = $grand_total + $item->total_order;
            }
        
         
        @endphp
        @foreach ($pembelian as $item)
        <tr>
            <th>{{ $i++ }}.</th>
			<td>{{ $item->kode_pembelian }}</td>
            <td>{{ date('d-M-Y', strtotime($item->tanggal_pembelian)) }}</td>
			<td>{{ $item->Pegawai->name }}</td>
			<td>{{ $item->nama_supplier }}</td>
			<td>{{ $item->nama_produk }}</td>
			<td>{{ $item->nama_kategori }}</td>
			<td>{{ $item->jumlah_order }}</td>
			<td>Rp. {{ number_format($item->harga_beli) }}</td>
			<td>Rp. {{ number_format($item->total_order) }}</td>
        </tr>
        @endforeach 
    </tbody>
    <tr>
        <th colspan="1"></th>
        <th colspan="8">Total Pembelian</th>
        <th colspan="1">Rp. {{ number_format($grand_total) }}</th>
    </tr>
</table>

<table class='table table-bordered'>
    <thead>
		<tr>
			<th colspan="3">Total Quantity Produk Yang Dibeli</th>
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

</body>
</html>