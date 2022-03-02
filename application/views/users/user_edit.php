<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= $title; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><?= $title; ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Form </h3>
                    <a href="<?= base_url('user'); ?>" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Back</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?= $this->session->flashdata('message'); ?>
                    <div class="row">
                        <form action="" method="post">
                            <div class="col-md-6">
                                <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?= $user['id']; ?>">
                                <div class="form-group <?= form_error('name') ? 'has-error' : ''; ?>">
                                    <label for="name">Name * </label>
                                    <input type="text" class="form-control" value="<?= $user['name'] ?>" id="name" name="name">
                                </div>
                                <div class="form-group <?= form_error('email') ? 'has-error' : ''; ?>">
                                    <label for="email">Email * </label>
                                    <input type="text" class="form-control" value="<?= $user['email']; ?>" id="email" name="email" readonly>
                                </div>
                                <div class="form-group <?= form_error('password1') ? 'has-error' : ''; ?>">
                                    <label for="password1">Reset Password * </label>
                                    <input type="password" class="form-control" value="" id="password1" name="password1">
                                </div>
                                <div class="form-group <?= form_error('password2') ? 'has-error' : ''; ?>">
                                    <label for="password2">Reset Confirm Password * </label>
                                    <input type="password" class="form-control" value="" id="password2" name="password2">
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div>
                                    <label for="site">Site *</label>
                                </div>
                                <div class="form-group input-group <?= form_error('site') ? 'has-error' : ''; ?>">
                                    <input type="hidden" class="form-control" id="site_id" name="site_id">
                                    <input type="text" class="form-control" id="site" name="site" value="<?= $user['id_site'] == 0 ? '' : $user['site']; ?>" readonly>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-site">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                                <div class="form-group <?= form_error('role') ? 'has-error' : ''; ?>">
                                    <label for="role">Role *</label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="">--Pilih--</option>
                                        <option value="6" <?= $user['id_role'] == 6 ? 'selected' : '' ?>>Admin</option>
                                        <option value="7" <?= $user['id_role'] == 7 ? 'selected' : '' ?>>Operational</option>
                                        <option value="8" <?= $user['id_role'] == 8 ? 'selected' : '' ?>>Danru</option>
                                        <option value="4" <?= $user['id_role'] == 4 ? 'selected' : '' ?>>Client</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-success" type="submit" name="submit"><i class="fa fa-paper-plane"></i> Save</button>
                                    <button class="btn btn-secondary" type="reset" name="reset">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->


        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->


<div class="modal fade" id="modal-site">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-item">Select Site</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped" id="example1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Site</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n = 1;
                        foreach ($sites as $site) : ?>
                            <tr>
                                <td><?= $n++ ?></td>
                                <td style="width: 80%;"><?= $site['site']; ?> <small><i>(<?= $site['site_id']; ?>)</i></small></td>
                                <td>
                                    <button class="btn btn-xs btn-info" id="selectSite" data-id="<?= $site['site_id']; ?>" data-site="<?= $site['site']; ?>"><i class=" fa fa-check"></i> Select</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $(document).on('click', '#selectSite', function() {
            var site_id = $(this).data('id');
            var site = $(this).data('site');
            $('#site_id').val(site_id);
            $('#site').val(site);
            $('#modal-site').modal('hide');
        })
    })
</script>