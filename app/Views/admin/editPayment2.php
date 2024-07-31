<?= $this->extend('layout/admintemplate'); ?>

<?= $this->section('content'); ?>
<h1>Edit Payment</h1>
<form action="<?php echo base_url(); ?>admin/save-payment" method="POST">
    <input type="hidden" name="invoice_id" value="<?= $payment->invoice_id ?>" />
    <?= csrf_field(); ?>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Student</label><br />
        <?php foreach ($student as $s) {
            if ($s['id'] == $payment->student_id) {
                echo "<input disabled type='text' value=\"" . htmlspecialchars($s['name']) . "\" class='form-control'/>";
            }
        } ?>
    </div>

    <p><strong>Class:</strong></p>
    <?php 
        $allTotal=0;
        foreach($items as $i){
        $total = $i->qty*$i->price;
        $discount = ((100 - $i->discount) / 100);
        $grandTotal = $total*$discount;
        $allTotal = $allTotal+$grandTotal;
        $item = '';
        foreach($class as $c){
            if($c->class_id == $i->class_id){
                $item =  $c->class_name;
            }
        }
        echo '<div class="">
        <div class="row class-form-row" style="display: flex;flex-direction:row;align-items:end">
            <div class="form-class">
                <label for="exampleFormControlInput1" class="form-label">Class / Item</label>
                <input type="text" disabled value="'.$item.'" class="form-control" />
            </div>
            <div class="form-qty">
                <label for="exampleFormControlInput1" class="form-label">Qty</label>
                <input disabled type="number" class="form-control" value="'.$i->qty.'" id="qty1" placeholder="Example: IDR, SGD, USD" name="qty1">
            </div>
            <div class="form-price">
                <label for="exampleFormControlInput1" class="form-label">Price</label>
                <input type="text" disabled value="'.$i->price.'" class="form-control" id="price1" placeholder="Example: IDR, SGD, USD" name="price1">
            </div>
            <div class="form-disc">
                <label for="exampleFormControlInput1" class="form-label">Discount %</label>
                <input type="number" disabled class="form-control" value="'.$i->discount.'" id="discount1" placeholder="Example: IDR, SGD, USD" name="discount1">
            </div>
            <div class="form-amount">
                <label for="exampleFormControlInput1" class="form-label">Amount</label>
                <input type="text" disabled value="'.$grandTotal.'" class="form-control" id="amount1" placeholder="Example: IDR, SGD, USD" name="amount1">
            </div>
        </div>
    </div>';
    }?>
   <div class="mb-3 mt-3">
            <label for="exampleFormControlInput1" class="form-label">Status</label>
            <!-- <select class="form-select" aria-label="Default select example" name="status" id="status"> -->
                <?php
                    if($payment->status == "Unpaid"){
                        echo '<input type="hidden" name="state" value="0"/>';
                        echo '
                            <select class="form-select" aria-label="Default select example" name="status" id="status" onchange="onSelectChange(this)">
                            <option value="Paid">Paid</option>
                            <option selected value="Unpaid">Unpaid</option>
                            </select>
                            ';
                    }else{
                        echo '<input type="hidden" name="state" value="21"/>';
                        echo '<input type="text" disabled value="Paid" class="form-control"/>';
                        echo '<input type="hidden" value="Paid" name="status"/>';
                    }
                ?>
            
    </div>
    <div id="paid-container1" class="mt-2" style="display: none;">
        <div class="paid" id="receive">
        <input type="hidden" name="done" value="no" />
            <input type="hidden" name="receive_id" value="<?php echo $r_id = isset($receive->id) ? $receive->id : 0;?>"/>
            <div class="row">
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Receipt Date</label>
                <input type="date" class="form-control" value="" id="r_date" placeholder="Example: IDR, SGD, USD" name="r_date">

            </div>
            <div class="col" style='display:none'>
                <label for="exampleFormControlInput1" class="form-label">Receipt No</label>
                <input type="hidden" class="form-control"  id="r_no" placeholder="Receive No" name="r_no">

            </div>
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Payment By</label>
                 <select class="form-select" aria-label="Default select example" name="r_by" id="r_by" >
                <option value="">--- Choose Payment Status ---</option>
                <option value="1">Cash</option>
                <option value="2">Transfer</option>
            </select>

            </div>
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Amount</label>
                <input  type="number" class="form-control"  id="r_amount" placeholder="Amount" name="r_amount" onchange="changeAmount(this)">

            </div>
            <div class="col">
        </div>
            </div>
            
        </div>
        </div>

    <?php
    $totalPaid = 0;
        foreach($receive as $re){
            $totalPaid = $totalPaid + $re->amount;
            $met = '';
            if($re->method == '1'){
                $met = "Cash";
            }else{
                $met = "Transfer";
            }
            echo '
            <div id="paid-container" class="mt-2">
        <div class="paid" id="receive" style="display: block;">
            <input type="hidden" name="receive_id" value="'.$re->id.'"/>
            <div class="row">
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Receipt Date</label>
                <input type="date" disabled class="form-control" value="'.$re->receive_date.'" >

            </div>
            <div class="col" style="display:none">
                <label for="exampleFormControlInput1" class="form-label">Receipt No</label>
                <input type="hidden" disabled class="form-control" value="'.$re->id.'"  id="r_no" placeholder="Receive No" name="r_no">

            </div>
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Payment By</label>
                <input disabled type="text" class="form-control" value="'.$met.'"/>
            </select>

            </div>
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Amount</label>
                <input type="number" disabled class="form-control" value="'.$re->amount.'" >

            </div>
            <div class="col">
        </div>
            </div>
            
        </div>
        </div>
            ';
        }
    ?>
    <?php 
    if(($allTotal - $totalPaid) != 0 && $payment->status == 'Paid'){
        echo '<input type="hidden" name="done" value="no" />';
        ?>
        <div id="paid-container" class="mt-2">
        <div class="paid" id="receive" style="display: block;">
            <input type="hidden" name="receive_id" value="<?php echo $r_id = isset($receive->id) ? $receive->id : 0;?>"/>
            <div class="row">
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Receipt Date</label>
                <input type="date" class="form-control" required='required' value="" id="r_date" placeholder="Example: IDR, SGD, USD" name="r_date">

            </div>
            <div class="col" style='display:none'>
                <label for="exampleFormControlInput1" class="form-label">Receipt No</label>
                <input type="hidden" class="form-control"  id="r_no" placeholder="Receive No" name="r_no">

            </div>
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Payment By</label>
                 <select class="form-select" aria-label="Default select example" name="r_by" id="r_by" required='required'>
                <option value="">--- Choose Payment Status ---</option>
                <option value="1">Cash</option>
                <option value="2">Transfer</option>
            </select>

            </div>
            <div class="col">
                <label for="exampleFormControlInput1" class="form-label">Amount</label>
                <input required='required' type="number" class="form-control"  id="r_amount" placeholder="Amount" name="r_amount" onchange="changeAmount(this)">

            </div>
            <div class="col">
        </div>
            </div>
            
        </div>
        </div>
    <?php }

    if(($allTotal - $totalPaid) == 0){
        echo '<input type="hidden" name="done" value="yes" />';
    }
    ?>
       
        <hr/>
        <div class="row" style="justify-content: end;text-align:end">
            <div class="col">
                <p>Sub-Total:</p>
                <p>Paid:</p>
                <p>Total Due:</p>
            </div>
            <div class="col">
                <p id="sub-total"><?=$branch->code.' '.$allTotal;?></p>
                <p id="total-paid"> <?=$branch->code.' '.$totalPaid?></p>
                <p id="total-due"> <?= $branch->code.' '.$allTotal - $totalPaid?></p>
            </div>
        </div>
        <button class="btn btn-primary" type="submit"> Generate Invoice</button>
