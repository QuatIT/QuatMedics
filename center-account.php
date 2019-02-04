<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUATMEDIC ADMIN</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/colorpicker.css" />
<link rel="stylesheet" href="css/datepicker.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/maruti-style.css" />
<link rel="stylesheet" href="css/maruti-media.css" class="skin-color" />
<link rel="stylesheet" href="assets/css/font-awesome.css" />
<link rel="icon" href="quatmedics.png" type="image/x-icon" style="width:50px;">
<style>
.active{
/*    background-color: #209fbf;*/
}
</style>
</head>
<body>

<?php
include 'layout/head.php';

$consultation = new Consultation();
$centerID = $_SESSION['centerID'];
$success = '';
$error = '';


//saving Account..
if(isset($_POST['saveAccount'])){
	//count number of service entered..
	$nameNum = count( $_POST['accountName']);
	$typeNum = count( $_POST['accountType']);
	//check number of services..
	if($nameNum > 0 && $typeNum >0){
		//saving services into database...
		for($n=0, $t=0; $n<$nameNum, $t<$typeNum; $n++,$t++){
				if(trim($_POST['accountName'][$n] != '') && trim($_POST['accountType'][$t] != '')) {
					$accountName = trim( $_POST["accountName"][$n]);
					$accountType = trim( $_POST["accountType"][$t]);
//						$serviceType = trim("Service");
					//generate account ID
					$accIDs = $consultation->loadAccPrices($centerID) + 1;
					$accountID = "ACC-".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$accIDs);

					//check account name if already entered else save account..
					$accExist = select("SELECT * FROM accounts WHERE accountName='$accountName' AND centerID='$centerID'");
					if($accExist){
						$error = "<script>document.write('Account Already Saved..');</script>";
					}else{
						$saveService = insert("INSERT INTO accounts(accountID,centerID,accountName,accountType,dateInsert) VALUES('$accountID','$centerID','$accountName','$accountType','$dateToday')");
						if($saveService){
							$success = "<script>document.write('Account Saved.');window.location='center-account';</script>";
						}else{
							$error = "<script>document.write('Account Not Saved, Try Again.');</script>";
						}
					}
				}
		}
	}else{
		$error = "<script>document.write('Empty Fields, Try Again.');</script>";
	}
}



	//saving services..
    if(isset($_POST['saveServiceprices'])){
		//count number of service entered..
		$serviceNum = count($_POST['serviceName']);
        $servicePriceNum = count($_POST['servicePrice']);
        $modeOfPaymentNum = count($_POST['modeOfPayment']);
		//check number of services..
		if($serviceNum > 0 && $servicePriceNum >0 && $modeOfPaymentNum >0){
			//saving services into database...
            for($n=0, $p=0, $m=0; $n<$serviceNum, $p<$servicePriceNum, $m<$modeOfPaymentNum; $n++,$p++,$m++){
                    if(trim($_POST['serviceName'][$n] != '') && trim($_POST['servicePrice'][$p] != '') && trim($_POST['modeOfPayment'][$m] != '')) {
                        $serviceName = trim(ucwords($_POST['serviceName'][$n]));
                        $servicePrice = trim(ucwords($_POST['servicePrice'][$p]));
                        $modeOfPayment = trim(ucwords($_POST['modeOfPayment'][$m]));
						$serviceType = trim(ucwords("Service"));
						//generate service ID
						$serviceIDs = $consultation->loadServicePrices($centerID) + 1;
						$serviceID = ucwords("SV.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$serviceIDs));

						//check service name if already entered else save service..
				$serviceExist = select("SELECT * FROM prices WHERE serviceName='$serviceName' AND modePayment='$modeOfPayment' AND centerID='$centerID' ");
						if($serviceExist){
							$error = "<script>document.write('Service Already Saved..');</script>";
						}else{
							$saveService = insert("INSERT INTO prices(serviceID,centerID,serviceName,servicePrice,serviceType,modePayment,dateInsert) VALUES('$serviceID','$centerID','$serviceName','$servicePrice','$serviceType','$modeOfPayment','$dateToday')");
							if($saveService){
								$success = "<script>document.write('Services Saved.');window.location='center-account';</script>";
							}else{
								$error = "<script>document.write('Services Not Saved, Try Again.');</script>";
							}
						}
               		}
            }
		}else{
			$error = "<script>document.write('Empty Fields, Try Again.');</script>";
		}
    }

	//saving laboratory services..
    if(isset($_POST['saveLabPrices'])){
		//count number of service entered..
		$serviceNum = count($_POST['serviceName']);
        $servicePriceNum = count($_POST['servicePrice']);
        $modeOfPaymentNum = count($_POST['modeOfPayment']);
		//check number of services..
		if($serviceNum > 0 && $servicePriceNum >0 && $modeOfPaymentNum >0){
			//saving services into database...
            for($n=0, $p=0, $m=0; $n<$serviceNum, $p<$servicePriceNum, $m<$modeOfPaymentNum; $n++,$p++,$m++){
        if(trim($_POST['serviceName'][$n] != '') && trim($_POST['servicePrice'][$p] != '') && trim($_POST['modeOfPayment'][$m] != '')){
                        $serviceName = trim($_POST['serviceName'][$n]);
                        $servicePrice = trim($_POST['servicePrice'][$p]);
                        $modeOfPayment = trim($_POST['modeOfPayment'][$m]);
						$serviceType = trim("Lab");
						//generate service ID
						$serviceIDs = $consultation->loadServicePrices($centerID) + 1;
						$serviceID = "SV.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$serviceIDs);

						//check service name if already entered else save service..
$serviceExist = select("SELECT * FROM prices WHERE centerID='$centerID' AND serviceName='$serviceName' AND modePayment='$modeOfPayment'");
						if(count($serviceExist) > 0){
							$error = "<script>document.write('Service Already Saved..');</script>";
						}else{
$saveService = insert("INSERT INTO prices(serviceID,centerID,serviceName,servicePrice,serviceType,modePayment,dateInsert) VALUES('$serviceID','$centerID','$serviceName','$servicePrice','$serviceType','$modeOfPayment','$dateToday')");
							if($saveService){
								$success = "<script>document.write('Services Saved.');window.location='center-account';</script>";
							}else{
								$error = "<script>document.write('Services Not Saved, Try Again.');</script>";
							}
						}
               		}
            }
		}else{
			$error = "<script>document.write('Empty Fields, Try Again.');</script>";
		}
    }


	//saving ward services..
    if(isset($_POST['saveWardPrices'])){
		//count number of service entered..
		$serviceNum = count($_POST['serviceName']);
        $servicePriceNum = count($_POST['servicePrice']);
        $modeOfPaymentNum = count($_POST['modeOfPayment']);
		//check number of services..
		if($serviceNum > 0 && $servicePriceNum > 0 && $modeOfPaymentNum > 0){
			//saving services into database...
            for($n=0, $p=0, $m=0; $n<$serviceNum, $p<$servicePriceNum, $m<$modeOfPaymentNum; $n++,$p++,$m++){
            if(trim($_POST['serviceName'][$n] != '') && trim($_POST['servicePrice'][$p] != '') && trim($_POST['modeOfPayment'][$m] != '')){
                        $serviceName = trim($_POST['serviceName'][$n]);
                        $servicePrice = trim($_POST['servicePrice'][$p]);
                        $modeOfPayment = trim($_POST['modeOfPayment'][$m]);
						$serviceType = trim("Ward");
						//generate service ID
						$serviceIDs = $consultation->loadServicePrices($centerID) + 1;
						$serviceID = "SV.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$serviceIDs);

						//check service name if already entered else save service..
$serviceExist = select("SELECT * FROM prices WHERE serviceName='$serviceName' AND modePayment='$modeOfPayment' AND centerID='$centerID' ");
						if($serviceExist){
							$error = "<script>document.write('Service Already Saved..');</script>";
						}else{
$saveService = insert("INSERT INTO prices(serviceID,centerID,serviceName,servicePrice,serviceType,modePayment,dateInsert) VALUES('$serviceID','$centerID','$serviceName','$servicePrice','$serviceType','$modeOfPayment','$dateToday')");
							if($saveService){
								$success = "<script>document.write('Services Saved.');window.location='center-account';</script>";
							}else{
								$error = "<script>document.write('Services Not Saved, Try Again.');</script>";
							}
						}
               	}
            }
		}else{
			$error = "<script>document.write('Empty Fields, Try Again.');</script>";
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
        <li class="active" style="background-color:#209fbf;"> <a href="center-account"> <i class="icon-list-alt"></i> <span>ACCOUNTS</span></a> </li>
        <li class=""> <a href="smsrequest-index"> <i class="icon-envelope"></i> <span>SMS REQUEST</span></a> </li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="ACCOUNT MANAGEMENT" class="tip-bottom"><i class="icon-file"></i> ACCOUNT MANAGEMENT</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">ACCOUNT &amp; CHARGES MANAGEMENT</h3>
      <div class="row-fluid">
		  <?php if($success || $error){?>
		 <div class="span12">
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
		</div>
		  <?php }?>

        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs labell">
                    <li class="active"><a data-toggle="tab" href="#tab1">ACCOUNT MANAGEMENT</a></li>
                    <li><a data-toggle="tab" href="#tab2">SERVICE CHARGES</a></li>
                    <li><a data-toggle="tab" href="#tab3">LAB TESTS CHARGES</a></li>
                    <li><a data-toggle="tab" href="#tab4">WARD CHARGES</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
<!--            <div class="widget-box">-->
				<div class="span6">
                    <form action="#" method="post" class="form-horizontal">
						  <table class="table table-bordered" id="dynamic_field4">
							  <tr>
							  	<td colspan="3" style="height:10px;">
								  	<h4 class="text-center" style="height:10px;"> CREATE ACCOUNT</h4>
								  </td>
							  </tr>
							<tr>
								<td style="width:30%;">
									<select class="span" name="accountName[]" required>
										<option value="OPD"> OPD </option>
										<option value="CONSULTATION"> CONSULTATION </option>
										<option value="LABORATORY"> LABORATORY </option>
										<option value="WARD"> WARD </option>
										<option value="PHARMACY"> PHARMACY </option>
									</select>
								</td>
								<td>
									<select class="span" name="accountType[]" required>
										<option value="CREDIT"> CREDIT ACCOUNT </option>
									</select>
								</td>
								<td><button type="button" name="add" id="add4" class="btn btn-primary labell">Add Account</button></td>
							</tr>
						</table>
						  <div class="form-actions">
							  <i class="span5"></i>
							  <button type="submit" name="saveAccount" class="btn btn-primary btn-block labell span6"><i class="fa fa-save"></i> Save Account</button>
						  </div>
              		</form>
				</div>

                    <div class="span6">
                        <div class="widget-box" style="margin:0px;">
                          <div class="widget-title">
                             <span class="icon"><i class="icon-th"></i></span>
                          </div>
                          <div class="widget-content nopadding">
                                <table class="table table-bordered table-stripped data-table">
                                    <thead>
                                        <th> ACCOUNT NAME</th>
                                        <th> ACOUNT TYPE</th>
                                        <th> ACCOUNT BALANCE</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $allAcc = select("SELECT * FROM accounts WHERE centerID='$centerID'");
                                        if($allAcc){
                                            foreach($allAcc as $accRow){
                                        ?>
                                        <tr>
                                            <td><?php echo $accRow['accountName'];?></td>
                                            <td><?php echo $accRow['accountType'];?></td>
                                            <td><?php echo $accRow['accBalance'];?></td>
                                        </tr>
                                        <?php }}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


        <div id="tab2" class="tab-pane">
            <div class="row-fluid">
				<div class="span6">
                    <form action="#" method="post" class="form-horizontal">
						  <table class="table table-bordered" id="dynamic_field2">
							  <tr>
							  	<td colspan="3" style="height:10px;">
								  	<h4 class="text-center" style="height:10px;"> SERVICE PRICING</h4>
								  </td>
							  </tr>
                              <?php
                              $n = 2;
                                for($t=0;$t<$n;$t++){
                              ?>
							<tr>
								<td>
									<select class="span" name="serviceName[]">
										<option>-- Select Service --</option>
										<option value="CONSULTATION"> CONSULTATION </option>
										<option value="ID CARD"> HOSPITAL CARD</option>
									</select>
								</td>
								<td><input type="number" step="any" min="1" name="servicePrice[]" placeholder="Price" class="span11" required /></td>
								<td><select class="span" name="modeOfPayment[]" required>
										<option>-- Payment Mode --</option>

									<?php
										$modePayment = select("select * FROM mode_of_payment ");
										if($modePayment){
											foreach($modePayment as $modePay){ ?>
									<option><?php echo $modePay['type']; ?></option>
										<?php }} ?>
									?>
									</select>
								</td>
							</tr>
                              <?php }?>
						</table>
						  <div class="form-actions">
							  <i class="span5"></i>
							  <button type="submit" name="saveServiceprices" class="btn btn-primary btn-block labell span6"><i class="fa fa-save"></i> Save Prices</button>
						  </div>
              		</form>
				</div>

				<div class="span6">
                     <div class="widget-box" style="margin:0px;">
                          <div class="widget-title">
                             <span class="icon"><i class="icon-th"></i></span>
                          </div>
                          <div class="widget-content nopadding">
                            <table class="table table-bordered table-stripped data-table">
                                <thead>
                                    <th> SERVICE NAME</th>
                                    <th> PAYMODE</th>
                                    <th> SERVICE PRICE</th>
                                    <th> ACTION</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $allService = select("SELECT * FROM prices WHERE centerID='$centerID' AND serviceType='Service'");
                                    if($allService){
                                        foreach($allService as $serviceRow){
                                    ?>
                                    <tr>
                                        <td><?php echo $serviceRow['serviceName'];?></td>
                                        <td><?php echo $serviceRow['modePayment'];?></td>
                                        <td><?php echo $serviceRow['servicePrice'];?></td>
                                        <td style="text-align:center;">
                                            <a href="updateservice?sid=<?php echo $serviceRow['serviceID'];?>" class="btn btn-primary">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                         </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="tab3" class="tab-pane">
            <div class="row-fluid">
                <div class="span6">
                    <form action="#" method="post" class="form-horizontal">
						  <table class="table table-bordered" id="dynamic_field">
							  <tr>
							  	<td colspan="3" style="height:10px;">
								  	<h4 class="text-center" style="height:10px;"> LAB PRICING</h4>
								  </td>
							  </tr>
                              <?php
                              $n = 4;
                                for($t=0;$t<$n;$t++){
                              ?>
							<tr>
								<td>
									<select class="span" name="serviceName[]">
										<option>-- Select Lab --</option>
										<?php
											$lablist = select("SELECT * FROM lablist WHERE centerID='$centerID'");
										if($lablist){
											foreach($lablist as $labRow){
										?>
										<option value="<?php echo $labRow['labName']?>"><?php echo $labRow['labName'];?></option>
										<?php }}?>
									</select>
								</td>
								<td><input type="number" step="any" min="1" name="servicePrice[]" placeholder="Price" class="span11" required/></td>
								<td><select class="span" name="modeOfPayment[]" required>
										<option>-- Payment Mode --</option>

									<?php
										$modePayment = select("select * FROM mode_of_payment ");
										if($modePayment){
											foreach($modePayment as $modePay){ ?>
									<option><?php echo $modePay['type']; ?></option>
										<?php }} ?>
									?>
									</select>
								</td>
<!--								<td><button type="button" name="add" id="add" class="btn btn-primary labell">Add</button></td>-->
							</tr>
                              <?php }?>
						</table>
						  <div class="form-actions">
							  <i class="span5"></i>
							  <button type="submit" name="saveLabPrices" class="btn btn-primary btn-block labell span6"><i class="fa fa-save"></i> Save Prices</button>
						  </div>
              		</form>
				</div>
				<div class="span6">
                     <div class="widget-box" style="margin:0px;">
                          <div class="widget-title">
                             <span class="icon"><i class="icon-th"></i></span>
                          </div>
                          <div class="widget-content nopadding">
					<table class="table table-bordered table-stripped data-table">
						<thead>
							<th> LAB NAME</th>
							<th> PAYMODE</th>
							<th> LAB PRICE</th>
							<th> ACTION</th>
						</thead>
						<tbody>
							<?php
							$allService = select("SELECT * FROM prices WHERE centerID='$centerID' AND serviceType='Lab'");
							if($allService){
								foreach($allService as $serviceRow){
							?>
							<tr>
								<td><?php echo $serviceRow['serviceName'];?></td>
								<td><?php echo $serviceRow['modePayment'];?></td>
								<td><?php echo $serviceRow['servicePrice'];?></td>
								<td style="text-align:center;">
                                    <a href="updateservice?sid=<?php echo $serviceRow['serviceID'];?>" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </td>
							</tr>
							<?php }}?>
						</tbody>
					</table>
                         </div>
                    </div>
				</div>
            </div>
        </div>

        <div id="tab4" class="tab-pane">
            <div class="row-fluid">
				<div class="span6">
                    <form action="#" method="post" class="form-horizontal">
						  <table class="table table-bordered" id="dynamic_field3">
							  <tr>
							  	<td colspan="3" style="height:10px;">
								  	<h4 class="text-center" style="height:10px;"> WARD PRICING</h4>
								  </td>
							  </tr>
                              <?php
                              $n = 4;
                                for($t=0;$t<$n;$t++){
                              ?>
							<tr>
								<td>
									<select class="span" name="serviceName[]">
										<option>-- Select Ward --</option>
										<option value="Emergency"> Emergency</option>
										<?php
											$wardlist = select("SELECT * FROM wardlist WHERE centerID='$centerID'");
										if($wardlist){
											foreach($wardlist as $wardRow){
										?>
										<option value="<?php echo $wardRow['wardName']?>"><?php echo $wardRow['wardName'];?></option>
										<?php }}?>
									</select>
								</td>
								<td><input type="number" step="any" min="1" name="servicePrice[]" placeholder="Price" class="span11" required/></td>
								<td><select class="span" name="modeOfPayment[]" required>
										<option>-- Payment Mode --</option>

									<?php
										$modePayment = select("select * FROM mode_of_payment ");
										if($modePayment){
											foreach($modePayment as $modePay){ ?>
									<option><?php echo $modePay['type']; ?></option>
										<?php }} ?>
									?>
									</select>
								</td>
							</tr>
                              <?php }?>
						</table>
						  <div class="form-actions">
							  <i class="span5"></i>
							  <button type="submit" name="saveWardPrices" class="btn btn-primary btn-block labell span6"><i class="fa fa-save"></i> Save Prices</button>
						  </div>
              		</form>
				</div>

                        <div class="span6">
                             <div class="widget-box" style="margin:0px;">
                          <div class="widget-title">
                             <span class="icon"><i class="icon-th"></i></span>
                          </div>
                          <div class="widget-content nopadding">
                            <table class="table table-bordered table-stripped data-table">
                                <thead>
                                    <th> WARD NAME</th>
                                    <th> PAYMODE</th>
                                    <th> WARD PRICE</th>
                                    <th> ACTION</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $allService = select("SELECT * FROM prices WHERE centerID='$centerID' AND serviceType='Ward'");
                                    if($allService){
                                        foreach($allService as $serviceRow){
                                    ?>
                                    <tr>
                                        <td><?php echo $serviceRow['serviceName'];?></td>
                                        <td><?php echo $serviceRow['modePayment'];?></td>
                                        <td><?php echo $serviceRow['servicePrice'];?></td>
                                        <td style="text-align:center;">
                                            <a href="updateservice?sid=<?php echo $serviceRow['serviceID'];?>" class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                    <?php }}?>
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
    </div>
</div>
<div class="row-fluid">
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
-->

<script>
//    $(document).ready(function(){
        var i=1;
        $('#add4').click(function(){
            i++;
            $('#dynamic_field4').append('<tr id="row'+i+'"><td><select class="span" name="accountName[]" required><option value="OPD"> OPD </option><option value="CONSULTATION"> CONSULTATION </option><option value="LABORATORY"> LABORATORY </option><option value="WARD"> WARD </option><option value="PHARMACY"> PHARMACY </option></select></td><td><select class="span" name="accountType[]" required><option value="CREDIT"> CREDIT ACCOUNT </option></select></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
</script>
</body>
</html>
