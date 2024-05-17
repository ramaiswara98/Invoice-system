<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
   <h1>Edit Student</h1>
   <form action="<?php echo base_url();?>admin/save-student" method="POST">
        <?= csrf_field(); ?>
        <input type="hidden" name="student_id" value="<?= $student->id ?>"/>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Student No</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Student Number" name="student_no" value="<?= $student->student_no;?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Student Full Name" name="name" value="<?=$student->name?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Student Email" name="email" value="<?=$student->email?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Address</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Student Address" name="address" value="<?=$student->address?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">School From</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="School From" name="school" value="<?=$student->school?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Previous Grade</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Student Previous Grade" name="grade" value="<?=$student->grade?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Parent Name/ Guardian</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Parent Name" name="parent_name" value="<?=$student->parent_name?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Parent Email</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Parent Email" name="parent_email" value="<?=$student->parent_email?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Branch</label>
            <select class="form-select" aria-label="Default select example" name="branch">
                <option selected disabled>Choose Branch</option>
                <?php foreach ($branch as $br) {
                   
                    if($session->get('role') != '1'){
                        if($session->get('branch_id') == $br['id']){
                            if($br['id'] == $student->branch_id){
                                echo "<option selected value=$br[id]>$br[branch_name]</option>";
                            }else{
                                echo "<option value=$br[id]>$br[branch_name]</option>";
                            }
                        }
                    }else{
                        if($br['id'] == $student->branch_id){
                            echo "<option selected value=$br[id]>$br[branch_name]</option>";
                        }else{
                            echo "<option value=$br[id]>$br[branch_name]</option>";
                        }
                    }
                }
                ?>
            </select>
        </div>
   
    <button class="btn btn-primary" type="submit"> Save Student</button>
    </form>
</div>

<?= $this->endSection();?>
