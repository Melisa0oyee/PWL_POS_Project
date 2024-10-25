@empty($stok)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data stok yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/stok') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/stok/' . $stok->stok_id.'/update_ajax') }}" method="POST" id="form-edit-stok-{{ $stok->stok_id }}">
        @csrf
        @method('PUT')
        <div id="modal-master-{{ $stok->stok_id }}" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Stok</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Supplier ID</label>
                        <select name="supplier_id" id="supplier_id" class="form-control" required>
                            <option value="">Pilih Supplier</option>
                            @foreach($supplier as $item)
                                <option value="{{ $item->supplier_id }}" {{ $stok->supplier_id == $item->supplier_id ? 'selected' : '' }}>
                                    {{ $item->supplier_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-supplier_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Barang ID</label>
                        <input value="{{ $stok->barang_id }}" type="text" name="barang_id" id="barang_id" class="form-control" required>
                        <small id="error-barang_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Stok</label>
                        <input value="{{ $stok->stok_jumlah }}" type="number" name="stok_jumlah" id="stok_jumlah" class="form-control" required>
                        <small id="error-stok_jumlah" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Stok</label>
                        <input value="{{ $stok->stok_tanggal }}" type="date" name="stok_tanggal" id="stok_tanggal" class="form-control" required>
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
            $("#form-edit-stok-{{ $stok->stok_id }}").validate({
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
                    var formData = new FormData(form); // Gunakan FormData untuk file upload

                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status) {
                                // Menampilkan notifikasi berhasil
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                }).then(function() {
                                    // Reload halaman atau update data setelah Swal ditutup
                                    if (typeof dataStok !== 'undefined') {
                                        dataStok.ajax.reload(); // Reload data table jika ada
                                    } else {
                                        location.reload(); // Reload halaman jika tidak ada dataStok
                                    }
                                });
                            } else {
                                // Menampilkan error dari validasi field
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
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan. Silakan coba lagi nanti.'
                            });
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
@endempty
