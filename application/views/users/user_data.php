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
                    <h3 class="box-title"><?= $title; ?> List</h3>
                    <a href="<?= base_url('user/add'); ?>" class="btn btn-primary pull-right"><i class="fa fa-user-plus"></i> Tambah</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?= $this->session->flashdata('message'); ?>
                    <table class="table table-striped table-bordered table-hover" id="listTable">
                        <thead>
                            <tr>
                                <th class="text-center" width="10px">No</th>
                                <th class="text-center" width="200">Name</th>
                                <th class="text-center" width="200">Username</th>
                                <?php if ($this->session->userdata('id_site') == 0) : ?>
                                    <th class="text-center" width="200">Site</th>
                                <?php endif ?>
                                <th class="text-center" width="100px">Role</th>
                                <th class="text-center" width="50px">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $n = 1;
                            foreach ($users as $user) : ?>
                                <tr>
                                    <td class="text-center"><?= $n++; ?></td>
                                    <td><?= $user['nama']; ?></td>
                                    <td><?= $user['username']; ?></td>
                                    <?php if ($this->session->userdata('id_site') == 0) : ?>
                                        <td><?= $user['site']; ?></td>
                                    <?php endif ?>
                                    <?php if ($user['id_role'] == 1) : ?>
                                        <td class="text-center"><span class="label label-default">Super Admin</span></td>
                                    <?php elseif ($user['id_role'] == 2) : ?>
                                        <td class="text-center"><span class="label label-primary">Admin Site</span></td>
                                    <?php elseif ($user['id_role'] == 3) : ?>
                                        <td class="text-center"><span class="label bg-orange">Manager</span></td>
                                    <?php elseif ($user['id_role'] == 4) : ?>
                                        <td class="text-center"><span class="label bg-teal">Pengawas</span></td>
                                    <?php endif ?>

                                    <td class="text-center">
                                        <form action="<?= base_url('user/delete'); ?>" method="post">
                                            <a href="<?= base_url('user/edit/') . $user['username']; ?>" class="label label-warning"><i class="fa fa-cog"></i> Update</a>
                                            <input type="hidden" name="username" value="<?= $user['username']; ?>">
                                            <button onclick="return confirm('Apakah anda yakin?')" type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>

                    </table>
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