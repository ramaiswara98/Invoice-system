<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
   <h1>Create Student</h1>
   <form action="<?php echo base_url();?>admin/save-new-student" method="POST" id="add-student-form">
        <?= csrf_field(); ?>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Student No</label>
            <input type="text" class="form-control" id="studentno-form" placeholder="Student Number" name="student_no">
            <p class="form-alert" id="student-no-alert" style="display: none;">Please enter student number</p>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Full Name <span style="color:red;">*</span></label>
            <input type="text" class="form-control" id="student-name-form" placeholder="Student Full Name" name="name">
            <p class="form-alert" id="student-name-alert" style="display: none;">Please enter student name</p>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email <span style="color:red;">*</span></label>
            <input type="email" class="form-control" id="student-email-form" placeholder="Student Email" name="email">
            <p class="form-alert" id="student-email-alert" style="display: none;">Please enter correct student email</p>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Address</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Student Address" name="address">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">School From</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="School From" name="school">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Previous Grade</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Student Previous Grade" name="grade">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Parent Name/ Guardian <span style="color:red;">*</span></label>
            <input type="text" class="form-control" id="parent-name-form" placeholder="Parent Name" name="parent_name">
            <p class="form-alert" id="parent-name-alert" style="display: none;">Please enter parent / guardian name</p>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Parent Email <span style="color:red;">*</span></label>
            <input type="email" class="form-control" id="parent-email-form" placeholder="Parent Email" name="parent_email">
            <p class="form-alert" id="parent-email-alert" style="display: none;">Please enter parent / guardian email</p>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Branch <span style="color:red;">*</span></label>
            <select class="form-select" aria-label="Default select example" name="branch" id="branch-form">
                <option selected disabled value="0">Choose Branch</option>
                <?php foreach ($branch as $br) {
                    if($session->get('role') != '1'){
                        if($session->get('branch_id') == $br['id']){
                            echo "<option value=$br[id]>$br[branch_name]</option>";
                        }
                    }else{
                        echo "<option value=$br[id]>$br[branch_name]</option>";
                    }
                }
                ?>
            </select>
            <p class="form-alert" id="branch-alert" style="display: none;">Please choose branch</p>
        </div>
   
    <button class="btn btn-primary" type="button" id="add-student-btn"> Create Student</button>
    </form>
</div>
<script>
    document.getElementById("add-student-btn").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent the form from submitting

        // Validation
        var form = document.getElementById("add-student-form");
        var isValid = true;

        // Validate student number
        // var studentNo = document.getElementById("studentno-form");
        // if (!studentNo.value.trim()) {
        //     document.getElementById("student-no-alert").style.display = "block";
        //     isValid = false;
        // } else {
        //     document.getElementById("student-no-alert").style.display = "none";
        // }

        // Validate student name
        var studentName = document.getElementById("student-name-form");
        if (!studentName.value.trim()) {
            document.getElementById("student-name-alert").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("student-name-alert").style.display = "none";
        }

        // Validate student email
        var studentEmail = document.getElementById("student-email-form");
        if (!studentEmail.value.trim() || !studentEmail.value.includes("@")) {
            document.getElementById("student-email-alert").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("student-email-alert").style.display = "none";
        }

        // Validate parent name
        var parentName = document.getElementById("parent-name-form");
        if (!parentName.value.trim()) {
            document.getElementById("parent-name-alert").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("parent-name-alert").style.display = "none";
        }

        // Validate parent email
        var parentEmail = document.getElementById("parent-email-form");
        if (!parentEmail.value.trim() || !parentEmail.value.includes("@")) {
            document.getElementById("parent-email-alert").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("parent-email-alert").style.display = "none";
        }

        // Validate branch selection
        var branch = document.getElementById("branch-form");
        if (branch.value === "0" || branch.value === 0) {
            document.getElementById("branch-alert").style.display = "block";
            isValid = false;
        } else {
            document.getElementById("branch-alert").style.display = "none";
        }

        // If all fields are valid, submit the form
        if (isValid) {
            form.submit();
        }
    });
</script>
<?= $this->endSection();?>
