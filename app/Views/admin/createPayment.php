<?= $this->extend('layout/admintemplate'); ?>

<?= $this->section('content'); ?>
<div>
    <h1>Create Payment</h1>
    <form action="/aedno/admin/save-new-payment" method="POST" id="invoice-form">
        <?= csrf_field(); ?>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Choose Student <span style="color:red;">*</span></label><br />
            <select class="selectpicker student-select" data-live-search="true" style="width: 100%;" name="student_id" id="student_id">
                <option selected disabled value="0">--- Choose Student ---</option>
                <?php foreach ($student as $s) {
                    echo "<option value='" . $s->id . "' data-branch='".$s->branch_id."' >" . $s->name . "</option>";
                } ?>

            </select>
            <p class="form-alert" id="student-alert" style="display: none;">Please choose student first</p>
        </div>
        <div>
            <p><strong>Class: <span style="color:red;">*</span></strong></p>
            <p class="form-alert" id="class-alert" style="display: none;">Please choose at least one class</p>
            <div class="section-class">
                <div class="class-form">
                    <input type="hidden" name="class_sum" value="1" id="class_sum" />
                    <div class="row class-form-row" style="display: flex;flex-direction:row;align-items:end">
                        <div class="form-class">
                            <label for="exampleFormControlInput1" class="form-label">Class</label>
                            <select class="form-select" data-live-search="true" style="width: 100%;" name="class1" id="select-class1">
                                <option selected disabled value="0">--- Please choose student first ---</option>
                                <!-- <?php foreach ($class as $c) {
                                    echo "<option data-price='" . $c->price . "' data-currency='" . $c->currency_id . "' value ='" . $c->class_id . "'>" . $c->class_name . "</option>";
                                } ?> -->


                            </select>
                        </div>
                        <div class="form-qty">
                            <label for="exampleFormControlInput1" class="form-label">Qty</label>
                            <input type="number" class="form-control" value="0" id="qty1" placeholder="Example: IDR, SGD, USD" name="qty1">
                        </div>
                        <div class="form-price">
                            <label for="exampleFormControlInput1" class="form-label">Price</label>
                            <input type="text" disabled value="0" class="form-control" id="price1" placeholder="Example: IDR, SGD, USD" name="price1">
                        </div>
                        <div class="form-disc">
                            <label for="exampleFormControlInput1" class="form-label">Discount %</label>
                            <input type="number" class="form-control" value="0" id="discount1" placeholder="Example: IDR, SGD, USD" name="discount1">
                        </div>
                        <div class="form-amount">
                            <label for="exampleFormControlInput1" class="form-label">Amount</label>
                            <input type="text" disabled value="0" class="form-control" id="amount1" placeholder="Example: IDR, SGD, USD" name="amount1">
                        </div>
                        <div class="form-delete">
                            <button type="button" class="btn btn-danger" id="delete-btn-1"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                </div>
                <br />
                <button class="btn btn-primary" id="add-more-class" type="button" disabled>Add More Class</button>
            </div>

        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Status <span style="color:red;">*</span></label>
            <select class="form-select" aria-label="Default select example" name="status" id="status">
                <option selected disabled value="0">--- Choose Payment Status ---</option>
                <option value="Paid">Paid</option>
                <option value="Unpaid">Unpaid</option>
            </select>
            <p class="form-alert" id="status-alert" style="display: none;">Please choose invoice status</p>
        </div>
        <div class="paid" id="receive" style="display: none;">
            <div class="row">
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Receive Date  <span style="color:red;">*</span></label>
                <input type="date" class="form-control" value="" id="r_date" placeholder="Example: IDR, SGD, USD" name="r_date">
                <p class="form-alert" id="r-date-alert" style="display: none;">Please choose receive date</p>
            </div>
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Receive No  <span style="color:red;">*</span></label>
                <input type="text" class="form-control"  id="r_no" placeholder="Receive No" name="r_no">
                <p class="form-alert" id="r-no-alert" style="display: none;">Please Enter receive number</p>
            </div>
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Payment By  <span style="color:red;">*</span></label>
                 <select class="form-select" aria-label="Default select example" name="r_by" id="r_by">
                <option selected disabled value="0">--- Choose Payment Methode ---</option>
                <option value="1">Cash</option>
                <option value="2">Transfer</option>
            </select>
            <p class="form-alert" id="r-by-alert" style="display: none;">Please Choose Payment Method</p>
            </div>
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Amount  <span style="color:red;">*</span></label>
                <input type="number" class="form-control" value="0" id="r_amount" placeholder="Amount" name="r_amount">
                <p class="form-alert" id="r-amount-alert" style="display: none;">Please Enter Amount greater than 0</p>
            </div>
            </div>
            
        </div>
        <hr />
        <div class="row" style="justify-content: end;text-align:end">
            <div class="col">
                <p>Sub-Total:</p>
                <p>Paid:</p>
                <p>Total Due:</p>
            </div>
            <div class="col">
                <p id="sub-total"> -</p>
                <p id="total-paid"> -</p>
                <p id="total-due"> -</p>
            </div>
        </div>
        <button class="btn btn-primary" type="button" id="generate-invoice"> Generate Invoice</button>
    </form>
