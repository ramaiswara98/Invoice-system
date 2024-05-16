<?= $this->extend('layout/admintemplate'); ?>

<?= $this->section('content'); ?>
<div>
    <h1>Edit Users</h1>
    <form action="/aedno/admin/save-users" method="POST">
        <?= csrf_field(); ?>
        <input type="hidden" name="id" value="<?= $user['id']; ?>" />
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Name</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="User Full Name" name="name" value="<?= $user['name'] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Username</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Username" name="username" value="<?= $user['username'] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email" name="email" value="<?= $user['email'] ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Role</label>
            <select name="role" class="form-select">
                <option value="0" <?= ($user['role'] == 0) ? 'selected' : '' ?> disabled>--- Select Role ---</option>
                <?php if ($session->get('role') == '1') {
                    echo '<option value="1" ' . (($user['role'] == 1) ? 'selected' : '') . '>Super Admin</option>';
                }
                ?>
                <option value="2" <?= ($user['role'] == 2) ? 'selected' : '' ?>>Branch Admin</option>
                <option value="3" <?= ($user['role'] == 3) ? 'selected' : '' ?>>Teacher</option>
            </select>

        </div>
        <?php
        if ($session->get('role') != '1') {
            echo "<input type='hidden' name='branch' value='" . $session->branch_id . "' />";
        } else {
            echo '<div class="mb-3 branch-form" style="display: none;">
    <label for="exampleFormControlInput1" class="form-label">Branch</label>
    <select class="form-select" aria-label="Default select example" name="branch">
        <option selected disabled>Choose Branch</option>';
            foreach ($branch as $br) {
                echo "<option value=\"$br[id]\">$br[branch_name]</option>";
            }
            echo '</select>
</div>';
        }
        ?>


        <button class="btn btn-primary" type="submit"> Save Users</button>
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
<?= $this->endSection(); ?>