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
                    <h3 class="box-title">Form Tag</h3>
                    <a href="<?= base_url('tag'); ?>" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Back</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <form action="" method="post">
                            <div class="col-md-6">
                                <?php if ($this->session->userdata('id_site') == 0) : ?>
                                    <div>
                                        <label for="site">Site *</label>
                                    </div>
                                    <div class="form-group input-group <?= form_error('site') ? 'has-error' : ''; ?>">
                                        <input type="hidden" class="form-control" id="id_site" name="id_site">
                                        <input type="text" class="form-control" id="site" name="site">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-site">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                <?php endif ?>

                                <div class="form-group <?= form_error('label') ? 'has-error' : ''; ?>">
                                    <label for="label">Label *</label><small> (cth: checkpoint 1 / attendance 1)</small>
                                    <input class="form-control" type="label" id="label" name="label" value="<?= set_value('label'); ?>" autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="location">Location</label><small> (cth: Pos / lobby)</small>
                                    <textarea type="text" class="form-control" id="location" name="location" style="height: 150px;"><?= set_value('location'); ?></textarea>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="qrcode">QrCode</label>
                                    <input class="form-control" type="qrcode" id="qrcode" name="qrcode" value="<?= $kode; ?>" readonly>
                                </div>
                                <div class="form-group ">
                                    <label for="latitude_longitude">Latitude, Longitude</label>
                                    <input class="form-control" type="latitude_longitude" id="latitude_longitude" name="latitude_longitude" value="">
                                </div>


                                <div class="form-group <?= form_error('is_tag') ? 'has-error' : ''; ?>">
                                    <label for="is_tag">Jenis Tag *</label>
                                    <select class="form-control" id="is_tag" name="is_tag">
                                        <option value="">-- Pilih Tag --</option>
                                        <option value="1" <?= set_value('is_tag') == 1 ? 'selected' : ''; ?>>Patroli</option>
                                        <option value="2" <?= set_value('is_tag') == 2 ? 'selected' : ''; ?>>Absensi</option>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="status">Status *</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1" selected>Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-success" type="submit" name="submit"><i class="fa fa-paper-plane"></i> Save</button>
                                    <button class="btn btn-secondary" type="reset" name="reset">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
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


<div class="modal fade" id="modal-site">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-item">Select Site</h4>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped" id="listTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Site</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n = 1;
                        foreach ($sites as $site) : ?>
                            <tr>
                                <td><?= $n++ ?></td>
                                <td style="width: 80%;"><?= $site['site']; ?> <small><i>(<?= $site['id_site']; ?>)</i></small></td>
                                <td>
                                    <button class="btn btn-xs btn-info" id="selectSite" data-id="<?= $site['id_site']; ?>" data-site="<?= $site['site']; ?>"><i class=" fa fa-check"></i> Select</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $(document).on('click', '#selectSite', function() {
            var id_site = $(this).data('id');
            var site = $(this).data('site');
            $('#id_site').val(id_site);
            $('#site').val(site);
            $('#modal-site').modal('hide');
        })
    })
</script>