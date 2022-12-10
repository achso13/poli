<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- <script src="<?= base_url('assets/third_party/tinymce/tinymce.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/tinymce.js') ?>"></script> -->

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
		<div class="card ">
			<div class="card-body py-0 p-0">
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
						<span class="ml-3">Tgl. Kunjungan : </span><br />
						<span class="ml-3 text-semibold text-fiord-blue"><?= time_format($result['tanggal_kunjungan'], 'd M Y') ?></span>
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
					<div class="card-header">
						<h5>Keluhan</h5>
					</div>
					<div class="card-body pt-0">
						<div class="blog-comments__item d-flex">
							<div class="blog-comments__content">
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

			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h5>Tindakan Dokter</h5>
					</div>
					<?php if (session()->get('log_role') == "DOKTER" || session()->get('log_role') == "ADMIN") : ?>
						<?php if (isset($rekamMedis)) : ?>
							<?= form_open('rekam_medis/update') ?>
						<?php else : ?>
							<?= form_open('rekam_medis/store') ?>
						<?php endif; ?>

						<input type="hidden" name="f_id_kunjungan" value="<?= $result['id_kunjungan'] ?>">
						<input type="hidden" name="f_id_pasien" value="<?= $result['id_pasien'] ?>">
						<input type="hidden" name="f_id_dokter" value="<?= $result['id_dokter'] ?>">
						<input type="hidden" value="<?= isset($rekamMedis['id_rekam_medis']) ? $rekamMedis['id_rekam_medis'] : "" ?>" name="f_id_rekam_medis">

						<div class="card-body py-0">
							<div class="form-group">
								<label>Tinggi Badan</label>
								<input type="number" class="form-control" name="f_tinggi_badan" placeholder="Tinggi badan pasien (cm)" value="<?= isset($rekamMedis['tinggi_badan']) ? $rekamMedis['tinggi_badan'] : "" ?>">
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label>Berat Badan</label>
								<input type="number" class="form-control" name="f_berat_badan" placeholder="Berat badan pasien (kg)" value="<?= isset($rekamMedis['berat_badan']) ? $rekamMedis['berat_badan'] : "" ?>">
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label>Alergi Obat</label>
								<input type="text" class="form-control" name="f_alergi_obat" placeholder="Alergi obat pasien" value="<?= isset($rekamMedis['alergi_obat']) ? $rekamMedis['alergi_obat'] : "" ?>">
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label>Anamnesa <span class="text-danger">*</span></label>
								<textarea class="form-control " style="height: 120px;" name="f_anamnesa" placeholder="Anamnesa pasien"><?= isset($rekamMedis['anamnesa']) ? $rekamMedis['anamnesa'] : "" ?></textarea>
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label>Diagnosa <span class="text-danger">*</span></label>
								<textarea class="form-control" style="height: 120px;" name="f_diagnosa" placeholder="Diagnosa pasien"><?= isset($rekamMedis['diagnosa']) ? $rekamMedis['diagnosa'] : "" ?></textarea>
								<div class="invalid-feedback"></div>
							</div>
							<div class="form-group">
								<label>Keterangan</label>
								<textarea class="form-control" style="height: 120px;" name="f_keterangan" placeholder="Keterangan pemeriksaan (jika ada)"><?= isset($rekamMedis['keterangan']) ? $rekamMedis['keterangan'] : "" ?></textarea>
								<div class="invalid-feedback"></div>
							</div>

							<hr>
							<h5><strong>Tindakan/Terapi</strong></h5>
							<hr>

							<div class="form-group">
								<label>Treatment</label>
								<select name="f_id_treatment" class="form-control">
									<option value=""> --- Select one ---</option>
									<?php foreach ($treatment as $row) : ?>
										<option value="<?= $row['id_treatment'] ?>" <?= isset($rekamMedis['id_treatment']) && $rekamMedis['id_treatment'] == $row['id_treatment'] ? "selected" : "" ?>>
											<?= $row['nama_klinik'] ?> - <?= $row['nama_treatment'] ?> (<?= $row['jam_buka'] ?> - <?= $row['jam_tutup'] ?>)
										</option>
									<?php endforeach; ?>
								</select>
								<div class="invalid-feedback"></div>
							</div>

							<div class="form-group">
								<label>Jadwal Treatment</label>
								<input type="datetime-local" class="form-control" name="f_jadwal_treatment" value="<?= isset($rekamMedis['jadwal_treatment']) ? $rekamMedis['jadwal_treatment'] : "" ?>">
								<div class="invalid-feedback"></div>
							</div>

							<hr>
							<h5><strong>Resep Dokter</strong></h5>
							<hr>

							<div class="form-group">
								<label>Resep Dokter <span class="text-danger">*</span></label>
								<textarea class="form-control" style="height: 120px;" name="f_resep_dokter" placeholder="Resep obat untuk pasien"><?= isset($rekamMedis['resep_dokter']) ? $rekamMedis['resep_dokter'] : "" ?></textarea>
								<div class="invalid-feedback"></div>
							</div>


						</div>
						<div class="card-footer">
							<div class="d-table mx-auto">
								<input type="submit" name="f_store" class="btn btn-primary text-white btn-simpan" value="Simpan">
							</div>
						</div>
						<?= form_close() ?>
					<?php else : ?>
						<div class="card-body py-0">
							<div class="form-group">
								<label>Tinggi Badan</label>
								<p><?= isset($rekamMedis['tinggi_badan']) ? $rekamMedis['tinggi_badan'] : "" ?></p>
							</div>
							<div class="form-group">
								<label>Berat Badan</label>
								<p><?= isset($rekamMedis['berat_badan']) ? $rekamMedis['berat_badan'] : "" ?></p>
							</div>
							<div class="form-group">
								<label>Alergi Obat</label>
								<p><?= isset($rekamMedis['alergi_obat']) ? $rekamMedis['alergi_obat'] : "" ?></p>
							</div>
							<div class="form-group">
								<h6>Diagnosa :</h6>
								<p><?= isset($rekamMedis['diagnosa']) ? $rekamMedis['diagnosa'] : "" ?></p>
							</div>
							<hr>
							<div class="form-group">
								<h6>Anamnesa :</h6>
								<p><?= isset($rekamMedis['anamnesa']) ? $rekamMedis['anamnesa'] : "" ?></p>
							</div>
							<div class="form-group">
								<h6>Keterangan :</h6>
								<p><?= isset($rekamMedis['keterangan']) ? $rekamMedis['keterangan'] : "" ?></p>
							</div>
							<hr>
							<div class="form-group">
								<h6>Tindakan/Terapi :</h6>
								<p><?= isset($rekamMedis['tindakan']) ? $rekamMedis['tindakan'] : "" ?></p>
							</div>
							<hr>
							<div class="form-group">
								<h6>Resep Dokter :</h6>
								<p><?= isset($rekamMedis['resep_dokter']) ? $rekamMedis['resep_dokter'] : "" ?></p>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<!-- <div class="row mt-3">
			<div class="col-md-12 text-right">
				<button uc="<?= $result['id_kunjungan'] ?>" class="btn btn-primary btn-reply  ml-auto" data-toggle="modal" data-target="#form-modals">
					<i class="material-icons">reply</i> Reply
				</button>
			</div>
		</div>

		<?php if (isset($comment)) : ?>
			<div class="load-comment">
				<?php $this->load->view('tiket/load_comment'); ?>
			</div>
			
		<?php else : ?>
			<div class="alert alert-info alert-dismissible fade show mb-0 text-center mt-3" role="alert">Belum ada percakapan ...</div>
		<?php endif; ?> -->


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