<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUAT MEDICS ADMIN</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="assets/css/font-awesome.min.css" />
<link rel="stylesheet" href="css/font-awesome.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/colorpicker.css" />
<link rel="stylesheet" href="css/datepicker.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/maruti-style.css" />
<link rel="stylesheet" href="css/maruti-media.css" class="skin-color" />
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php
	include 'layout/head.php';

	$patientID = $_GET['pid'];


	//patient deatils
	$patdetail_sql = select("select * from patient where patientID='$patientID'");
	foreach($patdetail_sql as $patient_row){}

	//calculate age
	$dateOfBirth = $patient_row['dob'];
	$today = date("Y-m-d");
	$diff = date_diff(date_create($dateOfBirth), date_create($today));

//	$consultation_sql = select("select * from consultation where patientID='$patientID' group by patientID order by consultID DESC");
	$prescription_sql = select("select * from prescriptions where patientID='$patientID' order by prescribeCode asc");
	foreach($prescription_sql as $prescription_row){}

	$consultation_sql = select("select * from consultation where patientID='$patientID' order by consultID asc");
	foreach($consultation_sql as $consultation_row){}

	$prescribedmeds = select("select * from prescribedmeds where prescribeCode='".$prescription_row['prescribeCode']."' ");
	$investigation = select("select * from investigation_tb where patientID='$patientID' && consultID='".$consultation_row['consultID']."' ");
	$diagnosis = select("select * from diagnose_tb where patientID='$patientID' && consultID='".$consultation_row['consultID']."' ");

	?>

<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>

<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
<!--    <li class="active"><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>-->
<!--
    <li> <a href="opd-index.php"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
    <li> <a href="opd-patient.php"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
    <li><a href="opd-appointment.php"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
-->
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
<!--
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="" class="tip-bottom"><i class="icon-plus"></i> OPD</a>
        <a title="" class="tip-bottom"><i class="icon-plus"></i> PATIENT INFORMATION</a>
-->
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">CLAIM FORM (NHIS)</h3>

      <div class="row-fluid">
        <div class="widget-box">
<!--
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Patient List</a></li>
                </ul>
            </div>
-->
            <div class="widget-content tab-content" style="">

				<div class="container row">
				<div class="span6" style="padding-left:20px">
					<h5 style="text-decoration:underline;">Individual Personal Detail</h5>
					Patient ID: <input type="text" name="patient_id" value="<?php echo $patientID; ?>" readonly style="width:100px;">
					Patient Name: <input type="text" name="patient_name"value="<?php echo $patient_row['firstName']." ".$patient_row['otherName']." ".$patient_row['lastName']; ?>" readonly style="width:250px;">
					Age: <input type="text" name="age" readonly value="<?php echo $diff->format('%y'); ?>" style="width:50px;">
					Gender: <input type="text" name="gender" value="<?php echo $patient_row['gender']; ?>" readonly style="width:37px;">
					NHIS No: <input type="text" name="nhis_no" readonly style="width:100px;">
					Date: <input type="text" name="date" value="<?php echo $consultation_row['doe']; ?>" readonly style="width:100px;">
					</div>
				<div class="span6">
					<h5 style="text-decoration:underline;">Specialties</h5>
					<input type="checkbox" name="OUT"> Out-Patient
					<input type="checkbox" name="IN"> In-Patient
					</div>
					</div>
				</div>

		  </div>
	  <div class="widget-box">

            <div class="widget-content tab-content" style="">

				<div class="container row">
				<div class="span6" style="padding-left:20px">

					<h5 style="text-decoration:underline;">Diagnosis</h5>
					<table class="table">
					<thead>
						<tr>
							<th>No.</th>
							<th>Diagnosis</th>
							<th>ICD-10</th>
							<th>G-DRG</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
							<?php

								$count = 1;
								foreach($diagnosis as $diag_row){

							?>
							<tr>
								<td><?php echo @$count++; ?></td>
								<td><?php echo @$diag_row['diagnosis']; ?></td>
								<td><?php echo @$diag_row['icd10'];?></td>
								<td><?php echo @$diag_row['G-DRG']?></td>
								<td><?php echo @$diag_row['dateRegistered']?></td>
								<td><a href="update_diagnosis?id=<?php echo $diag_row['id']; ?>"><!--<i span="fa fa-pencil"></i>--> Update</a> | <a href="delete_diagnosis?id=<?php echo $diag_row['id']; ?>">Delete</a></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>


					<h5 style="text-decoration:underline;">Medicine (DRUG)</h5>
					<table class="table">
					<thead>
						<tr>
							<th>No.</th>
							<th>Medicine</th>
							<th>Frequency (Dosage)</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Code</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
							<?php
								$counterz = 1;
								foreach($prescribedmeds as $prescribedmeds_row){ ?>
							<tr>
								<td><?php echo $counterz++; ?></td>
								<td><?php echo $prescribedmeds_row['medicine'];?></td>
								<td><?php echo $prescribedmeds_row['dosage'];?></td>
								<td></td>
								<td></td>
								<td><?php echo $prescribedmeds_row['medprice'];?></td>
								<td><?php echo $prescribedmeds_row['dateInsert'];?></td>
								<td></td>
								<td><a href="update_med?id=<?php echo $prescribedmeds_row['id']; ?>"><!--<i span="fa fa-pencil"></i>--> Update</a> | <a href="delete_med?id=<?php echo $prescribedmeds_row['id']; ?>">Delete</a></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>


					</div>
				<div class="span6">

					<h5 style="text-decoration:underline;">Investigation</h5>
					<table class="table">
					<thead>
						<tr>
							<th>No.</th>
							<th>Findings</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
							<?php

								$counter='1';
								foreach($investigation as $invest_row){
							?>
							<tr>
								<td><?php echo $counter++; ?></td>
								<td><?php echo $invest_row['examination']; ?></td>
								<td><?php echo $invest_row['dateRegistered']; ?></td>
								<td><a href="update_investigation?id=<?php echo $invest_row['id']; ?>">Update</a> | <a href="delete_investigation?id=<?php echo $invest_row['id']; ?>">Delete</a></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>

					</div>
<!--
				<div class="span6">

					</div>
-->
					</div>
				</div>

		  </div>

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
            $('#dynamic_field2').append('<tr id="row'+i+'"><td><select class="span" name="serviceType"><option value="Service">Service</option><option value="Lab"> Lab Test</option></select></td><td><input type="text" name="ServiceName[]" placeholder="Service or Lab Name" class="span11" required /></td><td><input type="text" name="servicePrice[]" placeholder="Price" class="span11" required /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
</script>
</body>
</html>
