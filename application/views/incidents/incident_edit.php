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
                        <form action="" method="post">
                            <input type="hidden" name="incident_id" id="incident_id" value="<?= $incident['arid']; ?>">
                            <div class="col-md-6">
                                <div>
                                    <label for="site">Site *</label>
                                </div>
                                <div class="form-group input-group <?= form_error('site') ? 'has-error' : ''; ?>">
                                    <input type="text" class="form-control" id="site" name="site" value="<?= $incident['site']; ?>" readonly>
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
                                    <input type="text" class="form-control" value="<?= $incident['title'] ?>" id="subject" name="subject">
                                </div>
                                <div class=""><br><br></div>
                                <!-- <div class="form-group <?= form_error('fileIncident') ? 'has-error' : ''; ?>">
                                    <label for="exampleInputFile">File input </label>
                                    <input type="file" name="fileIncident" id="exampleInputFile" value="<?= $incident['doc']; ?>">

                                    <p class="help-block"><i>format .doc .docx .odt .pdf</i> </p>
                                </div> -->
                            </div>

                            <div class="col-md-6">
                                <div class="form-group <?= form_error('time') ? 'has-error' : ''; ?>">
                                    <label for="date">Date / Time</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input class="form-control" type="date" id="date" name="date" value="<?= $incident['thedate']; ?>" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="bootstrap-timepicker">
                                                <div class="input-group">
                                                    <input type="text" class="form-control timepicker" name="time" value="<?= $incident['thetime']; ?>" readonly>

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
                                        <option value="1" <?= $incident['status'] == 1 ? 'selected' : ''; ?>>Draft</option>
                                        <option value="2" <?= $incident['status'] == 2 ? 'selected' : ''; ?>>Review</option>
                                        <option value="3" <?= $incident['status'] == 3 ? 'selected' : ''; ?>>Publish</option>
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