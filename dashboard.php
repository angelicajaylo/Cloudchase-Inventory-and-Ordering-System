<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CCVS | Dashboard</title>
  <?php 
  session_start();
  include_once 'db_include.php';
  if(!$_SESSION['name']) header("Location: login.php");
  $sql = "SELECT * FROM `user_account` where `role` = 'customer' ";
  $result = mysqli_query($conn,$sql);
  $resultCheck = mysqli_num_rows($result);
    $total_stocks=0;

  $hardwaresql = "SELECT * FROM `product_tbl` where product_type = 'Hardware'";
  $hardware = mysqli_query($conn,$hardwaresql);
  while ($row = mysqli_fetch_array($hardware))
  {
    $total_stocks += $row['qty'];
  }
  $juicesql = "SELECT * FROM `product_tbl` where product_type = 'Juice'";
  $juice = mysqli_query($conn,$juicesql);
  
  while ($row = mysqli_fetch_array($juice))
  {
    $total_stocks += $row['qty'];
  }
  $accesssql = "SELECT * FROM `product_tbl` where product_type = 'Accessory'";
  $access = mysqli_query($conn,$accesssql);
  while ($row = mysqli_fetch_array($access))
  {
    $total_stocks += $row['qty'];
  }

  $sqlhard = "SELECT * FROM `product_tbl` where product_type = 'Hardware'";
  $resulthard = mysqli_query($conn,$sqlhard);
  $resultCheckhard = mysqli_num_rows($resulthard);

  $sqlacc = "SELECT * FROM `product_tbl` where product_type = 'Accessory'";
  $resultacc = mysqli_query($conn,$sqlacc);
  $resultCheckacc = mysqli_num_rows($resultacc);

  $sqljuices = "SELECT * FROM `product_tbl` where product_type = 'Juice'";
  $resultjuices = mysqli_query($conn,$sqljuices);
  $resultCheckjuices = mysqli_num_rows($resultjuices);

  if(isset($_POST["addsubmit"]))
  {
    $pid = $_POST["pid"];
    $qty = $_POST["qty"];
    $price = 0;
    $name='';

    $sql = "SELECT * FROM `product_tbl`";
    $resultprod = mysqli_query($conn,$sql);
    foreach($resultprod as $row){
      if($_POST['pid'] == $row['product_id'])
      {
        $name = $row['name'];
        $price = $row['price'];
      }
    }
    $sqladdh = "INSERT INTO `punch_logs` (`logs_id`, `product_id`,`prod_name`, `price`, `quantity`, `status`) VALUES (NULL, '$pid', '$name', '$price', '$qty', 'pending');";
    $resultaddh = mysqli_query($conn,$sqladdh);
    header("Location: dashboard.php?result=Success");
  }
  
  if(isset($_POST["reserve_sub"]))
  {
    $cdate = date('Y-m-d');
    $sqlreserve = "INSERT INTO `reservation_tbl` (`reservation_no`, `customer_id`, `product_id`, `name`, `qty`, `price`, `date_reserved`, `status`) VALUES (NULL, '$_SESSION[cust_id]', '$_POST[pid]', '$_POST[pname]', '$_POST[pqty]', '$_POST[pprice]', '$cdate', 'Reserved');";
    $resultres = mysqli_query($conn,$sqlreserve);
    header("Location: dashboard.php?result=Success");
  }


    if(isset($_GET["cancel"]))
    {
      $sqlpnch = "SELECT * FROM `punch_logs` where status = 'pending'";
      $resultpnch = mysqli_query($conn,$sqlpnch);
      foreach($resultpnch as $row)
      {
        $id = $row['logs_id'];
        $sql = "UPDATE `punch_logs` SET `status` = 'cancelled' WHERE `punch_logs`.`logs_id` = $id;";
        $result = mysqli_query($conn,$sql);  
      }
      
    header("Location: dashboard.php?result=Success");
    }

    if(isset($_POST["outsubmit"]))
    {
      $sqlpnch = "SELECT * FROM `punch_logs` where status = 'pending'";
      $resultpnch = mysqli_query($conn,$sqlpnch);
      $sqlproductqty = "SELECT * FROM `product_tbl` where qty >= 1";
      $resulproductqty = mysqli_query($conn,$sqlproductqty);
      foreach($resultpnch as $row)
      {
        $id = $row['logs_id'];
        $prodqty=0;
        foreach($resulproductqty as $row1)
        {
          if ($row['product_id'] == $row1['product_id']) $prodqty = $row1['qty'];
        } 
        $prodqty= $prodqty - $row['quantity'];
        $sqlprod = "UPDATE `product_tbl` SET `qty` = $prodqty WHERE `product_tbl`.`product_id` = $row[product_id];";
        $result = mysqli_query($conn,$sqlprod); 
        $sql = "UPDATE `punch_logs` SET `status` = 'paid' WHERE `punch_logs`.`logs_id` = $id;";
        $result = mysqli_query($conn,$sql);  
      }
      
    header("Location: dashboard.php?result=Success");
    }

    if(isset($_GET["remove"]))
    {
      $log_id=$_GET["remove"];
      $sqlremove = "UPDATE `punch_logs` SET `status` = 'cancelled' WHERE `punch_logs`.`logs_id` = $log_id;";
      $resultremove = mysqli_query($conn,$sqlremove);
    header("Location: dashboard.php?result=Success");
    }

  $sqlproducts = "SELECT * FROM `product_tbl` WHERE qty > 0";
  $resulproducts = mysqli_query($conn,$sqlproducts);
  $resulproductsmod = mysqli_query($conn,$sqlproducts);
  // $resultCheckhard = mysqli_num_rows($resulproducts);
  
  $sqlpunch = "SELECT * FROM `punch_logs` where status='pending'";
  $resultpunch = mysqli_query($conn,$sqlpunch);
  $resultCheckpunch = mysqli_num_rows($resultpunch);

  $sqlpunchmod = "SELECT * FROM `punch_logs` where status='pending'";
  $resultpunchmod = mysqli_query($conn,$sqlpunchmod);
  // $resultCheckpunch = mysqli_num_rows($resultpunch);  

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
      <img src="assets/chasing_cloud.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Chasing Clouds</span>
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
            <a href="dashboard.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <!-- <span class="badge badge-info right">2</span> -->
              </p>
            </a>
          </li>
          <!-- menu-open -->
          <?php if($_SESSION['role']=='Administrator'){ ?>
          <li class="nav-item ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                Inventory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="hardwares.php" class="nav-link">
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
          <?php } ?>

          <?php if($_SESSION['role']=='Administrator'){ ?>
          <li class="nav-item">
            <a href="customers.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Customers
                <!-- <span class="badge badge-info right">2</span> -->
              </p>
            </a>
          </li>
          <?php } ?>
          <?php if($_SESSION['role']=='Administrator'){ ?>
          <li class="nav-item">
            <a href="reserve.php" class="nav-link">
            <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                Reserve Orders
                <!-- <span class="badge badge-info right">2</span> -->
              </p>
            </a>
          </li>
          <?php } ?>
          <?php if($_SESSION['role']=='Customer'){ ?>
          <li class="nav-item">
            <a href="reserve.php" class="nav-link">
            <i class="nav-icon fas fa-cart-arrow-down"></i>
              <p>
                My Cart
                <!-- <span class="badge badge-info right">2</span> -->
              </p>
            </a>
          </li>
          <?php }?>
          
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
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <?php if($_SESSION['role']=='Administrator'){ ?>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $total_stocks; ?></h3>
                <p>Available Stocks</p>
              </div>
              <div class="icon">
                <i class="fas fa-wind"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $resultCheck; ?></h3>
                <p>Customer Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="customers.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>
                <p>Reserved Items</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <?php }?>
          <!-- ./col -->
          <!-- ./col -->
          <!-- <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section <?php if($_SESSION['role']=='Administrator') echo "class='col-lg-6 connectedSortable'"; else echo "class='col-lg-4 connectedSortable'"; ?> class="col-lg-6 connectedSortable">
            <div class="card bg-gradient-default">
                <div class="card-header border-1">
                    <h3 class="card-title">
                    <i class="fas fa-info"></i>&nbsp
                    About
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body pt-0">
                    <p><q>Chasing Clouds Sorsogon is an online e-juice shop which allows clients to try, explore and boost their taste for they can find the real vaping satisfaction with very affordable price.</q></p>
                    <label><i class="fas fa-location-arrow"></i>&nbsp
                    Location</label>
                    <p>501 Cogon Bibincahan 4700 Sorsogon, Philippines</p>
                    <label><i class="fas fa-clock"></i>&nbsp
                    Open Hours</label>
                    <p>24/7</p>
                    <label><i class="fas fa-phone"></i>&nbsp
                    Contact Number</label>
                    <p>24/7</p>
                    <label><i class="fab fa-facebook-square"></i>&nbsp
                    Facebook Page</label>
                    <p><a href='https://web.facebook.com/cloudchasesorsogon' target="_blank">https://web.facebook.com/cloudchasesorsogon</a></p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col -->
          
          <?php if($_SESSION['role']=='Administrator') { ?>
          <section class="col-lg-6 connectedSortable">
          <div class="card bg-gradient-default">
                <div class="card-header border-1">
                    <h3 class="card-title">
                    <i class="fas fa-cash-register"></i>&nbsp
                    Customer Orders
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body pt-0">
                <br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Item</th>
                      <th style="width: 40px">Price</th>
                      <th style="width: 40px">Qty</th>
                      <th style="width: 90px">Total</th>
                      <th style="width: 10px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $ctr=0;
                  $max_tot = 0;
                  while($row = mysqli_fetch_array($resultpunch))
                  {
                    $ctr++;
                    $tot = $row['price'] * $row['quantity'];
                    $num = number_format($tot,2);
                    $max_tot+=$tot;
                    // $paid_mod = 'paid-'.$row['logs_id'];
                    echo "
                    <tr>
                      <td>$ctr</td>
                      <td>$row[prod_name]</td>
                      <td>$row[price]</td>
                      <td>$row[quantity]</td>
                      <td>$num</td>
                      <td><a href='dashboard.php?remove=$row[logs_id]'><button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button></a></td>
                    </tr>
                    ";
                  }
                  ?>
                  </tbody>
                </table>
                <div class="col-12">
                <span class='float-right'>
                <hr>
                <h2>
                <?php $cart_tot = number_format($max_tot,2); echo "<span class='text-success'> TOTAL: &#8369;".$cart_tot."</span>" ?>
                </h3>
                </span>
                </div>
                <hr>
                <span>
                <a href='dashboard.php?cancel=yes'><button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Cancel</button></a>
                <button type="button" class="btn btn-info btn-sm" data-toggle='modal' data-target='#add-hardware'><i class="fas fa-shopping-cart"></i> Hardware</button>
                <button type="button" class="btn btn-info btn-sm" data-toggle='modal' data-target='#add-juice'><i class="fas fa-shopping-cart"></i> Juice</button>
                <button type="button" class="btn btn-info btn-sm" data-toggle='modal' data-target='#add-acce'><i class="fas fa-shopping-cart"></i> Accessory</button>
                <?php if($max_tot > 1)
                {
                  echo "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#paid-mod'><i class='fa fa-check'></i> Checkout</button>";
                }
                else echo "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#paid-mod' disabled><i class='fa fa-check'></i> Checkout</button>";  
                ?>
                
                <!-- <button type="button" class="btn btn-info btn-sm" data-toggle='modal' data-target='#add-acce'><i class="fa fa-plus"></i> Add Accessory</button>
                <a href='dashboard.php?paid=yes'><button type="button" class="btn btn-success btn-sm"><b>&#8369</b> Pay Ordered</button></a> -->
                </span>
            
                </div>
                <!-- /.card-body -->
            </div>
          </section>
          <?php } else { ?>
          <section class="col-lg-8 connectedSortable">
          <div class="container-fluid">
        
      <div class="card">
              <div class="card-header ">
                <h3 class="card-title">List of Products</h3>
                <!-- <span class="float-sm-right"><button type="button" class="btn btn-success btn-block" data-toggle='modal' data-target='#modal-add'><i class="fa fa-plus"></i> Add New Hardwares</button></span> -->
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
                    <th>Stock Qty</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($resultCheck > 0 )
                  while ($row = mysqli_fetch_array($resulproducts))
                  {
                      $reserved = '#res-'.$row['product_id'];
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
                              <button class='btn bg-gradient-info' data-toggle='modal' data-target='$reserved'>
                                  <i class='fas fa-shopping-cart'></i>
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
          <?php } ?>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="add-hardware">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header  text-success">
              <h4 class="modal-title "><i class='fas fa-bag'></i> Select Order (Hardware)</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="post">
              <div class="row">
                <label class="col-3">Select Item:</label>
                      <select class="form-control col-9 mb-2" name='pid'>
                      <?php
                      $avail = 0;
                      while ($row = mysqli_fetch_array($resulthard))
                      {
                       echo "<option value='$row[product_id]'>$row[name] - Price: $row[price].00 ($row[qty])</option>";
                       $avail = $row['qty'];
                      }
                      ?>
                      </select>
                <label class="col-3">Quantity:</label> 
                <input type="number" class="form-control col-3  mb-2" min='1' name='qty' required>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button> 
              <button type="submit" name='addsubmit' class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <div class="modal fade" id="add-juice">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header  text-success">
              <h4 class="modal-title "><i class='fas fa-bag'></i> Select Order (Juice)</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="post">
              <div class="row">
              <label class="col-3">Select Item:</label>
                      <select class="form-control col-9 mb-2" name='pid'>
                      <?php
                      $avail = 0;
                      while ($row = mysqli_fetch_array($resultjuices))
                      {
                       echo "<option value='$row[product_id]'>$row[name] - Price: $row[price].00($row[qty])</option>";
                       $avail = $row['qty'];
                      }
                      ?>
                      </select>
                <label class="col-3">Quantity:</label> 
                <input type="number" class="form-control col-3  mb-2" min='1' name='qty' required>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button> 
              <button type="submit" name='addsubmit' class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->  
      <div class="modal fade" id="add-acce">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header  text-success">
              <h4 class="modal-title "><i class='fas fa-bag'></i> Select Order (Accessory)</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="post">
              <div class="row">
              <label class="col-3">Select Item:</label>
                      <select class="form-control col-9 mb-2" name='pid'>
                      <?php
                      $avail = 0;
                      while ($row = mysqli_fetch_array($resultacc))
                      {
                       echo "<option value='$row[product_id]'>$row[name] - Price: $row[price].00($row[qty])</option>";
                       $avail = $row['qty'];
                      }
                      ?>
                      </select>
                <label class="col-3">Quantity:</label> 
                <input type="number" class="form-control col-3  mb-2" min='1' name='qty' required>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button> 
              <button type="submit" name='addsubmit' class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal --> 

      <!-- paid modal -->
      <div class="modal fade" id="paid-mod">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header  text-warning">
              <h4 class="modal-title "><i class='fas fa-bag'></i> Checkout</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="post">
              <div class="row">
              <label class="col-4">Total Amount: </label>
              <input type="number" class="form-control col-3  mb-2" min='0' name='total' value='<?php echo $max_tot;?>' required>
              <!-- <label class="col-6">Pesos</label> -->
              <div class='col-5'></div>
              <label class="col-4">Customer Paid:</label> 
              <input type="number" class="form-control col-3  mb-2" name='c_paid' min='<?php echo $max_tot;?>' required>
              <!-- <input class="form-control col-3  mb-2" id="change"> -->
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button> 
              <button type="submit" name='outsubmit' class="btn btn-warning"><i class="fas fa-check"></i> Checkout</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal --> 

      <!-- <?php
      while($row = mysqli_fetch_array($resultpunchmod))
      {
        $paid_mod='paid-'.$row['logs_id'];
        
      }
      ?> -->


      <?php
      while($row = mysqli_fetch_array($resulproductsmod))
      {
        $paid_mod='res-'.$row['product_id'];
        echo " 
        <div class='modal fade' id='$paid_mod'>
        <div class='modal-dialog'>
          <div class='modal-content'>
            <div class='modal-header  text-success'>
              <h4 class='modal-title '><i class='fas fa-bag'></i> Select Product ($row[product_type])</h4>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'>
            <form method='post'>
              <div class='row'>
                <div class='col-4 mb-2'>
                  <label>Product Name:</label>
                </div>
                <div class='col-6 mb-2'>
                <input type='text' name='pid' value='$row[product_id]' hidden>
                <input type='text' name='pname' value='$row[name]' hidden>
                <input type='text' class='form-control' value='$row[name]' disabled>
                </div>
                <div class='col-2'></div>
                <div class='col-4 mb-2'>
                  <label>Product Price:</label>
                </div>
                <div class='col-6 mb-2'>
                <input type='number' name='pprice' value='$row[price]' hidden>
                <input type='text' class='form-control' value='$row[price]' disabled>
                </div>
                <div class='col-2'></div>
                <div class='col-4 mb-2'>
                  <label>in Stock:</label>
                </div>
                <div class='col-6 mb-2'>
                <input type='text' class='form-control'value='$row[qty]' disabled>
                </div>
                <div class='col-2'></div>
                <div class='col-4 mb-2'>
                  <label>Quantity:</label>
                </div>
                <div class='col-6 mb-2'>
                <input type='number' class='form-control' name='pqty' min='1' max='$row[qty]' required>
                </div>
                <div class='col-2'></div>
              </div>
            </div>
            <div class='modal-footer justify-content-between'>
              <button type='reset' class='btn btn-default' data-dismiss='modal'>Close</button> 
              <button type='submit' name='reserve_sub' class='btn btn-success'><i class='fas fa-shopping-cart'></i> Add</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
        ";
      }
      ?>
      
      

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
