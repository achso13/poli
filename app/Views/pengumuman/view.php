<?= $this->extend('layouts/main'); ?>

<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<script src="<?= base_url('assets/third_party/tinymce/tinymce.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/tinymce.js') ?>"></script>

<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
        <span class="text-uppercase page-subtitle">Pengumuman</span>
        <h3 class="page-title mb-3"><?= $result['judul'] ?></h3>
        <div class="text-muted font-weight-normal">
            <i class="material-icons">person</i>
            <span><?= $result['nama'] ?>, <?= time_format($result['created_at'], "d M Y H:i") ?></span>
        </div>
    </div>
</div>
<!-- End Page Header -->

<div class="page-header">
    <div class="card">
        <div class="card-body">
            <div class="blog-comments__item d-flex p-3">
                <div class="blog-comments__content">
                    <p class="m-0 my-1 mb-2">
                        <?= $result['isi'] ?>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>