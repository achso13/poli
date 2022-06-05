<?php if (isset($result)) : ?>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0" id="dataTable">
                <thead>
                    <tr class="bg-light">
                        <td class="text-primary text-center" width="5%">No</td>
                        <td class="text-primary text-center">Nama Treatment</td>
                        <td class="text-primary text-center">Poliklinik</td>
                        <td class="text-primary text-center" width="25%">Description</td>
                        <td class="text-primary text-center" width="15%">Waktu Treatment</td>
                        <td class="text-primary text-center">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($result as $row) : ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $row['treatment_name'] ?></td>
                            <td class="text-primary"><?= $row['clinic_name'] ?></td>
                            <td><?= $row['description'] ?></td>
                            <td><?= $row['open_time'] ?> s/d <?= $row['close_time'] ?></td>
                            <td width="17%">

                                <button class="btn btn-info btn-sm btn-edit" uc="<?= $row['id_treatment'] ?>" data-toggle="modal" data-target="#form-modals">
                                    <i class="mr-1 fa fa-pen-square"></i> Edit
                                </button>

                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modals-delete-<?= $row['id_treatment'] ?>">
                                    <i class="mr-1 fa fa-trash-alt"></i> Delete
                                </button>

                                <div class="modal fade" id="modals-delete-<?= $row['id_treatment'] ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Warning</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center"><i class="fa fa-info-circle"></i> Do you really want to delete this record ?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <?= form_open('treatment/delete/' . $row['id_treatment']) ?>
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger btn-delete">
                                                    Delete
                                                </button>
                                                <?= form_close() ?>
                                                <button class="btn btn-light" type="button" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
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