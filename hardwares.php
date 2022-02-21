<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CCVS | Inventory</title>
  <?php 
  session_start();
  include_once 'db_include.php';
  if(!$_SESSION['name']) header("Location: login.php");

  $sql = "SELECT * FROM `product_tbl` where product_type = 'Hardware'";
  $result = mysqli_query($conn,$sql);
  $resultCheck = mysqli_num_rows($result);
  $notif = '';

  if(isset($_POST["addsubmit"]))
  {
    $hname = $_POST["hname"];
    $htype = $_POST["htype"];
    $hprice = $_POST["hprice"];
    $hdesc = $_POST["hdesc"];
    $hquantity = $_POST["hquantity"];
    $sqladdh = "INSERT INTO `product_tbl` (`product_id`, `name`, `product_type`, `juice_type`, `hardware_type`, `description`, `price`, `qty`, `status`) VALUES (NULL, '$hname', 'Hardware', '', '$htype', '$hdesc', '$hprice', '$hquantity', 'Available');";
    $resultaddh = mysqli_query($conn,$sqladdh);
    header("Location: hardwares.php?result=Success");
  }
  if(isset($_POST["updatesubmit"]))
  { 
    $hid=$_POST["hid"];
    $hname = $_POST["hname"];
    $htype = $_POST["htype"];
    $hprice = $_POST["hprice"];
    $hdesc = $_POST["hdesc"];
    $hquantity = $_POST["hquantity"];

    $sqlupdateh = "UPDATE `product_tbl` SET `name` = '$hname', `hardware_type` = '$htype', `description` = '$hdesc', `price` = '$hprice', `qty` = '$hquantity' WHERE `product_tbl`.`product_id` = $hid;";
    $resultupdateh = mysqli_query($conn,$sqlupdateh);
    header("Location: hardwares.php?result=Updated");
  }
  if(isset($_POST["submitdel"]))
  { 
    $hid=$_POST["hid"];
    $sqldelh = "DELETE FROM `product_tbl` WHERE `product_tbl`.`product_id` = $hid";
    $resultdelh = mysqli_query($conn,$sqldelh);
    header("Location: hardwares.php?result=Deleted");
  }
  

  if(isset($_GET['result'])) {
    $notif = $_GET['result'];
  }
  $sqlmodal = "SELECT * FROM `product_tbl` where product_type = 'Hardware'";
  $resultmodal = mysqli_query($conn,$sqlmodal);
  $resultCheckmodal = mysqli_num_rows($resultmodal);
  ?>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="Bootstrap/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="Bootstrap/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="Bootstrap/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="Bootstrap/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="Bootstrap/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="Bootstrap/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="Bootstrap/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="Bootstrap/plugins/summernote/summernote-bs4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="Bootstrap/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="Bootstrap/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="Bootstrap/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="Bootstrap/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="Bootstrap/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="Bootstrap/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="Bootstrap/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="Bootstrap/plugins/dropzone/min/dropzone.min.css">
  
  <link rel="icon" href="assets/ccvs_logo.png" type="image/gif" sizes="16x16">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php?logout=success" role="button">
        <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="assets/ccvs_logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Cloud Chase</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="assets/profile_icon.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['name']; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <!-- <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Widgets
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li> -->
          
          
          
          <!-- <li class="nav-header">EXAMPLES</li> -->
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <!-- <span class="badge badge-info right">2</span> -->
              </p>
            </a>
          </li>
          <!-- menu-open -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                Inventory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="hardwares.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hardwares</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="juices.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Juices</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="accessories.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Accessories</p>
                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="customers.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customers
                <!-- <span class="badge badge-info right">2</span> -->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/calendar.html" class="nav-link">
              <i class="nav-icon ion ion-bag"></i>
              <p>
                Orders
                <!-- <span class="badge badge-info right">2</span> -->
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        <?php
          if($notif=='Success')
          {
            echo "<div class='alert alert-success alert-dismissible col-sm-3'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='icon fas fa-check'></i> Alert!</h5>
            Hardware Successfully Added!
          </div>";
          }
          if($notif=='Updated')
          {
            echo "<div class='alert alert-warning alert-dismissible col-sm-3'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='icon fas fa-check'></i> Alert!</h5>
            Hardware Successfully Updated!
          </div>";
          }
          if($notif=='Deleted')
          {
            echo "<div class='alert alert-danger alert-dismissible col-sm-3'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='icon fas fa-check'></i> Alert!</h5>
            Hardware Successfully Deleted!
          </div>";
          }
        ?>
                
         <div class='col-sm-6'>
        </div>
          <!-- /.col -->
          <div class="col-sm-12 float-sm-right">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inventory</a></li>
              <li class="breadcrumb-item active">Hardwares</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    
      <div class="container-fluid">
        
      <div class="card">
              <div class="card-header ">
                <h3 class="card-title">List of Hardwares</h3>
                <span class="float-sm-right"><button type="button" class="btn btn-success btn-block" data-toggle='modal' data-target='#modal-add'><i class="fa fa-plus"></i> Add New Hardwares</button></span>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body">
                
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Hardware Name</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                <?php
                if($resultCheck > 0 )
                while ($row = mysqli_fetch_array($result))
                {
                  $updatemod = '#update-'.$row['product_id'];
                  $deletemod = '#delete-'.$row['product_id'];
                    $price = number_format($row['price'], 2, '.', '');
                    echo "
                    <tr>
                        <td>$row[name]</td>
                        <td>$row[hardware_type]</td>
                        <td>$row[description]</td>
                        <td>&#8369 $price</td>
                        <td>$row[qty]</td>
                        <td>
                        <center>
                            
                            </button>
                            <button class='btn bg-gradient-warning' data-toggle='modal' data-target='$updatemod'>
                                <i class='fas fa-edit'></i> 
                            </button>
                            <button class='btn bg-gradient-danger' data-toggle='modal' data-target='$deletemod'>
                                <i class='fas fa-trash'></i> 
                            </button>
                        </center>
                        </td>
                    </tr>
                    ";
                }
                ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="modal-view">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title text-success"><i class='fas fa-info-circle'></i> View Hardware Info</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

    <?php
    if($resultCheckmodal > 0 )
    while ($row = mysqli_fetch_array($resultmodal))
    {
      $updatemod = 'update-'.$row['product_id'];
      $deletemod = 'delete-'.$row['product_id'];
      echo "
      <div class='modal fade' id='$updatemod'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header  text-warning'>
            <h4 class='modal-title'><i class='fas fa-edit'></i> Update Hardware Info $updatemod</h4>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
          <form method='post'>
            <div class='row'>
              <label class='col-4'>Hardware Name:</label> 
              <input type='text' class='form-control col-8  mb-2' hidden name='hid' value='$row[product_id]'>
              <input type='text' class='form-control col-8  mb-2' name='hname' value='$row[name]'>
              <label class='col-4'>Hardware Type:</label>";
              ?>
              <select class='form-control col-8 mb-2' name='htype'>
                      <option value='MOD' <?php if($row['hardware_type']=='MOD') echo 'selected'; ?> >- MOD</option>
                      <option value='AUTOMIZERS' <?php if($row['hardware_type']=='AUTOMIZERS')  echo 'selected'; ?>>- AUTOMIZERS</option>
                      <option value='PODS' <?php if($row['hardware_type']=='PODS')  echo 'selected'; ?>>- PODS</option>
                      <option value='OCC & RBA' <?php if($row['hardware_type']=='OCC & RBA')  echo 'selected'; ?>>- OCC & RBA</option>
                      <option value='BATTERY & CHARGERS' <?php if($row['hardware_type']=='BATTERY & CHARGERS') echo 'selected'; ?>>- BATTERY & CHARGERS</option>
                      <option value='WIRES & COTTONS' <?php if($row['hardware_type']=='WIRES & COTTONS') echo 'selected'; ?>>- WIRES & COTTONS</option>
                    </select>
              <?php echo "
                    <label class='col-4'>Description:</label>
              <textarea class='form-control col-8 mb-3' name='hdesc'>$row[description]
              </textarea>
              <label class='col-4'>Hardware Price:</label> 
              <input type='text' class='form-control col-8  mb-2' name='hprice' placeholder='&#8369 0.00' value='$row[price]'>
              <label class='col-4'>Hardware Quantity:</label> 
              <input type='number' class='form-control col-8  mb-2' name='hquantity' value='$row[qty]'>
            </div>
          </div>
          <div class='modal-footer justify-content-between'>
            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button> 
            <button type='submit' name='updatesubmit' class='btn btn-warning'><i class='fas fa-edit'></i> Update</button>
          </div>
        </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <form method='post'>
    <div class='modal fade' id='$deletemod'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header  text-danger'>
            <h4 class='modal-title'><i class='fas fa-trash'></i> Delete Hardware Info</h4>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
          <input type='text' class='form-control col-8  mb-2' hidden name='hid' value='$row[product_id]'>
            <p>Are you sure you want to DELETE this Hardware <span class='text-danger'>$row[name]</span>?</p>
          </div>
          <div class='modal-footer justify-content-between'>
            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
            <button type='submit' name='submitdel' class='btn btn-danger'><i class='fas fa-trash'></i> Delete</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    </form>
    <!-- /.modal -->
      ";
    }
    ?>

     
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header  text-success">
              <h4 class="modal-title "><i class='fas fa-plus'></i> Add New Hardware</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="post">
              <div class="row">
                <label class="col-4">Hardware Name:</label> 
                <input type="text" class="form-control col-8  mb-2" name='hname'>
                <label class="col-4">Hardware Type:</label>
                <select class="form-control col-8 mb-2" name='htype'>
                        <option selected="selected" value="">--Select Type--</option>
                        <option value='MOD'>- MOD</option>
                        <option value='AUTOMIZERS'>- AUTOMIZERS</option>
                        <option value='PODS'>- PODS</option>
                        <option value='OCC & RBA'>- OCC & RBA</option>
                        <option value='BATTERY & CHARGERS'>- BATTERY & CHARGERS</option>
                        <option value='WIRES & COTTONS'>- WIRES & COTTONS</option>
                      </select>
                      <label class="col-4">Description:</label>
                <textarea class="form-control col-8 mb-3" name="hdesc">
                </textarea>
                <label class="col-4">Hardware Price:</label> 
                <input type="text" class="form-control col-8  mb-2" name='hprice' placeholder="&#8369 0.00">
                <label class="col-4">Hardware Quantity:</label> 
                <input type="number" class="form-control col-8  mb-2" name='hquantity'>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
              <button type="submit" name='addsubmit' class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->  
      

  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0-rc
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="Bootstrap/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="Bootstrap/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="Bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="Bootstrap/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="Bootstrap/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="Bootstrap/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="Bootstrap/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="Bootstrap/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="Bootstrap/plugins/moment/moment.min.js"></script>
<script src="Bootstrap/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="Bootstrap/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="Bootstrap/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="Bootstrap/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="Bootstrap/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="Bootstrap/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="Bootstrap/dist/js/pages/dashboard.js"></script>
<!-- DataTables  & Plugins -->
<script src="Bootstrap/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="Bootstrap/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="Bootstrap/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="Bootstrap/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="Bootstrap/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="Bootstrap/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="Bootstrap/plugins/jszip/jszip.min.js"></script>
<script src="Bootstrap/plugins/pdfmake/pdfmake.min.js"></script>
<script src="Bootstrap/plugins/pdfmake/vfs_fonts.js"></script>
<script src="Bootstrap/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="Bootstrap/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="Bootstrap/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- InputMask -->
<script src="Bootstrap/plugins/moment/moment.min.js"></script>
<script src="Bootstrap/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- Select2 -->
<script src="Bootstrap/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="Bootstrap/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
    }).container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  });

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false;

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template");
  previewNode.id = "";
  var previewTemplate = previewNode.parentNode.innerHTML;
  previewNode.parentNode.removeChild(previewNode);

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  });

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
  });

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
  });

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1";
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
  });

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0";
  });

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
  };
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true);
  };
  // DropzoneJS Demo Code End
</script>
</body>
</html>
