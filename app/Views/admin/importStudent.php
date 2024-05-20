<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
    <h3>Import Student</h3>
    <p>You can follow the instruction below to import student on xls or xslx format :
        1. Donwload Excel format here
    </p>
    <form action="<?php echo base_url();?>/admin/get-imported-student" method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">File</label>
            <input type="file" class="form-control" id="exampleFormControlInput1" placeholder="Excel File" name="student" required>
        </div>
        <button class="btn btn-primary" type="submit">Import File</button>
    </form>
</div>



<?= $this->endSection();?>