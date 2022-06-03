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
                    <h3 class="box-title">Form </h3>
                    <a href="<?= base_url('contact'); ?>" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Back</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?= $this->session->flashdata('message'); ?>
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <div class="form-group <?= form_error('service') ? 'has-error' : ''; ?>">
                                    <label for="service">Service *</label>
                                    <select class="form-control" id="service" name="service">
                                        <option value="">--Pilih--</option>
                                        <?php foreach ($services as $service) : ?>
                                            <option value="<?= $service['id_service']; ?>"><?= $service['service']; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group <?= form_error('name') ? 'has-error' : ''; ?>">
                                    <label for="nama">Nama * </label>
                                    <input type="text" class="form-control" value="<?= set_value('nama'); ?>" id="nama" name="nama" autofocus>
                                </div>
                                <div class="form-group <?= form_error('telephone') ? 'has-error' : ''; ?>">
                                    <label for="text">Telephone * </label>
                                    <input type="number" class="form-control" value="<?= set_value('telephone'); ?>" id="telephone" name="telephone">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group <?= form_error('area') ? 'has-error' : ''; ?>">
                                    <label>Area *</label>
                                    <select class="form-control select" id="area" name="area" style="width: 100%" ;>
                                        <option value="" selected>-- Pilih --</option>
                                        <?php foreach ($areas as $area) : ?>
                                            <option value="<?= $area['id_area']; ?>"><?= $area['area']; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
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

                                <div class="form-group <?= form_error('maps') ? 'has-error' : ''; ?>">
                                    <label for="maps">Maps </label>
                                    <textarea type="text" class="form-control" id="maps" name="maps"><?= set_value('maps'); ?></textarea>
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
                <table class="table table-bordered table-striped" id="example1">
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
            var site_id = $(this).data('id');
            var site = $(this).data('site');
            $('#site_id').val(site_id);
            $('#site').val(site);
            $('#modal-site').modal('hide');
        })
    })
</script>