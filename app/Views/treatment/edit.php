<?= form_open('treatment/update') ?>
<?= csrf_field() ?>
<input type="hidden" name="f_id" value="<?= $result['id_treatment'] ?>">
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Treatment Update</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label>Nama Treatment<span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="f_nama_treatment" placeholder="Nama treatment yang diadakan" value="<?= $result['nama_treatment'] ?>">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Poliklinik<span class="text-danger">*</span></label>
        <select name="f_id_klinik" class="form-control">
            <option value="">---Choose---</option>
            <?php
            $dep = listClinic();

            if (isset($dep)) :
                foreach ($dep as $de) :
            ?>
                    <option value="<?= $de['id_klinik'] ?>" <?= $result['id_klinik'] === $de['id_klinik'] ? 'selected' : '' ?>><?= $de['nama_klinik'] ?></option>
            <?php
                endforeach;
            endif;
            ?>
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="f_deskripsi" class="form-control" placeholder="Deskripsi treatment yang diadakan"><?= $result['deskripsi'] ?></textarea>
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Jam Buka Klinik<span class="text-danger">*</span></label>
        <input type="time" class="form-control" name="f_jam_buka" value="<?= $result['jam_buka'] ?>">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Jam Tutup Klinik<span class="text-danger">*</span></label>
        <input type="time" class="form-control" name="f_jam_tutup" value="<?= $result['jam_tutup'] ?>">
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
                        $('textarea').removeClass('is-invalid');
                        $('.invalid-feedback').text("");

                        $.each(response.message, function(key, value) {
                            $('input[name=f_' + key + ']').addClass('is-invalid');
                            $('select[name=f_' + key + ']').addClass('is-invalid');
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