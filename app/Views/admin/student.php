<?= $this->extend('layout/admintemplate'); ?>

<?= $this->section('content'); ?>
<div>
<meta name="csrf-token" content="<?php echo csrf_token(); ?>">
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

  <!-- Modal Class-->
  <div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Student Atendance</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <table class="table table-bordered table-striped" width="100%">
    <thead>
      <tr>
        <th scope="col">Invoice No</th>
        <th scope="col">Class Name</th>
        <th scope="col">Attendance</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody id="class-table-body">
    
       <p id="load">Loading...</p>
      
     
    
    </tbody>
      </table>
   
      </div>
     
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Attendance</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="historyBody">
        Loading..
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

</div>
<script src="<?php echo base_url() ?>public/datatable/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>public/datatable/dataTables.bootstrap4.js"></script>
<script src="<?php echo base_url() ?>public/datatable/dataTables.select.min.js"></script>
<script>
  function getCurrentDateTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }
  async function openClass(id){
    console.log(id);
    var dates = getCurrentDateTime();
    var tbody = document.getElementById('class-table-body');
    var load = document.getElementById('load');
    var base_url = "<?php echo base_url();?>";
    var response = await fetch(base_url+'admin/get-class/'+id, {method:'GET'});
    if(response.ok){
      const jsonData = await response.json(); // Parse response as JSON
      const attendance = jsonData.attendance;
      var content = "";
      if(attendance.length > 0){
        for(let i=0;i<attendance.length;i++){
          if((attendance[i].require_attendance - attendance[i].attendance_total) != 1 && (attendance[i].require_attendance - attendance[i].attendance_total) != 0 ){
            var item = "<tr><td>" + attendance[i].invoice_no + "</td><td>" + attendance[i].class_name + "</td><td>" + attendance[i].attendance_total + "/" + attendance[i].require_attendance + "</td><td style='display:flex'><div style='max-width:250px;margin-right:10px' class='input-group'><input class='form-control' type='datetime-local' value='"+dates+"' id='"+attendance[i].items_id+"'></input><button class='btn btn-primary' onclick='sendAttendance("+attendance[i].items_id+","+attendance[i].student_id+")'><i class='fa-solid fa-user-plus'></i></button> </div> <button onclick='getAttendance(" + attendance[i].items_id + ", \"" + attendance[i].student_name.replace(/"/g, '\\"') + "\")' class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#historyModal'><i class='fa-solid fa-clock-rotate-left'></i></button></td></tr>";
          }else{
            if((attendance[i].require_attendance - attendance[i].attendance_total) == 0){
              var item = "<tr><td>"+attendance[i].invoice_no+"</td><td>"+attendance[i].class_name+"</td><td>"+attendance[i].attendance_total+"/"+attendance[i].require_attendance+"</td><td><button disabled class='btn btn-primary' onclick='sendAttendance("+attendance[i].items_id+","+attendance[i].student_id+")'><i class='fa-solid fa-user-plus'></i></button> <button onclick='getAttendance(" + attendance[i].items_id + ", \"" + attendance[i].student_name.replace(/"/g, '\\"') + "\")' class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#historyModal'><i class='fa-solid fa-clock-rotate-left'></i></button><a href='"+base_url+"admin/create-payment?student-id="+attendance[i].student_id+"' class='btn btn-success' style='margin-left:10px'><i class='fa-solid fa-file-circle-plus'></i></a></td></tr>"
            }else{
              var item = "<tr><td>"+attendance[i].invoice_no+"</td><td>"+attendance[i].class_name+"</td><td>"+attendance[i].attendance_total+"/"+attendance[i].require_attendance+"</td><td style='display:flex'><div style='max-width:250px;margin-right:10px' class='input-group'><input class='form-control' type='datetime-local' value='"+dates+"' id='"+attendance[i].items_id+"'></input><button class='btn btn-primary' onclick='sendAttendance("+attendance[i].items_id+","+attendance[i].student_id+")'><i class='fa-solid fa-user-plus'></i></button> </div><button onclick='getAttendance(" + attendance[i].items_id + ", \"" + attendance[i].student_name.replace(/"/g, '\\"') + "\")' class='btn btn-secondary' data-bs-toggle='modal' data-bs-target='#historyModal'><i class='fa-solid fa-clock-rotate-left'></i></button><a href='"+base_url+"admin/create-payment?student-id="+attendance[i].student_id+"' class='btn btn-success' style='margin-left:10px'><i class='fa-solid fa-file-circle-plus'></i></a></td></tr>"
            }

          }
          content = content+item
        }
        tbody.innerHTML = content;
        load.style.display = "none";
      }
    }else{
    }
  }

  function getOurDate(date){
    const currentDate = new Date(date);

    // Get the current year, month, day, hours, and minutes
    const year = currentDate.getFullYear().toString(); // Get last two digits of the year
    const month = currentDate.getMonth() + 1; // Month is zero-indexed, so add 1
    const day = currentDate.getDate();
    const hours = currentDate.getHours();
    const minutes = currentDate.getMinutes();

    // Format the date as desired
    const formattedDate = `${day < 10 ? '0' + day : day}-${month < 10 ? '0' + month : month}-${year} ${hours < 10 ? '0' + hours : hours}:${minutes < 10 ? '0' + minutes : minutes}`;
    return formattedDate;
  }
  async function sendAttendance(items_id,student_id){
    const dateElement = document.getElementById(items_id);
    const dates = getOurDate(dateElement.value);
    const data = {
      items_id,
      items_date:dates,
      user_id:<?php echo $session->get('id');?>
    }
    var base_url = "<?php echo base_url();?>";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const response = await fetch(base_url+'admin/add-attendance-api',{
      method:'POST',
      headers:{
        'Content-Type':'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body:JSON.stringify(data)
    });

    if(response.ok){
      console.log(await response.json());
      openClass(student_id);
    }else{
      console.log('something wrong')
    }
  }

  async function deleteAttendance(id,iId,name){
    var base_url = "<?php echo base_url();?>";
    var response =  await fetch(base_url+'admin/delete-attendance/'+id,{
      method:'GET'
    });
    if(response.ok){
      const jsonData = await response.json();
      console.log(jsonData);
      if(jsonData.success){
        getAttendance(iId,name);
      }
    }else{
      
    }
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
                const modalBody = document.getElementById('historyBody'); // Access the first element with class "modal-body"
                const content = "<table class='table table-striped table-hover'><tr><th>Attendance Date</th><th>Attendance Mark By</th><th>Action</th></tr>";
                var contents="";
                for(let i=0;i< attendance.length;i++){
                    // var items = "<tr><td>"+attendance[i].items_date+"</td><td>"+attendance[i].user_name+"</td><td><button class='btn btn-danger' onClick='deleteAttendance("+attendance[i].id+","+id+","+name+")'><i class='fa-solid fa-trash'></i></button></td></tr>"
                    var items = 
                "<tr>" +
                  "<td>" + attendance[i].items_date + "</td>" +
                  "<td>" + attendance[i].user_name + "</td>" +
                  "<td>" +
                    "<button class='btn btn-danger' onClick='deleteAttendance(" + attendance[i].id + ",\"" + id + "\",\"" + name + "\")'>" +
                      "<i class='fa-solid fa-trash'></i>" +
                    "</button>" +
                  "</td>" +
                "</tr>";

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