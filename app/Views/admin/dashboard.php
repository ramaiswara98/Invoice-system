<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
   <h1>Dashboard</h1>
   <div class="dashboard-row-one">
      <div class="card-board">
         <h3>Invoice</h3>
         <canvas id="myChart"></canvas>
      </div>
      <di class="card-board">
         <h3>Last Inovoice</h3>
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
      <di class="card-board">
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
</script>

<?= $this->endSection();?>
