<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<script src="<?= base_url('assets/third_party/tinymce/tinymce.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/tinymce.js') ?>"></script>

<!-- Page Header -->
<div class="page-header row no-gutters py-4">
	<div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
		<span class="text-uppercase page-subtitle">Pemeriksaan Offline</span>
		<h3 class="page-title">Kode Kunjungan : <?= $result['id_kunjungan'] ?></h3>
	</div>
</div>
<!-- End Page Header -->

<div class="row">
	<div class="col-md-4 mb-3">
		<div class="card">
			<div class="card-body p-0">
				<ul class="list-group list-group-flush">
					<li class="list-group-item p-2">
						<span class="ml-3">Nama Pasien : </span><br />
						<span class="ml-3 text-semibold text-fiord-blue"><?= $result['id_pasien'] . ' - ' . $result['nama_pasien'] ?></span>
					</li>
					<li class="list-group-item p-2">
						<span class="ml-3">Nama Dokter : </span><br />
						<span class="ml-3 text-semibold text-fiord-blue"><?= $result['id_dokter'] . ' - ' . $result['nama_dokter'] ?></span>
					</li>
					<li class="list-group-item p-2">
						<span class="ml-3">Tgl. Pemeriksaan : </span><br />
						<span class="ml-3 text-semibold text-fiord-blue"><?= time_format($result['tanggal_kunjungan'], 'd M Y') ?></span>
					</li>

					<li class="list-group-item p-2">
						<span class="ml-3">Status : </span><br />
						<?php if ($result['status'] == "Belum Selesai") : ?>
							<span class="badge badge-pill badge-danger text-white ml-3">Belum Selesai</span>
						<?php elseif ($result['status'] == "Sedang Disiapkan") : ?>
							<span class="badge badge-pill badge-warning ml-3 text-white">Sedang Disiapkan</span>
						<?php elseif ($result['status'] == "Sudah Selesai") : ?>
							<span class="badge badge-pill badge-success ml-3">Sudah Selesai</span>
						<?php endif; ?>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<h5>Resep Obat Dokter</h5>

						<div class="blog-comments__item d-flex p-3">

							<div class="blog-comments__content">
								<p class="m-0 my-1 mb-2 text-muted">
									<?= $result['resep_dokter'] ?>
								</p>
							</div>
						</div>
					</div>

				</div>

			</div>
		</div>
		<div class="row mt-2">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<button class="btn-add btn btn-primary d-inline-flex mb-sm-0 mx-auto ml-sm-auto mr-sm-0" resep="<?= $result['id_resep'] ?>" data-toggle="modal" data-target="#form-modals">
							<i class="material-icons">add</i> Tambah Obat </a>
						</button>
						<button class="btn btn-warning btn-sm text-white btn-status" resep="<?= $result['id_resep'] ?>" data-toggle="modal" data-target="#modals-approve">
							<i class="material-icons">send</i> Ubah Status Resep
						</button>
						<div class="modal fade" id="modals-approve" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
							<div class="modal-dialog " role="document">
								<div class="modal-content load-status">

								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<?php if (isset($obat)) : ?>
							<div class="table-responsive">
								<table class="table table-bordered table-hover" width="100%" cellspacing="0" id="dataTable">
									<thead>
										<tr class="bg-light">
											<td class="text-primary text-center" width="5%">No</td>
											<td class="text-primary text-center">Nama Obat</td>
											<td class="text-primary text-center" width="25%">Jumlah</td>
											<td class="text-primary text-center" width="30%">Catatan</td>
											<td class="text-primary text-center">Action</td>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1; ?>
										<?php foreach ($obat as $row) : ?>
											<tr>
												<td><?= $no ?></td>
												<td><?= $row['nama_obat'] ?></td>
												<td><?= $row['jumlah'] ?> - <?= $row['satuan'] ?></td>
												<td><?= $row['keterangan'] ?></td>
												<td>
													<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modals-delete-<?= $row['id_resep_detail'] ?>">
														<i class="mr-1 fa fa-trash-alt"></i> Delete
													</button>

													<div class="modal fade" id="modals-delete-<?= $row['id_resep_detail'] ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
														<div class="modal-dialog " role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title">Warning</h5>
																	<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
																</div>
																<div class="modal-body">
																	<p class="text-center"><i class="fa fa-info-circle"></i> Do you really want to delete this record ?</p>
																</div>
																<div class="modal-footer">
																	<?= form_open('resep/delete/' . $row['id_resep_detail']) ?>
																	<?= csrf_field() ?>
																	<input type="hidden" name="_method" value="DELETE">
																	<button type="submit" class="btn btn-danger btn-delete">
																		Delete
																	</button>
																	<?= form_close() ?>
																	<button class="btn btn-light" type="button" data-dismiss="modal">Cancel</button>
																</div>
															</div>
														</div>
													</div>
												</td>
											</tr>

											<?php $no++; ?>
										<?php endforeach; ?>

									</tbody>
								</table>
							</div>

						<?php else : ?>

							<div class="alert alert-warning alert-dismissible fade show mb-0 text-center" role="alert">Empty..</div>

						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="form-modals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content load-form">

				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		const base_url = $("#base-url").html();

		$('.btn-add').click(function() {
			var resep = $(this).attr('resep');

			$('.load-form').load(base_url + '/resep/add', {
				id: resep
			});
		});

		$('.btn-status').click(function() {
			var resep = $(this).attr('resep');

			$('.load-status').load(base_url + '/resep/status', {
				id: resep
			});
		});

		var table = $('#dataTable').DataTable({
			"columnDefs": [{
				"searchable": false,
				"orderable": false,
				"targets": 0
			}, {
				"searchable": false,
				"targets": 3
			}],
		});
		table.on('order.dt search.dt', function() {
			table.column(0, {
				search: 'applied',
				order: 'applied'
			}).nodes().each(function(cell, i) {
				cell.innerHTML = i + 1;
			});
		}).draw();
	});
</script>
<?= $this->endSection() ?>