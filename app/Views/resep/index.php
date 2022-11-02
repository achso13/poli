<?= $this->extend("layouts/main") ?>
<?= $this->section("content") ?>
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
	<div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
		<span class="text-uppercase page-subtitle">List</span>
		<h3 class="page-title">Resep</h3>
	</div>
</div>
<!-- End Page Header -->

<div class="card">
	<div class="card-body load-data">
		<?= $this->include('resep/content') ?>
	</div>
</div>

<?= $this->endSection() ?>