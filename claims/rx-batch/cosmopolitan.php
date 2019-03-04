<?php
    include '../../assets/core/connection.php';

    // $patient_id = $_GET['pid'];
    $insurance = $_GET['insurance'];
    $datefrom = $_GET['df'];
    $dateto = $_GET['dt'];
    // $date_insert = $_GET['dinst'];






    //get patient details for claims
    $patient_details = select("select * from insure_data where dateinsert between '$datefrom' AND '$dateto' && insurancetype='$insurance' ");
    // $patient_details = select("select * from insure_data where patientid='$patient_id' && dateinsert='$date_insert' ");
    foreach($patient_details as $patient_detail){


//check patient table for patient detail
$patient_details = select("select * from patient where patientID='".$patient_detail['patientid']."' ");
foreach($patient_details as $patient_row){}

//check consultation for some patient data
$consultation_query = select("select * from consultation where patientID='".$patient_detail['patientid']."' AND insuranceType='$insurance' AND dateInsert between '$datefrom' AND '$dateto' ");
foreach($consultation_query as $consultation_row){}

//Check diagnosis
$diagnosis_query = select("select * from diagnose_tb where patientID='".$patient_detail['patientid']."' && dateRegistered between '$datefrom' AND '$dateto' ");

//CHECK TARIFF IN NHIS_TARIFF
$med_tarif = select("select * from nhis_tariff where patientid='".$patient_detail['patientid']."'");
foreach($med_tarif as $med_taf){}

//check medicine for tariff
$med_tarf = select("select * from insure_med_frequency where patientid='".$patient_detail['patientid']."' && dateinsert='".$patient_detail['dateinsert']."' ");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>COSMOPOLITAN</title>

<!-- Bootstrap -->
<link href="css/bootstrap-4.0.0.css" rel="stylesheet">

    <style>
        input[type='text']{font-weight: bolder;}
        input[type='date']{font-weight: bolder;}
        select{font-weight: bolder;}
    </style>
</head>
<body>
<div class="container" style="padding-top: 40px">
  <div class="text-center">
    <h3>COSMOPOLITAN HEALTH INSURANCE</h3>
    <p><?php echo @$patient_detail['centername']; ?></p>
  </div>
  <form>
    CLAIM No. <b><?php echo @$consultation_row['claimNumber']; ?></b>
    <div class="card">
      <div class="card-header"> Claim Form </div>
      <div class="card-body">
        <h5>Patient</h5>
        <hr>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="surname">Surname</label>
            <input type="text" class="form-control form-control-sm" id="surname" readonly placeholder="Surname" name="surname" value="<?php echo @$patient_detail['lastname']; ?>">
          </div>
          <div class="form-group col-md-4">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control form-control-sm" id="first_name" readonly placeholder="First Name" name="first_name" value="<?php echo @$patient_detail['firstname']; ?>">
          </div>
          <div class="form-group col-md-4">
            <label for="other_names">Other Names</label>
            <input type="text" class="form-control form-control-sm" id="other_names" readonly placeholder="Other Names" name="other_names" value="<?php echo @$patient_detail['othername']; ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="company">Company</label>
            <input type="text" class="form-control form-control-sm" id="company" readonly placeholder="Company" name="company" value="<?php if(empty(@$patient_detail['company'])){echo "-";}else{echo $patient_detail['company'];}; ?>">
          </div>
          <div class="form-group col-md-2">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" class="form-control form-control-sm" id="date_of_birth" readonly placeholder="Date of Birth" name="date_of_birth" value="<?php echo @$patient_detail['dob']; ?>">
          </div>
          <div class="form-group col-md-2">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" class="form-control  form-control-sm" readonly>
              <option selected><?php echo @$patient_detail['gender']; ?></option>
<!--
              <option value="male">Male</option>
              <option value="female">Female</option>
-->
            </select>
          </div>
          <div class="form-group col-md-2">
            <label for="phone">Phone</label>
            <input type="text" class="form-control form-control-sm" id="phone" placeholder="Phone" name="phone" readonly value="<?php echo @$patient_row['phoneNumber']; ?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-2">
            <label for="member_number">Member Number</label>
            <input type="text" class="form-control form-control-sm" id="member_number" placeholder="Member Number" name="member_number" value="<?php echo @$patient_detail['patientid']; ?>" readonly>
          </div>
          <div class="form-group col-md-4">
            <label for="plan">Plan</label>
            <input type="text" class="form-control form-control-sm" id="plan" placeholder="Plan" name="plan" readonly>
          </div>
          <div class="form-group col-md-2">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control  form-control-sm" readonly>
              <option selected><?php echo @$patient_detail['status']; ?></option>
<!--
              <option value="in_patient">In-Patient</option>
              <option value="out_patient">Out-Patient</option>
-->
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="refered_by">Refered By (Name of HSP)</label>
            <input type="text" class="form-control form-control-sm" id="refered_by" placeholder="Refered By (Name of Hospital)" name="refered_by" readonly>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="service_provider">Service Provider</label>
            <input type="text" class="form-control form-control-sm" id="service_provider" placeholder="Service Provider's Name" name="service_provider" value="<?php echo @$patient_detail['centername']; ?>">
          </div>
          <div class="form-group col-md-12">
            <label for="diagnosis">Diagnosis</label>
            <textarea name="diagnosis" id="diagnosis" cols="30"  class="form-control form-control-sm"><?php foreach($diagnosis_query as $diag_row){echo @$diag_row['diagnosis'].",";}?></textarea>
          </div>
        </div>
        <h5>Claim Details</h5>
        <hr>
        <table class="table table-bordered table-sm">
          <tbody>
            <tr>
              <th style="text-align:center" scope="col">Tarrif Code</th>
              <th style="text-align:center" scope="col">Description</th>
              <th style="text-align:center" scope="col">Qty</th>
              <th style="text-align:center" scope="col">From</th>
              <th style="text-align:center" scope="col">Fee Charged</th>
            </tr>

            <tr>
              <td style="text-align:center">1</td>
              <td>OPD & CONSULTATION</td>
              <td style="text-align:center">1</td>
              <td rowspan="<?php echo count(@$med_tarf) + 1; ?>">&nbsp;</td>
              <td style="text-align:right"><?php echo @$med_taf['Tariff']; ?></td>
            </tr>

            <?php foreach($med_tarf as $medt){ ?>
              <tr>
                <td style="text-align:center">2</td>
                <td><?php echo @$medt['medicine']; ?></td>
                <td style="text-align:center"><?php echo count(select("select count(medicine) from insure_med_frequency where patientid='".$patient_detail['patientid']."' && dateinsert='".$patient_detail['dateinsert']."' ")); ?></td>

                <td style="text-align:right"><?php echo @$medt['medprice']; ?></td>
              </tr>
            <?php } ?>

            <tr>
              <td colspan="3" rowspan="3"><small>I confirm that ....</small></td>
              <th style="text-align: center">Amount Due</th>
              <th style="text-align: right"><?php echo @number_format((float)$med_taf['Total'], 2, '.', ''); ?></th>
            </tr>
            <tr>
              <th colspan="2">Patient's signature : <?php echo strtoupper(@$patient_detail['lastname']." ".@$patient_detail['othername']." ".@$patient_detail['firstname']); ?></th>
            </tr>
            <tr>
              <th >Date : <?php echo @$patient_detail['dateinsert']; ?></th>
              <th >Stamp : </th>
            </tr>
          </tbody>
        </table>
        <hr>
        <small>I certify that ...</small>
        <h6>Please check where applicable</h6>
        <div class="form-row">
          <div class="form-group col-md-2">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="doctor" value="doctor">
              <label class="form-check-label" for="doctor">Dr.</label>
            </div>
          </div>
          <div class="form-group col-md-2">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="dental" value="dental">
              <label class="form-check-label" for="dental">Dental</label>
            </div>
          </div>
          <div class="form-group col-md-2">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="pharmacy" value="pharmacy">
              <label class="form-check-label" for="pharmacy">Parm.</label>
            </div>
          </div>
          <div class="form-group col-md-2">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="optician" value="optician">
              <label class="form-check-label" for="optician">Optician</label>
            </div>
          </div>
          <div class="form-group col-md-2">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="lab_tech" value="lab_tech">
              <label class="form-check-label" for="lab_tech">Lab Tech.</label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="name">Name</label>
            <input type="text" class="form-control form-control-sm" id="name" placeholder="Name" name="name">
          </div>
          <div class="form-group col-md-4">
            <label for="date">Date</label>
            <input type="date" class="form-control form-control-sm" id="date" placeholder="Date" name="date">
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

<?php } ?>
