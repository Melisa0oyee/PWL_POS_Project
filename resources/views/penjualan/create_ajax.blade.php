<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>User</label>
                    <select class="form-control" id="user_id" name="user_id" required>
                        <option value="">- Pilih user -</option>
                        @foreach ($user as $c)
                            <option value="{{ $c->user_id }}">{{ $c->username }}</option>
                        @endforeach
                    </select>
                    <small id="error-user_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Pembeli</label>
                    <input value="" type="text" name="pembeli" id="pembeli" class="form-control"
                        required>
                    <small id="error-pembeli" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <input value="" type="text" name="penjualan_kode" id="penjualan_kode" class="form-control"
                        required>
                    <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input value="" type="date" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control"
                        required>
                    <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Event listener untuk barang_id
        $('#barang_id').on('change', function() {
            let barangId = $(this).val();
            if (barangId) {
                $.ajax({
                    url: "{{ url('/barang/harga') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        barang_id: barangId
                    },
                    success: function(response) {
                        if (response.status) {
                            $('#harga').val(response.harga); // Isi harga otomatis
                        } else {
                            $('#harga').val(''); // Reset harga jika tidak ditemukan
                            Swal.fire({
                                icon: 'error',
                                title: 'Barang tidak ditemukan',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        console.error("Error:", error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Tidak dapat mengambil data harga'
                        });
                    }
                });
            } else {
                $('#harga').val(''); // Kosongkan kolom harga jika tidak ada barang yang dipilih
            }
        });

        // Validasi form
        $("#form-tambah").validate({
            rules: {
                penjualan_id: {
                    required: true,
                    number: true
                },
                barang_id: {
                    required: true,
                    number: true
                },
                harga: {
                    required: true,
                    number: true,
                    minlength: 3
                },
                jumlah: {
                    required: true,
                    number: true,
                    minlength: 1,
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            tableDetail.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>