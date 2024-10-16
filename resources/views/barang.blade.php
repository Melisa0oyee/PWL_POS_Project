<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>
    <h1>Data Barang</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID Barang</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Kode Kategori</th>
        </tr>
        @foreach ($data as $barang)
        <tr>
            <td>{{ $barang->barang_id }}</td>
            <td>{{ $barang->barang_kode }}</td>
            <td>{{ $barang->barang_nama }}</td>
            <td>{{ number_format($barang->harga_beli, 2, ',', '.') }}</td>
            <td>{{ number_format($barang->harga_jual, 2, ',', '.') }}</td>
            <td>{{ $barang->kategori_kode }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
