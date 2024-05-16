<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
   <h1>Create Tuition</h1>
   <form action="/aedno/admin/save-new-tuition" method="POST">
        <?= csrf_field(); ?>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Tuition Type</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Tuition Type" name="tuition_type">
        </div>
   
    <button class="btn btn-primary" type="submit"> Create Tuition</button>
    </form>
</div>

<?= $this->endSection();?>
