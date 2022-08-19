<?php if (isset($result)) : ?>
    <div class="row">

        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0" id="dataTable">
                <thead>
                    <tr class="bg-light">
                        <td class="text-primary text-center" width="5%">No</td>
                        <td class="text-primary text-center">Pasien</td>
                        <td class="text-primary text-center">Dokter</td>
                        <td class="text-primary text-center">Keluhan</td>
                        <td class="text-primary text-center" width="15%">Status</td>
                        <td class="text-primary text-center">Action</td>
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
                                <?= $row['nama_dokter'] ?>
                            </td>
                            <td class="text-left">
                                <?= $row['keluhan'] ?>
                            </td>
                            <td class="text-center">
                                <?php if ($row['status'] == "Open") : ?>

                                    <span class="badge badge-pill badge-success text-white">Open</span>

                                <?php elseif ($row['status'] == "Close") : ?>

                                    <span class="badge badge-pill badge-danger">Close</span>

                                <?php endif; ?>
                            </td>
                            <td width="25%" class="text-center">

                                <?php if (session()->get('log_role') === "PASIEN") : ?>


                                    <div class="btn-group btn-group-sm">

                                        <a href="<?= base_url('tiket/view/' . $row['id_kunjungan']) ?>" class="btn btn-white">
                                            <span class="text-light">
                                                <i class="material-icons">visibility</i>
                                            </span> Lihat
                                        </a>

                                    </div>

                                <?php elseif (session()->get('log_role') === "ADMIN" || session()->get('log_role') === "DOKTER") : ?>

                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('tiket/view/' . $row['id_kunjungan']) ?>" class="btn btn-white">
                                            <span class="text-light">
                                                <i class="material-icons">visibility</i>
                                            </span> Lihat
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </td>
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