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
                    <a href="<?= base_url('report/incident/upload'); ?>" class="btn btn-primary pull-right"><i class="fa fa-upload"></i> Upload Report</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-striped table-bordered table-hover" id="dataActivity">
                        <thead>
                            <tr>
                                <th class="text-center" width="10px">No</th>
                                <th class="text-center" width="60px">Tanggal</th>
                                <th class="text-center" width="50px">Jam</th>
                                <th class="text-center" width="200px">Site</th>
                                <th class="text-center" width="250px">Subject</th>
                                <th class="text-center" width="50px">Status</th>
                                <th class="text-center" width="300px">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $n = 1;
                            foreach ($incidents as $incident) : ?>
                                <tr>
                                    <td class="text-center"><?= $n++; ?></td>
                                    <td class="text-center"><?= indo_date($incident['thedate']); ?></td>
                                    <td class="text-center"><?= $incident['thetime']; ?></td>
                                    <td><?= $incident['site']; ?></td>
                                    <td><?= $incident['title']; ?></td>
                                    <td class="text-center">
                                        <?php if ($incident['status'] == 1) : ?>
                                            <a class="label label-default"> Draft</a>
                                        <?php elseif ($incident['status'] == 2) : ?>
                                            <a class="label label-info"> Preview</a>
                                        <?php elseif ($incident['status'] == 3) : ?>
                                            <a class="label label-success"> Publish</a>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('uploads/') . $incident['doc']; ?>" class="btn btn-sm btn-success"><i class="fa fa-download"></i> Download Report</a>
                                        <a href="<?= base_url('report/incident/update/') . $incident['arid']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-cogs"></i> Update Report</a>
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