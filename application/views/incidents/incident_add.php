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
                    <a href="<?= base_url('report/incident'); ?>" class="btn btn-warning pull-right"><i class="fa fa-undo"></i> Back</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <?= $this->session->flashdata('message'); ?>
                    <div class="row">
                        <form action="<?= base_url('incident/add'); ?>" method="post" enctype="multipart/form-data">
                            <div class="col-md-6">
                                <div>
                                    <label for="site">Site *</label>
                                </div>
                                <div class="form-group input-group <?= form_error('site') ? 'has-error' : ''; ?>">
                                    <input type="hidden" class="form-control" id="site_id" name="site_id">
                                    <input type="text" class="form-control" id="site" name="site">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal-site">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                                <div class="form-group <?= form_error('reporter') ? 'has-error' : ''; ?>">
                                    <label for="reporter">Reporter </label>
                                    <input type="text" class="form-control" value="<?= $this->fungsi->user_login()->name; ?>" id="reporter" name="reporter" readonly>
                                </div>
                                <div class="form-group <?= form_error('subject') ? 'has-error' : ''; ?>">
                                    <label for="subject">Subject </label>
                                    <input type="text" class="form-control" value="<?= set_value('subject'); ?>" id="subject" name="subject">
                                </div>
                                <div class="form-group <?= form_error('fileIncident') ? 'has-error' : ''; ?>">
                                    <label for="exampleInputFile">File input </label>
                                    <input type="file" name="fileIncident" id="exampleInputFile">

                                    <p class="help-block"><i>format .doc .docx .odt .pdf</i> </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group <?= form_error('time') ? 'has-error' : ''; ?>">
                                    <label for="date">Date / Time</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input class="form-control" type="date" id="date" name="date" value="<?= date('Y-m-d'); ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="bootstrap-timepicker">
                                                <div class="input-group">
                                                    <input type="text" class="form-control timepicker" name="time">

                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <input type="text" class="form-control" id="time" name="time" value="" placeholder="00:00"> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group <?= form_error('status') ? 'has-error' : ''; ?>">
                                    <label for="status">Status *</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">--Pilih--</option>
                                        <option value="1">Draft</option>
                                        <option value="2">Review</option>
                                        <option value="3">Publish</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-md-12">
                                <div class="form-group">
                                    <label for="position">Subject </label>
                                    <textarea id="editor1" name="editor1" rows="10" cols="80">
                                                This is my textarea to be replaced with CKEditor.
                                    </textarea>
                                </div>

                            </div> -->

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
                                <td style="width: 80%;"><?= $site['site']; ?> <small><i>(<?= $site['site_id']; ?>)</i></small></td>
                                <td>
                                    <button class="btn btn-xs btn-info" id="selectSite" data-id="<?= $site['site_id']; ?>" data-site="<?= $site['site']; ?>"><i class=" fa fa-check"></i> Select</button>
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