<?= form_open_multipart('patient/update') ?>
<?= csrf_field() ?>
<input type="hidden" name="f_id_patient" value="<?= $result['id_patient'] ?>">
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
                <label>Nama Lengkap<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="f_fullname" placeholder="Nama lengkap pasien" value="<?= $result['fullname'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>NIP<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="f_nip" placeholder="Nomor induk pegawai pasien" value="<?= $result['nip'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir<span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="f_birth_date" placeholder="Tanggal lahir pasien" value="<?= $result['birth_date'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin<span class="text-danger">*</span></label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="f_gender" value="L" id="laki" <?= $result['gender'] === 'L' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="laki">
                        Laki-Laki
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="f_gender" value="P" id="perempuan">
                    <label class="form-check-label" for="perempuan" <?= $result['gender'] === 'P' ? 'checked' : '' ?>>
                        Perempuan
                    </label>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="form-group">
                <label>Golongan Darah<span class="text-danger">*</span></label>
                <select class="form-control show-tick" name="f_blood_type">
                    <option value="">Select One</option>
                    <?php foreach (BLOOD_TYPE as $blood_type) : ?>
                        <option value="<?= $blood_type ?>" <?= $result['blood_type'] === $blood_type ? 'selected' : '' ?>><?= $blood_type ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label>Alamat<span class="text-danger">*</span></label>
                <textarea name="f_address" class="form-control" placeholder="Alamat rumah pasien"><?= $result['address'] ?></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Nomor HP<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="f_phone" placeholder="Nomor handphone pasien, contoh: 0851xxx" value="<?= $result['phone'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Photo<span class="text-danger">*</span></label>
                <input type="file" class="form-control" name="f_photo">
                <div class="invalid-feedback"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Tanggal Pendaftaran<span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="f_admission_date" value="<?= $result['admission_date'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="f_old_username" value="<?= $result['username'] ?>">
                <label>Username<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="f_username" placeholder="Username untuk login pasien" value="<?= $result['username'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Password<span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="f_password" placeholder="Kosongkan jika tidak ingin diganti">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label>Email<span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="f_email" placeholder="Email pasien" value="<?= $result['email'] ?>">
                <div class="invalid-feedback"></div>
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

        const value = $('select[name=f_id_role]').val();
        if (value == 4) {
            $('.load-dep').css('display', 'block');
        }

        $('select[name=f_id_role]').change(function() {
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