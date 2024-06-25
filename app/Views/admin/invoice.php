<?= $this->extend('layout/admintemplate'); ?>

<?= $this->section('content'); ?>
<div class="button-container">
<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
<button type="button" class="btn btn-primary" onclick="generatePDF()">Download PDF</button>
<button type="button" id="email_student" class="btn btn-primary" onclick="sendPDFToController('<?= $student['email'];?>','<?= $student['name'];?>','<?= $student['name'];?>')">Send to Student</button>
<button type="button" id="email_parent"
class="btn btn-primary" onclick="sendPDFToController('<?= $student['parent_email'];?>','<?= $student['name'];?>','<?= $student['parent_name'];?>')">Send to Parent/Guardian</button>

</div>
<div class="full-invoice" id="full-invoice">
    <div class="first-row">
        <div class="logo">
            <img src="<?= base_url() . "public/aedno-long-nobg.png"; ?>" width="200px" />
        </div>
        <div class="right-side-first-row">
            <h4>Aedno Consulting Pte.Ltd.</h4>
            <p>Website: www.aedno.com</p>
            <p>Tel: <?=$items[0]->phone?></p>
        </div>
    </div>

    <div class="info-box">
        <div class="info-box-left">
            <div class="info-box-left-text">
                <p class="info-box-label">Student No.: </p>
               <p><?= $student['student_no'];?></p>
            </div>
            <div class="info-box-left-text">
                <p class="info-box-label">Student Name: </p>
                <p><?= $student['name'];?></p>
            </div>
            <div class="info-box-left-text">
                <p class="info-box-label">Student Address: </p>
                <p><?= $student['address'];?></p>
            </div>
            <div class="info-box-left-text">
                <p class="info-box-label">Name of Parent/Guardian: </p>
                <p><?= $student['parent_name'];?></p>
            </div>
            <div class="info-box-left-text">
                <p class="info-box-label">Contac: </p>
                <p><?= $student['email'];?></p>
            </div>

        </div>
        <div class="info-box-right">
            <div class="info-box-left-text">
                <p class="info-box-label">Invoice No. </p>
                <p><?= $invoice['id'];?></p>
            </div>
            <div class="info-box-left-text">
                <p class="info-box-label">Invoice Date: </p>
                <p><?= $invoice['date'];?></p>
            </div>
            <div class="info-box-left-text">
                <p class="info-box-label">Status: </p>
                <p><?= $invoice['status'];?></p>
            </div>
            <div class="info-box-left-text">
                <p class="info-box-label">Mobile 1: </p>
                <p></p>
            </div>

            <div class="info-box-left-text">
                <p class="info-box-label">Mobile 2: </p>
                <p></p>
            </div>
        </div>
    </div>

    <div class="invoice-box">
        <div class="invoice-box-title">
            <p class="invoice-title-text desc"><strong>Description</strong></p>
            <p class="invoice-title-text qty"><strong>Qty</strong></p>
            <p class="invoice-title-text price"><strong>Unit Price</strong></p>
            <p class="invoice-title-text disc"><strong>Discount %</strong></p>
            <p class="invoice-title-text amount"><strong>Amount</strong></p>
        </div>
        <?php 
        $amount = 0;
        $currency;
            foreach($items as $it){
                echo "<div class='invoice-box-item'>";
                echo "<p class='invoice-text desc'>".$it->class_name."</p>";
                echo "<p class='invoice-text qty'>".$it->qty."</p>";
                echo "<p class='invoice-text price'>".$it->code." ".$it->price."</p>";
                echo "<p class='invoice-text disc'>".$it->discount."</p>";
                echo "<p class='invoice-text amount'>".$it->code." ".$it->price * $it->qty."</p>";
                echo "</div>";
                $amount+= $it->price * $it->qty;
                $currency = $it->code;
            }
        ?>
  
    </div>
    <div class="invoice-box-item">
            <p class="invoice-text desc"></p>
            <p class="invoice-text qty"></p>
            <p class="invoice-text price"></p>
            <p class="invoice-text disc">Sub-Total:</p>
            <p class="invoice-text amount"><?= $currency." ".$amount;?></p>
        </div>
        <div class="invoice-box-item">
            <p class="invoice-text desc"></p>
            <p class="invoice-text qty"></p>
            <p class="invoice-text price"></p>
            <p class="invoice-text disc">Paid:</p>
            <?php
                $paid = 0;
                // var_dump($receive)
                foreach($receive as $re){
                    $paid+= $re->amount;
                }
            ?>
            <p class="invoice-text amount"><?=$currency." ".$paid?></p>
        </div>
        <div class="invoice-box-item">
            <p class="invoice-text desc"></p>
            <p class="invoice-text qty"></p>
            <p class="invoice-text price"></p>
            <p class="invoice-text disc">Total Due:</p>
            <p class="invoice-text amount"><?= $currency." ".$amount - $paid?></p>
        </div>

    <div>
        <p><strong>Offical Use (Transactions)</strong></p>
        <div class="offical">
            <p class="offical-text ">Date Receive</p>
            <p class="offical-text ">Receipt No.</p>
            <p class="offical-text ">Payment By</p>
            <p class="offical-text ">Amount</p>
        </div>

    </div>

    <div class="term">
        <p>Term & Conditions:</p>
        <p>1) All payments by Cash or Transfer.</p>
        <p>2) Transfer to be made to <?php echo $items[0]->account_name ?>, <?php echo $items[0]->bank_name." ".$items[0]->account_number; ?></p>
    </div>

    <div class="bottom">
        <p>Registered in Singapore. Registration No. 200301298R</p>
        <p>Registered Office: 246S Upper Thomson Road Singapore 574370</p>
        <p>E. & O.E.</p>
    </div>
