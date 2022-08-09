<?= form_open_multipart('doctor/update') ?>
<?= csrf_field() ?>
<input type="hidden" name="f_id_dokter" value="<?= $result['id_dokter'] ?>">
<input type="hidden" name="f_id_user" value="<?= $result['id_user'] ?>">
<input type="hidden" name="f_old_photo" value="<?= $result['photo'] ?>">
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Dokter Update</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>NIP<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="f_nip" placeholder="NIP dokter" value="<?= $result['nip'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Nama<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="f_nama" placeholder="Dilengkapi dengan gelar" value="<?= $result['nama'] ?>">
            </div>
            <div class="form-group">
                <label>Jenis<span class="text-danger">*</span></label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="f_tipe_dokter" id="umum" value="Umum" <?= $result['tipe_dokter'] === "Umum" ? "checked" : "" ?>>
                    <label class="form-check-label" for="umum">
                        Dokter Umum
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="f_tipe_dokter" id="gigi" value="Gigi" <?= $result['tipe_dokter'] === "Gigi" ? "checked" : "" ?>>
                    <label class="form-check-label" for="gigi">
                        Dokter Gigi
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="f_tempat_lahir" placeholder="Tempat lahir dokter" value="<?= $result['tempat_lahir'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="f_tanggal_lahir" placeholder="Tanggal lahir dokter" value="<?= $result['tanggal_lahir'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="f_jenis_kelamin" value="Laki-laki" id="laki" <?= $result['jenis_kelamin'] === 'Laki-laki' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="laki">
                        Laki-Laki
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="f_jenis_kelamin" value="Perempuan" id="perempuan" <?= $result['jenis_kelamin'] === 'Perempuan' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="perempuan">
                        Perempuan
                    </label>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="form-group">
                <label>Nomor Telepon/HP <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="f_telepon" placeholder="Nomor telepon/handphone dokter, contoh: 0851xxx" value="<?= $result['telepon'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Photo<span class="text-danger">*</span></label>
                <input type="file" class="form-control" name="f_photo">
            </div>

        </div>
        <div class="col-md-6">
            <input type="hidden" class="form-control" name="f_old_username" value="<?= $result['username'] ?>">
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="f_username" placeholder="Username untuk login" value="<?= $result['username'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="f_password" placeholder="Kosongkan jika tidak ingin diganti">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Email<span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="f_email" placeholder="Email dokter" value="<?= $result['email'] ?>">
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="submit" name="f_store" class="btn btn-primary" value="Save">
</div>

<?= form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        const base_url = $("#base-url").html();

        const value = $('select[name=f_role]').val();
        if (value == 4) {
            $('.load-dep').css('display', 'block');
        }

        $('select[name=f_role]').change(function() {
            var val = $(this).val();

            if (val == 4) {
                $('.load-dep').css('display', 'block');
            } else {
                $('.load-dep').css('display', 'none');
            }
        });

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
                        $('radio').removeClass('is-invalid');
                        $('textarea').removeClass('is-invalid');
                        $('.invalid-feedback').text("");

                        $.each(response.message, function(key, value) {
                            $('input[name=f_' + key + ']').addClass('is-invalid');
                            $('radio[name=f_' + key + ']').addClass('is-invalid');
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