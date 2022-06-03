<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Version 2.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"> Team</span>
                    <span class="info-box-number"><?= $count_team['counts']; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-map-marker"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Checkpoint</span>
                    <span class="info-box-number"><?= $count_checkpoint_user['counts']; ?>/<?= $count_checkpoint['counts']; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-eye"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Visitor</span>
                    <span class="info-box-number"><?= $count_visitor['counts']; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>



    </div>
    <!-- /.row -->


    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-md-6">


            <!-- TABLE: LATEST ORDERS -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> Patroli</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <?php if ($this->session->userdata('id_site') == 0) : ?>
                                        <th>Site</th>
                                    <?php endif ?>
                                    <th>Nama</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($limit_checkpoint as $lc) : ?>
                                    <?php if ($lc['tagid'] == $lc['tagid_user']) : ?>
                                        <tr>
                                            <?php if ($this->session->userdata('id_site') == 0) : ?>
                                                <td><?= $lc['site']; ?></td>
                                            <?php endif ?>
                                            <td><?= $lc['nama']; ?></td>
                                            <td><?= $lc['lokasi']; ?></td>
                                            <td> <?= $lc['isclear'] == 1 ? '<span class="label label-success">kondisif</span>' : '<span class="label label-default">tidak kondisif</span>'; ?></td>
                                            <td><?= indo_time($lc['currentdatetime']); ?>
                                            </td>
                                        </tr>
                                    <?php endif ?>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All </a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6">

            <!-- TABLE: LATEST ORDERS -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> Absensi</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <?php if ($this->session->userdata('id_site') == 0) : ?>
                                        <th>Site</th>
                                    <?php endif ?>
                                    <th>Nama</th>
                                    <th>Shift</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($limit_attendance as $la) : ?>
                                    <tr>
                                        <?php if ($this->session->userdata('id_site') == 0) : ?>
                                            <td><?= $la['site']; ?></td>
                                        <?php endif ?>
                                        <td><?= $la['nama']; ?></td>
                                        <td><?= $la['code']; ?></td>
                                        <td><?= indo_time($la['datetime_in']); ?> - <?= indo_time($la['datetime_out']); ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All </a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->


        <!-- <div class="col-md-6">

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> Visitor</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>No Kartu</th>
                                    <th>Status</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A02</td>
                                    <td><span class="label label-success">check in</span></td>
                                    <td>
                                        08:00
                                    </td>
                                </tr>

                                <tr>
                                    <td>A02</td>
                                    <td><span class="label label-default">check out</span></td>
                                    <td>
                                        09:00
                                    </td>
                                </tr>
                                <tr>
                                    <td>A02</td>
                                    <td><span class="label label-success">check in</span></td>
                                    <td>
                                        08:00
                                    </td>
                                </tr>
                                <tr>
                                    <td>A02</td>
                                    <td><span class="label label-default">check out</span></td>
                                    <td>
                                        09:00
                                    </td>
                                </tr>
                                <tr>
                                    <td>A02</td>
                                    <td><span class="label label-success">check in</span></td>
                                    <td>
                                        08:00
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">Detail </a>
                </div>
            </div>
        </div>


    </div>
    /.row -->
</section>