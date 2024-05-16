<?= $this->extend('layout/admintemplate'); ?>

<?= $this->section('content'); ?>
<div>
    <h1>Edit Payment</h1>
    <form action="/aedno/admin/save-payment" method="POST">
        <?= csrf_field(); ?>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Choose Student</label><br />
            <input type="hidden" name="invoice_id" value="<?php echo $payment->invoice_id;?>"/>
            <input type="hidden" name="student_id" value="<?php echo $payment->student_id;?>"/>
            <select class="selectpicker student-select" data-live-search="true" style="width: 100%;" name="student_id" id="student_id" readonly>
                <option selected disabled value="0">--- Choose Student ---</option>
                <?php foreach ($student as $s) {
                    if($s['id'] == $payment->student_id){
                        echo "<option selected value='" . $s['id'] . "' data-branch='".$s['branch_id']."' >" . $s['name'] . "</option>";

                    }else{
                        echo "<option value='" . $s['id'] . "' data-branch='".$s['branch_id']."' >" . $s['name'] . "</option>";

                    }
                } ?>

            </select>
        </div>
        <div>
            <p><strong>Class:</strong></p>
            <div class="section-class">
                <div class="class-form">
                    <input type="hidden" name="class_sum" value="1" id="class_sum" />
                    <div class="row class-form-row" style="display: flex;flex-direction:row;align-items:end">
                        <div class="form-class">
                            <label for="exampleFormControlInput1" class="form-label">Class</label>
                            <select class="form-select" data-live-search="true" style="width: 100%;" name="class1" id="select-class1" readonly>
                                <option selected disabled>--- Please choose student first ---</option>
                                <!-- <?php foreach ($class as $c) {
                                    echo "<option data-price='" . $c->price . "' data-currency='" . $c->currency_id . "' value ='" . $c->id . "'>" . $c->class_name . "</option>";
                                } ?> -->


                            </select>
                        </div>
                        <div class="form-qty">
                            <label for="exampleFormControlInput1" class="form-label">Qty</label>
                            <input readonly type="number" class="form-control" value="0" id="qty1" placeholder="Example: IDR, SGD, USD" name="qty1">
                        </div>
                        <div class="form-price">
                            <label for="exampleFormControlInput1" class="form-label">Price</label>
                            <input type="text" readonly value="0" class="form-control" id="price1" placeholder="Example: IDR, SGD, USD" name="price1">
                        </div>
                        <div class="form-disc">
                            <label for="exampleFormControlInput1" class="form-label">Discount %</label>
                            <input type="number" readonly class="form-control" value="0" id="discount1" placeholder="Example: IDR, SGD, USD" name="discount1">
                        </div>
                        <div class="form-amount">
                            <label for="exampleFormControlInput1" class="form-label">Amount</label>
                            <input type="text" readonly value="0" class="form-control" id="amount1" placeholder="Example: IDR, SGD, USD" name="amount1">
                        </div>
                        <!-- <div class="form-delete">
                            <button type="button" class="btn btn-danger" id="delete-btn-1"><i class="fa-solid fa-trash"></i></button>
                        </div> -->
                    </div>
                </div>
                <br />
                <button class="btn btn-primary" id="add-more-class" type="button" disabled style="display:none">Add More Class</button>
            </div>

        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Status</label>
            <select class="form-select" aria-label="Default select example" name="status" id="status">
                <option selected disabled>--- Choose Payment Status ---</option>
                <option value="Paid">Paid</option>
                <option value="Unpaid">Unpaid</option>
            </select>
        </div>
        <div class="paid" id="receive" style="display: none;">
            <input type="hidden" name="receive_id" value="<?php echo $r_id = isset($receive->id) ? $receive->id : 0;?>"/>
            <div class="row">
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Receive Date</label>
                <input type="date" class="form-control" value="" id="r_date" placeholder="Example: IDR, SGD, USD" name="r_date">

            </div>
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Receive No</label>
                <input type="text" class="form-control"  id="r_no" placeholder="Receive No" name="r_no">

            </div>
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Payment By</label>
                 <select class="form-select" aria-label="Default select example" name="r_by" id="r_by">
                <option selected disabled>--- Choose Payment Status ---</option>
                <option value="1">Cash</option>
                <option value="2">Transfer</option>
            </select>

            </div>
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Amount</label>
                <input type="number" class="form-control" value="0" id="r_amount" placeholder="Amount" name="r_amount">

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
        <button class="btn btn-primary" type="submit"> Generate Invoice</button>
    </form>
