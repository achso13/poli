<?= $this->extend('layouts/main'); ?>
<?= $this->section('content') ?>
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Overview</span>
        <h3 class="page-title">Dashboard</h3>
    </div>
</div>
<!-- End Page Header -->

<!-- Dashboard Content -->
<div class="row">
    <?= $this->include("home/$menu") ?>
</div>
<?php if (session()->get('log_role') === "ADMIN" || session()->get("log_role") === "PASIEN") : ?>
    <div class="row">
        <div class="col-md-6">
            <div class="stats-small stats-small--1 card card-small w-100 mb-5">
                <div class="card-body p-4">
                    <div class="stats-small__data mb-2">
                        <span class="text-uppercase">Pengumuman</span>
                    </div>
                    <div class="mb-2">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($pengumuman as $p) : ?>
                                <li class="list-group-item px-0">
                                    <a href="<?= base_url('pengumuman/view/' . $p['id_pengumuman']) ?>" class="text-semibold">
                                        <?= $p['judul'] ?>
                                    </a>
                                    <p class="text-normal text-muted m-0"><?= $p['nama'] ?>, <?= time_format($p['created_at'], "d M Y H:i") ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <a href="<?= base_url("pengumuman") ?>">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- End Dashboard Content -->
<?= $this->endSection(); ?>