<?= form_open_multipart('doctor/store') ?>
<?= csrf_field() ?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Dokter Add</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>NIP<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="f_nip" placeholder="NIP dokter">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Nama<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="f_nama" placeholder="Dilengkapi dengan gelar">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Tipe<span class="text-danger">*</span></label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="f_tipe_dokter" value="Umum" id="umum" checked>
                    <label class="form-check-label" for="umum">
                        Dokter Umum
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="f_tipe_dokter" value="Gigi" id="gigi">
                    <label class="form-check-label" for="gigi">
                        Dokter Gigi
                    </label>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="form-group">
                <label>Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="f_tempat_lahir" placeholder="Tempat lahir dokter">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="f_tanggal_lahir" placeholder="Tanggal lahir dokter">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="f_jenis_kelamin" value="Laki-laki" id="laki" checked>
                    <label class="form-check-label" for="laki">
                        Laki-Laki
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="f_jenis_kelamin" value="Perempuan" id="perempuan">
                    <label class="form-check-label" for="perempuan">
                        Perempuan
                    </label>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="form-group">
                <label>Nomor Telepon/HP <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="f_telepon" placeholder="Nomor telepon/handphone dokter, contoh: 0851xxx">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label>Photo</label>
                <input type="file" class="form-control" name="f_photo">
                <div class="invalid-feedback"></div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Username<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="f_username" placeholder="Username untuk login">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Password<span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="f_password" placeholder="Minimal 3 karakter">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Email<span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="f_email" placeholder="Email dokter">
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" name="f_store" class="btn btn-primary btn-simpan">Save</button>
</div>

<?= form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        const base_url = $("#base-url").html();

        // ajax input to server
        $('form').submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: "JSON",
                data: formData,
                processData: false,
                contentType: false,

                beforeSend: () => {
                    $('.btn-simpan').attr('disabled');
                    $('.btn-simpan').html('<i class="fa fa-spinner fa-spin"></i> Saving...');
                },
                complete: () => {
                    $('.btn-simpan').removeAttr('disabled');
                    $('.btn-simpan').html('Save');
                },

                success: function(response) {
                    if (response.error) {
                        $('input').removeClass('is-invalid');
                        $('select').removeClass('is-invalid');
                        $('radio').removeClass('is-invalid');
                        $('textarea').removeClass('is-invalid');
                        $('.invalid-feedback').text("");

                        $.each(response.message, function(key, value) {
                            $('input[name=f_' + key + ']').addClass('is-invalid');
                            $('select[name=f_' + key + ']').addClass('is-invalid');
                            $('radio[name=f_' + key + ']').last().addClass('is-invalid');
                            $('textarea[name=f_' + key + ']').addClass('is-invalid');
                            $('[name=f_' + key + ']').parent().children(".invalid-feedback").text(value);
                        });
                    } else {
                        location.reload();
                    }
                }
            });
        });
    });
</script>