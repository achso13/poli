<script src="<?= base_url('assets/third_party/tinymce/tinymce.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/tinymce.js') ?>"></script>


<?= form_open('tiket/store_comment', [
	'id' => 'formComment',
]) ?>

<input type="hidden" name="f_id_kunjungan" value="<?= $result['id_kunjungan'] ?>">
<div class="modal-header">
	<h5 class="modal-title" id="exampleModalLabel">Comment</h5>
	<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
	<div class="form-group">
		<div class="form-group">
			<label>Massage <span class="text-danger">*</span></label>
			<textarea id="editor" class="form-control " style="height: 230px;" name="f_pesan"></textarea>
			<div class="invalid-feedback"></div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<input type="submit" name="f_store" class="btn btn-primary btn-send" value="Kirim">
</div>

<?= form_close(); ?>


<script type="text/javascript">
	$(document).ready(function() {
		var base_url = $("#base-url").html();

		$("#formComment").submit(function(e) {
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
					$('.btn-send').attr('disabled');
					$('.btn-send').html('<i class="fa fa-spinner fa-spin"></i> Saving...');
				},
				complete: () => {
					$('.btn-send').removeAttr('disabled');
					$('.btn-send').html('Save');
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
	})
</script>