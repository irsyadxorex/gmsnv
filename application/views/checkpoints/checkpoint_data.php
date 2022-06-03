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
                    <table class="table table-striped table-bordered table-hover" id="datacheckpoint">
                        <thead>
                            <tr>
                                <th width="10px">No</th>
                                <th width="80px">Tanggal</th>
                                <th width="30px">Jam</th>
                                <th width="300px">Anggota</th>
                                <?php if ($this->session->userdata('id_site') == 0) : ?>
                                    <th width="300px">Site </th>
                                <?php endif ?>
                                <th>Lokasi</th>
                                <th width="100px">Kondusif</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($checkpoints as $check) : ?>
                                <?php if ($check['tagid'] == $check['tagid_user']) : ?>
                                    <tr>
                                        <td width="10px"><?= $i++; ?></td>
                                        <td width="80px"><?= indo_date($check['currentdatetime']); ?></td>
                                        <td width="30px"><?= indo_time($check['currentdatetime']); ?></th>
                                        <td width="300px"><?= $check['nama']; ?></td>
                                        <?php if ($this->session->userdata('id_site') == 0) : ?>
                                            <td width="300px"><?= $check['site']; ?> </td>
                                        <?php endif ?>
                                        <td><?= $check['lokasi']; ?></td>
                                        <td width="100px"><?= $check['isclear'] == 1 ? '<span class="text-success"><i class="fa fa-check"></i></span>' : '<span class="text-danger"><i class="fa fa-ban"></i></span>' ?></td>
                                        <td><?= $check['note']; ?></td>
                                    </tr>
                                <?php endif ?>
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
<script>
    $(document).ready(function() {
        $('#datacheckpoint').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= site_url('checkpoint/get_ajax') ?>",
                "type": "POST"
            },

            "columnDefs": [{
                "targets": [0, 1, 2, 5, 6],
                "className": 'text-center ',
            }, {
                "targets": [0, 4, 5, 6],
                "orderable": false,
            }, ],
            "order": [],
            "lengthMenu": [
                [15, 30, 50, 100, -1],
                [15, 30, 50, 100, "All"]
            ]
        });
    });
</script>