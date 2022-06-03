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
                    <?= $this->session->flashdata('message'); ?>
                    <table class="table table-striped table-bordered table-hover" id="dataActivity">
                        <thead>
                            <tr>
                                <th class="text-center" width="10px">No</th>
                                <th class="text-center" width="60px">Tanggal</th>
                                <th class="text-center" width="50px">Jam</th>
                                <?php if ($this->session->userdata('id_site') == 0) : ?>
                                    <th class="text-center" width="100px">Site</th>
                                <?php endif ?>
                                <th class="text-center" width="500px">Subject</th>
                                <th class="text-center" width="50px">Pelapor</th>
                                <th class="text-center" width="200px">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $n = 1;
                            foreach ($incidents as $incident) : ?>
                                <tr>
                                    <td class="text-center"><?= $n++; ?></td>
                                    <td class="text-center"><?= indo_date($incident['tanggal']); ?></td>
                                    <td class="text-center"><?= indo_sort_time($incident['waktu']); ?></td>
                                    <?php if ($this->session->userdata('id_site') == 0) : ?>
                                        <td><?= $incident['site']; ?></td>
                                    <?php endif ?>
                                    <td><?= $incident['subjek']; ?></td>
                                    <td class="text-center"><?= $incident['nama']; ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('uploads/') . $incident['dokumentasi']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> Download Report</a>
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