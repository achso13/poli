<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- <script src="<?= base_url('assets/third_party/tinymce/tinymce.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/tinymce.js') ?>"></script> -->

<!-- Page Header -->
<div class="page-header row no-gutters py-4">
	<div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
		<span class="text-uppercase page-subtitle">Konsultasi Online</span>
		<h3 class="page-title">Kode Tiket : <?= $result['id_kunjungan'] ?></h3>
	</div>
</div>
<!-- End Page Header -->

<div class="row">
	<div class="col-md-4 mb-3">
		<div class="card ">
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
						<span class="ml-3">Tgl. Pengiriman : </span><br />
						<span class="ml-3 text-semibold text-fiord-blue"><?= time_format($result['created_at'], 'd M Y H:i') ?></span>
					</li>

					<li class="list-group-item p-2">
						<span class="ml-3">Status : </span><br />
						<?php if ($result['status'] == "Aktif") : ?>
							<span class="badge badge-pill badge-success text-white ml-3">Aktif</span>
						<?php elseif ($result['status'] == "Selesai") : ?>
							<span class="badge badge-pill badge-dark text-white ml-3">Selesai</span>
						<?php endif; ?>
					</li>

					<?php if (session()->get('log_role') !== "PASIEN") : ?>
						<li class="list-group-item p-2">
							<span class="ml-3">Rekam Medis Pasien : </span><br />
							<span class="ml-3 text-semibold text-fiord-blue"> <a href="<?= base_url('rekam_medis/' . $result['id_pasien']) ?>" class="btn btn-primary btn-sm btn-edit text-white">
									<i class="mr-1 fa fa-history"></i> Rekam Medis
								</a></span>

						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<h5>Keluhan</h5>

						<div class="blog-comments__item d-flex p-3">
							<div class="blog-comments__avatar mr-3">
								<?php if ($pasien['photo'] == NULL) : ?>
									<img src="<?= base_url('assets/images/no-user-image.png') ?>" class="img-responsive" width="100%">
								<?php else : ?>
									<img src="<?= base_url('uploads/photo/' . $pasien['photo']) ?>" class="img-responsive" width="100%">
								<?php endif; ?>
							</div>
							<div class="blog-comments__content">
								<div class="blog-comments__meta text-muted">
									<a class="text-secondary" href="#"><?= $pasien['nama'] ?></a>
									<span class="text-muted">– <?= $result['created_at'] ?></span>
								</div>
								<p class="m-0 my-1 mb-2 text-muted">
									<?= $result['keluhan'] ?>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-md-12 text-right">
				<?php if (session()->get('log_role') === "PASIEN" || session()->get('log_role') === "DOKTER") : ?>
					<?php if ($result['status'] == "Aktif") :  ?>
						<button uc="<?= $result['id_kunjungan'] ?>" class="btn btn-primary btn-reply  ml-auto" data-toggle="modal" data-target="#form-modals">
							<i class="material-icons">reply</i> Balas
						</button>
					<?php else : ?>
						<button class="btn btn-primary btn-reply  ml-auto" disabled>
							<i class="material-icons">reply</i> Balas
						</button>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>

		<?php if (!empty($pesan)) : ?>
			<div class="load-comment">
				<?= $this->include('tiket/load_comment'); ?>
			</div>

		<?php else : ?>
			<div class="row mt-3">
				<div class="col-md-12 text-right">
					<div class="alert alert-info alert-dismissible fade show mb-0 text-center mt-3" role="alert">Belum ada percakapan ...</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if (session()->get('log_role') === "DOKTER") : ?>
			<div class="row mt-3">
				<div class="col-md-12 text-right">
					<?php if ($result['status'] == "Aktif") :  ?>
						<a href="<?= base_url('tiket/status/selesai/' . $result['id_kunjungan']) ?>" onclick="return confirm('Hentikan pembicaraan?')" class="btn btn-primary btn-block my-3">
							<span class="text-danger">

							</span> Hentikan Pembicaraan
						</a>
					<?php else : ?>
						<button class="btn btn-primary btn-block my-3" disabled>
							Hentikan Pembicaraan
						</button>
					<?php endif; ?>

				</div>
			</div>
		<?php endif; ?>

	</div>
</div>

<div class="modal fade" id="form-modals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content load-form">

		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		const base_url = $("#base-url").html();

		$('.btn-reply').click(function() {

			var uc = $(this).attr('uc');

			$('.load-form').load(base_url + '/tiket/form_comment', {
				js_id: uc
			});
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
						$('textarea').removeClass('is-invalid');
						$('.invalid-feedback').text("");

						$.each(response.message, function(key, value) {
							$('input[name=f_' + key + ']').addClass('is-invalid');
							$('select[name=f_' + key + ']').addClass('is-invalid');
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