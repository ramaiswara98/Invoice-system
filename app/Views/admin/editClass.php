<?= $this->extend('layout/admintemplate'); ?>

<?= $this->section('content'); ?>
<div>
    <h1>Edit Classes</h1>
    <form action="<?php echo base_url();?>admin/save-class" method="POST">
        <?= csrf_field(); ?>
        <input type="hidden" name="class_id" value="<?= $class->id;?>"/>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Class Name</label>
            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="class name" name="name" value="<?php echo $class->class_name?>">
        </div>
        <!-- <div class="session-section">
            <input type="hidden" name="section" value="1" id="section" />
            <p><strong>Session</strong></p>
            <div class="session-form-container">
                <div class="row session-form" id="session-form-1">
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Number Of Session / Weeks</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Input number of session" name="session1">
                            <span class="input-group-text">/ Weeks</span>
                        </div>
                    </div>
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Price</label>
                        <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Input Price" name="price1">
                    </div>
                    <div class="col">
                        <label for="exampleFormControlInput1" class="form-label">Currency</label>
                        <select class="form-select" aria-label="Default select example" name="currency1">
                            <option selected disabled>Choose Currency</option>
                            <?php foreach ($currency as $c) {
                                echo "<option value=$c[id]>$c[code]</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-danger" type="button" id="delete-section-1" onclick="onThisClick()">Delete</button>
                    </div>
                </div>

            </div>
            <button class="btn btn-primary" id="add-session-btn" type="button"> Add More Session</button><br /><br />
        </div> -->
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Branch</label>
            <select class="form-select" aria-label="Default select example" name="branch" id="branchSelect">
                <option selected disabled>Choose Branch</option>
                <?php foreach ($branch as $br) {
                     if($session->get('role') != '1'){
                        if($session->get('branch_id') == $br->branch_id){
                            if($br->branch_id == $class->branch_id){
                                $c_code = $br->code;
                                echo "<option selected value=$br->branch_id data-currency=$br->code data-currency-id=$br->currency_id>$br->branch_name</option>";
                            }else{
                                echo "<option value=$br->branch_id data-currency=$br->code data-currency-id=$br->currency_id>$br->branch_name</option>";
                            }                        }
                    }else{
                        if($br->branch_id == $class->branch_id){
                            $c_code = $br->code;
                            echo "<option selected value=$br->branch_id data-currency=$br->code data-currency-id=$br->currency_id>$br->branch_name</option>";
                        }else{
                            echo "<option value=$br->branch_id data-currency=$br->code data-currency-id=$br->currency_id>$br->branch_name</option>";
                        }
                    }
                    

                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="currency"><?= $c_code;?></span>
                <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="price" value="<?=$class->price; ?>">
                <span class="input-group-text">.00</span>
            </div>
        </div>
        <input type="hidden" name="currency_id" id="currency_id" value="<?= $class->currency_id?>"/>
        <button class="btn btn-primary" type="submit"> Save Class</button>
    </form>
</div>
<script>
    // Add an event listener to the select element
    document.getElementById('branchSelect').addEventListener('change', function() {
        // Get the selected option
        var selectedOption = this.options[this.selectedIndex];
        
        // Get the currency attribute value of the selected option
        var currency = selectedOption.getAttribute('data-currency');
        var currency_id = selectedOption.getAttribute('data-currency-id');
        
        // Log or use the currency value as needed
        var currencyHTML =  document.getElementById("currency");
        currencyHTML.innerHTML = currency;

        var currencyIDHTML = document.getElementById("currency_id");
        currencyIDHTML.value = currency_id;
    });
</script>

<script>
    document.getElementById('add-session-btn').addEventListener('click', function() {
        var sessionInput = document.getElementById('section');
        // Clone the session-form div
        var sessionForm = document.querySelector('.session-form');
        var newSessionForm = sessionForm.cloneNode(true);

        // Generate unique ID for the new session form
        var newId = 'session-form-' + (document.querySelectorAll('.session-form').length + 1);
        newSessionForm.setAttribute('id', newId);

        // Change the names of inputs to make them unique
        var inputsAndSelects = newSessionForm.querySelectorAll('input, select');
        inputsAndSelects.forEach(function(element) {
            var name = element.getAttribute('name');
            if (name) {
                var number = parseInt(sessionInput.value) + 1
                var newName = name.slice(0, -1) + number;
                element.setAttribute('name', newName);
                element.value = '';
            }
        });
        var sessionInput = document.getElementById('section');
        sessionInput.value = parseInt(sessionInput.value) + 1;

        // Generate unique ID for the delete button
        var deleteButton = newSessionForm.querySelector('.btn-danger');
        deleteButton.setAttribute('id', 'delete-' + newId);

        // Append the cloned form to the session-section div
        var sessionSection = document.querySelector('.session-form-container');
        sessionSection.appendChild(newSessionForm);
    });

    // Add event listener for delete buttons
    document.addEventListener('click', function(event) {
        var sessionInput = document.getElementById('section');
        if (event.target && event.target.classList.contains('btn-danger') && parseInt(sessionInput.value) > 1) {
            var formId = event.target.parentElement.parentElement.id;
            document.getElementById(formId).remove();
            sessionInput.value = parseInt(sessionInput.value) - 1;
        }
    });
</script>


<?= $this->endSection(); ?>