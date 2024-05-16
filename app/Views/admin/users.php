<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
   <h1>Users</h1>
   <a href="<?= base_url().'admin/create-users';?>" class="btn btn-primary"> Create Users</a>
   <table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Full name</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Role</th>
      <th scope="col">Branch</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($users as $u){
      echo '<tr>';
      echo '<th scope="row">'.$u->user_id.'</th>';
      echo '<td>'.$u->name.'</td>';
      echo '<td>'.$u->username.'</td>';
      echo '<td>'.$u->user_email.'</td>';
      if($u->role == '1'){
        echo '<td>Super Admin</td>';
      }else if($u->role == '2'){
        echo '<td>Branch Admin</td>';
      }else{
        echo '<td>Teacher</td>';
      }
      // echo '<td>'.$u->role.'</td>';
      echo '<td>'.$u->branch_name.'</td>';
          
      echo '<td>
        <a href="' . base_url() . '/admin/edit-users/' . $u->user_id . '" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
        <form style="display:inline" action="' . base_url('admin/delete-users') . '" method="POST">
          <input type="hidden" name="id" value="' . $u->user_id . '"/>
          <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
        </form>
      </td>';



      //echo '<td><form></form><button class="btn btn-primary">Edit</button><button class="btn btn-danger">Delete</button></td>';
      echo '</tr>';
   } ?>

    
  </tbody>
</table>
</div>

<?= $this->endSection();?>
