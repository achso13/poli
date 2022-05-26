<?php if (isset($result)) : ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr class="bg-light">
                    <td class="text-primary text-center" width="5%">No</td>
                    <td class="text-primary text-center">Username</td>
                    <td class="text-primary text-center">Email</td>
                    <td class="text-primary text-center">Role</td>
                    <?php if ($role == 4) : ?>
                        <td class="text-primary text-center">Poliklinik</td>
                    <?php endif; ?>
                    <td class="text-primary text-center">Status</td>
                    <td class="text-primary text-center">Action</td>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td>
                            <div class="d-table mx-auto">
                                <span class="badge badge-pill badge-success"><?= $row['role'] ?></span>
                            </div>
                        </td>
                        <?php if ($role == 4) : ?>
                            <td class="text-primary text-center"><?= $row['clinic_name'] ?></td>
                        <?php endif; ?>
                        <td><?= ($row['is_active'] == 1 ? 'Active' : 'Deactive') ?></td>
                        <td width="17%">
                            <button class="btn btn-info btn-sm btn-edit" uc="<?= $row['id'] ?>" data-toggle="modal" data-target="#form-modals">
                                <i class="mr-1 fa fa-pen-square"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modals-delete-<?= $row['id'] ?>">
                                <i class="mr-1 fa fa-trash-alt"></i> Delete
                            </button>
                            <div class="modal fade" id="modals-delete-<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog " role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Warning</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-center"><i class="fa fa-info-circle"></i> Do you really want to delete this record ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <?= form_open('users/delete/' . $row['id']) ?>
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
        const base_url = $("#base-url").html();

        $('.btn-add').click(function() {
            $('.load-form').load(base_url + '/users/add');
        });


        $('.btn-edit').click(function() {
            var id = $(this).attr('uc');

            $('.load-form').load(base_url + '/users/edit/', {
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