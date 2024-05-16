<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="row" style="display:flex;flex-direction:row;align-items:center;height:100vh;justify-content:center">
  <img src="<?php echo base_url() . 'public/aedno.png' ?>" style="width:300px;" />
  <div class="card" style="max-width:500px;padding:20px;margin:auto">
    <form action=<?php echo base_url() . "/auth/login-check"; ?> method="POST" style="max-width:100%">
      <h1 style="text-align: center;">Login</h1>
      <div class="mb-3">

        <label for="exampleFormControlInput1" class="form-label">Username</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Username" name="username">
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Password</label>
        <input type="password" class="form-control" id="exampleFormControlInput1" placeholder="Password" name="password">
      </div>
      <?php 
        if($status != NULL){
          if($status == "incorrectpassword"){
            echo '<div class="alert alert-danger" role="alert">
            Password is Incorrect
          </div>';
          }else{
            echo '<div class="alert alert-danger" role="alert">
            Incorrect Username
          </div>';
          }
        }
      ?>
      
      <button class="btn btn-primary" style="width:120px">Login</button>
    </form>
  </div>
</div>

<?= $this->endSection(); ?>