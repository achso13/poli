<?= form_open_multipart('doctor/jadwal/update') ?>
<?= csrf_field() ?>
<input type="hidden" name="f_id_jadwal_dokter" value="<?= $result['id_jadwal_dokter'] ?>">
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Update Jadwal Dokter</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label>Nama Dokter <span class="text-danger">*</span></label>
        <select name="f_id_dokter" class="form-control">
            <option value="">--Select One--</option>
            <?php
            if (isset($dokter)) :
                foreach ($dokter as $d) :
            ?>
                    <option value="<?= $d['id_dokter'] ?>" <?= $d['id_dokter'] === $result['id_dokter'] ? "selected" : "" ?>><?= $d['tipe_dokter'] ?> - <?= $d['nama'] ?></option>
            <?php
                endforeach;
            endif;
            ?>
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Jam Mulai Praktek<span class="text-danger">*</span></label>
        <input type="time" class="form-control" name="f_jam_mulai" value="<?= $result['jam_mulai'] ?>">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Jam Tutup Praktek<span class="text-danger">*</span></label>
        <input type="time" class="form-control" name="f_jam_selesai" value="<?= $result['jam_selesai'] ?>">
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group">
        <label>Hari <span class="text-danger">*</span></label>
        <select name="f_hari" class="form-control">
            <option value="">--Pilih Hari--</option>
            <option value="Senin" <?= $result['hari'] == "Senin" ? "selected" : "" ?>>Senin</option>
            <option value="Selasa" <?= $result['hari'] == "Selasa" ? "selected" : "" ?>>Selasa</option>
            <option value="Rabu" <?= $result['hari'] == "Rabu" ? "selected" : "" ?>>Rabu</option>
            <option value="Kamis" <?= $result['hari'] == "Kamis" ? "selected" : "" ?>>Kamis</option>
            <option value="Jumat" <?= $result['hari'] == "Jumat" ? "selected" : "" ?>>Jumat</option>
        </select>
        <div class="invalid-feedback"></div>
    </div>
</div>
<div class="modal-footer">
    <input type="submit" name="f_store" class="btn btn-primary" value="Simpan">
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