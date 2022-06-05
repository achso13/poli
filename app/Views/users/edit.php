<?= form_open_multipart('users/update') ?>
<?= csrf_field() ?>
<input type="hidden" name="f_id" value="<?= $result['id'] ?>">
<input type="hidden" name="f_old_photo" value="<?= $result['photo'] ?>">
<input type="hidden" name="f_old_username" value="<?= $result['username'] ?>">
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">User Update</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label>Fullname<span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="f_fullname" value="<?= $result['fullname'] ?>" placeholder="Nama lengkap anda">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Username<span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="f_username" value="<?= $result['username'] ?>" placeholder="Username untuk login anda">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>New Password</label>
        <input type="password" class="form-control" name="f_password" placeholder="Kosongkan Jika tidak akan diubah">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Email<span class="text-danger">*</span></label>
        <input type="email" class="form-control" name="f_email" value="<?= $result['email'] ?>" placeholder="Email anda">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Foto</label>
        <input type="file" class="form-control" name="f_photo">
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label>Role<span class="text-danger">*</span></label>
        <select name="f_id_role" class="form-control">
            <option value="">--Select One--</option>
            <option value="1" <?= selectSet($result['id_role'], 1) ?>>Administrator</option>
            <option value="4" <?= selectSet($result['id_role'], 4) ?>>Klinik</option>
            <option value="5" <?= selectSet($result['id_role'], 5) ?>>Apoteker</option>
        </select>
        <div class="invalid-feedback"></div>
    </div>

    <div class="form-group load-dep" style="display: none;">
        <label>Poliklinik<span class="text-danger">*</span></label>
        <select name="f_id_clinic" class="form-control">
            <option value="">---Choose---</option>
            <?php

            $dep = listClinic();

            if (isset($dep)) :
                foreach ($dep as $de) :
            ?>
                    <option value="<?= $de['id_clinic'] ?>" <?= selectSet($result['id_clinic'], $de['id_clinic']) ?>><?= $de['clinic_name'] ?></option>
            <?php
                endforeach;
            endif;
            ?>
        </select>
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