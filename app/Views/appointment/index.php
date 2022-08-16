<?= $this->extend("layouts/main") ?>
<?= $this->section("content") ?>
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
	<div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
		<span class="text-uppercase page-subtitle">List</span>
		<h3 class="page-title">Appointment / Periksa Offline</h3>
	</div>
	<div class="col-12 col-sm-6 d-flex align-items-center">
		<?php if (session()->get('log_role') === "ADMIN" || session()->get('log_role') === "PASIEN") : ?>
			<a href="<?= base_url('appointment/form') ?>" class="btn btn-primary d-inline-flex mb-sm-0 mx-auto ml-sm-auto mr-sm-0">
				<i class="material-icons">add</i> Add Appointment / Periksa Offline </a>
			</a>
		<?php endif; ?>

	</div>
</div>
<!-- End Page Header -->

<div class="card">
	<div class="card-body load-data">
		<?= $this->include('appointment/content') ?>
	</div>
</div>

<?= $this->endSection() ?>