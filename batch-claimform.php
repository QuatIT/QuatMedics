<?php session_start();
// require_once __DIR__ . '/vendor/autoload.php';
//
// $mpdf = new \Mpdf\Mpdf();
// $mpdf->WriteHTML('');
// $mpdf->Output();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>QUATMEDIC</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="assets/css/font-awesome2.css" />
<link rel="stylesheet" href="css/font-awesome.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/colorpicker.css" />
<link rel="stylesheet" href="css/datepicker.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/maruti-style.css" />
<link rel="stylesheet" href="css/maruti-media.css" class="skin-color" />
<link rel="icon" href="quatmedics.png" type="image/x-icon" style="width:50px;">

    <style>
        hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #000;
    margin: 1em 0;
    padding: 0;
}
    </style>
</head>
<body>

<?php
	include "layout/head.php";

//	$patientID = $_GET['pid'];

	?>

<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li class="active"><a href="claim-index"><i class="icon icon-file"></i> <span>Claims</span></a> </li>
    <li> <a href="batch-claim"><i class="icon icon-file"></i> <span>Batch Claims</span></a> </li>
    </ul>
</div>




<div id="content">
  <div id="content-header">
    <div id="breadcrumb">

    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">CLAIM FORM (<?php echo $_GET['insurance']; ?>)</h3>


      <div class="text-center">
        <?php
        //PRINT BATCH CLAIM
          if($_GET['insurance']=="COSMOPOLITAN"){
            echo '<a href="claims/rx-batch/cosmopolitan?df='.$_GET['df'].'&dt='.$_GET['dt'].'&insurance='.$_GET['insurance'].'" class="btn btn-primary">Print Batch</a>';
          }elseif ($_GET['insurance']=="NHIS") {
            echo '<a href="claims/rx-batch/nhis?df='.$_GET['df'].'&dt='.$_GET['dt'].'&insurance='.$_GET['insurance'].'" class="btn btn-primary">Print Batch</a>';
          }elseif ($_GET['insurance']=="NHIS") {
            echo '<a href="claims/rx-batch/nhis?df='.$_GET['df'].'&dt='.$_GET['dt'].'&insurance='.$_GET['insurance'].'" class="btn btn-primary">Print Batch</a>';
          }elseif ($_GET['insurance']=="ACACIA") {
            echo '<a href="claims/rx-batch/acacia?df='.$_GET['df'].'&dt='.$_GET['dt'].'&insurance='.$_GET['insurance'].'" class="btn btn-primary">Print Batch</a>';
          }elseif ($_GET['insurance']=="MOMENTUM") {
            echo '<a href="claims/rx-batch/momentum?df='.$_GET['df'].'&dt='.$_GET['dt'].'&insurance='.$_GET['insurance'].'" class="btn btn-primary">Print Batch</a>';
          }elseif ($_GET['insurance']=="NATIONWIDE") {
            echo '<a href="claims/rx-batch/nationwide?df='.$_GET['df'].'&dt='.$_GET['dt'].'&insurance='.$_GET['insurance'].'" class="btn btn-primary">Print Batch</a>';
          }elseif ($_GET['insurance']=="PREMIER") {
            echo '<a href="claims/rx-batch/premier?df='.$_GET['df'].'&dt='.$_GET['dt'].'&insurance='.$_GET['insurance'].'" class="btn btn-primary">Print Batch</a>';
          }
        ?>


<!-- EXPORT SUMMARY CLAIM TO .XLS -->
        <a href="claims/rx-batch/batch_summary?df=<?php echo $_GET['df']; ?>&dt=<?php echo $_GET['dt'];?>&insurance=<?php echo $_GET['insurance']; ?>" class="btn btn-primary">Print Summary</a>
      </div>

<?php

      $insurance = $_GET['insurance'];
