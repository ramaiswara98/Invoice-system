<?= $this->extend('layout/admintemplate');?>

<?= $this->section('content');?>
<div>
  <div style="display: flex; flex-directio:row; justify-content:space-between;align-items:center">
  <h1>Attendance</h1>
   <p style="margin: 0px;"><i class="fa-solid fa-calendar-days"></i> <?php echo date("d/m/Y", time());?></p>
  </div>
   <table class="table table-striped table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Student Name</th>
      <th scope="col">Register Date</th>
      <th scope="col">Attendance</th>
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
      echo '<td>'.$it->date.'</td>';
      echo '<td>'.$it->attendance_total."/".$it->qty.'</td>';
      if($it->attendance_total < $it->qty){
        if(($it->qty - $it->attendance_total) == 1 ){
          echo '<td><button class="btn btn-primary" onclick="submitForm(' . $it->items_id . ')"><i class="fa-solid fa-user-plus"></i></button> <button onclick="getAttendance(' . $it->items_id . ', \'' . $it->name . '\')" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-clock-rotate-left"></i></button><a href="'.base_url().'admin/create-payment?student-id='.$it->student_id.'" class="btn btn-success" style="margin-left:5px"><i class="fa-solid fa-file-circle-plus"></i></a></td>'; 
        }else{
          echo '<td><button class="btn btn-primary" onclick="submitForm(' . $it->items_id . ')"><i class="fa-solid fa-user-plus"></i></button> <button onclick="getAttendance(' . $it->items_id . ', \'' . $it->name . '\')" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-clock-rotate-left"></i></button></td>'; 
        }

    }else{
      echo '<td><button disabled class="btn btn-primary" onclick="submitForm(' . $it->items_id . ')"><i class="fa-solid fa-user-plus"></i></button> <button onclick="getAttendance(' . $it->items_id . ', \'' . $it->name . '\')" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-clock-rotate-left"></i></button><a href="'.base_url().'admin/create-payment?student-id='.$it->student_id.'" class="btn btn-success" style="margin-left:5px"><i class="fa-solid fa-file-circle-plus"></i></a></td>'; 
      }
    //   echo "<td><a href='" . base_url() . "admin/edit-class/" . $c->class_id . "' type='button' class='btn btn-warning' style='margin-right:10px;margin-left:10px'><i class='fa-solid fa-pen-to-square'></i></a><a href='" . base_url() . "admin/delete-class/" . $c->class_id . "' type='button' class='btn btn-danger'><i class='fa-solid fa-trash'></i></a></td>";
      echo '</tr>';
   } ?>

    
  </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Loading..
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<form method="POST" action="<?php echo base_url();?>admin/add-attendance" id="addForm">
<?= csrf_field(); ?>
<input type="hidden" name="items_id" id="items_id"/>
<input type="hidden" name="items_date" id="items_date"/>
<input type="hidden" name="class_id" value="<?php echo $class_id;?>"/>
<input type="hidden" name="user_id" value="<?php echo $session->get('id');?>"/>
</form>
</div>

<script>
    function submitForm($id){
        const formId = document.getElementById('items_id');
        const formDate = document.getElementById('items_date');
        const form = document.getElementById("addForm");
        formId.value = $id;
        const dates = getOurDate();
        formDate.value = dates;
        console.log(formId.value);
        console.log(formDate.value);
        form.submit();
    }

    function getOurDate(){
    const currentDate = new Date();

    // Get the current year, month, day, hours, and minutes
    const year = currentDate.getFullYear().toString().slice(-2); // Get last two digits of the year
    const month = currentDate.getMonth() + 1; // Month is zero-indexed, so add 1
    const day = currentDate.getDate();
    const hours = currentDate.getHours();
    const minutes = currentDate.getMinutes();

    // Format the date as desired
    const formattedDate = `${day < 10 ? '0' + day : day}-${month < 10 ? '0' + month : month}-${year} ${hours < 10 ? '0' + hours : hours}:${minutes < 10 ? '0' + minutes : minutes}`;
    return formattedDate;
}

async function getAttendance(id, name){
    var title = document.getElementById('exampleModalLabel');
    title.innerHTML=name;
   
    var base_url = "<?php echo base_url();?>";
    console.log(base_url+'admin/get-attendance/'+id);
    try {
    var response = await fetch(base_url+'admin/get-attendance/'+id, {
                method: 'GET'
            });
            if (response.ok) {
                const jsonData = await response.json(); // Parse response as JSON
                const attendance = jsonData.attendance;
                const modalBody = document.getElementsByClassName("modal-body")[0]; // Access the first element with class "modal-body"
                const content = "<table class='table table-striped table-hover'><tr><th>Attendance Date</th><th>Attendance Mark By</th></tr>";
                var contents="";
                for(let i=0;i< attendance.length;i++){
                    var items = "<tr><td>"+attendance[i].items_date+"</td><td>"+attendance[i].user_name+"</td></tr>"
                    contents = contents+items;
                }
                const content3 = "</table>";
                modalBody.innerHTML = content+contents+content3;
                console.log(modalBody);
            } else {
                console.error('Error sending PDF to server1:', response);
            }
        } catch (error) {
            console.error('Error sending PDF to server:', error);
        }
}

</script>

<?= $this->endSection();?>
