<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
   <h1>Currency</h1>
   <a class="btn btn-primary" href="<?= base_url()."admin/create-currency" ?>"> Create Currency</a>
   <table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Currency</th>
      <th scope="col">Currency Code</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($currency as $c){
      echo '<tr>';
      echo '<th scope="row">'.$c['id'].'</th>';
      echo '<td>'.$c['name'].'</td>';
      echo '<td>'.$c['code'].'</td>';
      echo "<td><button type='button' class='btn btn-warning' style='margin-right:10px;margin-left:10px'><i class='fa-solid fa-pen-to-square'></i></button><a href='" . base_url() . "admin/delete-currency/" . $c['id'] . "' type='button' class='btn btn-danger'><i class='fa-solid fa-trash'></i></a></td>";
      echo '</tr>';
   } ?>

    
  </tbody>
</table>
</div>

<?= $this->endSection();?>
