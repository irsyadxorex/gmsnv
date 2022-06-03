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
                    <a href="<?= base_url('contact/add'); ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?= $this->session->flashdata('message'); ?>
                    <table class="table table-striped table-bordered table-hover" id="listTable">
                        <thead>
                            <tr>
                                <th class="text-center" width="10px">No</th>
                                <?php if ($this->session->userdata('id_site') == 0) : ?>
                                    <th class="text-center" width="">Site</th>
                                <?php endif ?>
                                <th class="text-center" width="100px">Blok</th>
                                <th class="text-center" width="">Penghuni</th>
                                <th class="text-center" width="">Kategori</th>
                                <th class="text-center" width="200px">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $n = 1;
                            foreach ($penghuni as $peng) : ?>
                                <tr>
                                    <td class="text-center"><?= $n++; ?></td>
                                    <?php if ($this->session->userdata('id_site') == 0) : ?>
                                        <td><?= $peng['site'] ?> </td>
                                    <?php endif ?>
                                    <td><?= $peng['blok']; ?></td>
                                    <td><?= $peng['penghuni']; ?></td>
                                    <td><?= $peng['kategori'] ?> </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-xs btn-warning"><i class="fa fa-cog"></i> Update</a>
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