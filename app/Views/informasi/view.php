<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Info Dokter</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">

    <div class="d-flex justify-content-center">
        <?php if ($dokter['photo'] == null) : ?>
            <img src="<?= base_url('assets/images/no-user-image.png') ?>" alt="" class="img-responsive user-avatar rounded-circle mb-3" width="100px">
        <?php else : ?>
            <img src="<?= base_url('uploads/photo/' . $d['photo']) ?>" alt="" class="img-responsive user-avatar rounded-circle mb-3" width="100px">
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <p class="mb-0">Nama</p>
        <h6><?= $dokter['nama'] ?></h6>
    </div>
    <div class="mb-4">
        <p class="mb-0">Keahlian</p>
        <h6>Dokter <?= $dokter['tipe_dokter'] ?></h6>
    </div>
    <div class="mb-4">
        <p class="mb-0">Jadwal Praktik</p>
        <?php foreach ($jadwal as $j) : ?>
            <h6 class="mb-0"><?= $j['hari'] ?> - <?= date('H:i', strtotime($j['jam_mulai'])) ?> - <?= date('H:i', strtotime($j['jam_selesai'])) ?></h6>
        <?php endforeach; ?>
    </div>
    <div class="mb-4">
        <p class="mb-0">Pengalaman Praktik</p>
        <h6><?= $dokter['pengalaman_praktik'] ?></h6>
    </div>

</div>