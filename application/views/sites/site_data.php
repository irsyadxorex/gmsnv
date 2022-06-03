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
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-striped table-bordered table-hover" id="listTable">
                        <thead>
                            <tr>
                                <th class="text-center" width="10px">No</th>
                                <th class="text-center" width="">Site</th>
                                <th class="text-center" width="50">Aktif</th>
                                <th class="text-center" width="100px">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $n = 1;
                            foreach ($sites as $site) : ?>
                                <tr>
                                    <td class="text-center"><?= $n++; ?></td>
                                    <td><?= $site['site']; ?></td>
                                    <td class="text-center">
                                        <?= $site['gms_status'] == 1 ? '<span class="text-success"><i class="fa fa-check"></i></span>' : '<span class="text-danger"><i class="fa fa-ban"></i></span>'; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('site/update/') . $site['site_id']; ?>" class="label label-warning"><i class="fa fa-cog"></i> Update</a>
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