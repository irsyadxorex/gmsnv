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
                    <table class="table table-striped table-bordered table-hover" id="dataatt">
                        <thead>
                            <tr>
                                <th class="text-center" width="10px">No</th>
                                <?php if ($this->session->userdata('id_site') == 0) :  ?>
                                    <th class="text-center" width="100px">Site</th>
                                <?php endif ?>
                                <th class="text-center" width="50px">Status</th>
                                <th class="text-center" width="50px">Tanggal/Jam</th>
                                <th class="text-center" width="500px">Petugas</th>
                                <th class="text-center" width="50px">Shift</th>
                                <th class="text-center" width="80px">Opsi</th>
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
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Detail Attendance</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered no-margin">
                    <tbody>
                        <tr>
                            <th>QrCode</th>
                            <td><span id="qrcode"></span></td>
                        </tr>
                        <tr>
                            <th>Nama </th>
                            <td><span id="nama"></span> <span id="posisi"></span></td>
                        </tr>
                        <tr>
                            <th>Site</th>
                            <td><span id="site"></span></td>
                        </tr>
                        <tr>
                            <th>Label</th>
                            <td><span id="label"></span></td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td><span id="location"></span></td>
                        </tr>
                        <tr>
                            <th>Latitude Longitude</th>
                            <td><span id="latitude_longitude"></span></td>
                        </tr>
                        <tr>
                            <th>Latitude Longitude IN</th>
                            <td><span id="latitude_longitude_in"></span></td>
                        </tr>
                        <tr>
                            <th>Latitude Longitude OUT</th>
                            <td><span id="latitude_longitude_out"></span></td>
                        </tr>
                        <tr>
                            <th>Time IN - OUT</th>
                            <td><span id="time_in"></span> - <span id="time_out"></span></td>
                        </tr>
                        <tr>
                            <th>Shift</th>
                            <td><span id="code_shift"></span> - <span id="ket_shift"></span></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="" id="status"></span>
                            </td>
                        </tr>
                        <!-- <tr>
                            <th>GPS</th>
                            <td>
                                <span class="label label-default" id="gps"></span>
                            </td>
                        </tr> -->

                        <!-- <tr>
                            <th>Action</th>
                            <td>
                                <a href="<?= base_url('asset/edit/' . $asset['asset_id']); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Update</a>
                                <a href="<?= base_url('asset/del/' . $asset['asset_id']); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah anda yakin?')"><i class="fa fa-trash"></i> Delete</a>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', '#set_detail', function() {
            var qrcode = $(this).data('qrcode');
            var nama = $(this).data('nama');
            // var posisi = $(this).data('posisi');
            var site = $(this).data('site');
            var label = $(this).data('label');
            var location = $(this).data('location');
            var status = $(this).data('status');
            var latitude_longitude = $(this).data('latitude_longitude');
            var latitude_longitude_in = $(this).data('latitude_longitude_in');
            var latitude_longitude_out = $(this).data('latitude_longitude_out');
            var time_in = $(this).data('time_in');
            var time_out = $(this).data('time_out');
            var code_shift = $(this).data('code_shift');
            var ket_shift = $(this).data('ket_shift');
            if (status == 1) {
                status_label = "label label-warning"
            } else {
                status_label = "label label-default"
            }
            $('#qrcode').text(qrcode);
            $('#nama').text(nama);
            // $('#posisi').text(posisi);
            $('#site').text(site);
            $('#label').text(label);
            $('#location').text(location);
            $('#latitude_longitude').text(latitude_longitude);
            $('#latitude_longitude_in').text(latitude_longitude_in);
            $('#latitude_longitude_out').text(latitude_longitude_out);
            $('#time_in').text(time_in);
            $('#time_out').text(time_out);
            $('#code_shift').text(code_shift);
            $('#ket_shift').text(ket_shift);
            $('#status').attr("class", status_label);
            $('#status').text(status == 1 ? 'IN' : 'OUT');
            // $('#qrcode').attr("src", "<?= site_url('assets/qrcode/') ?>" + qrcode + ".png");
        })
    })

    $(document).ready(function() {
        $('#dataatt').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= site_url('attendances/get_ajax') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0, 1, -1, -2, -4, -5],
                "className": 'text-center',
            }, {
                "targets": [0, -1],
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