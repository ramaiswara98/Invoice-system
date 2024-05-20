<?= $this->extend('layout/admintemplate'); ?>

<?= $this->section('content'); ?>
<div>
  <h1>Invoice</h1>
  <a href='<?= base_url() . "admin/create-payment" ?>' class="btn btn-primary"> Create Invoice</a>
  <br/><br/>
  <table id="na_datatable" class="table table-bordered table-striped" width="100%">
    <thead>
      <tr>
        <th scope="col">#Invoice No.</th>
        <th scope="col">Student</th>
        <th scope="col">Status</th>
        <th scope="col">Amount</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  <!-- <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">#Invoice No.</th>
        <th scope="col">Student</th>
        <th scope="col">Status</th>
        <th scope="col">Amount</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $invoice_id = 0;
      $amount = 0;
      $code;
      $in_id;
      foreach ($items as $it) {
        if($session->get('role') !== '1'){
          if($session->get('branch_id') == $it->branch_id){
            if ($invoice_id !== $it->invoice_id) {

              $code = $it->code;
              if ($invoice_id !== 0) {
                echo "<td>" . $code . " " . number_format($amount, 2) . "</td>";
                echo "<td><a href='" . base_url() . "admin/invoice/" . $in_id . "' type='button' class='btn btn-secondary'><i class='fa-solid fa-eye'></i></a><a href='" . base_url() . "admin/edit-payment/" . $in_id . "' type='button' class='btn btn-warning' style='margin-right:10px;margin-left:10px'><i class='fa-solid fa-pen-to-square'></i></a><a href='" . base_url() . "admin/delete-invoice/" . $in_id . "' type='button' class='btn btn-danger'><i class='fa-solid fa-trash'></i></a></td>";
                echo "</tr>";
              }
              $amount = 0;
              $invoice_id = $it->invoice_id;
              $in_id = $it->invoice_id;
              echo "<tr>";
              echo "<td>" . $it->invoice_id . "</td>";
              echo "<td>" . $it->name . "</td>";
              if ($it->status == "Unpaid") {
                echo "<td><span class='badge bg-danger'>" . $it->status . "</span></td>";
              } else {
                echo "<td><span class='badge bg-success'>" . $it->status . "</span></td>";
              }
    
              $amount += $it->qty * $it->price;
              $code = $it->code;
            } else {
              $amount += $it->qty * $it->price;
              $code = $it->code;
              $in_id = $it->invoice_id;
            }
          }
        }else{
          if ($invoice_id !== $it->invoice_id) {

            // $code = $it->code;
            if ($invoice_id !== 0) {
              echo "<td>" . $code . " " . number_format($amount, 2) . "</td>";
              echo "<td><a href='" . base_url() . "admin/invoice/" . $in_id . "' type='button' class='btn btn-secondary'><i class='fa-solid fa-eye'></i></a><a href='" . base_url() . "admin/edit-payment/" . $in_id . "' type='button' class='btn btn-warning' style='margin-right:10px;margin-left:10px'><i class='fa-solid fa-pen-to-square'></i></a><a href='" . base_url() . "admin/delete-invoice/" . $in_id . "' type='button' class='btn btn-danger'><i class='fa-solid fa-trash'></i></a></td>";
              echo "</tr>";
            }
            $amount = 0;
            $invoice_id = $it->invoice_id;
            $in_id = $it->invoice_id;
            echo "<tr>";
            echo "<td>" . $it->invoice_id . "</td>";
            echo "<td>" . $it->name . "</td>";
            if ($it->status == "Unpaid") {
              echo "<td><span class='badge bg-danger'>" . $it->status . "</span></td>";
            } else {
              echo "<td><span class='badge bg-success'>" . $it->status . "</span></td>";
            }
  
            $amount += $it->qty * $it->price;
            $code = $it->code;
          } else {
            $amount += $it->qty * $it->price;
            $code = $it->code;
            $in_id = $it->invoice_id;
          }
        }
        
      }
      echo "<td>" . $code . " " . number_format($amount, 2) . "</td>";
      echo "<td><a href='" . base_url() . "admin/invoice/" . $in_id . "' type='button' class='btn btn-secondary'><i class='fa-solid fa-eye'></i></a><a href='" . base_url() . "admin/edit-payment/" . $in_id . "' type='button' class='btn btn-warning' style='margin-right:10px;margin-left:10px'><i class='fa-solid fa-pen-to-square'></i></a><a href='" . base_url() . "admin/delete-invoice/" . $in_id . "' type='button' class='btn btn-danger'><i class='fa-solid fa-trash'></i></a></td>";
      echo "</tr>";
      ?>


    </tbody>
  </table> -->
</div>
<script src="<?php echo base_url() ?>public/datatable/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>public/datatable/dataTables.bootstrap4.js"></script>
<script src="<?php echo base_url() ?>public/datatable/dataTables.select.min.js"></script>
<script>
	$(document).ready(function() {
		$.fn.DataTable.ext.pager.numbers_length = 10;
	 });
	
  const table = $('#na_datatable').DataTable({
    "ordering": false,
    "processing": true,
   "serverSide": true,
    "pageLength": 10, // new addings
    "ajax": "<?= base_url('admin/dt-payment') ?>",
    initComplete: function() {
      $('#na_datatable_filter').css({
        'display': 'flex',
        'justify-content': 'flex-end'
      })

      this.api().columns().every(function() {
        var column = this;
        const dataTableHeader = $(column.header()).text().trim();

      });
    },
  });

</script>
<?= $this->endSection(); ?>