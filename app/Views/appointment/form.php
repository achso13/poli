<!-- <script src="<?= base_url('assets/third_party/tinymce/tinymce.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/tinymce.js') ?>"></script> -->
<?= form_open('appointment/store') ?>
<script>
	$(document).ready(function() {
		$('select[name=f_id_dokter]').change(function() {
			var val = $(this).val();

			$.ajax({
				url: '<?= base_url('doctor/jadwal/get_jadwal') ?>' + `/${val}`,
				type: 'GET',
				dataType: 'JSON',
				success: function(response) {
					$('select[name=f_id_jadwal_dokter]').empty();
					if (response.length > 0) {
						$('select[name=f_id_jadwal_dokter]').append(`<option value="">-- Pilih Jadwal Dokter --</option>`);
						$.each(response, function(index, value) {
							$('select[name=f_id_jadwal_dokter]').append(`<option value="${value.id_jadwal_dokter}">${value.hari} - ${value.jam_mulai} - ${value.jam_selesai}</option>`);
						});
					} else {
						$('select[name=f_id_jadwal_dokter]').empty();
						$('select[name=f_id_jadwal_dokter]').append('<option value="">--Pilih Dokter Terlebih Dahulu--</option>');
					}
				},
			});
		});

		$(".select2").select2({
			theme: "bootstrap4",
		});
	});
</script>



<div class="modal-header">
	<h5 class="modal-title" id="exampleModalLabel">Kunjungan</h5>
	<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
	<?php if (session()->get('log_role') === "ADMIN") : ?>
		<div class="form-group">
			<label>Nama Pasien <span class="text-danger">*</span></label>

			<!-- select2 for pasien -->
			<select class="form-control select2" name="f_id_pasien" id="f_id_pasien" id="select-beast">
				<option value="">---Pilih Pasien---</option>
				<?php foreach ($pasien as $p) : ?>
					<option value="<?= $p['id_pasien'] ?>"><?= $p['id_pasien'] ?> - <?= $p['nama'] ?> - <?= $p['nip'] ?></option>
				<?php endforeach; ?>
			</select>
			<div class="invalid-feedback"></div>
		</div>
	<?php endif; ?>
	<div class="form-group">
		<label>Nama Dokter <span class="text-danger">*</span></label>
		<select name="f_id_dokter" class="form-control">
			<option value="">--Pilih Dokter--</option>
			<?php
			if (isset($dokter)) :
				foreach ($dokter as $d) :
			?>
					<option value="<?= $d['id_dokter'] ?>"><?= $d['tipe_dokter'] ?> - <?= $d['nama'] ?></option>
			<?php
				endforeach;
			endif;
			?>
		</select>
		<div class="invalid-feedback"></div>
	</div>
	<div class="form-group">
		<label>Jadwal Dokter <span class="text-danger">*</span></label>
		<select name="f_id_jadwal_dokter" class="form-control">
			<option value="">--Pilih Dokter Terlebih Dahulu--</option>
		</select>
		<div class="invalid-feedback"></div>
	</div>
	<div class="form-group">
		<label>Tanggal Kunjungan <span class="text-danger">*</span></label>
		<input type="date" class="form-control" name="f_tanggal_kunjungan" id="date1">
		<div class="invalid-feedback"></div>
	</div>

	<?php if (session()->get('log_role') === "PASIEN") : ?>
		<input type="hidden" name="f_id_pasien" value="<?= $pasien['id_pasien'] ?>">
	<?php endif; ?>

	<div class="form-group">
		<label>Keluhan <span class="text-danger">*</span></label>
		<textarea id="editor" class="form-control" style="height: 230px;" name="f_keluhan"></textarea>
		<div class="invalid-feedback"></div>
	</div>

</div>
<div class="modal-footer">
	<input type="submit" name="f_store" class="btn btn-primary btn-simpan" value="Simpan">
</div>

<?= form_close(); ?>

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
						window.location.href = "<?= base_url('/appointment') ?>";
					}
				}
			});
		});
	});
</script>