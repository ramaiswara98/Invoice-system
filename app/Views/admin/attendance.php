<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
  <div style="display: flex; flex-directio:row; justify-content:space-between;align-items:center">
  <h1>Attendance</h1>
  </div>
  <div class="mt-3 mb-3">
    <form>
      <div style="display: flex; flex-direction:row;gap:50px;width:300px">
        <input type="date" name="datenow" id="dating" value="<?=$datenow;?>" class="form-control"/>
        <button class="btn btn-primary" onclick="tries()" type="button">Show</button>
      </div>
    </form>
  </div>
   <table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Student Name</th>
      <th scope="col">Class</th>
      <th scope="col">Attendance Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php 
    $count= 0;
  foreach($items as $it){
    $count++;
      echo '<tr>';
      echo '<th scope="row">'.$count.'</th>';
      echo '<td>'.$it->name.'</td>';
      echo '<td>'.$it->class_name.'</td>';
      echo '<td>'.$it->items_date.'</td>';
      echo '<td>'.$it->items_date.'</td>';
      echo '<td><button class="btn btn-danger" onclick="deleteAttendance('.$it->attendance_id.')"><i class="fa-solid fa-trash"></i></button></td>';
      echo '</tr>';
   } ?>

    
  </tbody>
</table>


<script>
  function tries(){
    var form = document.getElementById('att-form');
    var date = document.getElementById('dating');
    var datenow = getCurrentDateFormatted(date.value);
    var base = "<?php echo base_url('admin/attendance/'); ?>";
    window.location.href = base+datenow;
    
  }

  function getCurrentDateFormatted(datess) {
    const date = new Date(datess);

    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
    const year = date.getFullYear();

    return `${day}-${month}-${year}`;
}

  async function deleteAttendance(id){
    var base_url = "<?php echo base_url();?>";
    var response =  await fetch(base_url+'admin/delete-attendance/'+id,{
      method:'GET'
    });
    if(response.ok){
      const jsonData = await response.json();
      console.log(jsonData);
      if(jsonData.success){
       window.location.reload();
      }
    }else{
      
    }
  }
</script>

<?= $this->endSection();?>