<script>
    function changeAmount(food){
        var value = food.value;
        var amountElement = document.getElementById('r_amount');
        var totalPaidElement = document.getElementById('total-paid');
        var totalDue = document.getElementById('total-due');
        var currency = '<?= $branch->code;?>';
        var allTotal = '<?= $allTotal;?>';
        var totalPaid = '<?=$totalPaid?>';
        var totalLeft = allTotal - totalPaid;
        if(value > totalLeft){
            food.value = totalLeft;
            totalPaid = parseFloat(totalPaid) + parseFloat(totalLeft);
            totalLeft = totalLeft - totalLeft;
            totalPaidElement.innerHTML = currency+' '+totalPaid;
            totalDue.innerHTML = currency+' '+totalLeft;
        }else{
            totalPaid = parseFloat(totalPaid) + parseFloat(value);
            totalLeft = totalLeft - value;
            totalPaidElement.innerHTML = currency+' '+totalPaid;
            totalDue.innerHTML = currency+' '+totalLeft;
        }
       
    }

    function onSelectChange(selectedElement){
        var value = selectedElement.value;
        var rElement = document.getElementById('paid-container1')
        if(value == "Paid"){
            rElement.style.display = "block";
            rDate = document.getElementById('r_date');
            rBy = document.getElementById('r_by');
            rAmount = document.getElementById('r_amount');

            rDate.setAttribute('required','required');
            rBy.setAttribute('required','required');
            rAmount.setAttribute('required','required');
        }else{
            rElement.style.display = "none";
        }

    }
</script>
    <?= $this->endSection(); ?>