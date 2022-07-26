<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
<?php require_once('inc/header.php') ?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
  $(function(){
    alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
  })
</script>
<?php endif;?>
  <script>
    start_loader()
  </script>
  <style>
    body{
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size:cover;
      background-repeat:no-repeat;
      backdrop-filter: brightness(.85);
    }
    #page-title{
      color: #fff4f4 !important;
      text-shadow: 3px 3px 7px #000
    }
    #sys-logo{
      height:15rem;
      width:15rem;
      object-fit:cover;
      object-position:center center;
    }
  </style>
  <img src="<?= validate_image($_settings->info('logo')) ?>" alt="" id="sys-logo" class="img-thumbnail img-circle rounded-circle border border-4">
  <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo $_settings->info('name') ?></b></h1>
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary my-2 rounded-0 shadow">
    <div class="card-body">
      <p class="login-box-msg">Please enter your credentials</p>
      <form id="rlogin-form" action="" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" autofocus placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="row">

          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat btn-sm">Sign In</button>
          </div>
          
          <div class="col-12 text-center">
              <a href="./register.php">Create an Account</a>
          </div>
        </div>
       
      </form>
      <!-- /.social-auth-links -->

       <p class="mb-1">
        <a href="./forgotted password">I forgot my password</a>
      </p> 
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>