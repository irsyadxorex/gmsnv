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
                    <table class="table table-striped table-bordered table-hover" id="datavisitor">
                        <thead>
                            <tr>
                                <th class="text-center" width="10px">No</th>
                                <th class="text-center" width="150px">Tanggal</th>
                                <th class="text-center" width="80px">No Visitor</th>
                                <th class="text-center" width="50px">Status</th>
                                <?php if ($this->session->userdata('id_site') == 0) : ?>
                                    <th class="text-center" width="">Site</th>
                                <?php endif ?>
                                <th class="text-center" width="">Tamu</th>
                                <th class="text-center" width="">Keperluan</th>
                                <th class="text-center" width="">Yang dituju</th>
                                <th class="text-center" width="">Petugas</th>
                                <th class="text-center" width="">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>

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


<div class="modal fade" id="modal-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail Visitor</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered no-margin">
                    <tbody>
                        <tr>
                            <th class="">Identitas</th>
                        </tr>
                        <tr>
                            <td><img src="" width="200px" id="images"></img></td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




<script>
    $(document).ready(function() {
        $('#datavisitor').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= site_url('visitor/get_ajax') ?>",
                "type": "POST"
            },

            "columnDefs": [{
                "targets": [0, 1, 2, 3, -1],
                "className": 'text-center ',
            }, {
                "targets": [0, -1, -4, -5],
                "orderable": false,
            }, ],
            "order": [],
            "lengthMenu": [
                [15, 30, 50, 100, -1],
                [15, 30, 50, 100, "All"]
            ]
        });
    });

    $(document).ready(function() {
        $(document).on('click', '#set_detail', function() {
            var images = $(this).data('images');
            $('#images').attr("src", "https://hris.tpm-facility.com/assets/imagesofgms/activities/" + images);
        })
    })
</script>