//	$claim_date = $_GET['dinst'];

      $datefrom = $_GET['df'];
      $dateto = $_GET['dt'];


	$consultation_sql = select("select * from consultation where dateInsert BETWEEN '$datefrom' AND '$dateto' && insuranceType='".$_GET['insurance']."' order by consultID asc");
	foreach($consultation_sql as $consultation_row){


	//patient deatils
	$patdetail_sql = select("select * from patient where patientID='".$consultation_row['patientID']."'");
	foreach($patdetail_sql as $patient_row){}

//	//calculate age
	$dateOfBirth = $patient_row['dob'];
	$today = date("Y-m-d");
	$diff = date_diff(date_create($dateOfBirth), date_create($today));

//	$consultation_sql = select("select * from consultation where patientID='$patientID' group by patientID order by consultID DESC");
	$prescription_sql = select("select * from prescriptions where  dateInsert BETWEEN '$datefrom' AND '$dateto' && patientID='".$consultation_row['patientID']."' && datePrescribe='".$consultation_row['dateInsert']."' order by prescribeCode asc");
	foreach($prescription_sql as $prescription_row){}
////
////	$consultation_sql = select("select * from consultation where patientID='$patientID' && insuranceType='".$_GET['insurance']."' && dateInsert='".$_GET['dinst']."' order by consultID asc");
////	foreach($consultation_sql as $consultation_row){}
//
	$prescribedmeds = select("select * from prescribedmeds where dateInsert='".$consultation_row['dateInsert']."' && prescribeCode='".$prescription_row['prescribeCode']."' ");

	$investigation = select("select * from investigation_tb where dateRegistered='".$consultation_row['dateInsert']."' && patientID='".$consultation_row['patientID']."' && consultID='".$consultation_row['consultID']."'  ");

	$diagnosis = select("select * from diagnose_tb where dateRegistered='".$consultation_row['dateInsert']."' && patientID='".$consultation_row['patientID']."' && consultID='".$consultation_row['consultID']."' ");


?>

      <div class="row-fluid">
        <div class="widget-box">

            <div class="widget-content tab-content" style="">

				<div class="container row">
				<div class="span7" style="padding-left:20px; word-spacing: 10px;">
					<h5 style="text-decoration:underline;">Individual Personal Detail</h5>
					<u>Patient ID</u>: <b><?php echo strtoupper(@$patient_row['patientID']); ?></b>
					 <u>Patient Name</u>: <b><?php echo strtoupper(@$patient_row['firstName']." ".@$patient_row['otherName']." ".@$patient_row['lastName']); ?></b>
					<br><u>Age</u>:<b><?php echo $diff->format('%y'); ?></b>
					<u>Gender</u>: <b><?php echo strtoupper(@$patient_row['gender']); ?></b>
					<u>NHIS No</u>: <b><?php echo $consultation_row['insuranceNumber']; ?></b>
					<u>Date</u>: <b><?php echo $consultation_row['dateInsert']; ?></b>
					</div>
				<div class="span5">
					<h5 style="text-decoration:underline;">Specialties</h5>

					<!-- search if patient has been to consultation -->
				<?php
						$search_consultation = select("select * from consultation where patientID='".$patient_row['patientID']."' && dateInsert='".$patient_row['dateRegistered']."' ");
						if(count($search_consultation)>=1){
							echo '<input type="checkbox" name="OUT" checked  onclick="return false;"> Out-Patient';
							echo '<input type="checkbox" name="OUT" onclick="return false;"> In-Patient';
						}
				?>

					<!-- search if patient has been to ward -->
				<?php
						$search_ward = select("select * from wardassigns where patientID='".$patient_row['patientID']."' && dateInsert=".$patient_row['dateRegistered']." ");
						if(count($search_ward)>=1){
							echo '<input type="checkbox" name="OUT" onclick="return false;"> Out-Patient';
							echo '<input type="checkbox" name="OUT" checked onclick="return false;"> In-Patient';
						}
				?>

					<!-- search if patient has been to prescriptions -->
				<?php
						$search_prescriptions = select("select * from prescriptions where patientID='".$patient_row['patientID']."' && dateInsert=".$patient_row['dateRegistered']." ");
						if(count($search_prescriptions)>=1){
							echo '<input type="checkbox" name="OUT" checked onclick="return false;"> Pharmacy';
						}
				?>

	<!-- <input type="checkbox" name="OUT"> Out-Patient
					<input type="checkbox" name="IN"> In-Patient -->

					<hr>

					<b>Number of Claims:</b> <?php $numcliams = select("select * from consultation where patientID='".$patient_row['patientID']."' && insuranceType='".$_GET['insurance']."'"); echo @count($numcliams); ?>
					 | <b>Claim Number:</b> <?php echo sprintf('%010d',@$consultation_row['claimNumber']); ?>
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
								<td><?php echo @$diag_row['gdrg']?></td>
								<td><?php echo @$diag_row['dateRegistered']?></td>
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
              <th>Number of Intakes</th>
              <th>Dosage per Day</th>
              <th>Number of Days</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Code</th>
						</tr>
						</thead>
						<tbody>
							<?php
								$counterz = 1;
								foreach($prescribedmeds as $prescribedmeds_row){
										$meds = select("select * from pharmacy_inventory where mode_of_payment='$insurance' && medicine_name='".$prescribedmeds_row['medicine']."'  ");
										foreach($meds as $med){}
                                    $dosage =  " ".$prescribedmeds_row['dosage'];

                                    //remove numbers from string
                                    preg_match_all('!\d+!', $dosage, $matches);
                                    foreach($matches as $dose){}
											// $amount = $med['price'] * $prescribedmeds_row['totalMeds'];

											//get medicine code
											$medicine_codes = select("select * from pharmacy_inventory where medicine_name = '".$prescribedmeds_row['medicine']."' ");
											foreach($medicine_codes as $medicine_code){}
									?>
							<tr>
								<td><?php echo @$counterz++; ?></td>
								<td><?php echo @$prescribedmeds_row['medicine'];?></td>
								<td><?php echo @$prescribedmeds_row['dosage'];?></td>
                <td><?php echo @$dose[0]; ?></td>
                <td><?php echo @$dose[1]; ?></td>
                <td><?php echo @$dose[2]; ?></td>
								<td><?php echo @$medicine_code['price'];?></td>
								<td><?php echo @$prescribedmeds_row['totalMeds'];?></td>
								<td><?php echo @$prescribedmeds_row['medprice'];?></td>
								<td><?php echo @$prescribedmeds_row['dateInsert'];?></td>
								<td><?php echo @$medicine_code['medicine_id'];?></td>
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
						</tr>
						</thead>
						<tbody>
							<?php

								$counter='1';
								foreach($investigation as $invest_row){
							?>
							<tr>
								<td><?php echo @$counter++; ?></td>
								<td><?php echo @$invest_row['labID']; ?></td>
								<td><?php echo @$invest_row['dateInsert']; ?></td>

								<?php
										if(isset($_POST['btninvestigation'.$invest_row['id']])){
											$findings = $_POST['examination'];

											$update_findings = update("update investigation_tb set examination='$findings' where id='".$invest_row['id']."' ");

											      if($update_findings){
											        $success =  "<script>document.write('FINDINGS UPDATED SUCCESSFULLY')
											                      window.location.href='claimform?pid={$patientID}&insurance={$insurance}&dinst={$claim_date}'</script>";
											      }else{
											        $error = "FINDINGS UPDATE FAILED";
											      }
														echo "<script>window.location.href='claimform?pid={$patientID}&insurance={$insurance}&dinst={$claim_date}'</script>";
										}
								?>

								<!-- Modal -->
								<div id="update_investigation<?php echo $invest_row['id']; ?>" class="modal fade" role="dialog">
								<div class="modal-dialog">

									<!-- Modal content-->
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Examination Findings</h4>
										</div>
										<form action="" method="post">
											<div class="modal-body">
												<div class="span11">
														Findings
														<textarea name="examination" class="form-control span12"><?php echo @$invest_row['examination']; ?></textarea>
												</div>
											</div>

									       <div class="modal-footer">
									         <button type="submit" class="btn btn-primary" name="btninvestigation<?php echo $invest_row['id']; ?>">Update</button>
									         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									       </div>
											 </form>
								     </div>

								   </div>
								 </div>


							</tr>


							<?php } ?>
						</tbody>
					</table>

					</div>

					</div>


				</div>

		  </div>

	  </div>
      <hr>
      <?php } ?>
    </div>
</div>
<div class="row-fluid">
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
