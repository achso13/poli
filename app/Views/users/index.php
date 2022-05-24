<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
	<div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
		<span class="text-uppercase page-subtitle">List</span>
		<h3 class="page-title">User Management</h3>
	</div>
	<div class="col-12 col-sm-6 d-flex align-items-center">
		<button class="btn-add btn btn-primary d-inline-flex mb-sm-0 mx-auto ml-sm-auto mr-sm-0" data-toggle="modal" data-target="#form-modals">
			<i class="material-icons">add</i> Add User </a>
		</button>
	</div>
</div>
<!-- End Page Header -->

<div class="row mb-3">
	<div class="col-md-12">
		<div class="btn-group ">
			<a href="<?= base_url('users/role/1') ?>" class="btn btn-white btn-sm btn-edit text-primary">
				Administrator
			</a>
			<a href="<?= base_url('users/role/4') ?>" class="btn btn-white btn-sm btn-edit text-primary ml-2">
				Klinik
			</a>
			<a href="<?= base_url('users/role/5') ?>" class="btn btn-white btn-sm btn-edit text-primary ml-2">
				Apoteker
			</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body load-data">
				<?= $this->include('users/content'); ?>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>