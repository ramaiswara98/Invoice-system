<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>

   <h1>Branch</h1>
   <a href="<?= base_url()?>admin/create-branch" class="btn btn-primary"> Create Branch</a>
   <hr/>
   <table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Branch Name</th>
      <th scope="col">Email</th>
      <th scope="col">Address</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($branch as $b){
      echo '<tr>';
      echo '<th scope="row">'.$b['id'].'</th>';
      echo '<td>'.$b['branch_name'].'</td>';
      echo '<td>'.$b['email'].'</td>';
      echo '<td>'.$b['address'].'</td>';
      echo "<td><a href='" . base_url() . "admin/edit-branch/" . $b['id'] . "' type='button' class='btn btn-warning' style='margin-right:10px;margin-left:10px'><i class='fa-solid fa-pen-to-square'></i></a><a href='" . base_url() . "admin/delete-branch/" . $b['id'] . "' type='button' class='btn btn-danger'><i class='fa-solid fa-trash'></i></a></td>";
      echo '</tr>';
   } ?>

    
  </tbody>
</table>
</div>

<?= $this->endSection();?>
