<?php if (isset($result)) : ?>
    <div class="row">

        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0" id="dataTable">
                <thead>
                    <tr class="bg-light">
                        <td class="text-primary text-center" width="5%">No</td>
                        <td class="text-primary text-center">ID</td>
                        <td class="text-primary text-center">Pasien</td>
                        <td class="text-primary text-center">Dokter</td>
                        <td class="text-primary text-center">Keluhan</td>
                        <td class="text-primary text-center">Tanggal Kedatangan</td>
                        <td class="text-primary text-center">Waktu</td>
                        <td class="text-primary text-center">Status</td>
                        <?php if (session()->get('log_role') !== "PASIEN") : ?>
                            <td class="text-primary text-center">Action</td>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($result as $row) : ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td class="text-left">
                                <b><?= $row['id_kunjungan'] ?></b>
                            </td>
                            <td class="text-left">
                                Nama: <?= $row['nama_pasien'] ?> <br>
                                Unit Kerja: <?= $row['nama_biro'] ?> - <?= $row['nama_bagian'] ?><br>
                            </td>
                            <td class="text-left">
                                <b><?= $row['nama_dokter'] ?></b>
                            </td>
                            <td class="text-center">
                                <b><?= $row['keluhan'] ?></b>
                            </td>
                            <td class="text-center">
                                <b><?= time_format($row['tanggal_kunjungan'], 'd M Y') ?></b>
                            </td>
                            <td class="text-center">
                                <b><?= time_format($row['jam_mulai'], 'H:i') ?> - <?= time_format($row['jam_selesai'], 'H:i') ?></b>
                            </td>

                            <td class="text-center">
                                <?php if ($row['status'] == "Aktif") : ?>
                                    <span class="badge badge-pill badge-success text-white">Aktif</span>
                                <?php elseif ($row['status'] == "Selesai") : ?>
                                    <span class="badge badge-pill badge-dark text-white">Selesai</span>
                                <?php endif; ?>
                            </td>

                            <?php if (session()->get('log_role') === "ADMIN" || session()->get('log_role') === "DOKTER") : ?>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('appointment/view/' . $row['id_kunjungan']) ?>" class="btn btn-white">
                                            <span class="text-light">
                                                <i class="material-icons">visibility</i>
                                            </span> Lihat
                                        </a>
                                    </div>
                                </td>
                            <?php endif; ?>

                        </tr>
                        <?php $no++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

<?php endif; ?>

<script type="text/javascript">
    $(document).ready(function() {
        var base_url = $("#base-url").html();

        var table = $('#dataTable').DataTable({
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }, {
                "searchable": false,
                "targets": 3
            }],
        });
        table.on('order.dt search.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>