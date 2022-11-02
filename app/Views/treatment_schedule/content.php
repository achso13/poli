<?php if (isset($result)) : ?>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0" id="dataTable">
                <thead>
                    <tr class="bg-light">
                        <td class="text-primary text-center" width="5%">No</td>
                        <td class="text-primary text-center" width="15%">ID Treatment</td>
                        <td class="text-primary text-center" width="20%">Nama Treatment</td>
                        <td class="text-primary text-center">Jadwal Treatment</td>
                        <td class="text-primary text-center" width="15%">Dokter</td>
                        <td class="text-primary text-center" width="15%">Pasien</td>
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
                            <td><?= $row['id_treatment'] ?></td>
                            <td><?= $row['nama_treatment'] ?></td>
                            <td><?= $row['jadwal_treatment'] ?></td>
                            <td><?= $row['nama_dokter'] ?></td>
                            <td><?= $row['nama_pasien'] ?></td>
                            <?php if (session()->get('log_role') !== "PASIEN") : ?>
                                <td width="17%">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('treatment_schedule/' . $row['id_rekam_medis']) ?>" class="btn btn-white">
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

<?php else : ?>

    <div class="alert alert-warning alert-dismissible fade show mb-0 text-center" role="alert">Empty..</div>

<?php endif; ?>

<div class="modal fade" id="form-modals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content load-form">

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var base_url = $("#base-url").html();

        $('.btn-add').click(function() {
            $('.load-form').load(base_url + '/treatment/add');
        });

        $('.btn-edit').click(function() {
            var id = $(this).attr('uc');

            $('.load-form').load(base_url + '/treatment/edit', {
                id: id
            });
        });
        var table = $('#dataTable').DataTable({
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
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