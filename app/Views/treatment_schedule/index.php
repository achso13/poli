<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
	<div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
		<span class="text-uppercase page-subtitle">List</span>
		<h3 class="page-title">Jadwal Treatment</h3>
	</div>
</div>
<!-- End Page Header -->

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body load-data">
				<?= $this->include('treatment_schedule/content') ?>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>