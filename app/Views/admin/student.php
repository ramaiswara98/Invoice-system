<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
   <h1>Student</h1>
   <a href="<?= base_url()?>admin/create-student" class="btn btn-primary"> Create Student</a>
   <table class="table table-striped table-hover">
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
  <?php foreach($student as $s){
      echo '<tr>';
      echo '<th scope="row">'.$s->student_id.'</th>';
      echo '<td>'.$s->name.'</td>';
      echo '<td>'.$s->email.'</td>';
      echo '<td>'.$s->school.'</td>';
      echo '<td>'.$s->grade.'</td>';
      echo '<td>'.$s->address.'</td>';
      echo '<td>'.$s->branch_name.'</td>';
      echo "<td><a href='" . base_url() . "admin/edit-student/" . $s->student_id . "' type='button' class='btn btn-warning' style='margin-right:10px;margin-left:10px'><i class='fa-solid fa-pen-to-square'></i></a><a href='" . base_url() . "admin/delete-student/" . $s->student_id . "' type='button' class='btn btn-danger'><i class='fa-solid fa-trash'></i></a></td>";
      echo '</tr>';
   } ?>

    
  </tbody>
</table>
</div>

<?= $this->endSection();?>
