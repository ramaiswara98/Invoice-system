<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
   <h1>Create Currency</h1>
   <form action="<?php echo base_url();?>admin/save-new-currency" method="POST">
        <?= csrf_field(); ?>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Currency Name</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Currency Name" name="name">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Currency Code</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Example: IDR, SGD, USD" name="code">
        </div>
   
    <button class="btn btn-primary" type="submit"> Add Currency</button>
    </form>
</div>

<?= $this->endSection();?>
