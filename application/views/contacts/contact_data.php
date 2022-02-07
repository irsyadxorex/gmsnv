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
                    <a href="#" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-striped table-bordered table-hover" id="listTable">
                        <thead>
                            <tr>
                                <th class="text-center" width="10px">No</th>
                                <th class="text-center" width="200">Service</th>
                                <th class="text-center" width="">Nama</th>
                                <th class="text-center" width="">Phone</th>
                                <th class="text-center" width="100">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $n = 1;
                            foreach ($contacts as $contact) : ?>
                                <tr>
                                    <td class="text-center"><?= $n++; ?></td>
                                    <td><?= $contact['service']; ?></td>
                                    <td><?= $contact['name']; ?></td>
                                    <td><?= $contact['phone'] ?> </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-xs btn-warning"><i class="fa fa-cog"></i> Update</a>
                                        <a href="#" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>
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