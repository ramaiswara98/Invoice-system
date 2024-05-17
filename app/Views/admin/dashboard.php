<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
   <h1>Dashboard</h1>
   <?php if($session->get('role') == '1'){?>
   <div>
   <select class="form-select" aria-label="Default select example" name="branch" id="branch_id" onchange="selectChange()">
               <?php if($pass_branch != '0' || $pass_branch != NULL){
                  echo '<option value="0">All Branch</option>';
               }else{
                  echo '<option selected value="0">All Branch</option>';
               }
               ?>
                <?php foreach ($branch as $br) {
                  if($pass_branch != '0' || $pass_branch != NULL){
                     if($pass_branch == $br['id']){
                        echo "<option  selected value=$br[id]>$br[branch_name]</option>";

                     }else{
                        echo "<option value=$br[id]>$br[branch_name]</option>";

                     }
                  }else{
                     echo "<option value=$br[id]>$br[branch_name]</option>";
                  }
                    
                }
                ?>
            </select>
   </div>
   <?php } ?>
   <br/>
   <div class="dashboard-row-one">
      <div class="card-board">
         <h3>Invoice</h3>
         <canvas id="myChart"></canvas>
      </div>
      <div class="card-board">
         <h3>Last Invoice</h3>
         <table class="table table-striped table-hover">
            <tr>
            <th>No.</th>
            <th>Invoice No.</th>
            <th>Name</th>
            <th>Date</th>
            </tr>
            <?php 
            $count = 0;
            foreach ($last_invoice as $li){
               $count++;
               echo "<tr>
               <td>".$count."</td>
               <td>".$li->invoice_id."</td>
               <td>".$li->name."</td>
               <td>".$li->date."</td>
               </tr>";
            }
            ?>
         </table>
      </div>
   </div>
   <div class="dashboard-row-one">
      <div class="card-board">
         <h3>Top Class</h3>
         <canvas id="lastInvoiceChart"></canvas>
      </div>
      <div class="card-board">
         <h3>Last Login</h3>
         <table class="table table-striped table-hover">
            <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Date</th>
            </tr>
            <?php
            $count=0;
               foreach($last_login as $ll){
                  $count++;
                  echo "<tr>
                  <td>".$count."</td>
                  <td>".$ll->name."</td>
                  <td>".$ll->last_login."</td>
                  </tr>";
               }
            ?>
         </table>
      </div>
   </div>
   <div class="card-board">
         <h3>Student With One Session Left</h3>
         <table class="table table-striped table-hover">
            <tr>
            <th>No.</th>
            <th>Student Name</th>
            <th>Class</th>
            <th>Branch</th>
            <th>Attendance</th>
            <th>Action</th>
            </tr>
            <?php 
            $count = 0;
            foreach ($items as $it){
               $count++;
               echo "<tr>
           <td>".$count."</td>
           <td>".$it->name."</td>
           <td>".$it->class_name."</td>
           <td>".$it->branch_name."</td>
           <td>".$it->attendance_total."/".$it->qty."</td>
           <td><a href='".base_url()."admin/create-payment?student-id=".$it->student_id."' class='btn btn-success' style='margin-left:5px'><i class='fa-solid fa-file-circle-plus'></i></a><a href='".base_url()."admin/attendance/".$it->class_id."' class='btn btn-primary' style='margin-left:5px'><i class='fa-solid fa-clipboard-check'></i></a></td>
           </tr>";
            }
            ?>
         </table>
      </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ["Paid (<?php echo count($paid);?>)", "Unpaid (<?php echo count($unpaid);?>)"],
      datasets: [{
        data: [<?php echo count($paid);?>, <?php echo count($unpaid);?>],
        borderWidth: 1
      }]
    },
    
  });
  const ctxs = document.getElementById('lastInvoiceChart');
  const data = <?php echo json_encode($top_class); ?>;
  const className = [];
  const count = [];
  data.forEach((classItem, index) => {
    className.push(classItem.class_name)
    count.push(classItem.class_count)
  });
 
  new Chart(ctxs, {
    type: 'bar',
    data: {
      labels: className,
      datasets: [{
        data: count,
        borderWidth: 1
      }]
    },
    options:{
      plugins:{
         legend:{
            display:false
         }
      },
      scales:{
         y:{
            ticks:{
               min:0,
               stepSize:1
            }
         }
      }
   }
    
  });

  function selectChange (){
   const id = document.getElementById("branch_id").value;
   const base_url = "<?php echo base_url();?>"
   window.location.href= base_url+"admin/dashboard?branch="+id;
   console.log(id);
  }
</script>

<?= $this->endSection();?>
