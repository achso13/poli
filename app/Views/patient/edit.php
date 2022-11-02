<script>
    $(document).ready(function() {
        $('select[name=f_id_biro]').change(function() {
            var val = $(this).val();

            $.ajax({
                url: '<?= base_url('unitkerja/get_bagian') ?>' + "/" + val,
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    $('select[name=f_id_unitkerja]').empty();
                    $('select[name=f_id_unitkerja]').append('<option value="">---Choose---</option>');
                    $.each(response, function(key, value) {
                        $('select[name=f_id_unitkerja]').append('<option value="' + value.id_unitkerja + '">' + value.nama_bagian + '</option>');
                    });
                }
            });
        })
    });
</script>
<?= form_open_multipart('patient/update') ?>
<?= csrf_field() ?>
<input type="hidden" name="f_id_pasien" value="<?= $result['id_pasien'] ?>">
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
                <input type="text" class="form-control" name="f_nama" placeholder="Nama lengkap pasien" value="<?= $result['nama'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>NIP<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="f_nip" placeholder="Nomor induk pegawai pasien" value="<?= $result['nip'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Biro <span class="text-danger">*</span></label>
                <select name="f_id_biro" class="form-control biro">
                    <option value="">---Choose---</option>
                    <?php
                    if (isset($biro)) :
                        foreach ($biro as $list) :
                    ?>
                            <option value="<?= $list['id_biro'] ?>" <?= $list['id_biro'] === $result['id_biro'] ? "selected" : "" ?>><?= $list['nama_biro'] ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label>Bagian <span class="text-danger">*</span></label>
                <select name="f_id_unitkerja" class="form-control bagian">
                    <option value="">---Choose---</option>
                    <?php
                    if (isset($unitkerja)) :
                        foreach ($unitkerja as $list) :
                    ?>
                            <option value="<?= $list['id_unitkerja'] ?>" <?= $list['id_unitkerja'] === $result['id_unitkerja'] ? "selected" : "" ?>><?= $list['nama_bagian'] ?></option>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="f_tempat_lahir" placeholder="Tempat lahir pasien" value="<?= $result['tempat_lahir'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir<span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="f_tanggal_lahir" placeholder="Tanggal lahir pasien" value="<?= $result['tanggal_lahir'] ?>">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Jenis Kelamin<span class="text-danger">*</span></label>
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
                <label>Alamat Rumah<span class="text-danger">*</span></label>
                <textarea name="f_alamat_rumah" class="form-control" placeholder="Alamat rumah pasien"><?= $result['alamat_rumah'] ?></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Nomor Telepon/HP<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="f_telepon" placeholder="Nomor telepon/handphone pasien, contoh: 0851xxx" value="<?= $result['telepon'] ?>">
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
                <input type="hidden" name="f_old_username" value="<?= $result['username'] ?>">
                <label>Username<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="f_username" placeholder="Username untuk login pasien" value="<?= $result['nip'] ?>" disabled>
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
    <input type="submit" name="f_store" class="btn btn-primary" value="Simpan">
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