</div>
<script>

    document.getElementById("generate-invoice").addEventListener("click", function(){
        var chooseStudent =  document.getElementById("student_id");
        var chooseClass = document.getElementById("select-class1");
        var chooseStatus = document.getElementById("status");
        var valid = true;
        var firstElement=null;
        if(chooseStudent.value.trim() == "0"){
            var studentAlert = document.getElementById('student-alert');
            studentAlert.style.display = "block";
            valid=false;
            firstElement = chooseStudent;
            //chooseStudent.focus();
        }else{
            var studentAlert = document.getElementById('student-alert');
            studentAlert.style.display = "none";
        }
        if(chooseClass.value.trim() == "0"){
            var classAlert = document.getElementById('class-alert');
            classAlert.style.display = "block";
            if(firstElement == null){
                firstElement = chooseClass;
            }
            valid=false;
            // chooseClass.focus();
        }else{
            var classAlert = document.getElementById('class-alert');
            classAlert.style.display = "none";
        }
        if(chooseStatus.value.trim() == "0"){
            var statusAlert = document.getElementById('status-alert');
            statusAlert.style.display = "block";
            if(firstElement == null){
                firstElement = chooseStatus;
            }
            valid=false;
            // chooseClass.focus();
        }else{
            var statusAlert = document.getElementById('status-alert');
            statusAlert.style.display = "none";
            if(chooseStatus.value.trim() == "Paid"){
                var check = checkPaid();
                if(!check.valid){
                    valid = check.valid;
                    if(firstElement == null){
                    firstElement = check.firstElemet
                }
                }
                
                
            }
        }
        if(!valid){
            firstElement.focus();
        }else{
            var form = document.getElementById('invoice-form');
            form.submit();
        }

    })

    function checkPaid(){
        var receiveDateElement = document.getElementById('r_date');
        var receiveNoElement = document.getElementById('r_no');
        var receiveByElement = document.getElementById('r_by');
        var receiveAmountElement = document.getElementById('r_amount');

        //Alert Element 
        var receiveDateAlertElement = document.getElementById('r-date-alert');
        var receiveNoAlertElement = document.getElementById('r-no-alert');
        var receiveByAlertElement = document.getElementById('r-by-alert');
        var receiveAmountAlertElement = document.getElementById('r-amount-alert');
        var valid = true;
        var firstElemet = null;
        if(!receiveDateElement.value){
            receiveDateAlertElement.style.display = "block";
            valid = false;
            firstElemet = receiveDateElement;
        }else{
            receiveDateAlertElement.style.display = "none";
        }

        if(!receiveNoElement.value){
            receiveNoAlertElement.style.display = "block";
            valid = false;
            if(firstElemet == null){
                firstElemet = receiveNoElement;
            }
        }else{
            receiveNoAlertElement.style.display = "none";
        }

        if(!receiveByElement.value || receiveByElement.value.trim() == '0'){
            receiveByAlertElement.style.display = "block";
            valid = false;
            if(firstElemet == null){
                firstElemet = receiveByElement;
            }
            console.log("Makan");
        }else{
            receiveByAlertElement.style.display = "none";
        }

        if(!receiveAmountElement.value || receiveAmountElement.value.trim() <= 0){
            receiveAmountAlertElement.style.display = "block";
            valid = false;
            if(firstElemet == null){
                firstElemet = receiveAmountElement;
            }
        }else{
            receiveAmountAlertElement.style.display = "none";
        }
        var data = {
            valid,
            firstElemet
        }
        return data;
    }


    // Function to calculate amount for a specific index
    function calculateAmount(index) {
        var qty = parseFloat(document.getElementById('qty' + index).value) || 0;
        var price = parseFloat(document.getElementById('price' + index).value) || 0;
        var discount = parseFloat(document.getElementById('discount' + index).value) || 0;
        var amount = qty * price * (1 - discount / 100);
        document.getElementById('amount' + index).value = amount.toFixed(2);
        var hiddenInput = document.getElementById("class_sum");
        var currentValue = parseInt(hiddenInput.value);
        var total = 0;
        for (let i = 1; i <= currentValue; i++) {
            total += parseFloat(document.getElementById('amount' + i).value); // Add numeric value
        }
        var subTotalElement = document.getElementById("sub-total");
        var currencySymbol = subTotalElement.textContent.split(" ")[0]; // Extract currency symbol from the text content
        subTotalElement.textContent = <?php echo json_encode($class[0]->code);?> + " " + total.toFixed(2);
    }

    function calculateTotal(){
        var hiddenInput = document.getElementById("class_sum");
        var currentValue = parseInt(hiddenInput.value);
        var total = 0;
        for (let i = 1; i <= currentValue; i++) {
            var a = document.getElementById('amount' + i).value;
            total += parseFloat(a); // Add numeric value
        }

        var subTotalElement = document.getElementById("sub-total");
        var currencySymbol = subTotalElement.textContent.split(" ")[0]; // Extract currency symbol from the text content
        subTotalElement.textContent = currencySymbol + " " + total.toFixed(2);
    }

    // Function to handle change event for a specific index
    function handleChange(index) {
        return function() {
            var selectedIndex = this.selectedIndex;
            var selectedOption = this.options[selectedIndex];
            var price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            document.getElementById('price' + index).value = price.toFixed(2);
            calculateAmount(index);
        };
    }

    // Attach event listeners for each set of elements
    function attachEventListeners() {
        for (var i = 1; i <= count; i++) {
            document.getElementById('qty' + i).addEventListener('input', calculateAmount.bind(null, i));
            document.getElementById('discount' + i).addEventListener('input', calculateAmount.bind(null, i));
            document.getElementById('select-class' + i).addEventListener('change', handleChange(i));
        }
    }

    document.getElementById('status').addEventListener('change', function() {
        var receive =  document.getElementById("receive");
        var statusValue = this.value;
        if(statusValue == "Paid"){
            receive.style.display = "block";
            var total_paid = document.getElementById("total-paid");
            var r_amount =  document.getElementById("r_amount");
            total_paid.innerHTML = <?php echo json_encode($class[0]->code);?>+" "+r_amount.value;


        }else{
            var total_paid = document.getElementById("total-paid");
            total_paid.innerHTML = <?php echo json_encode($class[0]->code);?>+" 0.00"
            receive.style.display = "none";
            calculateEveything();
        }
        
    });

    document.getElementById("r_amount").addEventListener('change', function(){
        var r_amount = this.value;
        var total_paid = document.getElementById("total-paid");
        total_paid.innerHTML =<?php echo json_encode($class[0]->code);?>+" "+parseFloat(r_amount).toFixed(2);
        var subTotalElement = document.getElementById("sub-total");
        var subTotalText = subTotalElement.textContent;
        var subTotalValue = subTotalText.split(" ")[1];
        if(parseFloat(r_amount) > parseFloat(subTotalValue)){
            console.log("food");
            roaster = document.getElementById('r_amount');
            roaster.value = parseFloat(subTotalValue);
            total_paid.innerHTML =<?php echo json_encode($class[0]->code);?>+" "+parseFloat(roaster.value).toFixed(2);
            
        }
        calculateEveything();
        
    })
    document.getElementById("student_id").addEventListener('change', function(){
        var selectedOption = this.options[this.selectedIndex];
        var branch_id = selectedOption.getAttribute('data-branch');
       
        var classess =  document.getElementById("select-class1");
        var classData = <?php echo json_encode($class);?>;
        var makan = "<option selected disabled value='0'>--- Choose Class ---</option>";
        classData.map((classs,index) => {
            if(classs.branch_id == branch_id){
                
                makan+= "<option data-price="+classs.price+" data-currency="+classs.currency_id+" value="+classs.class_id+">"+classs.class_name+"</option>"

            }
            
        })
        classess.innerHTML = makan;
        document.getElementById("add-more-class").removeAttribute("disabled");
       
    })

    // Initial attachment of event listeners
    var count = 1;
    attachEventListeners();

    function calculateEveything(){
        var subTotalElement = document.getElementById("sub-total");
        var subTotalText = subTotalElement.textContent;
        var subTotalValue = subTotalText.split(" ")[1];
        var paidTotalElement = document.getElementById("total-paid");
        var paidTotalText = paidTotalElement.textContent;
        var paidTotalValue = paidTotalText.split(" ")[1];
        var dueTotalElement = document.getElementById("total-due");
        var totalDue = subTotalValue - paidTotalValue;
        dueTotalElement.innerHTML = <?php echo json_encode($class[0]->code);?>+" "+totalDue.toFixed(2);
    }

    $(document).ready(function() {
        $('#add-more-class').click(function() {
    count++;

    var newRow = $('.class-form-row').first().clone();
    newRow.find('input, select').each(function() {
        var oldId = $(this).attr('id');
        var newId = oldId.replace(/[0-9]/g, '') + count;
        var oldName = $(this).attr('name');
        var newName = oldName.replace(/[0-9]/g, '') + count;
        $(this).attr('id', newId).attr('name', newName);
    });

    // Update delete button ID and attach delete function
    var deleteBtnId = 'delete-btn-' + count;
    newRow.find('.form-delete button').attr('id', deleteBtnId).click(function() {
        $(this).closest('.class-form-row').remove();
        reorderComponents();
        minusClassSum();
        count --;
        calculateTotal();
        calculateEveything();
    });

    $('.class-form').append(newRow);
    attachEventListeners(); // Attach event listeners for the newly added elements
    updateClassSum();
});

function reorderComponents() {
    $('.class-form-row').each(function(index) {
        var newIndex = index + 1;
        $(this).find('input, select').each(function() {
            var oldId = $(this).attr('id');
            var newId = oldId.replace(/[0-9]/g, '') + newIndex;
            var oldName = $(this).attr('name');
            var newName = oldName.replace(/[0-9]/g, '') + newIndex;
            $(this).attr('id', newId).attr('name', newName);
        });
        var newDeleteBtnId = 'delete-btn-' + newIndex;
        $(this).find('.form-delete button').attr('id', newDeleteBtnId);
        
    });
}


    function updateClassSum() {
        var hiddenInput = document.getElementById("class_sum");
        var currentValue = parseInt(hiddenInput.value);
        hiddenInput.value = currentValue + 1;
    }
    function minusClassSum() {
        var hiddenInput = document.getElementById("class_sum");
        var currentValue = parseInt(hiddenInput.value);
        hiddenInput.value = currentValue - 1;
    }
});
</script>
<!-- <script>
    $(document).ready(function() {
        var count = 1;

        $('#add-more-class').click(function() {
            count++;

            var newRow = $('.class-form-row').first().clone();
            newRow.find('input, select').each(function() {
                var oldId = $(this).attr('id');
                var newId = oldId.replace(/[0-9]/g, '') + count;
                $(this).attr('id', newId).attr('name', newId);
            });

            $('.class-form').append(newRow);
        });
    });
</script> -->


<?= $this->endSection(); ?>