</div>
<script>
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
        subTotalElement.textContent = <?php echo json_encode($branch->code);?> + " " + total.toFixed(2);
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
        var currencySymbol = <?php echo json_encode($branch->code);?> // Extract currency symbol from the text content
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
            total_paid.innerHTML = <?php echo json_encode($branch->code);?>+" "+r_amount.value;
            calculateEveything();

        }else{
            var total_paid = document.getElementById("total-paid");
            total_paid.innerHTML = <?php echo json_encode($branch->code);?>+" 0.00"
            receive.style.display = "none";
            calculateEveything();
        }
        
    });

    document.getElementById("r_amount").addEventListener('change', function(){
        var r_amount = this.value;
        var total_paid = document.getElementById("total-paid");
        total_paid.innerHTML =<?php echo json_encode($class[0]->code);?>+" "+r_amount;
        calculateEveything();
        
    })
    document.getElementById("student_id").addEventListener('change', function(){
        var selectedOption = this.options[this.selectedIndex];
        var branch_id = selectedOption.getAttribute('data-branch');
       
        var classess =  document.getElementById("select-class1");
        var classData = <?php echo json_encode($class);?>;
        var makan = "<option selected disabled>--- Choose Class ---</option>";
        classData.map((classs,index) => {
            if(classs.branch_id == branch_id){
                
                makan+= "<option data-price="+classs.price+" data-currency="+classs.currency_id+" value="+classs.class_id+">"+classs.class_name+"</option>"

            }
            
        })
        classess.innerHTML = makan;
        document.getElementById("add-more-class").removeAttribute("disabled");
       
    })

    function initializePage() {
        var selectedOption = document.getElementById("student_id").options[document.getElementById("student_id").selectedIndex];
        var branch_id = selectedOption.getAttribute('data-branch');

        var classess =  document.getElementById("select-class1");
        var classData = <?php echo json_encode($class);?>;
        var makan = "<option selected disabled>--- Choose Class ---</option>";
        classData.forEach(function(classs) {
            if (classs.branch_id == branch_id) {
                makan+= "<option data-price="+classs.price+" data-currency="+classs.currency_id+" value="+classs.class_id+">"+classs.class_name+"</option>";
            }
        });
        classess.innerHTML = makan;
        document.getElementById("add-more-class").removeAttribute("disabled");
    }
    function updateClassSumsum() {
        var hiddenInput = document.getElementById("class_sum");
        var currentValue = parseInt(hiddenInput.value);
        hiddenInput.value = currentValue + 1;
    }
    function addItem() {
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
    updateClassSumsum();
}

