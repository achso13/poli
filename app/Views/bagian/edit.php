<?= form_open('unitkerja/bagian/update') ?>
<?= csrf_field() ?>
<input type="hidden" name="f_id_unitkerja" value="<?= $result['id_unitkerja'] ?>">
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Bagian Update</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label>Biro<span class="text-danger">*</span></label>
        <select class="form-control" name="f_id_biro">
            <option value="">-- Pilih Biro --</option>
            <?php foreach ($biro as $b) : ?>
                <option value="<?= $b['id_biro'] ?>" <?= $b['id_biro'] === $result['id_biro'] ? "selected" : "" ?>><?= $b['nama_biro'] ?></option>
            <?php endforeach; ?>
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Nama bagian<span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="f_nama_bagian" value="<?= $result['nama_bagian'] ?>" placeholder="Nama kliniknya">
        <div class="invalid-feedback"></div>
    </div>
</div>
<div class="modal-footer">
    <input type="submit" name="f_store" class="btn btn-primary" value="Save">
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