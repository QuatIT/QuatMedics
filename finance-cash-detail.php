<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUAT MEDICS ADMIN</title>
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
<link rel="stylesheet" href="assets/css/font-awesome.css" />
    <style>
        .active{
            background-color: #209fbf;
        }
    </style>
</head>
<body>

<?php
include 'layout/head.php';

	if(isset($_GET['id']) && isset($_GET['pid'])){
		$patid = $_GET['pid'];
		$id = $_GET['id'];
	}

$_SESSION['current_page']=$_SERVER['REQUEST_URI'];

	//get patient details..
	$pdet = select("SELECT * FROM patient where patientID='$patid'");
	foreach($pdet as $prow){}

	//GET CONSULTATION CHARGE..
	$concharge = select("SELECT * FROM paymentfixed WHERE patientID='$patid' AND serviceName='CONSULTATION' AND id='$id'");
	foreach($concharge as $conRow){
		$consultPrice = $conRow['servicePrice'];
		$consultDate = $conRow['dateinsert'];
	}


	//get lab details...
	$labTotal = 0;
	$fetchlab = select("SELECT * FROM labresults WHERE patientID='$patid' AND paymode='Private' AND dateInsert='$consultDate'");
	foreach($fetchlab as $labRow){
					$getlabName = select("SELECT labName FROM lablist WHERE labID='".$labRow['labID']."'");
						  foreach($getlabName as $labNmRow){}
		$labTotal += $labRow['labprice'];
	}

	//get medicine charges...
	$getPresciptionID = select("SELECT * From prescriptions WHERE patientID='$patid' AND dateInsert='$consultDate'");
					  if($getPresciptionID){
						  foreach($getPresciptionID as $presRow){
							  $getMeds = select("SELECT * FROM prescribedmeds WHERE prescribeCode='".$presRow['prescribeCode']."'");
							  foreach($getMeds as $medrow){

							  }
						  }
					  }

	//get medinine total
	@ $medtotal = 0;
   @$getMeds = select("SELECT * FROM prescribedmeds WHERE prescribeCode='".$presRow['prescribeCode']."'");
		  foreach($getMeds as $medrow){
			  $medtotal+=$medrow['medprice'];
		  }

	$overall =($consultPrice+$medtotal);
	$overallTotal = "GHC ".$overall;
?>

<div id="search">
  <input type="text" placeholder="Search here..." disabled/>
  <button type="submit" class="tip-left" title="Search" disabled><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->
<div id="sidebar">
    <ul>
        <li><a href="finance-cash"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
        <li class="active"> <a href="finance-cash"><i class="icon icon-briefcase"></i><span>CASH PAYMENT</span></a> </li>
        <li><a href="finance-insurance"><i class="icon icon-calendar"></i><span>INSURANCE</span></a></li>
    </ul>
</div>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="CASH PAYMENT" href="finance-cash" class="tip-bottom"><i class="icon-briefcase"></i> CASH PAYMENT</a>
        <a title="CASH PAYMENT DETAILS" class="tip-bottom"><i class="icon-briefcase"></i> CASH PAYMENT DETAILS</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">CASH PAYMENT DETAILS</h3>

      <div class="row-fluid">
		  <div class="span5">
				<form action="#" method="post" class="form-horizontal">
					  <div class="widget-title">
						  <span class="icon"> <i class="icon-align-justify"></i> </span>
							<h5>PAYMENT DETAILS</h5>
					  </div>
					  <div class="widget-content nopadding">
						  <div class="control-group">
							<label class="control-label"> <b>PATIENT ID :</b></label>
							<div class="controls">
							  <input type="text" class="span11" name="patientID" value="<?php echo $prow['patientID'];?>" readonly/>
							</div>
						  </div>
						  <div class="control-group">
							<label class="control-label"><b>PATIENT NAME :</b></label>
							<div class="controls">
							  <input type="text" class="span11" name="patientName" value="<?php echo $prow['lastName']." ".$prow['firstName']." ".$prow['otherName'];?>" readonly/>
							</div>
						  </div>
						 <div class="control-group">
							<label class="control-label"> <b style="color:red;">OVER ALL TOTAL :</b></label>
							<div class="controls">
			<input type="text" style="font-weight:bolder;" class="span11" name="overall" value="<?php echo $overallTotal;?>" readonly/>
							</div>
						  </div>
<!--
						  <div class="form-actions">
							  <i class="span1"></i>
							<button type="submit" name="makeAllPaymeny" class="btn btn-primary btn-block span10"> Make Payment</button>
						  </div>
