<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
   <h1>Tuition</h1>
   <button class="btn btn-primary"> Create Branch</button>
   <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Tuition Type</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($tuition as $t){
      echo '<tr>';
      echo '<th scope="row">'.$t['id'].'</th>';
      echo '<td>'.$t['tuition_type'].'</td>';
      echo '<td><button class="btn btn-primary">Edit</button><button class="btn btn-danger">Delete</button></td>';
      echo '</tr>';
   } ?>

    
  </tbody>
</table>
</div>

<?= $this->endSection();?>
