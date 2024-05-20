<?= $this->extend('layout/admintemplate'); ?>

<?= $this->section('content'); ?>
<div>
  <?php
  if ($session->getFlashdata('error') != '') {
  ?>
    <div class="alert alert-danger" role="alert">
      <?= $session->getFlashdata('error') ?>
    </div>
  <?php
  }
  ?>
  <?php
  if ($session->getFlashdata('success') != '') {
  ?>
    <div class="alert alert-success" role="alert">
      <?= $session->getFlashdata('success') ?>
    </div>
  <?php
  }
  ?>
  <h1>Student</h1>
  <a href="<?= base_url() ?>admin/create-student" class="btn btn-primary"> Create Student</a>
  <a href="#" class="btn btn-primary" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false"> Import Student <i class="fa-solid fa-chevron-down"></i></a>
  <div class="dropdown">
    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
      <li><a class="dropdown-item" href="<?php echo base_url();?>public/aedno.xlsx"> <i class="fa-solid fa-file-arrow-down"></i> Download Format</a></li>
      <li>
        <hr class="dropdown-divider">
      </li>
      <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="fa-solid fa-file-arrow-up"></i> Upload File</a></li>
    </ul>
  </div>
  <br/>
  <table id="na_datatable" class="table table-bordered table-striped" width="100%">
    <thead>
      <tr>
      <th scope="col">#</th>
        <th scope="col">Full name</th>
        <th scope="col">Email</th>
        <th scope="col">School</th>
        <!-- <th scope="col">Previous Grade</th> -->
        <!-- <th scope="col">Address</th> -->
        <th scope="col">Branch</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  <!-- <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Full name</th>
        <th scope="col">Email</th>
        <th scope="col">School</th>
        <th scope="col">Previous Grade</th>
        <th scope="col">Address</th>
        <th scope="col">Branch</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($student as $s) {
        echo '<tr>';
        echo '<th scope="row">' . $s->student_id . '</th>';
        echo '<td>' . $s->name . '</td>';
        echo '<td>' . $s->email . '</td>';
        echo '<td>' . $s->school . '</td>';
        echo '<td>' . $s->grade . '</td>';
        echo '<td>' . $s->address . '</td>';
        echo '<td>' . $s->branch_name . '</td>';
        echo "<td><a href='" . base_url() . "admin/edit-student/" . $s->student_id . "' type='button' class='btn btn-warning' style='margin-right:10px;margin-left:10px'><i class='fa-solid fa-pen-to-square'></i></a><a href='" . base_url() . "admin/delete-student/" . $s->student_id . "' type='button' class='btn btn-danger'><i class='fa-solid fa-trash'></i></a></td>";
        echo '</tr>';
      } ?>


    </tbody>
  </table> -->

  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="<?php echo base_url();?>/admin/get-imported-student" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    <?= csrf_field(); ?>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">File</label>
            <input type="file" class="form-control" id="exampleFormControlInput1" placeholder="Excel File" name="student" required>
        </div>
        <!-- <button class="btn btn-primary" type="submit">Import File</button> -->

      </div>
      <div class="modal-footer">
        <button  class="btn btn-primary" type="submit">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
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
    "ajax": "<?= base_url('admin/dt-student') ?>",
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