function updatePaid() {
        var receive =  document.getElementById("receive");
        var statusValue = document.getElementById("status").value;
        if(statusValue.trim() == "Paid"){
            receive.style.display = "block";
            var total_paid = document.getElementById("total-paid");
            var r_amount ="<?php echo $r_amount = isset($receive->amount) ? $receive->amount : 0;?>";
            console.log("makan "+r_amount);
            total_paid.innerHTML = <?php echo json_encode($branch->code);?>+" "+parseFloat(r_amount).toFixed(2);
            calculateEveything();
            var r_dateElement = document.getElementById('r_date');
            var r_noElement = document.getElementById('r_no');
            var r_byElement = document.getElementById('r_by');
            var r_amountElement = document.getElementById('r_amount');

            r_dateElement.value = "<?php echo $r_date = isset($receive->receive_date) ? $receive->receive_date : null;?>";
            r_noElement.value = "<?php echo $r_no = isset($receive->receive_no) ? $receive->receive_no : "";?>";
            r_byElement.value = "<?php echo $r_methode = isset($receive->method) ? $receive->method : 0;?>";
            r_amountElement.value = "<?php echo $r_amount1 = isset($receive->amount) ? $receive->amount : 0;?>";
            var met = <?php echo $r_met = isset($receive->method) ? $receive->method : 0;?> ;
            
            for (var i = 0; i < r_byElement.options.length; i++) {
                    // Check if the value of the current option matches the desired value
                    if (r_byElement.options[i].value == met) {
                        // Set the selected attribute for the matching option
                        r_byElement.options[i].selected = true;
                        // Break the loop since we found the desired option
                        break;
                    }else{
                        console.log("maian"+r_byElement.options[i].value);
                    }
                }

        }else{
            console.log("makan gorengan");
            var total_paid = document.getElementById("total-paid");
            total_paid.innerHTML = <?php echo json_encode($branch->code);?>+" 0.00"
            receive.style.display = "none";
            calculateEveything();
        }
        
    }

    document.addEventListener("DOMContentLoaded", function() {
        initializePage();
        var itemClassElementss = document.getElementById("select-class1");
        itemClassElementss.addEventListener("change",function(){
            console.log(this.value);
        })
        var itemsData = <?php echo json_encode($items);?>;
        count=0;
        document.getElementById('class_sum');
        var paidElement = document.getElementById("total-paid");
        // class
        itemsData.forEach(function(itemitem){
            if(count > 0){
                addItem();
                var itemClassElement = document.getElementById("select-class"+count);
                var itemQtyElement = document.getElementById("qty"+count);
                var itemPriceElement = document.getElementById("price"+count);
                var itemDiscElement = document.getElementById("discount"+count);
                var itemAmountElement = document.getElementById("amount"+count);
                // Iterate through the options of the select element
                itemQtyElement.value = itemitem.qty;
                itemPriceElement.value = itemitem.price;
                itemDiscElement.value = itemitem.discount;
                itemAmountElement.value = itemitem.price * itemitem.qty;
                var valueOps = itemitem.class_id;
                for (var i = 0; i < itemClassElement.options.length; i++) {
                    // Check if the value of the current option matches the desired value
                    if (itemClassElement.options[i].value == valueOps) {
                        // Set the selected attribute for the matching option
                        itemClassElement.options[i].selected = true;
                        // Break the loop since we found the desired option
                        break;
                    }else{
                        console.log("maian"+itemClassElement.options[i].value);
                    }
                }
            }else{
                var itemClassElement = document.getElementById("select-class1");
                var itemQtyElement = document.getElementById("qty1");
                var itemPriceElement = document.getElementById("price1");
                var itemDiscElement = document.getElementById("discount1");
                var itemAmountElement = document.getElementById("amount1");
                // Iterate through the options of the select element
                itemQtyElement.value = itemitem.qty;
                itemPriceElement.value = itemitem.price;
                itemDiscElement.value = itemitem.discount;
                itemAmountElement.value = itemitem.price * itemitem.qty;
                var valueOps = itemitem.class_id;
                for (var i = 0; i < itemClassElement.options.length; i++) {
                    // Check if the value of the current option matches the desired value
                    if (itemClassElement.options[i].value == valueOps) {
                        // Set the selected attribute for the matching option
                        itemClassElement.options[i].selected = true;
                        // Break the loop since we found the desired option
                        break;
                    }else{
                        console.log("maian"+itemClassElement.options[i].value);
                    }
                }
                
            }
            console.log(itemitem);
            count++
            
            calculateTotal();
            calculateEveything();
            
        })

        var statusElement = document.getElementById('status');
        var stat = "<?php echo $payment->status; ?>";

        for (var i = 0; i < statusElement.options.length; i++) {
                    // Check if the value of the current option matches the desired value
                    if (statusElement.options[i].value == stat) {
                        // Set the selected attribute for the matching option
                        statusElement.options[i].selected = true;
                        // Break the loop since we found the desired option
                        updatePaid
                        break;
                    }else{
                        
                    }
                }
                updatePaid();
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
        dueTotalElement.innerHTML = <?php echo json_encode($branch->code);?>+" "+totalDue.toFixed(2);
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