<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<script src="<?= base_url('assets/third_party/tinymce/tinymce.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/tinymce.js') ?>"></script>

<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
        <span class="text-uppercase page-subtitle">Treatment</span>
        <h3 class="page-title">Kode Kunjungan : <?= $result['id_kunjungan'] ?></h3>
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
                        <span class="ml-3">Nama Treatment : </span><br />
                        <span class="ml-3 text-semibold text-fiord-blue"><?= $result['id_treatment'] . ' - ' . $result['nama_treatment'] ?></span>
                    </li>
                    <li class="list-group-item p-2">
                        <span class="ml-3">Jadwal Treatment : </span><br />
                        <span class="ml-3 text-semibold text-fiord-blue"><?= time_format($result['jadwal_treatment'], 'd M Y H:i') ?></span>
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
                        <?php if (session()->get('log_role') === "KLINIK") : ?>
                            <?= form_open('treatment_schedule/store') ?>
                            <input type="hidden" name="f_id_rekam_medis" value="<?= $result['id_rekam_medis'] ?>">
                            <div class="form-group">
                                <label><b>Catatan Klinik</b><span class="text-danger">*</span></label>
                                <textarea name="f_notes_klinik" id="" cols="30" rows="10"><?= isset($result['notes_klinik']) ? $result['notes_klinik'] : "" ?></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <input type="submit" value="Save" name="f_store" class="btn btn-primary">
                            <?= form_close(); ?>
                        <?php elseif (session()->get('log_role') === "PASIEN") : ?>
                            <div class="form-group">
                                <label><b>Catatan Klinik</b><span class="text-danger">*</span></label>
                                <div><?= isset($result['notes_klinik']) ? $result['notes_klinik'] : "" ?></div>
                            </div>
                        <?php endif; ?>

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

                    <div class="card-body">
                        <div class="form-group">
                            <h6>Diagnosa :</h6>
                            <p><?= isset($result['diagnosa']) ? $result['diagnosa'] : "" ?></p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <h6>Anamnesa :</h6>
                            <p><?= isset($result['anamnesa']) ? $result['anamnesa'] : "" ?></p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <h6>Tindakan yang dilakukan :</h6>
                            <p><?= isset($result['tindakan']) ? $result['tindakan'] : "" ?></p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <h6>Resep Dokter :</h6>
                            <p><?= isset($result['resep_dokter']) ? $result['resep_dokter'] : "" ?></p>
                        </div>
                    </div>


                </div>

            </div>
        </div>

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