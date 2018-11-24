<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUAT MEDICS ADMIN</title>
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
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style>
.active{
    background-color: #209fbf;
}
</style>
</head>
<body>

<?php
    include 'layout/head.php';

    $consultation = new Consultation;
 	$centerID = $_SESSION['centerID'];
    $success = '';
    $error = '';


	//saving services..
    if(isset($_POST['saveServiceprices'])){
		//count number of service entered..
		$nameNum = count($_POST['accountName']);
        $typeNum = count($_POST['accountType']);
		//check number of services..
		if($nameNum > 0 && $typeNum >0){
			//saving services into database...
            for($n=0, $t=0; $n<$nameNum, $p<$typeNum; $n++,$t++){
                    if(trim($_POST['accountName'][$n] != '') && trim($_POST['accountType'][$t] != '')) {
                        $serviceName = trim($_POST["serviceName"][$n]);
                        $servicePrice = trim($_POST["servicePrice"][$t]);
						$serviceType = trim("Service");
						//generate service ID
						$serviceIDs = $consultation->loadServicePrices($centerID) + 1;
						$serviceID = "SV-".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$serviceIDs);

						//check service name if already entered else save service..
						$serviceExist = select("SELECT * FROM prices WHERE serviceName='$serviceName'");
						if($serviceExist){
							$error = "<script>document.write('Service Already Saved..');</script>";
						}else{
							$saveService = insert("INSERT INTO prices(serviceID,centerID,serviceName,servicePrice,serviceType,dateInsert) VALUES('$serviceID','$centerID','$serviceName','$servicePrice','$serviceType','$dateToday')");
							if($saveService){
								$success = "<script>document.write('Services Saved.');window.location='centerprices-index';</script>";
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

//	//saving laboratory services..
//    if(isset($_POST['saveLabPrices'])){
//		//count number of service entered..
//		$serviceNum = count($_POST['serviceName']);
//        $servicePriceNum = count($_POST['servicePrice']);
//		//check number of services..
//		if($serviceNum > 0 && $servicePriceNum >0){
//			//saving services into database...
//            for($n=0, $p=0; $n<$serviceNum, $p<$servicePriceNum; $n++,$p++){
//                    if(trim($_POST['serviceName'][$n] != '') && trim($_POST['servicePrice'][$p] != '')) {
//                        $serviceName = trim($_POST["serviceName"][$n]);
//                        $servicePrice = trim($_POST["servicePrice"][$p]);
//						$serviceType = trim("Lab");
//						//generate service ID
//						$serviceIDs = $consultation->loadServicePrices($centerID) + 1;
//						$serviceID = "SV-".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$serviceIDs);
//
//						//check service name if already entered else save service..
//						$serviceExist = select("SELECT * FROM prices WHERE serviceName='$serviceName'");
//						if($serviceExist){
//							$error = "<script>document.write('Service Already Saved..');</script>";
//						}else{
//							$saveService = insert("INSERT INTO prices(serviceID,centerID,serviceName,servicePrice,serviceType,dateInsert) VALUES('$serviceID','$centerID','$serviceName','$servicePrice','$serviceType','$dateToday')");
//							if($saveService){
//								$success = "<script>document.write('Services Saved.');window.location='centerprices-index';</script>";
//							}else{
//								$error = "<script>document.write('Services Not Saved, Try Again.');</script>";
//							}
//						}
//               		}
//            }
//		}else{
//			$error = "<script>document.write('Empty Fields, Try Again.');</script>";
//		}
//    }

    ?>

<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>

<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"><a href="center-account"><i class="icon icon-file"></i> <span>Account Management</span></a> </li>
    <li><a href="centerprices-index"><i class="icon icon-list-alt"></i> <span>Charge Management</span></a> </li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="PRICING" class="tip-bottom"><i class="icon-file"></i> ACCOUNT MANAGEMENT</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">ACCOUNT MANAGEMENT</h3>
<!--
	<div class="row-fluid">

	</div>
-->
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
            <div class="widget-content tab-content">
				<div class="span6">
                    <form action="#" method="post" class="form-horizontal">
						  <table class="table table-bordered" id="dynamic_field2">
							  <tr>
							  	<td colspan="3" style="height:10px;">
								  	<h4 class="text-center" style="height:10px;"> CREATE ACCOUNT</h4>
								  </td>
							  </tr>
							<tr>
								<td>
									<select class="span" name="accountName[]">
										<option>-- Select Account --</option>
										<option value="OPD"> OPD </option>
										<option value="CONSULTATION"> CONSULTATION </option>
										<option value="LABORATORY"> LABORATORY </option>
										<option value="WARD"> WARD </option>
										<option value="PHARMACY"> PHARMACY </option>
									</select>
								</td>
								<td>
									<select class="span" name="accountType[]">
										<option>-- Account Type --</option>
										<option value="CREDIT"> CREDIT ACCOUNT </option>
									</select>
								</td>
<!--
								<td>
									<input type="number" step="any" min="1" name="servicePrice[]" placeholder="Price" class="span11" required />
								</td>
-->
								<td><button type="button" name="add" id="add2" class="btn btn-primary">Add Account</button></td>
							</tr>
						</table>
						  <div class="form-actions">
							  <i class="span5"></i>
							  <button type="submit" name="saveAccount" class="btn btn-primary btn-block span6"> Save Account</button>
						  </div>
              		</form>
				</div>

				<div class="span6">
					<table class="table table-bordered table-stripped">
						<thead>
							<th> ACCOUNT NAME</th>
							<th> ACOUNT TYPE</th>
							<th> ACTION</th>
						</thead>
						<tbody>
							<?php
							$allService = select("SELECT * FROM prices WHERE centerID='$centerID' && serviceType='Service'");
							if($allService){
								foreach($allService as $serviceRow){
							?>
							<tr>
								<td><?php echo $serviceRow['serviceName'];?></td>
								<td><?php echo $serviceRow['servicePrice'];?></td>
								<td><a href="#?sid=<?php echo $serviceRow['serviceID'];?>" class="btn btn-primary"> <i class="fa fa-eye"></i></a></td>
							</tr>
							<?php }}else{?>
							<tr><td colspan="3"> <h6 class="text-center">NO SERVICE CHARGE SAVED.</h6></td></tr>
							<?php }?>
						</tbody>
					</table>
				</div>
			</div>
		  </div>

		  <hr/>
	  </div>
    </div>
</div>
<div class="row-fluid">
  <div id="footer" class="span12"> 2018 &copy; QUAT MEDICS ADMIN By  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a> </div>
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

<script>
//    $(document).ready(function(){
        var i=1;
        $('#add2').click(function(){
            i++;
            $('#dynamic_field2').append('<tr id="row'+i+'"><td><select class="span" name="accountName[]"><option>-- Select Account --</option><option value="OPD"> OPD </option><option value="CONSULTATION"> CONSULTATION </option><option value="LABORATORY"> LABORATORY </option><option value="WARD"> WARD </option><option value="PHARMACY"> PHARMACY </option></select></td><td><select class="span" name="accountName[]"><option>-- Account Type --</option><option value="CREDIT"> CREDIT ACCOUNT </option></select></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
</script>

<script>
//    $(document).ready(function(){
        var i=1;
        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'"><td><select class="span" name="serviceName[]"><option>-- Select Service --</option><?php $lablist = select("SELECT * FROM lablist");if($lablist){foreach($lablist as $labRow){?><option value="<?php echo $labRow['labName']?>"><?php echo $labRow['labName'];?></option><?php }}?></select></td><td><input type="number" step="any" min="1" name="servicePrice[]" placeholder="Price" class="span11" required /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
</script>
</body>
</html>
