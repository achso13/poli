<?= $this->extend('layouts/main') ?>
<?= $this->section("content") ?>

<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
        <span class="text-uppercase page-subtitle">Cetak</span>
        <h3 class="page-title">Laporan</h3>
    </div>
</div>
<!-- End Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body load-data">
                <?= form_open('laporan/export') ?>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Pilih Jenis Laporan <span class="text-danger">*</span></label>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="f_type" value="kunjungan" checked>
                                    <label class="form-check-label">Data Kunjungan</label>
                                </div>
                                <!-- <div class="form-check">
                                    <input class="form-check-input" type="radio" name="f_type" value="pasien">
                                    <label class="form-check-label">Data Pasien</label>
                                </div> -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="f_type" value="obat">
                                    <label class="form-check-label">Data Obat</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="f_type" value="resep">
                                    <label class="form-check-label">Data Resep</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Tanggal Awal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_awal" id="tanggal" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Tanggal Akhir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal_akhir" id="tanggal" required>
                        </div>
                    </div>
                </div>


                <input type="submit" name="cetak" class="btn btn-primary btn-block btn-simpan" value="Cetak">

                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modals-export-kunjungan" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<?= $this->endSection() ?>