<script type="text/javascript">
    $(document).ready(function() {
        $('select[name=f_role]').change(function() {
            var val = $(this).val();

            if (val == "KLINIK") {
                $('.load-dep').css('display', 'block');
            } else {
                $('.load-dep').css('display', 'none');
            }
        });
    });
</script>

<?= form_open_multipart('users/store') ?>
<?= csrf_field() ?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">User Add</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label>Nama <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="f_nama" placeholder="Nama lengkap anda">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Username <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="f_username" placeholder="Username untuk login anda">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control" name="f_password" placeholder="Minimal 3 karakter">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" name="f_email" placeholder="Email anda">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Photo</label>
        <input type="file" class="form-control" name="f_photo">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Role <span class="text-danger">*</span></label>
        <select name="f_role" class="form-control">
            <option value="">--Select One--</option>
            <option value="ADMIN">Administrator</option>
            <option value="KLINIK">Klinik</option>
            <option value="APOTEKER">Apoteker</option>
        </select>
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group load-dep" style="display: none;">
        <label>Klinik <span class="text-danger">*</span></label>
        <select name="f_id_klinik" class="form-control">
            <option value="">---Choose---</option>
            <?php
            $dep = listClinic();

            if (isset($dep)) :
                foreach ($dep as $de) :
            ?>
                    <option value="<?= $de['id_klinik'] ?>"><?= $de['nama_klinik'] ?></option>
            <?php
                endforeach;
            endif;
            ?>
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
                        $('.invalid-feedback').text("");

                        $.each(response.message, function(key, value) {
                            $('input[name=f_' + key + ']').addClass('is-invalid');
                            $('select[name=f_' + key + ']').addClass('is-invalid');
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