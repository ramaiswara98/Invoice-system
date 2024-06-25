<?= $this->extend('layout/admintemplate'); ?>

<?= $this->section('content'); ?>
<div>
    <h1>Edit Branch</h1>

    <form action="<?php echo base_url();?>admin/save-branch" method="POST">
        <?= csrf_field(); ?>
        <input type="hidden" name="branch_id" value="<?php echo $branch->id ?>"/>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Branch Name</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="branch name" name="name" value="<?php echo $branch->branch_name?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Branch Email</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name="email" value="<?php echo $branch->email?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Branch Phone Number</label>
            <input type="tel" class="form-control" id="exampleFormControlInput1" placeholder="+62812323223" name="phone" value="<?php echo $branch->phone?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Branch Address</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="address" value="<?php echo $branch->address?>"><?php echo $branch->address?></textarea>
        </div>
        <div class="input-group mb-3">
            <select class="form-select" aria-label="Default select example" name="currency" style="width: 20%;">
                <option selected disabled>Choose Currency</option>
                <?php foreach ($currency as $c) {
                    if($c["id"] == $branch->currency_id){
                        echo "<option selected value=$c[id]>(".$c["code"].") ".$c["name"]."</option>";
                    }else{
                        echo "<option value=$c[id]>(".$c["code"].") ".$c["name"]."</option>";
                    }
                    
                }
                ?>
            </select>
        </div>
        <br/>
        <p>Payment Info:</p>
        <hr/>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Bank Name <span style="color:red;">*</span></label>
            <input type="text" class="form-control" id="form-name" placeholder="Bank Name" value="<?php echo $branch->bank_name ?>" name="bank_name" required>
            <!-- <p class="form-alert" id="name" style="display: none;">Please insert branch name</p> -->
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Account Name <span style="color:red;">*</span></label>
            <input type="text" class="form-control" id="form-name" placeholder="Account Nmae" value="<?php echo $branch->account_name ?>" name="account_name" required>
            <!-- <p class="form-alert" id="name" style="display: none;">Please insert branch name</p> -->
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Account Number <span style="color:red;">*</span></label>
            <input type="text" class="form-control" id="form-name" placeholder="Account Number" value="<?php echo $branch->account_number ?>" name="account_number" required>
            <!-- <p class="form-alert" id="name" style="display: none;">Please insert branch name</p> -->
        </div>
    <button class="btn btn-primary" type="submit"> Save Branch</button>
    </form>
</div>


<?= $this->endSection(); ?>