</div>

<script>
    function generatePDF() {
        var invoiceHTML = document.getElementById('full-invoice');
        var opt = {
            margin: 1,
            filename: 'myfile.pdf',
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 4,
                scrollY: 0,
                scrollX: 0,
                dpi: 192,
                letterRendering: true
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };
        var worker = html2pdf().set(opt).from(invoiceHTML).save();

    }

    async function savePDF(){
        var invoiceHTML = document.getElementById('full-invoice');
        var opt = {
            margin: 1,
            filename: 'myfile.pdf',
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 4,
                scrollY: 0,
                scrollX: 0,
                dpi: 192,
                letterRendering: true
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };
        var worker = await html2pdf().set(opt).from(invoiceHTML).output('blob');
        // var worker = html2pdf().set(opt).from(invoiceHTML).output('dataurlnewwindow');
        return worker;
    }

    async function sendPDFToController($email,$student_name,$name) {
        try {
            var button;
			var btnText;
			if($student_name == $name){
				button = document.getElementById('email_student');
				btnText = "Send to Student"
			}else{
				button = document.getElementById('email_parent');
				btnText = "Send to Parent/Guardian"
			}
            var pdfBlob = await savePDF(); // Get the PDF Blob
			console.log(pdfBlob);
            var formData = new FormData();
			
            formData.append('makan', pdfBlob);
			formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
			formData.append('email', $email);
			formData.append('student_name', $student_name);
			formData.append('name', $name);
			formData.append('id', <?php echo $invoice['id']?>);
			formData.append('Content-Type', 'multipart/form-data');
            var response = await fetch('https://aedno.acktechnologies.com/aedno/admin/send-invoice', {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                const jsonData = await response.json(); // Parse response as JSON
                alert("Email has been sent successfully.");
				button.disabled=false;
				button.textContent = btnText;
            } else {
                alert("Something wrong, email is not sent");
				button.disabled=false;
				button.textContent = btnText;
            }
        } catch (error) {
            alert("Something wrong, email is not sent");
				button.disabled=false;
				button.textContent = btnText;
        }
    }
    
</script>

<?= $this->endSection(); ?>