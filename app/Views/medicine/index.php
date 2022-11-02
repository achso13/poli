<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
	<div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
		<span class="text-uppercase page-subtitle">List</span>
		<h3 class="page-title">Obat</h3>
	</div>

	<div class="col-12 col-sm-6 d-flex align-items-center justify-content-end">
		<div class="float-right">
			<!-- <?php if (session()->get('log_role') === "ADMIN") : ?>
				<button class="btn btn-success mb-sm-0 mx-auto ml-sm-auto mr-sm-0 btn-report" data-toggle="modal" data-target="#modals-export-kunjungan">
					<i class="material-icons">add</i> Export
				</button>

				<div class="modal fade" id="modals-export-kunjungan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
					<div class="modal-dialog " role="document">
						<div class="modal-content">
							<?= form_open('export/resep', ["method" => "get"]) ?>
							<div class="modal-header">
								<h5 class="modal-title">Cetak Laporan Pemberian Obat</h5>
								<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-6">
										<div class="form-group">
											<label for="exampleFormControlSelect1">Tanggal Awal</label>
											<input type="date" class="form-control" name="tanggal_awal" id="tanggal" required>
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="exampleFormControlSelect1">Tanggal Akhir</label>
											<input type="date" class="form-control" name="tanggal_akhir" id="tanggal" required>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<input type="submit" name="cetak" class="btn btn-primary btn-simpan" value="Cetak">
								<button class="btn btn-light" type="button" data-dismiss="modal">Cancel</button>
							</div>
							<?= form_close(); ?>
						</div>
					</div>
				</div>
			<?php endif; ?> -->


			<button class="btn-add btn btn-primary d-inline-flex mb-sm-0 mx-auto ml-sm-auto mr-sm-0" data-toggle="modal" data-target="#form-modals">
				<i class="material-icons">add</i> Tambah Obat </a>
			</button>
		</div>
	</div>
</div>
<!-- End Page Header -->

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body load-data">
				<?= $this->include('medicine/content') ?>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>