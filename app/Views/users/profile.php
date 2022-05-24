 <!-- Page Header -->
<div class="page-header row no-gutters py-4">
	<div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
		<span class="text-uppercase page-subtitle">Overview</span>
		<h3 class="page-title">Profile Account</h3>
	</div>
</div>
<!-- End Page Header -->

<div class="row">
	<div class="col-lg-4">
		<div class="card card-small mb-4 pt-3">
			<div class="card-header border-bottom text-center">
				<div class="mb-3 mx-auto">
					 <?php if($row->photo == NULL):?>
                        <img src="<?=base_url('assets/images/no-user-image.png')?>" class="img-responsive rounded-circle" width="110">
                    <?php else:?>
                        <img src="<?=base_url('uploads/photo/'.$row->photo)?>" class="img-responsive rounded-circle" width="110">
                    <?php endif;?>

				</div>
				<h4 class="mb-0"><?=$row->full_name?></h4>
				<span class="text-muted d-block mb-2"><?=$row->email?></span>
				
			</div>
			
		</div>
	</div>
	<div class="col-lg-8">
		<?=form_open('profile/update')?>
		<div class="card card-small mb-4">
			<div class="card-header">
				Information Account
			</div>
			<div class="card-body">
				<div class="form-group">
					<label>Username</label>
					<input type="text" class="form-control" name="f_username" value="<?=$row->username?>" readonly>
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="text" class="form-control" name="f_email" value="<?=$row->email?>" readonly>
				</div>
				<div class="form-group">
					<label>Nama Lengkap</label>
					<input type="text" class="form-control" name="f_full_name" value="<?=$row->full_name?>" >
				</div>

				<div class="form-group">
					<label>Replace Photo</label>
					<input type="file" class="form-control" name="f_photo" >
				</div>

				<div class="form-group">
					<label>New Password</label>
					<input type="text" class="form-control" name="f_password" >
					<span class="text-danger">*Diisi jika ingin mengubah password</span>
				</div>
			</div>
			<div class="card-footer">
				<input type="submit" name="f_update" value="Simpan Perubahan" class="btn btn-info">
			</div>
		</div>
		<?=form_close()?>
	</div>
</div>