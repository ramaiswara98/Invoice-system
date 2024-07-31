<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
   <h1>Class</h1>
   <a href="<?= base_url()?>admin/create-class" class="btn btn-primary"> Create Class</a>
   <table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Class Name</th>
      <th scope="col">Price</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($class as $c){
      echo '<tr>';
      echo '<th scope="row">'.$c->class_id.'</th>';
      echo '<td>'.$c->class_name.'</td>';
      echo '<td>'.$c->code." ".$c->price.'</td>';
      echo "<td><a href='" . base_url() . "admin/edit-class/" . $c->class_id . "' type='button' class='btn btn-warning' style='margin-right:10px;margin-left:10px'><i class='fa-solid fa-pen-to-square'></i></a><a href='" . base_url() . "admin/delete-class/" . $c->class_id . "' type='button' class='btn btn-danger'><i class='fa-solid fa-trash'></i></a></td>";
      echo '</tr>';
   } ?>

    
  </tbody>
</table>
</div>

<?= $this->endSection();?>
