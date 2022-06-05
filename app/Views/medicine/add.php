<?= form_open('medicine/store') ?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Medicine Add</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label>Label<span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="f_medicine_name" placeholder="Nama dari obatnya">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Description<span class="text-danger">*</span></label>
        <textarea name="f_description" class="form-control" placeholder="Penjelasan dari obatnya"></textarea>
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Stock<span class="text-danger">*</span></label>
        <input type="number" class="form-control" name="f_stock" placeholder="Stok obat">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Unit<span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="f_unit" placeholder="Satuan, contoh: Strip, Botol dst">
        <div class="invalid-feedback"></div>
    </div>
</div>
<div class="modal-footer">
    <input type="submit" name="f_store" class="btn btn-primary btn-simpan" value="Save">
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