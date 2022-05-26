<?php if (isset($result)) : ?>
    <div class="row">

        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0" id="dataTable">
                <thead>
                    <tr class="bg-light">
                        <td class="text-primary text-center" width="5%">No</td>
                        <td class="text-primary text-center">Klinik</td>
                        <td class="text-primary text-center" width="30%">Deskripsi</td>
                        <td class="text-primary text-center">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($result as $row) : ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $row['clinic_name'] ?></td>
                            <td><?= $row['description'] ?></td>
                            <td width="17%">

                                <button class="btn btn-info btn-sm btn-edit" uc="<?= $row['id'] ?>" data-toggle="modal" data-target="#form-modals">
                                    <i class="mr-1 fa fa-pen-square"></i> Edit
                                </button>

                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modals-delete-<?= $row['id'] ?>">
                                    <i class="mr-1 fa fa-trash-alt"></i> Delete
                                </button>

                                <div class="modal fade" id="modals-delete-<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
                                                <?= form_open('clinic/delete/' . $row['id']) ?>
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
            $('.load-form').load(base_url + '/clinic/add');
        });

        $('.btn-edit').click(function() {
            var id = $(this).attr('uc');

            $('.load-form').load(base_url + '/clinic/edit', {
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
    });
</script>