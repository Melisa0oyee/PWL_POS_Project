@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('penjualan') }}">
                @csrf

                <div class="form-group">
                    <label for="pembeli">Nama Pembeli</label>
                    <input type="text" name="pembeli" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="penjualan_tanggal">Tanggal Penjualan</label>
                    <input type="datetime-local" name="penjualan_tanggal" class="form-control" required>
                </div>

                <h3>Detail Barang</h3>
                <div id="barang-section">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="barang_id">Barang</label>
                            <select name="barangs[0][barang_id]" class="form-control" required>
                                <option value="">- Pilih Barang -</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="barangs[0][jumlah]" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="harga">Harga</label>
                            <input type="number" name="barangs[0][harga]" class="form-control" required>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-barang" class="btn btn-info">Tambah Barang</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let barangIndex = 1;

        document.getElementById('add-barang').addEventListener('click', function() {
            let barangSection = document.getElementById('barang-section');
            let newBarang = `
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="barang_id">Barang</label>
                    <select name="barangs[${barangIndex}][barang_id]" class="form-control" required>
                        <option value="">- Pilih Barang -</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" name="barangs[${barangIndex}][jumlah]" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="harga">Harga</label>
                    <input type="number" name="barangs[${barangIndex}][harga]" class="form-control" required>
                </div>
            </div>`;

            barangSection.insertAdjacentHTML('beforeend', newBarang);
            barangIndex++;
        });
    </script>
    @endpush
@endsection