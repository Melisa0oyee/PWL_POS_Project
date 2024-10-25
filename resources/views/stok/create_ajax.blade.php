<form action="{{ url('/stok/ajax') }}" method="POST" id="form-tambah-stok">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Input Supplier ID -->
                <div class="form-group">
                    <label>Supplier ID</label>
                    <select name="supplier_id" id="supplier_id" class="form-control" required>
                        <option value="">Pilih Supplier</option>
                        @foreach($supplier as $item)
                            <option value="{{ $item->supplier_id }}">{{ $item->supplier_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-supplier_id" class="error-text form-text text-danger"></small>
                </div>
                <!-- Input Barang ID -->
                <div class="form-group">
                    <label>Barang ID</label>
                    <input type="text" name="barang_id" id="barang_id" class="form-control" required>
                    <small id="error-barang_id" class="error-text form-text text-danger"></small>
                </div>
                <!-- Input Jumlah Stok -->
                <div class="form-group">
                    <label>Jumlah Stok</label>
                    <input type="number" name="stok_jumlah" id="stok_jumlah" class="form-control" required>
                    <small id="error-stok_jumlah" class="error-text form-text text-danger"></small>
                </div>
                <!-- Input Tanggal Stok -->
                <div class="form-group">
                    <label>Tanggal Stok</label>
                    <input type="date" name="stok_tanggal" id="stok_tanggal" class="form-control" required>
                    <small id="error-stok_tanggal" class="error-text form-text text-danger"></small>
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
        // Validasi Form dengan jQuery Validate
        $("#form-tambah-stok").validate({
            rules: {
                supplier_id: {
                    required: true
                },
                barang_id: {
                    required: true,
                    minlength: 1,
                    maxlength: 10
                },
                stok_jumlah: {
                    required: true,
                    min: 1
                },
                stok_tanggal: {
                    required: true,
                    date: true
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        console.log(response); 
                        if (response.status) {
                            // Tutup modal jika berhasil
                            $('#modal-master').modal('hide'); // pastikan ID modal sesuai
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            // Reload data dari tabel yang relevan
                            dataStok.ajax.reload();
                        } else {
                            // Tampilkan error dari field yang salah
                            $('.error-text').text(''); // Kosongkan pesan error sebelumnya
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]); // Tampilkan pesan error untuk field yang salah
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        // Menangani kesalahan jika terjadi saat pengiriman AJAX
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Silakan coba lagi.'
                        });
                    }
                });
                return false; // Mencegah form dari pengiriman default
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
