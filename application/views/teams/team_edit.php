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
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Update Team </h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?= $this->session->flashdata('message'); ?>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group <?= form_error('name') ? 'has-error' : ''; ?>">
                                    <label for="nama">Name * </label>
                                    <input type="text" class="form-control" value="<?= $team['nama']; ?>" id="nama" name="nama" autofocus autocomplete="off">
                                </div>
                                <div class="form-group <?= form_error('identitas') ? 'has-error' : ''; ?>">
                                    <label for="identitas">No Identitas/NIK * </label>
                                    <input type="number" class="form-control" value="<?= $team['nik']; ?>" id="identitas" name="identitas">
                                </div>
                                <div class="form-group <?= form_error('role') ? 'has-error' : ''; ?>">
                                    <label for="jenis_kelamin">Jenis Kelamin *</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="1" <?= $team['jenis_kelamin'] == 1 ? 'selected' : ''; ?>>Laki-Laki</option>
                                        <option value="2" <?= $team['jenis_kelamin'] == 2 ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group <?= form_error('telephone') ? 'has-error' : ''; ?>">
                                    <label for="telephone">Telephone * </label>
                                    <input type="number" class="form-control" value="<?= $team['telephone']; ?>" id="telephone" name="telephone">
                                </div>
                                <div class="form-group <?= form_error('email') ? 'has-error' : ''; ?>">
                                    <label for="email">Email </label>
                                    <input type="text" class="form-control" value="<?= $team['email']; ?>" id="email" name="email" autocomplete="off">
                                </div>
                                <div class="form-group <?= form_error('tempat_lahir') ? 'has-error' : ''; ?>">
                                    <label for="tempat_lahir">Tempat Lahir </label>
                                    <input type="text" class="form-control" value="<?= $team['tempat_lahir']; ?>" id="tempat_lahir" name="tempat_lahir">
                                </div>
                                <div class="form-group <?= form_error('tanggal_lahir') ? 'has-error' : ''; ?>">
                                    <label for="tanggal_lahir">Tanggal Lahir </label>
                                    <input type="date" class="form-control" value="<?= $team['tanggal_lahir']; ?>" id="tanggal_lahir" name="tanggal_lahir">
                                </div>

                                <div class="form-group <?= form_error('alamat') ? 'has-error' : ''; ?>">
                                    <label for="alamat">Alamat </label>
                                    <textarea type="date" class="form-control" id="alamat" name="alamat"><?= $team['domisili']; ?></textarea>
                                </div>
                                <div class="form-group <?= form_error('tmt') ? 'has-error' : ''; ?>">
                                    <label for="tmt">Tanggal Masuk </label>
                                    <input type="date" class="form-control" value="<?= $team['tmt']; ?>" id="tmt" name="tmt">
                                </div>
                                <div class="form-group <?= form_error('resign') ? 'has-error' : ''; ?>">
                                    <label for="resign">Tanggal Resign </label>
                                    <input type="date" class="form-control" value="<?= $team['resign']; ?>" id="resign" name="resign">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->


            <div class="col-xs-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Akses Login </h3>
                        <a href="<?= base_url('team'); ?>" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Back</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?= $this->session->flashdata('message'); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <?php if ($this->session->userdata('id_site') == 0) : ?>
                                    <div>
                                        <label for="site">Site *</label>
                                    </div>
                                    <div class="form-group input-group <?= form_error('site') ? 'has-error' : ''; ?>">
                                        <input type="hidden" class="form-control" id="id_site" name="id_site" <?= $team['id_site']; ?>>
                                        <input type="text" class="form-control" id="site" name="site" value="<?= $team['site']; ?>" autocomplete="off" disabled>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-site">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                <?php endif ?>
                                <div class="form-group <?= form_error('username') ? 'has-error' : ''; ?>">
                                    <label for="text">Username * </label>
                                    <input type="text" class="form-control" value="<?= $team['username']; ?>" id="username" name="username" readonly>
                                </div>
                                <div class="form-group <?= form_error('password1') ? 'has-error' : ''; ?>">
                                    <label for="password1">Reset Password * </label>
                                    <input type="password" class="form-control" value="" id="password1" name="password1">
                                </div>
                                <div class="form-group <?= form_error('password2') ? 'has-error' : ''; ?>">
                                    <label for="password2">Confirm Reset Password * </label>
                                    <input type="password" class="form-control" value="" id="password2" name="password2">
                                </div>
                                <div class="form-group <?= form_error('position') ? 'has-error' : ''; ?>">
                                    <label for="position">Posisi *</label>
                                    <select class="form-control" id="position" name="position">
                                        <option value="1" <?= $team['id_position'] == 1 ? 'selected' : ''; ?>>Anggota Security</option>
                                        <option value="2" <?= $team['id_position'] == 2 ? 'selected' : ''; ?>>Komandan Regu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-success" type="submit" name="submit"><i class="fa fa-paper-plane"></i> Save</button>
                                    <button class="btn btn-secondary" type="reset" name="reset">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </form>


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
            var id_site = $(this).data('id');
            var site = $(this).data('site');
            $('#id_site').val(id_site);
            $('#site').val(site);
            $('#modal-site').modal('hide');
        })
    })
</script>