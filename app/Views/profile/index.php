 <?= $this->extend("layouts/main") ?>
 <?= $this->section("content") ?>


 <!-- Page Header -->
 <div class="page-header row no-gutters py-4">
     <div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
         <span class="text-uppercase page-subtitle">Overview</span>
         <h3 class="page-title">Profile</h3>
     </div>
 </div>
 <!-- End Page Header -->

 <div class="row">
     <div class="col-lg-4">
         <div class="card card-small mb-4 pt-3">
             <div class="card-header border-bottom text-center">
                 <div class="mb-3 mx-auto">
                     <?php if ($user['photo'] == NULL) : ?>
                         <img src="<?= base_url('assets/images/no-user-image.png') ?>" class="img-responsive rounded-circle" width="110" height="110">
                     <?php else : ?>
                         <img src="<?= base_url('uploads/photo/' . $user['photo']) ?>" class="img-responsive rounded-circle" width="110" height="110">
                     <?php endif; ?>

                 </div>
                 <h4 class="mb-0"><?= $user['nama'] ?></h4>
                 <span class="text-muted d-block mb-2"><?= $user['email'] ?></span>

             </div>

         </div>
     </div>
     <div class="col-lg-8">
         <?= form_open_multipart('profile/update') ?>
         <div class="card card-small mb-4">
             <div class="card-header">
                 Informasi Akun
             </div>
             <div class="card-body">
                 <div class="form-group">
                     <label>Username</label>
                     <input type="text" class="form-control" name="f_username" value="<?= $user['username'] ?>" readonly>
                 </div>
                 <div class="form-group">
                     <label>Email</label>
                     <input type="text" class="form-control" name="f_email" value="<?= $user['email'] ?>" readonly>
                 </div>
                 <div class="form-group">
                     <label>Nama Lengkap <span class="text-danger">*</span></label>
                     <input type="text" class="form-control" name="f_nama" value="<?= $user['nama'] ?>" disabled>
                 </div>

                 <div class="form-group">
                     <input type="hidden" name="f_old_photo" value="<?= $user['photo'] ?>">
                     <label>Ubah Photo</label>
                     <input type="file" class="form-control" name="f_photo">
                     <div class="invalid-feedback"></div>
                 </div>

                 <div class="form-group">
                     <label>Password Baru</label>
                     <input type="password" class="form-control" name="f_password" placeholder="Diisi jika ingin mengubah password">
                     <div class="invalid-feedback"></div>
                 </div>
             </div>
             <div class="card-footer">
                 <input type="submit" name="f_update" value="Simpan Perubahan" class="btn btn-info btn-simpan">
             </div>

         </div>
         <?= form_close() ?>
     </div>
 </div>

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
 <?= $this->endSection() ?>