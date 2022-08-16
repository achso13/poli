<?= form_open('resep/store') ?>

<input type="hidden" name="f_id_resep" value="<?= $id ?>">

<div class=" modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Medicine Add</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label>Pilih Obat <span class="text-danger">*</span></label>
        <select name="f_id_obat" class="form-control select2">
            <option value="">--Select One--</option>
            <?php if (isset($obat)) : ?>
                <?php foreach ($obat as $row) : ?>
                    <option value="<?= $row['id_obat'] ?>"><?= $row['nama_obat'] ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Stok</label>
        <input type="number" class="form-control" name="f_stok" readonly>
    </div>
    <div class="form-group">
        <label>Satuan</label>
        <input type="text" class="form-control" name="f_satuan" readonly>
    </div>


    <div class="form-group">
        <label>Jumlah <span class="text-danger">*</span></label>
        <input type="number" class="form-control" name="f_jumlah">
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group">
        <label>Keterangan Pemakaian <span class="text-danger">*</span></label>
        <textarea name="f_keterangan" class="form-control"></textarea>
        <div class="invalid-feedback"></div>
    </div>

</div>
<div class="modal-footer">
    <input type="submit" name="f_store" class="btn btn-primary btn-simpan" value="Save">
</div>

<?= form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        var base_url = $("#base-url").html();

        $('select[name=f_id_obat]').change(function() {
            var uc = $('select[name=f_id_obat] option:selected').val();

            $.ajax({
                url: base_url + '/resep/get_obat',
                type: 'post',
                dataType: 'json',
                data: {
                    id: uc
                },
                success: function(data) {
                    $('input[name=f_stok]').val(data['stok']);
                    $('input[name=f_satuan]').val(data['satuan']);
                },

            });

        });

        $('.select2').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#form-modals')
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