-->
					  </div>
				</form>
		</div>

		  <div class="span7">
			   <div class="widget-title">
				<span class="icon"> <i class="icon-align-justify"></i> </span>
				<h5>SERVICES AND CHARGES</h5>
			  </div>

              <!-- ============== TABLE FOR CONSULTATION AND OPD CHARGES ==================      -->
			  <table class="table table-bordered">
                  <thead>
                    <th> SERVICE</th>
                    <th> PRICE</th>
                    <th> STATUS</th>
                    <th> ACTION</th>
                  </thead>
				  <tbody>
				  		<tr>
						<td> CONSULTATION CHARGE</td>
						<td><?php echo $conRow['servicePrice'];?></td>
						<td style="text-align:center;">
							<?php// echo $conRow['status'];?>
							<?php if($conRow['status'] == 'Not Paid'){?>
							<span style="background-color:#c92929;" class="label label-danger text-center"><?php  echo $conRow['status'];?></span>
						   <?php }?>

							<?php if($conRow['status'] == 'Paid'){?>
							<span class="label label-success text-center"><?php  echo $conRow['status'];?></span>
						   <?php }?>
						</td>
                        <td style="text-align:center;">
                            <?php if($conRow['status'] == 'Not Paid'){?>
                            <a onclick="return confirm('Confirm Payment');" href="finance-cash-consultpay?id=<?php echo $conRow['id'];?>"><i class="btn btn-success btn-md fa fa-check"></i></a>
                            <?php }?>
                        </td>
					  </tr>
				  </tbody>
              </table>
              <!-- ============== END OF TABLE FOR CONSULTATION AND OPD CHARGES ==================      -->

              <hr/>

              <!-- ============== TABLE FOR LAB TESTS AND PRICES ==================      -->
              <?php
              if($fetchlab){
              ?>
              <table class="table table-bordered">
				  <thead>
				  		<th> LAB TEST </th>
				  		<th colspan="2"> PRICE</th>
				  		<th colspan="2"> STATUS</th>
				  </thead>
				  <tbody>
					  <?php

					  foreach($fetchlab as $labRow){
					$getlabName = select("SELECT labName FROM lablist WHERE labID='".$labRow['labID']."'");
						  foreach($getlabName as $labNmRow){}
					  ?>
				  		<tr>
						<td> <?php echo $labNmRow['labName'];?></td>
						<td colspan="2"><?php echo $labRow['labprice'];?></td>
						<td style="text-align:center;">
							<?php if($labRow['paystatus'] == 'Not Paid'){?>
							<span style="background-color:#c92929;" class="label label-danger text-center"><?php  echo $labRow['paystatus'];?></span>
						   <?php }?>

							<?php if($labRow['paystatus'] == 'Paid'){?>
							<span class="label label-success text-center"><?php  echo $labRow['paystatus'];?></span>
						   <?php }?>
						</td>
					  </tr>
					  <?php }?>
				  </tbody>
              </table>
              <?php }?>

              <!-- ============== END OF TABLE FOR LAB TESTS AND PRICES ==================      -->

              <hr/>

              <!--  TABLE FOR MEDICATIONS AND PRESCRIPTIONS  -->
              <table class="table table-bordered">
				  <thead>
				  		<th> MEDICATION </th>
				  		<th> DOSAGE</th>
				  		<th> PRICE</th>
				  		<th> STATUS</th>
				  		<th> ACTION</th>
				  </thead>
				  <tbody>

					  <?php
					  	$getPresciptionID = select("SELECT * From prescriptions WHERE patientID='$patid' AND dateInsert='$consultDate'");
					  if($getPresciptionID){
						  foreach($getPresciptionID as $presRow){
							  $getMeds = select("SELECT * FROM prescribedmeds WHERE prescribeCode='".$presRow['prescribeCode']."'");
							  foreach($getMeds as $medrow){

					  ?>
					  <tr>
					  	<td><?php echo $medrow['medicine']; ?></td>
					  	<td><?php echo $medrow['dosage']; ?></td>
					  	<td><?php echo $medrow['medprice']; ?></td>
					  	<td>
							<?php if($medrow['paystatus'] == 'Not Paid'){?>
							<span style="background-color:#c92929;" class="label label-danger text-center"><?php  echo $medrow['paystatus'];?></span>
						   <?php }?>

							<?php if($medrow['paystatus'] == 'Paid'){?>
							<span class="label label-success text-center"><?php  echo $medrow['paystatus'];?></span>
						   <?php }?>
							<?php //echo $medrow['paystatus']?>
						</td>
                          <td>
                            <?php if($medrow['paystatus'] == 'Not Paid'){?>
                            <a onclick="return confirm('Confirm Payment');" href="finance-cash-medpay?id=<?php echo $medrow['prescribeid'];?>"><i class="btn btn-success btn-md fa fa-check"></i></a>
                           <?php }?>

                            <?php if($medrow['paystatus'] == 'Paid'){?>
                            <span class="label label-success text-center"><?php  echo $medrow['paystatus'];?></span>
                           <?php }?>
                        </td>
					  </tr>
					  <?php }}}else{ ?>
                         <tr>
                            <td colspan="5" style="text-align:center;" > NO MEDICATION PRESCRIBED.</td>
                        </tr>
                      <?php }
					  $total = 0;
					   @$getMeds = select("SELECT * FROM prescribedmeds WHERE prescribeCode='".$presRow['prescribeCode']."'");
							  foreach($getMeds as $medrow){
								  $total+=$medrow['medprice'];
							  }
					  ?>
					  <tr>
					  	<td colspan="2" style="text-align:right"> <b>Total</b></td>
					  	<td colspan="3"> <b><?php echo "Ghc ".$total;?></b></td>

					  </tr>

				  </tbody>
			  </table>
            <!-- ================== END OF TABLE FOR MEDICATIONS AND PRESCRIPTIONS ===================== -->

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

<!--
<script>
function dis(){
    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","loads/consultappoint-load?staffID=<?php // echo $staffID;?>",false);
    xmlhttp.send(null);
    document.getElementById("appointment").innerHTML=xmlhttp.responseText;
}
    dis();

    setInterval(function(){
        dis();
    },1000);
</script>
-->

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {

          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();
          }
          // else, send page to designated URL
          else {
            document.location.href = newURL;
          }
      }
  }
// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>
</body>
</html>
