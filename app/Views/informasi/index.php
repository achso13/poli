<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
        <span class="text-uppercase page-subtitle">Informasi</span>
        <h3 class="page-title">Dokter</h3>
    </div>

    <!-- <div class="col-12 col-sm-6 d-flex align-items-center justify-content-end">
        <div class="float-right">
            <button class="btn-add btn btn-primary d-inline-flex mb-sm-0 mx-auto ml-sm-auto mr-sm-0" data-toggle="modal" data-target="#form-modals">
                <i class="material-icons">add</i> Tambah Obat
            </button>
        </div>
    </div> -->
</div>
<!-- End Page Header -->

<div class="row">
    <?php foreach ($dokter as $d) :  ?>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-body d-flex flex-column justify-content-center align-items-center px-2 py-4">
                    <?php if ($d['photo'] == null) : ?>
                        <img src="<?= base_url('assets/images/no-user-image.png') ?>" alt="" class="img-responsive user-avatar rounded-circle d-inline-block mb-3 w-50">
                    <?php else : ?>
                        <img src="<?= base_url('uploads/photo/' . $d['photo']) ?>" alt="" class="img-responsive user-avatar rounded-circle d-inline-block mb-3 w-50">
                    <?php endif; ?>
                    <div class="text-center mb-4">
                        <p class="mb-0">Dokter <?= $d['tipe_dokter'] ?></p>
                        <h7 class="font-weight-bold"><?= $d['nama'] ?></h7>
                    </div>

                    <button class="btn-schedule btn btn-outline-primary" data-toggle="modal" data-target="#form-modals" uc="<?= $d['id_dokter'] ?>">
                        Lihat Selengkapnya
                    </button>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="modal fade" id="form-modals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content load-form">

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var base_url = $("#base-url").html();

        $('.btn-schedule').click(function() {
            var id = $(this).attr('uc');
            $('.load-form').load(base_url + '/informasi/view', {
                id: id
            });
        });
    });
</script>
<?= $this->endSection(); ?>