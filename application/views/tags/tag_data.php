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
                    <a href="<?= base_url('tag/add'); ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?= $this->session->flashdata('message'); ?>
                    <table class="table table-striped table-bordered table-hover" id="list">
                        <thead>
                            <tr>
                                <th class="text-center" width="10px">No</th>
                                <th class="text-center" width="200px">QR</th>
                                <th class="text-center" width="150">Is Tag</th>
                                <?php if ($this->session->userdata('id_site') == 0) : ?>
                                    <th class="text-center" width="">Site</th>
                                <?php endif ?>
                                <th class="text-center" width="">Label</th>
                                <th class="text-center" width="">Lokasi</th>
                                <th class="text-center" width="50px">Active</th>
                                <th class="text-center" width="200">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $n = 1;
                            foreach ($tags as $tag) : ?>
                                <tr>
                                    <td class="text-center"><?= $n++; ?></td>
                                    <td class="text-center"><?= $tag['tagid']; ?> </td>
                                    <td class="text-center"><?= $tag['is_tag'] == 1 ? '<span class="label label-warning">patroli</span>' : '<span class="label label-info">absen</i></span>'; ?> </td>
                                    <?php if ($this->session->userdata('id_site') == 0) : ?>
                                        <td><?= $tag['site']; ?></td>
                                    <?php endif ?>
                                    <td><?= $tag['label'] ?> </td>
                                    <td><?= $tag['lokasi'] ?> </td>
                                    <td class="text-center"><?= $tag['status_tag'] !=  0 ? '<span class="text-success"><i class="fa fa-check"></i></span>' : '<span class="text-danger"><i class="fa fa-ban"></i></span>'; ?> </td>
                                    <td class="text-center">
                                        <?php if ($tag['status'] == 1) {
                                            $status  = 'Aktif';
                                        } else {
                                            $status =  'Tidak Aktif';
                                        }
                                        ?>
                                        <a href="<?= base_url('tag/print/') . $tag['tagid']; ?>" class="btn btn-xs btn-info"> <i class="fa fa-qrcode"></i> Print</a>
                                        <a id="set_detail" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modal-detail" data-qrcode="<?= $tag['tagid']; ?>" data-site="<?= $tag['site']; ?>" data-label="<?= $tag['label']; ?>" data-location="<?= $tag['lokasi']; ?>" data-status="<?= $tag['status_tag'] != 0 ? 'aktif' : 'tidak aktif'; ?>" data-latitude_longitude="<?= $tag['latitude_longitude']; ?>"><i class="fa fa-eye"></i> Detail</a>
                                        <a href="<?= base_url('tag/edit/') . $tag['id_qrcode']; ?>" class="btn btn-xs btn-warning"><i class="fa fa-cog"></i> Update</a>
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

<div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Detail Tag</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered no-margin">
                    <tbody>
                        <tr>
                            <th>QrCode</th>
                            <td><img src="" id="qrcode"></img></td>
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
                            <th>Status</th>
                            <td>
                                <span class="label label-default" id="status"></span>
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
            var site = $(this).data('site');
            var label = $(this).data('label');
            var location = $(this).data('location');
            var status = $(this).data('status');
            var latitude_longitude = $(this).data('latitude_longitude');
            $('#qrcode').text(qrcode);
            $('#site').text(site);
            $('#label').text(label);
            $('#location').text(location);
            $('#latitude_longitude').text(latitude_longitude);
            $('#status').text(status);
            $('#qrcode').attr("src", "<?= site_url('assets/qrcode/') ?>" + qrcode + ".png");
        })
    })
</script>