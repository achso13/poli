<?= form_open_multipart('doctor/jadwal/store') ?>
<?= csrf_field() ?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal Dokter</h5>
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
                    <option value="<?= $d['id_dokter'] ?>"><?= $d['tipe_dokter'] ?> - <?= $d['nama'] ?></option>
            <?php
                endforeach;
            endif;
            ?>
        </select>
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Jam Mulai Praktek<span class="text-danger">*</span></label>
        <input type="time" class="form-control" name="f_jam_mulai">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Jam Tutup Praktek<span class="text-danger">*</span></label>
        <input type="time" class="form-control" name="f_jam_selesai">
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group">
        <label>Hari <span class="text-danger">*</span></label>
        <select name="f_hari" class="form-control">
            <option value="">--Pilih Hari--</option>
            <option value="Senin">Senin</option>
            <option value="Selasa">Selasa</option>
            <option value="Rabu">Rabu</option>
            <option value="Kamis">Kamis</option>
            <option value="Jumat">Jumat</option>
        </select>
        <div class="invalid-feedback"></div>
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