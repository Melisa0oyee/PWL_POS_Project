<form action="{{ url('/level/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Input Kode Level -->
                <div class="form-group">
                    <label>Kode Level</label>
                    <input type="text" name="level_kode" id="level_kode" class="form-control" required>
                    <small id="error-level_kode" class="error-text form-text text-danger"></small>
                </div>
                <!-- Input Nama Level -->
                <div class="form-group">
                    <label>Nama Level</label>
                    <input type="text" name="level_nama" id="level_nama" class="form-control" required>
                    <small id="error-level_nama" class="error-text form-text text-danger"></small>
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
        $("#form-tambah").validate({
            rules: {
                level_kode: {
                    required: true,
                    minlength: 2,
                    maxlength: 10
                },
                level_nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
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
                            dataLevel.ajax.reload();
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
