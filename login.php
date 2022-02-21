<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cloud Chase | Log in</title>
  <?php 
  session_start();
  include_once 'db_include.php';
  if(isset($_GET['notif'])){  
    $notif = $_GET['notif'];                             
  }
  else 
  $notif ='';
  ?>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="Bootstrap/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="Bootstrap/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="Bootstrap/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page" >
<div class="login-box">
  
  <!-- /.login-logo -->
  <div class="card">
  <div class="login-logo"  style="background-color: #25D2C3;">
    <b>Chasing Clouds</b> 
  </div>
    <div class="card-body login-card-body">
        <center><img src="assets/chasing_cloud.png" style="width: 50%;"  alt='Cloud Chase Logo'></center>
        <br>
      <p class="login-box-msg">Sign in to start your session</p>
      <?php
        if(isset($_POST["register"]))
        {
            $username= $_POST['username'];
            $password= $_POST['password'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $bday = $_POST['bday'];
            $address = $_POST['add'];
            $cp_num = $_POST['cp_num'];

            $sql = "INSERT INTO `user_account` (`user_id`, `username`, `password`, `lastname`, `firstname`, `role`, `status`, `birthdate`, `address`, `contact_num`) VALUES (NULL, '$username', '$password', '$lname', '$fname', 'Customer', 'Active', '$bday', '$address', '$cp_num');";
            $result = mysqli_query($conn,$sql);
        }

        if(isset($_POST["login"]))
        {
            $sql = "SELECT * FROM `user_account` WHERE username = '$_POST[username]' AND password = '$_POST[pass]';";
            $result = mysqli_query($conn,$sql);
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck > 0 )
            {
                $now = time();
                $age = 0;
                  
                while ($row = mysqli_fetch_array($result))
                {
                    
                    $birthdate = strtotime($row['birthdate']);
                    while ($now >= ($birthdate = strtotime("+1 YEAR", $birthdate))) {
                      $age++;
                    }
                    if($age>18)
                    {
                      $_SESSION['cust_id'] = $row['user_id'];
                      $_SESSION['name'] = $row['firstname'].' '.$row['lastname'];
                      $_SESSION['username'] = $_POST['username'];
                      $_SESSION['pass'] = $_POST['pass'];
                      $_SESSION['role'] = $row['role'];
                      header("Location: dashboard.php?notif=Hi");
                    }
                    else header("Location: login.php?notif=age");
                }
            }
            else
            {
                header("Location: login.php?notif=error");
            }
        }
      ?>
      <form method="post">
        <div class="input-group mb-3">
                    <div class='alert alert-danger alert-dismissible col-12' <?php if($notif != 'error') echo 'hidden'; ?>>
                        <button type='button' class='close' data-dismiss='alert'   aria-hidden='true'>&times;</button>
                        <h5><i class='icon fa fa-exclamation-circle'></i> Alert!</h5>
                          Invalid Username or Password.
                      </div>
                    <div class='alert alert-success alert-dismissible col-12' <?php if($notif != 'regsuccess') echo 'hidden';  ?>>
                        <button type='button' class='close' data-dismiss='alert'   aria-hidden='true'>&times;</button>
                        <h5><i class='icon fa fa-check-circle'></i> Success!</h5>
                          Account Successfully Added!
                    </div>
                    <div class='alert alert-danger alert-dismissible col-12' <?php if($notif != 'age') echo 'hidden';  ?>>
                        <button type='button' class='close' data-dismiss='alert'   aria-hidden='true'>&times;</button>
                        <h5><i class='icon fa fa-check-circle'></i> Success!</h5>
                          Age Not Valid!
                    </div>
                    

              
          <input type="text" class="form-control" name='username' placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name='pass' placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name='login' class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
     

      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
      </div>
      <p class="mb-0">
        <a href="register.php" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="Bootstrap/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="Bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="Bootstrap/dist/js/adminlte.min.js"></script>
</body>
</html>
