@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Detail Barang</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($barang)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID Barang</th>
                    <td>{{ $barang->barang_id }}</td>
                </tr>
                <tr>
                    <th>Kode Barang</th>
                    <td>{{ $barang->barang_kode }}</td>
                </tr>
                <tr>
                    <th>Nama Barang</th>
                    <td>{{ $barang->barang_nama }}</td>
                </tr>
                <tr>
                    <th>Harga Beli</th>
                    <td id="harga_beli">{{ number_format($barang->barang_hargabeli, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Harga Jual</th>
                    <td id="harga_jual">{{ number_format($barang->barang_hargajual, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $barang->kategori->kategori_nama }}</td>
                </tr>
            </table>
        @endempty
        <a href="{{ url('barang') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('js')
<script>
    // Fungsi untuk format harga
    function formatRupiah(angka) {
        let numberString = angka.toString();
        let sisa = numberString.length % 3;
        let rupiah = numberString.substr(0, sisa);
        let ribuan = numberString.substr(sisa).match(/\d{3}/g);
        
        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return 'Rp ' + rupiah;
    }

    $(document).ready(function() {
        // Dapatkan nilai harga jual dan harga beli dari td
        let hargaJual = $('#harga_jual').text().replace(/\./g, '').replace('Rp ', '');
        let hargaBeli = $('#harga_beli').text().replace(/\./g, '').replace('Rp ', '');

        // Parsing angka sebelum diformat
        hargaJual = parseInt(hargaJual);
        hargaBeli = parseInt(hargaBeli);

        // Gantikan dengan format rupiah jika angka valid
        if (!isNaN(hargaJual)) {
            $('#harga_jual').text(formatRupiah(hargaJual));
        }
        if (!isNaN(hargaBeli)) {
            $('#harga_beli').text(formatRupiah(hargaBeli));
        }
    });
</script>
@endpush
