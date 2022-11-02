<?php if (isset($result)) : ?>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0" id="dataTable">
                <thead>
                    <tr class="bg-light">
                        <td class="text-primary text-center" width="5%">No</td>
                        <td class="text-primary text-center">Pasien</td>
                        <td class="text-primary text-center">Dokter</td>
                        <td class="text-primary text-center">Tanggal Pemeriksaan</td>
                        <td class="text-primary text-center">Status Resep</td>
                        <?php if (session()->get("log_role") === "APOTEKER") : ?>
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
                                <a href="#" title="Lihat Tiket"><b>[<?= $row['id_kunjungan'] ?>]</b></a> <br>

                                Nama Pasien : <?= $row['nama_pasien'] ?> <br>
                                Unit Kerja : <?= $row['nama_biro'] ?> - <?= $row['nama_bagian'] ?><br>
                            </td>
                            <td class="text-left">
                                <?= $row['nama_dokter'] ?><br>
                            </td>
                            <td class="text-center">
                                <?= time_format($row['tanggal_kunjungan'], 'd M Y') ?>
                            </td>
                            <td class="text-center">
                                <?php if ($row['status'] == "Belum Selesai") : ?>
                                    <span class="badge badge-pill badge-danger text-white ml-3">Belum Selesai</span>
                                <?php elseif ($row['status'] == "Sedang Disiapkan") : ?>
                                    <span class="badge badge-pill badge-warning ml-3 text-white">Sedang Disiapkan</span>
                                <?php elseif ($row['status'] == "Sudah Selesai") : ?>
                                    <span class="badge badge-pill badge-success ml-3">Sudah Selesai</span>
                                <?php elseif ($row['status'] == "Telah Diambil") : ?>
                                    <span class="badge badge-pill badge-dark ml-3">Telah Diambil</span>
                                <?php endif; ?>
                            </td>


                            <?php if (session()->get('log_role') === "APOTEKER") : ?>
                                <td width="25%" class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('resep/view/' . $row['id_resep']) ?>" class="btn btn-white">
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