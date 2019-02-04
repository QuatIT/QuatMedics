<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUATMEDIC ADMIN</title>
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

    $centerID = $_SESSION['centerID'];
    $consultation = new Consultation();
    //generate $PatientID
    $depIDs = $consultation->loadDepartment($centerID)+ 1;

    $success = '';
    $error = '';

//saving Departments..
if(isset($_POST['saveDepartment'])){
	//count number of departments entered..
	$nameNum = count( $_POST['departmentName']);
	//check number of services..
	if($nameNum > 0 ){
		//saving services into database...
		for($n=0; $n<$nameNum; $n++){
				if(trim($_POST['departmentName'][$n] != '')) {
					$departmentName = trim( $_POST['departmentName'][$n]);

					//generate department ID
					$depIDs = $consultation->loadDepartment($centerID)+ 1;
					$departmentID =  "DEP.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$depIDs);

					//check department name, if already entered else save account..
					$depExist = select("SELECT * FROM department WHERE departmentName='$departmentName' AND centerID='$centerID'");
					if($depExist){
						$error = "<script>document.write('Department Already Saved..');</script>";
					}else{
						$saveDepartment = insert("INSERT INTO department(departmentID,centerID,departmentName,dateInsert) VALUES('$departmentID','$centerID','$departmentName','$dateToday')");
						if($saveDepartment){
							$success = "<script>document.write('Department Saved.');window.location='centerdepartment-index';</script>";
						}else{
							$error = "<script>document.write('Department Not Saved, Try Again.');</script>";
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
    <li class="active"><a href="centerdepartment-index"><i class="icon icon-tasks"></i> <span>Department Management</span></a> </li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Department Management" class="tip-bottom"><i class="icon-tasks"></i> DEPARTMENT</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">DEPARTMENT MANAGEMENT</h3>
		<?php if($success){ ?>
			<div class="alert alert-success">
			<strong>Success : </strong> <?php echo $success; ?>
			</div>
		<?php } if($error){ ?>
			<div class="alert alert-danger">
			<strong>Error : </strong> <?php echo $error; ?>
			</div>
		<?php } ?>
      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">DEPARTMENT</a></li>
                </ul>
            </div>
<!--        <div class="widget-box">-->
            <div class="widget-content tab-content">
				<div class="span6">
                    <form action="#" method="post" class="form-horizontal">
						  <table class="table table-bordered" id="dynamic_field2">
							<tr>
								<td style="width:60%;">
									<select class="span" name="departmentName[]" required>
										<option value="OPD"> OPD </option>
										<option value="CONSULTATION"> CONSULTATION </option>
										<option value="LABORATORY"> LABORATORY </option>
										<option value="WARD"> WARD </option>
										<option value="PHARMACY"> PHARMACY </option>
										<option value="FINANCE"> FINANCE </option>
									</select>
								</td>
								<td><button type="button" name="add" id="add2" class="btn btn-primary">ADD DEPARTMENT</button></td>
							</tr>
						</table>
						  <div class="form-actions">
							  <i class="span5"></i>
							  <button type="submit" name="saveDepartment" class="btn btn-primary btn-block span6"> SAVE DEPARTMENT</button>
						  </div>
              		</form>
				</div>

				<div class="span6">
					<table class="table table-bordered table-stripped">
						<thead>
							<th> DEPARTMENT ID</th>
							<th> DEPARTMENT NAME</th>
						</thead>
						<tbody>
							<?php
							$allAcc = select("SELECT * FROM department WHERE centerID='$centerID'");
							if($allAcc){
								foreach($allAcc as $accRow){
							?>
							<tr>
								<td><?php echo $accRow['departmentID'];?></td>
								<td><?php echo $accRow['departmentName'];?></td>
<!--								<td><?php// echo $accRow['accBalance'];?></td>-->
							</tr>
							<?php }}else{?>
							<tr><td colspan="3"> <h6 class="text-center">NO DEPARTMENTS SAVED.</h6></td></tr>
							<?php }?>
						</tbody>
					</table>
				</div>
			</div>
		  </div>
        </div>
      </div>
<!--  </div>-->
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

<script>
//    $(document).ready(function(){
        var i=1;
        $('#add2').click(function(){
            i++;
            $('#dynamic_field2').append('<tr id="row'+i+'"><td style="width:60%;"><select class="span" name="departmentName[]" required><option value="OPD"> OPD </option><option value="CONSULTATION"> CONSULTATION </option><option value="LABORATORY"> LABORATORY </option><option value="WARD"> WARD </option><option value="PHARMACY"> PHARMACY </option><option value="FINANCE"> FINANCE </option></select></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
</script>

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

$(".alert").delay(6000).slideUp(1000, function() {
    $(this).alert('close');
});
</script>
</body>
</html>
