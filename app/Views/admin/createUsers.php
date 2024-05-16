<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
   <h1>Create Users</h1>
   <form action="/aedno/admin/save-new-users" method="POST">
        <?= csrf_field(); ?>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Name</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="User Full Name" name="name">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Username</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Username" name="username">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email" name="email">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleFormControlInput1" placeholder="Password" name="password">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Role</label>
            <select name="role"  class="form-select">
                <option value="1" selected disabled>--- Select Role ---</option>
                <?php if($session->get('role') == '1'){
                    echo '<option value="1">Super Admin</option>';
                }
                ?>
                <option value="2">Branch Admin</option>
                <option value="3">Teacher</option>
            </select>
        </div>
        <div class="mb-3 branch-form" style="display: none;">
            <label for="exampleFormControlInput1" class="form-label">Branch</label>
            <select class="form-select" aria-label="Default select example" name="branch">
                <option selected disabled>Choose Branch</option>
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
        </div>
   
    <button class="btn btn-primary" type="submit"> Create Users</button>
    </form>
</div>

<script>
$(document).ready(function() {
    // Initially hide branch-form div
    $('.branch-form').hide();

    // Listen for changes in role select
    $('select[name="role"]').change(function() {
        // If the selected value is not equal to 1, show the branch-form div; otherwise, hide it
        if ($(this).val() !== '1') {
            $('.branch-form').show();
        } else {
            $('.branch-form').hide();
        }
    });
});
</script>
<?= $this->endSection();?>
