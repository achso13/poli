<?= form_open('resep/status/store') ?>
<div class="modal-header">
    <h5 class="modal-title">Status Resep</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body ">
    <!-- radiobutton -->
    <div class="form-group">
        <input type="hidden" name="f_id_resep" value="<?= $result['id_resep'] ?>">
        <label class="form-control-label">Status Resep <span class="text-danger">*</span></label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="f_status" value="Belum Selesai" <?= $result['status'] === "Belum Selesai" ? "checked" : "" ?>>
            <label class="form-check-label">Belum Selesai</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="f_status" value="Sedang Disiapkan" <?= $result['status'] === "Sedang Disiapkan" ? "checked" : "" ?>>
            <label class="form-check-label">Sedang Disiapkan</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="f_status" value="Sudah Selesai" <?= $result['status'] === "Sudah Selesai" ? "checked" : "" ?>>
            <label class="form-check-label">Sudah Selesai</label>
            <div class="invalid-feedback"></div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="submit" name="f_store" class="btn btn-primary btn-simpan" value="Save">
    <button class="btn btn-light" type="button" data-dismiss="modal">Cancel</button>
</div>
<?= form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        var base_url = $("#base-url").html();

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