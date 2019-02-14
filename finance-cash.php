<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUATMEDIC</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/font-awesome.min.css" />
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
$_SESSION['current_page']=$_SERVER['REQUEST_URI'];
?>

<div id="search">
  <input type="text" placeholder="Search here..." disabled/>
  <button type="submit" class="tip-left" title="Search" disabled><i class="icon-search icon-white"></i></button>
</div>

<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"> <a href="finance-cash"><i class="icon icon-briefcase"></i><span>CASH PAYMENT</span></a> </li>
    <li><a href="finance-insurance"><i class="icon icon-file"></i><span>INSURANCE</span></a></li>
    <li><a href="finance-cash-report"><i class="icon-list-alt"></i><span>REPORT</span></a></li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="CASH PAYMENT" class="tip-bottom"><i class="icon-briefcase"></i> CASH PAYMENT</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">CASH PAYMENT</h3>

    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs labell">
                    <li class="active"><a data-toggle="tab" href="#tab1">CONSULTATION & MEDS</a></li>
                    <li><a data-toggle="tab" href="#tab2">LABORATORY PAYMENTS</a></li>
                    <li><a data-toggle="tab" href="#tab3">WARD PAYMENTS</a></li>
                    <li><a data-toggle="tab" href="#tab4">PAYMENT HISTORY</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                         <h5>CONSULTATION AND MEDICATION CHARGES</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>PID</th>
                              <th> NAME</th>
                              <th> CONSULTATION</th>
                              <th> ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
							  <?php
		$fetchAll = select("SELECT * FROM paymentfixed WHERE centerID='".$_SESSION['centerID']."' AND paymode='CASH' AND serviceName='CONSULTATION' AND dateinsert='$dateToday'");
							  if($fetchAll){
								  foreach($fetchAll as $PrivateRow){
									  $pdet = select("select * from patient where patientID='".$PrivateRow['patientID']."'");
									  foreach($pdet as $prow){
							  ?>
							  <tr>
							  	<td> <?php echo $PrivateRow['patientID'];?></td>
							  	<td> <?php echo $prow['lastName']." ".$prow['firstName']." ".$prow['otherName'];?></td>
							  	<td> <?php echo $PrivateRow['servicePrice'];?></td>
							  	<td style="text-align:center;"> <a href="finance-cash-detail?id=<?php echo $PrivateRow['id'];?>&pid=<?php echo $PrivateRow['patientID'];?>"><i class="btn btn-success btn-md fa fa-eye labell"> VIEW DETAILS</i></a></td>
							  </tr>
							  <?php }}}?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>

                <div id="tab2" class="tab-pane">
                     <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                         <h5>LABORATORY CHARGES</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>PID</th>
                              <th>NAME</th>
                              <th>LAB NAME</th>
                              <th>PRICE</th>
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
							   <?php
	$fetchlab = select("SELECT * FROM labresults WHERE centerID='".$_SESSION['centerID']."' AND paymode='CASH' AND paystatus='Not Paid' AND confirm='CONFIRMED'");
							  if($fetchlab){
								  foreach($fetchlab as $PrivateRow){
									  $pdet = select("select * from patient where patientID='".$PrivateRow['patientID']."'");
									  foreach($pdet as $prow){}

									  $labN = select("SELECT * FROM lablist WHERE labID='".$PrivateRow['labID']."'");
									  foreach($labN as $labRow){}
							  ?>
							  <tr>
							  	<td> <?php echo $PrivateRow['patientID'];?></td>
							  	<td> <?php echo $prow['lastName']." ".$prow['firstName']." ".$prow['otherName'];?></td>
							  	<td> <?php echo $labRow['labName'];?></td>
							  	<td> <?php echo $PrivateRow['labprice'];?></td>
							  	<td style="text-align:center;">
									<?php if($PrivateRow['paystatus'] == 'Not Paid'){?>
									<a onclick="return confirm('Confirm Payment');" href="finance-cash-labpay?id=<?php echo $PrivateRow['id'];?>"><i class="btn btn-success btn-md fa fa-check labell"> MAKE PAYMENT</i> </a>
								   <?php }?>

									<?php if($PrivateRow['paystatus'] == 'Paid'){?>
									<span class="label label-success text-center"><?php  echo $PrivateRow['paystatus'];?></span>
								   <?php }?>
								</td>
							  </tr>
							  <?php }}?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>

                <div id="tab3" class="tab-pane">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                         <h5>WARD CHARGES</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>PID</th>
                              <th>NAME</th>
                              <th>WARD NAME</th>
                              <th>PRICE</th>
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
							   <?php
	$fetchward = select("SELECT * FROM wardassigns WHERE centerID='".$_SESSION['centerID']."' AND paymode='CASH' AND paystatus='Not Paid' AND charge !='0'");
							  if($fetchward){
								  foreach($fetchward as $wardRow){
									  $pdet = select("select * from patient where patientID='".$wardRow['patientID']."'");
									  foreach($pdet as $prow){}

									  $warddet = select("SELECT * FROM wardlist WHERE wardID='".$wardRow['wardID']."'");
									  foreach($warddet as $warddets){}
							  ?>
							  <tr>
							  	<td> <?php echo $wardRow['patientID'];?></td>
							  	<td> <?php echo $prow['lastName']." ".$prow['firstName']." ".$prow['otherName'];?></td>
							  	<td> <?php echo $warddets['wardName'];?></td>
							  	<td> <?php echo $wardRow['charge'];?></td>
							  	<td style="text-align:center;">
									<?php if($wardRow['paystatus'] == 'Not Paid'){?>
									<a href="finance-ward-details?id=<?php echo $wardRow['assignID'];?>"><i class="btn btn-success btn-md fa fa-eye labell"> VIEW DETAILS</i></a>
								   <?php }?>

									<?php if($wardRow['paystatus'] == 'Paid'){?>
									<span class="label label-success text-center"><?php  echo $PrivateRow['paystatus'];?></span>
								   <?php }?>
								</td>
							  </tr>
							  <?php }}?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>

                <div id="tab4" class="tab-pane">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                         <h5>CONSULTATION AND MEDICATION CHARGES</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>PID</th>
                              <th> NAME</th>
                              <th> CONSULTATION</th>
                              <th> ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
							  <?php
		$fetchAll = select("SELECT * FROM paymentfixed WHERE centerID='".$_SESSION['centerID']."' AND paymode='CASH' AND serviceName='CONSULTATION'");
							  if($fetchAll){
								  foreach($fetchAll as $PrivateRow){
									  $pdet = select("select * from patient where patientID='".$PrivateRow['patientID']."'");
									  foreach($pdet as $prow){
							  ?>
							  <tr>
							  	<td> <?php echo $PrivateRow['patientID'];?></td>
							  	<td> <?php echo $prow['lastName']." ".$prow['firstName']." ".$prow['otherName'];?></td>
							  	<td> <?php echo $PrivateRow['servicePrice'];?></td>
							  	<td style="text-align:center;"> <a href="finance-cash-detail?id=<?php echo $PrivateRow['id'];?>&pid=<?php echo $PrivateRow['patientID'];?>"><i class="btn btn-success btn-md fa fa-eye labell"> VIEW DETAILS</i></a></td>
							  </tr>
							  <?php }}}?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
<div class="row-fluid ">
 	<div id="footer" class="span12">
	  2018 &copy; QUAT MEDICS ADMIN BY  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a>
	</div>
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

<script>
function dis(){
    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","loads/consultappoint-load?staffID=<?php echo $staffID;?>",false);
    xmlhttp.send(null);
    document.getElementById("appointment").innerHTML=xmlhttp.responseText;
}
    dis();

    setInterval(function(){
        dis();
    },1000);
</script>
</body>
</html>
