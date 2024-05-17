<?= $this->extend('layout/admintemplate'); ?>

<?= $this->section('content'); ?>
<div>
    <h1>Create Branch</h1>


    <form action="<?php echo base_url();?>admin/save-new-branch" method="POST" id="branch-form">
        <?= csrf_field(); ?>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Branch Name <span style="color:red;">*</span></label>
            <input type="text" class="form-control" id="form-name" placeholder="branch name" name="name">
            <p class="form-alert" id="name" style="display: none;">Please insert branch name</p>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Branch Email <span style="color:red;">*</span></label>
            <input type="email" class="form-control" id="form-email" placeholder="name@example.com" name="email">
            <p class="form-alert" id="email" style="display: none;">Please insert correct email</p>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Branch Address</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="address"></textarea>
        </div>
        <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Currency <span style="color:red;">*</span></label>
            <select class="form-select" aria-label="Default select example" name="currency" id="form-currency">
                <option selected disabled value="0">Choose Currency</option>
                <?php foreach ($currency as $c) {
                    echo "<option value=$c[id]>(".$c["code"].") ".$c["name"]."</option>";
                }
                ?>
            </select>
            <p class="form-alert" id="currency" style="display: none;">Please choose currency</p>
        </div>
        
    <button class="btn btn-primary" type="button" id="btn-submit"> Add Branch</button>
    </form>
</div>
<script>
    document.getElementById('btn-submit').addEventListener('click', function(){
        var formname = document.getElementById('form-name');
        var formemail = document.getElementById('form-email');
        var formcurrency = document.getElementById('form-currency');
        
        var formnamevalue = formname.value;
        var formemailvalue = formemail.value;
        var formcurrencyvalue = formcurrency.value;
        if(formnamevalue !== "" && formnamevalue !== " "){
            if(formnamevalue.length > 3){
                if(formemailvalue !== "" && formnamevalue !== " " ){
                    if(formemailvalue.includes("@")){
                        if(formcurrencyvalue != 0){
                            var branchForm = document.getElementById("branch-form");
                            branchForm.submit();
                        }else{
                            var currencyAlert = document.getElementById('currency');
                            currencyAlert.style.display = "block";
                            formcurrency.focus();
                        }
                    }else{
                        var emailAlert = document.getElementById('email');
                        emailAlert.style.display = "block";
                        formemail.focus();
                    }
                }else{
                    var emailAlert = document.getElementById('email');
                    emailAlert.style.display = "block";
                    formemail.focus();
                }
            }else{
                var nameAlert = document.getElementById('name');
                nameAlert.style.display = "block";
                nameAlert.innerHTML = "Branch name must be more than 3 character"
                formname.focus();
            }
            
        }else{
            var nameAlert = document.getElementById('name');
            nameAlert.style.display = "block";
            formname.focus();
        }
    });
</script>

<?= $this->endSection(); ?>