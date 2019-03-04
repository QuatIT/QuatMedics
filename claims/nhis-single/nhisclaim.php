<?php
    include '../../assets/core/connection.php';
@session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}else{
    $staff = select("SELECT * from centeruser WHERE username='".$_SESSION['username']."' AND password='".$_SESSION['password']."'");
    foreach($staff as $staffrow){
        $staffID = $staffrow['staffID'];
    }
}

//get staff details
$staff_details = select("select * from staff where staffID='$staffID' ");
foreach($staff_details as $staff_row){}


    $patient_id = $_GET['pid'];
    $insurance = $_GET['insurance'];
    $date_insert = $_GET['dinst'];


//GET PATIENT DETAIL FROM INSURE_DATA VIEW
$patients_view = select("SELECT * FROM insure_data where patientid='$patient_id' ");
foreach($patients_view as $patient_row){}

if(count($patients_view)>0){
//calculate age
$dateOfBirth = $patient_row['dob'];
$today = date("Y-m-d");
$diff = date_diff(date_create($dateOfBirth), date_create($today));


//consultation
$consultation_query = select("select * from consultation where patientID='$patient_id' && dateinsert='$date_insert'");
foreach($consultation_query as $consult_row){}


//diagnosis
$diagnosis = select("select * from diagnose_tb where patientID='$patient_id' && dateRegistered='$date_insert' ");

$diagnose_count = '1';


//medicine
$medis = select("select * from insure_med_frequency where patientid='$patient_id' && dateinsert='$date_insert' ");

$medicine_count ='1';


//investigation
$investigation_count = '1';

//search for lab results / investigations
$investigations = select("select * from labresults where patientID='$patient_id' && dateInsert='$date_insert' ");


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>NHIS</title>

<!-- Bootstrap -->
<link href="css/bootstrap-4.0.0.css" rel="stylesheet">
</head>
<body>

<div class="container">
  <form>
    <div class="text-center pull-right">
      <h3><b>NATIONAL HEALTH INSURANCE SCHEME</b></h3>
      <p><?php echo $patient_row['centername']; ?></p>

    </div>

    <div>

        Form No. <?php echo $consult_row['claimNumber']; ?> <br>
        HI Code : <span class="pull-right" style="float:right;">CCC: <?php echo $consult_row['cc_number']; ?><span>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-8"> Name of Scheme
            <input type="text" class="form-control form-control-sm" id="scheme" placeholder="Scheme" name="scheme" value="<?php echo $patient_row['centername']; ?>" readonly>
          </div>
          <div class="form-group col-md-2"> Claim Number
            <input type="text" class="form-control form-control-sm" id="claim_number" placeholder="Claim Number" name="claim_number" value="<?php echo $consult_row['claimNumber']; ?>" readonly>
          </div>
          <div class="form-group col-md-2"> Claim Date
            <input type="date" class="form-control form-control-sm" id="claim_date" placeholder="Claim Date" name="claim_date" value="<?php echo $consult_row['dateInsert']; ?>" readonly>
          </div>
        </div>
        <strong>Client Information</strong>
        <div class="form-row">
          <div class="form-group col-md-4"> Surname
            <input type="text" class="form-control form-control-sm" value="<?php echo $patient_row['lastname'];?>" readonly id="surname" placeholder="Surname" name="surname">
          </div>
          <div class="form-group col-md-6"> Other Names
            <input type="text" class="form-control form-control-sm" id="other_names" placeholder="Other Names" name="other_names" value="<?php echo $patient_row['firstname'].' '.$patient_row['othername'];?>" readonly >
          </div>
          <div class="form-group col-md-2"> Gender
            <select id="gender" name="gender" class="form-control  form-control-sm" readonly>
              <option selected><?php echo $patient_row['gender']; ?></option>
<!--
              <option value="male">Male</option>
              <option value="female">Female</option>
-->
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-2"> Date of Birth
            <input type="date" class="form-control form-control-sm" id="date_of_birth" name="date_of_birth" value="<?php echo $patient_row['dob'];?>" readonly >
          </div>
          <div class="form-group col-md-1"> Age
            <input type="text" class="form-control form-control-sm" id="age" placeholder="Age" name="age" value="<?php echo $diff->format('%y'); ?>" readonly>
          </div>
          <div class="form-group col-md-3"> NHIS No.
            <input type="text" class="form-control form-control-sm" placeholder="NHIS number" id="nhis_number" name="nhis_number" value="<?php echo $patient_row['insurancenumber'];?>" readonly>
          </div>
          <div class="form-group col-md-3"> Hospital Record No.
            <input type="text" class="form-control form-control-sm" placeholder="Hospital Record number" id="hospital_record_number" name="hospital_record_number" value="<?php echo $patient_row['patientid'];?>" readonly>
          </div>
        </div>
        <strong>Services Provided</strong><small> ( To be filled by all health care providers )</small>
        <div class="form-row">
          <div class="col-sm-8 col-xs-12">
            <div class="card"> <span style="padding-left: 5px">Type of Services</span>
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <td><Strong>A.</Strong> Select only one <br>


                        					<!-- search if patient has been to consultation -->
                        				<?php
                        						$search_consultation = select("select * from consultation where patientID='$patient_id' && dateInsert='$date_insert' ");
                        						if(count($search_consultation)>=1){
                        							echo '<div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="out_patient" checked id="out_patient" onclick="return false;">
                                      <label class="form-check-label" for="out_patient"> Out-Patient </label>
                                    </div>';
                        						}
                        				?>

                        					<!-- search if patient has been to ward -->
                        				<?php
                        						$search_ward = select("select * from wardassigns where patientID='$patient_id' && dateInsert='$date_insert' ");
                        						if(count($search_ward)>=1){
                        							echo '<div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="in_patient" checked id="in_patient" onclick="return false;">
                                      <label class="form-check-label" for="in_patient"> In-Patient </label>
                                    </div>';
                        						}
                        				?>

                        					<!-- search if patient has been to prescriptions -->
                        				<?php
                        						$search_prescriptions = select("select * from prescriptions where patientID='$patient_id' && dateInsert='$date_insert' ");
                        						if(count($search_prescriptions)>=1){
                        							echo '<div class="form-check">
                                      <input class="form-check-input" type="checkbox" checked value="pharmacy" id="pharmacy" onclick="return false;">
                                      <label class="form-check-label" for="pharmacy"> Pharmacy </label>
                                    </div>';
                        						}
                        				?>

                          <?php
                            #if($patient_row['status']="Outpatient"){
                            ?>

                              <!-- <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="out_patient" checked id="out_patient" onclick="return false;">
                              <label class="form-check-label" for="out_patient"> Out-Patient </label>
                            </div> -->
                            <!-- <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="diagnostic" id="diagnostic" onclick="return false;">
                              <label class="form-check-label" for="diagnostic"> Diagnostic </label>
                            </div></td>
                          <td><div class="form-check">
                              <input class="form-check-input" type="checkbox" value="in_patient" id="in_patient" onclick="return false;">
                              <label class="form-check-label" for="in_patient"> In-Patient </label>
                            </div></td>
                          <td><div class="form-check">
                              <input class="form-check-input" type="checkbox" checked value="pharmacy" id="pharmacy" onclick="return false;">
                              <label class="form-check-label" for="pharmacy"> Pharmacy </label>
                            </div> -->

                          <?php
                          #  }elseif($patient_row['status']="Inpatient"){
                                ?>


                              <!-- <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="out_patient" id="out_patient" onclick="return false;">
                          <label class="form-check-label" for="out_patient"> Out-Patient </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" checked value="diagnostic" id="diagnostic" onclick="return false;">
                          <label class="form-check-label" for="diagnostic"> Diagnostic </label>
                        </div></td>
                      <td><div class="form-check">
                          <input class="form-check-input" type="checkbox" value="in_patient" checked id="in_patient" onclick="return false;">
                          <label class="form-check-label" for="in_patient"> In-Patient </label>
                        </div></td>
                      <td><div class="form-check">
                          <input class="form-check-input" type="checkbox" checked value="pharmacy" id="pharmacy" onclick="return false;">
                          <label class="form-check-label" for="pharmacy"> Pharmacy </label>
                        </div> -->


                            <?php
                            #}
                          ?>

                        </td>
                    </tr>
                    <tr>
                      <td><Strong>B.</Strong> <br></td>
                      <td><div class="form-check">
                          <input class="form-check-input" type="checkbox" value="all_inclusive" id="all_inclusive" onclick="return false;">
                          <label class="form-check-label" for="all_inclusive"> All Inclusive </label>
                        </div></td>
                      <td><div class="form-check">
                          <input class="form-check-input" type="checkbox" value="unbundled" id="unbundled" onclick="return false;">
                          <label class="form-check-label" for="unbundled"> Unbundled </label>
                        </div></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <br>
            <div class="card"> <span style="padding-left: 5px">Outcome</span>
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <td><div class="form-check">
                          <input class="form-check-input" type="checkbox" value="discharged" id="discharged" onclick="return false;">
                          <label class="form-check-label" for="discharged" readonly> Discharged </label>
                        </div></td>
                      <td><div class="form-check">
                          <input class="form-check-input" type="checkbox" value="died" id="died" onclick="return false;">
                          <label class="form-check-label" for="died"> Died </label>
                        </div></td>
                      <td><div class="form-check">
                          <input class="form-check-input" type="checkbox" value="transfered_out" id="transfered_out" onclick="return false;">
                          <label class="form-check-label" for="transfered_out"> Transfered Out </label>
                        </div></td>
                    </tr>
                    <tr>
                      <td colspan="3"><div class="form-check">
                          <input class="form-check-input" type="checkbox" value="absconded" id="absconded" onclick="return false;">
                          <label class="form-check-label" for="absconded"> Absconded / Discharged against medical advice </label>
                        </div></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <br>
          </div>
          <div class="col-sm-4 col-xs-12"> <strong> Date(s) of Service Provisions</strong>
            <div class="form-row">
              <div class="form-group col-sm-12 col-xs-12"> 1st Visit / Admission
                <input type="date" class="form-control form-control-sm" id="first_date" name="first_date">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-sm-12 col-xs-12"> 2nd Visit / Discharge
                <input type="date" class="form-control form-control-sm" id="second_date" name="second_date">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-sm-12 col-xs-12"> 3rd Visit
                <input type="date" class="form-control form-control-sm" id="third_date" name="third_date">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-sm-12 col-xs-12"> 4t Visit
                <input type="date" class="form-control form-control-sm" id="fourth_date" name="fourth_date">
              </div>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-sm-12 col-xs-12">
            <div class="card"> <span style="padding-left: 5px">Type of Services</span>
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <td><div class="form-check">
                          <input class="form-check-input" type="checkbox" value="chronic_follow_up" id="chronic_follow_up">
                          <label class="form-check-label" for="chronic_follow_up"> Chronic Follow-up </label>
                        </div></td>
                      <td><div class="form-check">
                          <input class="form-check-input" type="checkbox" value="emergenty_or+accute_episode" id="emergenty_or+accute_episode">
                          <label class="form-check-label" for="emergenty_or+accute_episode"> Emergency / Acute episode </label>
                        </div></td>
                      <td><div class="form-group col-md-12">
                          <input type="text" class="form-control form-control-sm" id="specialty_code" placeholder="Specialty Code" name="specialty_code" readonly value="<?php echo $patient_row['gdrgcode']; ?>">
                        </div></td>
                    </tr>
                    <tr>
                      <td colspan="3">Specialty Description
                        <div class="form-group col-md-12">
                          <input class="form-control form-control-sm" type="text" readonly id="specialty_description" value="<?php $grd_decs = select("select * from gdrg_tb where gdrgcode='".$patient_row['gdrgcode']."'"); foreach($grd_decs as $gdrg_des){} echo $gdrg_des['description']; ?>">
                        </div></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
		  <p></p>
		  <strong>Procedure(s)</strong><small> To be filled by ....</small>
		   <div class="table-responsive">
		  <table class="table table-bordered table-sm">
  <tbody>
    <tr>
      <th scope="col" style="text-align:center">&nbsp;</th>
      <th scope="col" style="text-align:center">Description</th>
      <th scope="col" style="text-align:center">Date</th>
      <th scope="col" style="text-align:center">G-DRG</th>
    </tr>
    <tr>
      <td>Procedure 1</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Procedure 2</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	  <tr>
      <td>Procedure 3</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
		  </div>

		  <strong>Diagnosis</strong><small> To be filled by ....</small>
		  <div class="table-responsive">
		  <table class="table table-bordered table-sm">
  <tbody>
    <tr>
      <th scope="col" style="text-align:center">&nbsp;</th>
      <th scope="col" style="text-align:center">Description</th>
      <th scope="col" style="text-align:center">ICD-10</th>
      <th scope="col" style="text-align:center">G-DRG</th>
    </tr>
      <?php if(count($diagnosis)>=1){
            foreach( $diagnosis as $diagnose){
                $count_diagnose = $diagnose_count++;
      ?>
    <tr>
      <td><?php echo $count_diagnose; ?></td>
      <!-- <td><?php #echo $diagnose['id']; ?></td> -->
      <td><?php echo $diagnose['diagnosis']; ?></td>
      <td><?php echo $diagnose['icd10']; ?></td>
      <td><?php echo $diagnose['gdrg']; ?></td>
    </tr>
      <?php }} ?>
  </tbody>
</table>
		  </div>

		   <strong>Investigations</strong><small> To be filled by ....</small>
		  <div class="table-responsive">
		  <table class="table table-bordered table-sm">
  <tbody>
    <tr>
      <th scope="col" style="text-align:center">&nbsp;</th>
      <th scope="col" style="text-align:center">Description</th>
      <th scope="col" style="text-align:center">Date</th>
      <th scope="col" style="text-align:center">G-DRG</th>
    </tr>
      <?php if(count($investigations)>0){
            foreach($investigations as $investigation){
                $count_investigation = $investigation_count++;

                //get name of lab results by lab id
            $lab_details = select("select * from lablist where labID='".$investigation['labID']."' ");
                foreach($lab_details as $lab_detail){}
      ?>
    <tr>
      <td>Investigation <?php echo $count_investigation; ?></td>
      <td><?php echo @$lab_detail['labName']; ?></td>
      <td><?php echo @$investigation['dateInsert']; ?></td>
      <td>&nbsp;</td>
    </tr>
    <?php }} ?>
  </tbody>
</table>
		  </div>

		   <strong>Medicines</strong><small> To be filled by ....</small>
		  <div class="table-responsive">
		  <table class="table table-bordered table-sm">
  <tbody>
    <tr>
      <th scope="col" style="text-align:center">&nbsp;</th>
      <th scope="col" style="text-align:center">Description</th>
      <th scope="col" style="text-align:center">Prices</th>
      <th scope="col" style="text-align:center">Qty</th>
      <th scope="col" style="text-align:center">Total Cost</th>
      <th scope="col" style="text-align:center">Date</th>
      <th scope="col" style="text-align:center">Code</th>
    </tr>
      <?php if(count($medis)>0){
            foreach($medis as $medi){
                $count_medicine = $medicine_count++;


							//get medicine code
							$medicine_codes = select("select * from pharmacy_inventory where medicine_name = '".$medi['medicine']."' ");
							foreach($medicine_codes as $medicine_code){}
      ?>
    <tr>
      <!-- <td>MEDICINE <?php #echo $count_medicine; ?></td> -->
      <td>MEDICINE <?php echo $count_medicine; ?></td>
      <td><?php echo @$medi['medicine']." [".$medi['dosage']."]"; ?></td>
      <td><?php echo @$medicine_code['price'];?></td>
      <td><?php echo @$medi['totalmeds']; ?></td>
      <td><?php echo @$medi['medprice']; ?></td>
      <td><?php echo @$medi['dateinsert']; ?></td>
      <td><?php echo @$medicine_code['medicine_id'];?></td>
    </tr>
    <?php }} ?>
  </tbody>
</table>
		  </div>

		  <strong>Client Claim Summary</strong>
		   <div class="form-row">
          <div class="col-sm-8 col-xs-12">
			  <div class="table-responsive">
		  <table class="table table-bordered table-sm">
  <tbody>
    <tr>
      <th scope="col" style="text-align:center">&nbsp;</th>
      <th scope="col" style="text-align:center">Type of Service</th>
      <th scope="col" style="text-align:center">G-DRG / Code</th>
      <th scope="col" style="text-align:center">Date</th>
      <th scope="col" style="text-align:center">Tarrif Amount</th>
    </tr>
    <tr>
      <td style="text-align:center"><strong>A</strong></td>
      <td>In-Patient</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="text-align:center"><strong>B</strong></td>
      <td>Out-Patient</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	  <tr>
      <td style="text-align:center"><strong>C</strong></td>
      <td>Investigations</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	   <tr>
      <td style="text-align:center"><strong>D</strong></td>
      <td>Pharmacy</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	   <tr>
      <td colspan="4" style="text-align:right"><strong>Total</strong></td>
      <td>&nbsp;</td>
    </tr>

  </tbody>
</table>
		  </div>
			   </div>

			   <div class="col-sm-4 col-xs-12">
			   <div class="form-row">
          <div class="form-group col-md-12"> Signature
            <textarea class="form-control form-control-sm" name="signamure" readonly><?php echo @$staff_row['firstName']." ".@$staff_row['otherName']." ".@$staff_row['lastName']; ?></textarea>
          </div>
          <div class="form-group col-md-12">Name
            <input type="text" class="form-control form-control-sm" id="Name" placeholder="Name" name="Name" value="<?php echo @$staff_row['firstName']." ".@$staff_row['otherName']." ".@$staff_row['lastName']; ?>" readonly><small>(Health Facility Insurace Officer)</small>
          </div>

        </div>
			   </div>
		  </div>
      </div>
    </div>
    <p></p>
    <div class="card">
      <div class="card-body">
		 <strong>Scheme Use Only</strong> <small>Available choises A&D or B&D or C&D or C or D</small>
		  <div class="form-row">
          <div class="form-group col-md-3"> Date Received
            <input type="date" class="form-control form-control-sm" id="date_received" placeholder="Date Received" name="date_received">
          </div>
          <div class="form-group col-md-3"> Action 1
            <input type="text" class="form-control form-control-sm" id="action1" placeholder="Action 1" name="action1">
          </div>
          <div class="form-group col-md-3">  Date
            <input type="date" class="form-control form-control-sm" id="date" placeholder="Claim Date" name="date">
          </div>
			   <div class="form-group col-md-3"> Signed
            <input type="text" class="form-control form-control-sm" id="signed" placeholder="Signed" name="claim_date">
          </div>
        </div>
		  <div class="form-row">
          <div class="form-group col-md-3"> Signed
            <input type="date" class="form-control form-control-sm" id="date_received" placeholder="Signed" name="date_received">
          </div>
          <div class="form-group col-md-3"> Action 1
            <input type="text" class="form-control form-control-sm" id="action1" placeholder="Action 1" name="action1">
          </div>
          <div class="form-group col-md-3">  Date
            <input type="date" class="form-control form-control-sm" id="date" placeholder="Claim Date" name="date">
          </div>
			   <div class="form-group col-md-3"> Signed
            <input type="text" class="form-control form-control-sm" id="signed" placeholder="Signed" name="claim_date">
          </div>
        </div>
		</div>
    </div>
  </form>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-3.2.1.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-4.0.0.js"></script>
</body>
</html>

<?php }else{echo "Patient not found."; } ?>
