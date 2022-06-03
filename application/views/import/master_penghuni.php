<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> -->
    <!-- myCSS -->
    <!-- <link rel="stylesheet" href="asset/css/style.css"> -->

    <title>Import | Master Penghuni</title>
</head>

<body>
<div class="">
    <!-- <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div> -->
    <?php if ($this->session->flashdata('message')) {
        echo $this->session->flashdata('message');
    } ?>
    <!-- <h3 class="mt-3">List of Peoples</h3> -->

    <div class="row">
        <div class="col-4">
            <form action="<?= base_url('import/importmp'); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Import Excel Master Penghuni</label><br><br>
                    <input type="file" name="upload_file" id="upload_file" class="form-control" accept=".xls,.xlsx">
                </div><br>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script> -->

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
-->
<script src="<?= base_url(); ?>asset/js/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>asset/js/script.js"></script>
</body>

</html>
