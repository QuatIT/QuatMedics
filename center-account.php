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

$consultation = new Consultation();
$centerID = $_SESSION['centerID'];
$success = '';
$error = '';


//saving Account..
if(isset($_POST['saveAccount'])){
	//count number of service entered..
	$nameNum = count(ucwords($_POST['accountName']));
	$typeNum = count(ucwords($_POST['accountType']));
	//check number of services..
	if($nameNum > 0 && $typeNum >0){
		//saving services into database...
		for($n=0, $t=0; $n<$nameNum, $t<$typeNum; $n++,$t++){
				if(trim($_POST['accountName'][$n] != '') && trim($_POST['accountType'][$t] != '')) {
					$accountName = trim(ucwords($_POST["accountName"][$n]));
					$accountType = trim(ucwords($_POST["accountType"][$t]));
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
        <a title="ACCOUNT MANAGEMENT" class="tip-bottom"><i class="icon-file"></i> ACCOUNT MANAGEMENT</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">ACCOUNT MANAGEMENT</h3>
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
							<?php }}else{?>
							<tr><td colspan="3"> <h6 class="text-center">NO ACCOUNTS SAVED.</h6></td></tr>
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
  	<div id="footer" class="span12">
	  2018 &copy; QUAT MEDICS ADMIN By  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a>
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
            $('#dynamic_field2').append('<tr id="row'+i+'"><td><select class="span" name="accountName[]" required><option value="OPD"> OPD </option><option value="CONSULTATION"> CONSULTATION </option><option value="LABORATORY"> LABORATORY </option><option value="WARD"> WARD </option><option value="PHARMACY"> PHARMACY </option></select></td><td><select class="span" name="accountType[]" required><option value="CREDIT"> CREDIT ACCOUNT </option></select></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
</script>
</body>
</html>
