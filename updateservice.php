<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUATMEDIC ADMIN</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<!--<link rel="stylesheet" href="css/font-awesome.min.css" />-->
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/colorpicker.css" />
<link rel="stylesheet" href="css/datepicker.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/maruti-style.css" />
<link rel="stylesheet" href="css/maruti-media.css" class="skin-color" />
<link rel="stylesheet" href="assets/css/font-awesome2.css" />
<link rel="icon" href="quatmedics.png" type="image/x-icon" style="width:50px;">
<style>
.active{
    background-color: #209fbf;
}
</style>
</head>
<body>

<?php
include 'layout/head.php';
//$lab = new Lab();

$success = '';
$error = '';

$centerID = $_SESSION['centerID'];
if(isset($_GET['sid'])){
   $sid = $_GET['sid'];
    //fecth lab details..
    $fetchServ = select("SELECT * FROM prices WHERE serviceID='$sid' AND centerID='$centerID'");
    if($fetchServ){
        foreach($fetchServ as $serviceRow){}
    }
}else{
    $error = "<script>document.write('NO SERVICE CHARGE SELECTED.');</script>";
}

//update charges..
if(isset($_POST['upService'])){
    $servicePrice = trim(htmlentities($_POST['servicePrice']));
//    $roomName = trim(htmlentities($_POST['roomName']));
    //update labtest
    $updateCharge = update("UPDATE prices SET servicePrice='$servicePrice' WHERE serviceID='$sid'");
    if($updateCharge){
        $success = "<script>document.write('CHARGE UPDATED SUCCESSFUL.');window.location.href='center-account';</script>";
    }else{
        $error = "<script>document.write('CHARGE UPDATE FAILED, TRY AGAIN.');</script>";
    }
}

?>

<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
        <li><a href="medics-index"><i class="icon icon-home"></i> <span>DASHBOARD</span></a> </li>
        <li class=""> <a href="centerconsultation-index"><i class="icon-th-list"></i> <span>CONSULTATION</span></a> </li>
        <li class=""> <a href="centerward-index"><i class="icon-folder-close"></i> <span>WARD</span></a> </li>
        <li class=""> <a href="centerlab-index"> <i class="icon-search"></i> <span>LABORATORY</span></a> </li>
        <li class=""> <a href="centeruser-index"> <i class="icon-user"></i> <span>STAFF</span></a> </li>
        <li class=""> <a href="centerpharmacy-index"> <i class="icon-plus-sign"></i> <span>PHARMACY</span></a> </li>
        <li class="active"> <a href="center-account"> <i class="icon-list-alt"></i> <span>ACCOUNTS</span></a> </li>
        <li class=""> <a href="smsrequest-index"> <i class="icon-envelope"></i> <span>SMS REQUEST</span></a> </li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a href="center-account" title="Consultation" class="tip-bottom"><i class="icon-th-list"></i> ACCOUNTS</a>
        <a title="Accounts Management" class="tip-bottom"><i class="fa fa-edit"></i> UPDATE CHARGES</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">ACCOUNT &amp; CHARGES MANAGEMENT</h3>
<?php
if($success){
?>
<div class="alert alert-success">
<strong>Success!</strong> <?php echo $success; ?>
</div>
<?php } if($error){
  ?>
<div class="alert alert-danger">
<strong>Error!</strong> <?php echo $error; ?>
</div>
<?php
} ?>
      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs labell">
                    <li class="active"><a data-toggle="tab" href="#tab1">Update Service Charge</a></li>
<!--                    <li><a data-toggle="tab" href="#tab2">Add New Lab</a></li>-->
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <form method="post" enctype="multipart/form-data" onsubmit="return confirm('CONFIRM UPDATE');">
                        <div class="span6">
                            <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Service ID :</label>
                               <div class="controls">
                                  <input type="text" class="span11" name="serviceID" value="<?php echo $serviceRow['serviceID']; ?>" required readonly/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Service Name :</label>
                               <div class="controls">
                                  <input type="text" class="span11" name="serviceName" value="<?php echo $serviceRow['serviceName'];?>" readonly/>
                                </div>
                                  <div class="controls"></div>
                              </div>
                          </div>
                        </div>
                        <div class="span6">

                            <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Mode Of Payment</label>
                               <div class="controls">
                                  <input type="text" class="span11" name="modePayment" value="<?php echo $serviceRow['modePayment']; ?>" readonly/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Price </label>
                               <div class="controls">
                                  <input type="number" min="0" class="span11" name="servicePrice" value="<?php echo $serviceRow['servicePrice'];?>" required/>
                                </div>
                                  <div class="controls"></div>
                              </div>
                          </div>
                        <div class="widget-content nopadding">
                              <div class="form-actions">
                                  <i class="span5"></i>
                                <button type="submit" name="upService" class="btn btn-success labell btn-block span6">Update Charge</button>
                              </div>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
<div class="row-fluid ">
  <div id="footer" class="span12"> 2018 &copy; QUAT MEDICS ADMIN BY  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a> </div>
</div>
<script src="js/excanvas.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.ui.custom.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-colorpicker.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.flot.min.js"></script>
<script src="js/jquery.flot.resize.min.js"></script>
<script src="js/jquery.peity.min.js"></script>
<script src="js/fullcalendar.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/bootstrap-colorpicker.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.uniform.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/maruti.js"></script>
<script src="js/maruti.tables.js"></script>
<script src="js/maruti.dashboard.js"></script>
<script src="js/maruti.chat.js"></script>
<script src="js/maruti.form_common.js"></script>
<!--<script src="js/maruti.js"></script> -->

</body>
</html>
