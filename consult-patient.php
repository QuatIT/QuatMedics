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
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<!--
    <style>
        .active{
            background-color: #209fbf;
        }
    </style>
-->
</head>
<body>


<?php
include 'layout/head.php';
//check access or redirect to 404...
if($_SESSION['accessLevel']=='CONSULTATION' || $_SESSION['username']=='rik'){

	//get variables..
$success = "";
$error = "";
$conid = $_GET['conid'];
$roomID = $_GET['roomID'];
//consulting room details....
$rm = select("SELECT * FROM consultingroom WHERE roomID='$roomID' ");
foreach($rm as $r){}
//consultation  details...
$consultdet = select("SELECT * from consultation WHERE consultID='$conid'");
//get consulting staff details...
$staff = select("SELECT staffID from centeruser where userName='".$_SESSION['username']."' AND password='".$_SESSION['password']."'");
foreach($staff as $staffrow){
	$staffID = $staffrow['staffID'];
}
//get patient details for consultation...
foreach($consultdet as $consultrow){
	   $patientID = $consultrow['patientID'];
$fetchpatient = select("SELECT firstName,lastName,otherName from patient WHERE patientID='$patientID' && lock_center='".$_SESSION['centerID']."'");
	foreach($fetchpatient as $ptndetails){
		$name = $ptndetails['firstName']." ".$ptndetails['otherName']." ".$ptndetails['lastName'];
	}
}

 //generate presciptionCode
$codesql = select("SELECT * From prescriptions order by prescribeCode DESC limit 1");
if(count($codesql) >=1){
	foreach($codesql as $coderow){
		$code = $coderow['prescribeCode'];
		$oldcode = explode("-",$code);
		$newID = $oldcode[1]+1;
		$prescribeCode = $oldcode[0]."-".$newID;
	}
}else{
	$prescribeCode = "PRSCB.".$centerID."-1";
}

 //generate labRequestID
$codesql = select("SELECT * From labresults order by labrequestID DESC limit 1");
if(count($codesql) >=1){
	foreach($codesql as $coderow){
		$code = $coderow['labRequestID'];
		$oldcode = explode("-",$code);
		$newID = $oldcode[1]+1;
		$labReqID = $oldcode[0]."-".$newID;
	}
}else{
	$labReqID = "LABREQ.".$centerID."-1";
}

//Request Laboratory.....
if(isset($_POST['reqLab'])){
    $labNumber = count($_POST['labName']);
	    $paymode = filter_input(INPUT_POST, "paymode", FILTER_SANITIZE_STRING);

    if($labNumber > 0) {
        for($i=0; $i<$labNumber; $i++){
                if(trim($_POST["labName"][$i] != '')){
                    $labID = trim($_POST["labName"][$i]);
                    $status = SENT_TO_LAB;
					$paystatus = trim("Not Paid");
					//get labName from lablist table...
					$getLabName = select("SELECT labName FROM lablist where labID='$labID'");
					foreach($getLabName as $labName){}
					//get lab price from prices table using the name...
					$getLp = select("SELECT * FROM prices WHERE serviceName='".$labName['labName']."'");
					foreach($getLp as $labPrice){}

$insertLabReq = insert("INSERT INTO labresults(labRequestID,consultID,labID,centerID,patientID,staffID,consultingRoom,status,paymode,paystatus,labprice,dateInsert) VALUES('$labReqID','".$_GET['conid']."','$labID','".$_SESSION['centerID']."','$patientID','$staffID','$roomID','$status','$paymode','$paystatus','".$labPrice['servicePrice']."','$dateToday')");

                        if($insertLabReq){
                             $success =  "LAB REQUEST SENT SUCCESSFULLY";
        $updatePatient = update("UPDATE consultation set status='$status' where patientID='$patientID' AND consultID='$conid'");
                            echo "<script>window.location='consult-index?roomID={$roomID}';</script>";
                        }else{
                            $error =  "ERROR: LAB REQUEST NOT SENT";
                        }
                    }
        }
    }else{
       $error =  "ERROR: NO LAB REQUEST MADE";
    }
}

//Admit patient to ward..
if(isset($_POST['adWard'])){
    $wardID = filter_input(INPUT_POST, "wardID", FILTER_SANITIZE_STRING);
    $admitDetails = filter_input(INPUT_POST, "admitDetails", FILTER_SANITIZE_STRING);
    $admitDate = filter_input(INPUT_POST, "admitDate", FILTER_SANITIZE_STRING);
    $dischargeDate = filter_input(INPUT_POST, "dischargeDate", FILTER_SANITIZE_STRING);
    $symptoms = filter_input(INPUT_POST, "symptoms", FILTER_SANITIZE_STRING);
    $diagnoses = filter_input(INPUT_POST, "diagnoses", FILTER_SANITIZE_STRING);
    $bedID = filter_input(INPUT_POST, "bedID", FILTER_SANITIZE_STRING);
    $status = SENT_TO_WARD;
	$medsNum = count($_POST['medicine']);
	$dosagesNum = count($_POST['dosage']);
    //generate wardassign IDs
    $wardasignsql = select("SELECT assignID From wardassigns order by assignID DESC limit 1");
    if(count($wardasignsql) >=1){
        foreach($wardasignsql as $assignrow){
            $id = $assignrow['assignID'];
            $oldid = explode("-",$id);
            $newID = $oldid[1]+1;
            $assignID = $oldid[0]."-".$newID;
        }
    }else{
        $assignID = "ASSIGN.".$centerID."-1";
    }

		for($m=0, $d=0; $m<$medsNum, $d<$dosagesNum; $m++,$d++){
			if(trim($_POST["medicine"][$m] != '') && trim($_POST['dosage'][$d] != '')) {
				$medicine = trim($_POST["medicine"][$m]);
				$dosage = trim($_POST["dosage"][$d]);

		$insertWardMeds = insert("INSERT INTO wardMeds(assignID,patientID,staffID,wardID,medicine,dosage,symptoms,diagnoses,dateInsert) VALUES('$assignID','$patientID','$staffID','$wardID','$medicine','$dosage','$symptoms','$diagnoses','$dateToday')");
				}

		}

    $insertassign = insert("INSERT INTO wardassigns(assignID,wardID,patientID,staffID,admitDate,dischargeDate,admitDetails,bedID,dateInsert) VALUES('$assignID','$wardID','$patientID','$staffID','$admitDate','$dischargeDate','$admitDetails','$bedID','$dateToday')");

	//update bed status to occupied..
	$updateBedStatus = update("UPDATE bedlist SET status='Occupied' WHERE bedID='$bedID'");


    if($insertassign &&$updateBedStatus){
        $success =  "PATIENT ADMITTION SAVE SUCCESSFULLY";
        $updatePatient = update("UPDATE consultation set status='$status' where patientID='$patientID' AND consultID='$conid'");
        echo "<script>window.location='consult-index?roomID={$roomID}'';</script>";
    }else{
        $error =  "ERROR: PATIENT ADMITTION NOT SAVED";
    }
}


//prescribe medication to patient...
if(isset($_POST['presMeds'])){
        $diagnoses = filter_input(INPUT_POST, "diagnoses", FILTER_SANITIZE_STRING);
        $symptoms = filter_input(INPUT_POST, "symptoms", FILTER_SANITIZE_STRING);
        $pharmacyID = filter_input(INPUT_POST, "pharmacyID", FILTER_SANITIZE_STRING);
        $paymode = filter_input(INPUT_POST, "paymode", FILTER_SANITIZE_STRING);
		$paystatus = trim("Not Paid");
        $status = SENT_TO_PHARMACY;
        $prescribeStatus = trim("Prescibed");
        $datePrescribe = trim(date("Y-m-d"));
        $prescriptionCode = randomString('4');

        $medIDNum = count($_POST['medName']);
        $piecesNum = count($_POST['pieces']);
        $adayNum = count($_POST['aday']);
        $totalDaysNum = count($_POST['totalDays']);

        if($medIDNum > 0 && $piecesNum > 0) {
			//saving prescription..
        $insertpresciption = insert("INSERT INTO prescriptions(patientID,prescribeCode,staffID,pharmacyID,symptoms,diagnose,prescribeStatus,datePrescribe,perscriptionCode,dateInsert) VALUES('$patientID','$prescribeCode','$staffID','$pharmacyID','$symptoms','$diagnoses','$prescribeStatus','$datePrescribe','$prescriptionCode','$dateToday')");

		//saving the prescribed medications....
		for($m=0, $p=0, $a=0, $t=0; $m<$medIDNum, $p<$piecesNum, $a<$adayNum, $t<$totalDaysNum; $m++,$p++,$a++,$t++){
				if(trim($_POST['medName'][$m] != '') && trim($_POST['pieces'][$p] != '') && trim($_POST['aday'][$a] != '') && trim($_POST['totalDays'][$t] != '')) {
					$medicineID = trim($_POST['medName'][$m]);
					$pieces = trim($_POST['pieces'][$p]);
					$aday = trim($_POST['aday'][$a]);
					$totalDays = trim($_POST['totalDays'][$t]);
					//get medicine name for insert qeury...
					$findmedname = select("SELECT medicine_name,unit_price,medicine_type FROM pharmacy_inventory WHERE medicine_id='$medicineID'");
					foreach($findmedname as $nameRow){
						$medicine = $nameRow['medicine_name'];
						$unitPrice = $nameRow['unit_price'];
						$medicinetype = $nameRow['medicine_type'];
					}

					if($medicinetype='Capsule' || $medicinetype='Tablet' || $medicinetype='Suppositories' || $medicinetype='Implants'){
						//set dosage..
						$dosage = $pieces." X ".$aday." For ".$totalDays." Day(s)";
						//medicine price calculation..
						$medprice = trim($unitPrice*$pieces);
					}else{

					}




		$insertMeds = insert("INSERT INTO prescribedmeds(prescribeCode,medicine,dosage,prescribeStatus,paystatus,medprice,paymode,dateInsert) VALUES('$prescribeCode','$medicine','$dosage','$prescribeStatus','$paystatus','$medprice','$paymode','$dateToday')");
					}
		}

              if($insertpresciption && $insertMeds){
                    $success =  "PRESCRIPTION SENT SUCCESSFULLY";
                    $updatePatient = update("UPDATE consultation set status='$status' where patientID='$patientID' AND consultID='$conid'");


            //sms
            $medcen = select("SELECT * FROM medicalcenter WHERE centerID='".$_SESSION['centerID']."' ");
            foreach($medcen as $medi_sms){}

            if($medi_sms['creditArr'] >=1){

                $patnum = select("SELECT * FROM patient WHERE patientID='$patientID' ");
            foreach($patnum as $ptn){}

//                $phone_number= $ptn['phoneNumber'];
                $tel= $ptn['phoneNumber'];
                $body = "Hello, Kindly use this code ".$prescriptionCode." to collect your medicine from the pharmacist. Thank you.";
            $frm = "QUATMEDIC";

//            $sms= sendsms($bdy,$phone_number);
               $sms_send= sendsmsme($tel,$body,$frm);

                if($sms_send){
                    $newCreditArr = $medi_sms['creditArr'] - 1;
                    $updatesms = update("UPDATE medicalcenter SET creditArr='$newCreditArr' WHERE centerID='".$_SESSION['centerID']."' ");
                }


            }else{
                $error= 'couldnt send code to patient';
            }

                    echo "<script>window.location='consult-index?roomID={$roomID}';</script>";
                }else{
                    $error =  "ERROR: PRESCRIPTION NOT SENT";
                }


        }else{
            $error =  "ERROR: NO PRESCRIPTION RECORED";
        }

    }

//echo $patientID;

?>


<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active" style="background-color: #209fbf;"> <a href="consult-index?roomID=<?php echo $roomID;?>"><i class="icon icon-briefcase"></i> <span>Consultation</span></a> </li>
    <li> <a href="consult-appointment?roomID=<?php echo $roomID;?>"><i class="icon icon-calendar"></i> <span>Appointments</span></a> </li>
    <li> <a href="consult-inward?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Inward</span></a> </li>
    <li> <a href="consult-transfers?roomID=<?php echo $roomID;?>"><i class="icon-resize-horizontal"></i> <span>Transfers</span></a> </li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a title="Consultation" class="tip-bottom"><i class="icon-briefcase"></i> CONSULTATION</a>
        <a title="Consultation" class="tip-bottom"><i class="icon-user"></i> CONSULTATION ROOM</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">CONSULTATION ROOM <?php echo $r['roomName'];?></h3>
	  <?php if($success || $error){?>
			<div class="row-fluid">
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
			</div>
	  <?php }?>
      <div class="row-fluid">
          <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab1">Patient Health Details</a></li>
                            <li><a data-toggle="tab" href="#tab2"> Request Lab</a></li>
                            <li><a data-toggle="tab" href="#tab3"> Admit To Ward</a></li>
                            <li><a data-toggle="tab" href="#tab4"> Prescribe Medication</a></li>
                            <li><a data-toggle="tab" href="#tab5"> ICD-10</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="tab1" class="tab-pane active">
                            <form action="#" method="post" class="form-horizontal">
								<div class="span6">
									<div class="widget-content">
										<div class="control-group">
                                        <label class="control-label">Patient ID :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="patientID" value="<?php echo $patientID;?>" readonly/>
                                        </div>
                                      </div>
										<?php if(!empty($consultrow['mode']) || $consultrow['mode']='null'){ ?>
                                      <div class="control-group">
                                        <label class="control-label">Mode :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="patientName" value="<?php echo $consultrow['mode'];?>" readonly/>
                                        </div>
                                      </div>
                                      <?php } ?>
										<?php if(!empty($consultrow['insuranceNumber']) || $consultrow['insuranceNumber']='null'){ ?>
                                      <div class="control-group">
                                        <label class="control-label">Insurance Number :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="patientName" value="<?php echo $consultrow['insuranceNumber'];?>" readonly/>
                                        </div>
                                      </div>
                                      <?php } ?>
										<div class="control-group">
                                        <label class="control-label">Body Temperature :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="bodyTemp" value="<?php echo $consultrow['bodyTemperature'];?>" readonly/>
                                        </div>
                                      </div>
										<div class="control-group">
                                        <label class="control-label">Respiration Rate :</label>
                                        <div class="controls">
                <input type="text" class="span12" name="respirationRate" value="<?php echo $consultrow['respirationRate'];?>" readonly/>
                                        </div>
                                      </div>
										<div class="control-group">
                                        <label class="control-label">Weight :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="weight" value="<?php echo $consultrow['weight'];?>" readonly/>
                                        </div>
											<div class="controls"></div>
                                      </div>

									</div>
								</div>


								<div class="span6">
                                  <div class="widget-content">
                                      <div class="control-group">
                                        <label class="control-label">Patient Name :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="patientName" value="<?php echo $name;?>" readonly/>
                                        </div>
                                      </div>

                                        <?php if(!empty($consultrow['insuranceType']) || $consultrow['insuranceType']='null'){ ?>
                                      <div class="control-group">
                                        <label class="control-label">Insurance Type :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="patientName" value="<?php echo $consultrow['insuranceType'];?>" readonly/>
                                        </div>
                                      </div>
                                      <?php } ?>

                                      <?php if(!empty($consultrow['company']) || $consultrow['company']='null'){ ?>
                                      <div class="control-group">
                                        <label class="control-label">Company :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="patientName" value="<?php echo $consultrow['company'];?>" readonly/>
                                        </div>
                                      </div>
                                      <?php } ?>

                                      <div class="control-group">
                                        <label class="control-label">Pulse Rate :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="bloodPressure" value="<?php echo $consultrow['pulseRate'];?>" readonly/>
                                        </div>
                                      </div>

                                      <div class="control-group">
                                        <label class="control-label">Blood Pressure :</label>
                                        <div class="controls">
                <input type="text" class="span12" name="bloodPressure" value="<?php echo $consultrow['bloodPressure'];?>" readonly/>
                                        </div>
                                      </div>

                                      <div class="control-group">
                                        <label class="control-label">Other Health Vitals :</label>
                                        <div class="controls">
                                            <textarea class="span12" name="healthVitals" readonly><?php echo $consultrow['otherHealth'];?></textarea>
                                        </div>
                                      </div>
                                  </div>
								</div>
                            </form>
                        </div>
                        <div id="tab2" class="tab-pane">
                             <form action="#" method="post" class="form-horizontal">
								 <div class="span6">
									 <div class="widget-content nopadding">
									 	<div class="control-group">
                                        <label class="control-label"> Consulting Room</label>
                                          <div class="controls">
                                            <input type="text" name="consultroom" class="span11" value="<?php echo $roomID?>" readonly>
                                          </div>
                                      	</div>
										 	<?php if(!empty($consultrow['mode']) || $consultrow['mode']='null'){ ?>
                                      <div class="control-group">
                                        <label class="control-label">Pay Mode :</label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="paymode" value="<?php echo $consultrow['mode'];?>" readonly/>
                                        </div>
                                      </div>
                                      <?php } ?>
									 </div>
								 </div>
								 <div class="span6">
									 <div class="widget-content nopadding">
									 	<div class="control-group">
                                        <label class="control-label"> Staff ID</label>
                                          <div class="controls">
                                            <input type="text" name="consultroom" class="span11" value="<?php echo $staffID;?>" readonly>
                                          </div>
                                      </div>
									 </div>
										 <div class="control-group">
                                        <label class="control-label">Request lab</label>
                                        <div class="controls">
                                          <select multiple name="labName[]">
                                               <?php
                                            $lablist = select("SELECT * from lablist");
                                            foreach($lablist as $labrow){
                                            ?>
                                            <option value="<?php echo $labrow['labID'];?>"><?php echo $labrow['labName'];?></option>
                                              <?php }?>
                                          </select>
                                        </div>
                                      </div>
									 <div class="form-actions">
                                          <i class="span1"></i>
                                        <button type="submit" name="reqLab" class="btn btn-primary btn-block span10"> Request Lab</button>
                                      </div>
								 </div>
                            </form>
                        </div>
                        <div id="tab3" class="tab-pane">
                             <form action="#" method="post" class="form-horizontal">
								 <div class="span6">
								 	<div class="widget-content nopadding">
                                       <div class="control-group">
                                        <label class="control-label">Ward</label>
                                        <div class="controls">
                                          <select name="wardID" onchange="ward_id(this.value);">
                                            <option value=""></option>
                                              <?php
                                                $wardsql = select("SELECT * From wardlist");
                                              foreach($wardsql as $wardrow){
                                              ?>
                                            <option value="<?php echo $wardrow['wardID'];?>"> <?php echo $wardrow['wardName'];?> </option>
                                              <?php }?>
                                          </select>
                                        </div>
                                      </div>
                                       <div class="control-group" id="bedlist">

										</div>
                                       <div class="control-group">
                                        <label class="control-label">Admission Details</label>
                                        <div class="controls">
                                          <select name="admitDetails">
                                            <option value=""> </option>
                                            <option value="Treatment And Observation"> Treatment And Observation </option>
                                            <option value="Operation"> Operation</option>
                                            <option value="Other Reasons"> Other Reasons</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label"> Date Admitted</label>
                                          <div class="controls">
                                            <input type="date" class="span11" name="admitDate" required/>
                                          </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label"> Discharge Date</label>
                                          <div class="controls">
                                            <input type="date" class="span11" name="dischargeDate"/>
                                          </div>
                                      </div>
                                  </div>
								 </div>
								 <div class="span6">
                                      <table class="table table-bordered" id="dynamic_field2">
										  <tr>
										  	<td colspan="3"><textarea class="span12" name="symptoms" placeholder="Symptoms" required></textarea></td>
										  </tr>
										  <tr>
										  	<td colspan="3"><textarea class="span12" name="diagnoses" placeholder="Diagnosis" required></textarea></td>
										  </tr>
                                        <tr>
                                            <td><input type="text" name="medicine[]" placeholder="Medicine" class="span11" required /></td>
                                            <td><input type="text" name="dosage[]" placeholder="Dosage" class="span11" required /></td>
                                            <td><button type="button" name="add" id="add2" class="btn btn-primary">Add Medicine</button></td>
                                        </tr>
                                    </table>
                                      <div class="form-actions">
                                          <i class="span1"></i>
                                        <button type="submit" name="adWard" class="btn btn-primary btn-block span10"> Admit To Ward</button>
                                      </div>
								 </div>
                            </form>
                        </div>
                        <div id="tab4" class="tab-pane">
                             <form action="#" method="post" id="add_name" class="form-horizontal">
								 <div class="span4">
								 	<table class="table table-bordered">
                                          <tr>
                                              <td> Presciption Code</td>
                                              <td colspan="2">
									<input type="text" name="prescribeCode" value="<?php echo $prescribeCode;?>" readonly class="span12" /></td>
                                          </tr>
                                          <tr>
                                            <td> Pharmacy</td>
                                            <td colspan="2">
                                              <select name="pharmacyID" class="span12" required>

                                                  <?php
                                                    $pharmsql = select("SELECT * from pharmacy WHERE centerID='".$_SESSION['centerID']."'");
                                                    if(count($pharmsql)>=1){
                                                        foreach($pharmsql as $pharmow){
                                                  ?>
                                        <option value="<?php echo $pharmow['pharmacyID'];?>" ><?php echo $pharmow['pharmacyName'];?></option>
                                                  <?php }}else{?>
                                                  <option value=""> No Pharmacy Available </option>
                                                  <?php }?>
                                                </select>
                                              </td>
                                          </tr>
                                          <tr>
                                            <td colspan="3"><textarea class="span12" name="diagnoses" placeholder="Diagnosis" required></textarea>  </td>
                                          </tr>
                                          <tr>
                                            <td colspan="3"><textarea class="span12" name="symptoms" placeholder="Symptoms" required></textarea>  </td>
                                          </tr>
                                    </table>
								 </div>
								 <div class="span8">
                                      <table class="table table-bordered" id="dynamic_field">
									<?php if(!empty($consultrow['mode']) || $consultrow['mode']='null'){ ?>
                                      <div class="control-group" style="display:none;">
                                        <label class="control-label">Pay Mode :</label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="paymode" value="<?php echo $consultrow['mode'];?>" readonly/>
                                        </div>
                                      </div>
                                      <?php } ?>
					<thead>
						<th> Medicine Name</th>
						<th> No of intakes / Pieces</th>
						<th> Intakes Per Day</th>
						<th> Number Of Days</th>
						<th></th>
					</thead>

					<tr>
						<td style="width:30%;">
							<select name="medName[]" class="span11">
							<?php
								if($consultrow['mode']== 'Private'){
								$meds = select("SELECT * FROM pharmacy_inventory WHERE centerID='$centerID'");
								if($meds){
									foreach($meds as $medrow){

							?>
							<option value="<?php echo $medrow['medicine_id']; ?>"> <?php echo $medrow['medicine_name'];?></option>
							<?php }}}?>
							</select>
						</td>
						<td><input type="number" min="1" name="pieces[]" placeholder="e.g. 2" class="span11" required /></td>
						<td><input type="number" min="1" name="aday[]" placeholder="e.g. 3" class="span11" required /></td>
						<td><input type="number" min="1" name="totalDays[]" placeholder="e.g. 7" class="span11" required /></td>
						<td><button type="button" name="add" id="add" class="btn btn-primary">Add</button></td>
					</tr>
                                    </table>
                                      <div class="form-actions">
                                          <i class="span7"></i>
                                        <button type="submit" name="presMeds" class="btn btn-primary btn-block span5"> Save Prescription</button>
                                      </div>
								 </div>
                            </form>
                        </div>

						<div id="tab5" class="tab-pane">
                              <form action="" method="post">
		  <input type="text" placeholder="ICD-10 SEARCH" class="class-form span12 text-center" style="height:30px;" name="search_icd" onkeyup="icd(this.value);">
	  </form>

							 <div class="widget-box" style="height:300px; overflow-y: scroll;">

						<span id="icd_load"></span>

                    </div>
                        </div>
                    </div>
                </div>
          </div>

		  <div class="span12" style="margin-left:0px;">
		  		<div class="widget-box">
			  			<div class="widget-content">
						<div class="accordion" id="collapse-group">
<!--
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                                            <span class="icon"><i class="icon-eye-open"></i></span><h5>Accordion option1</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse in accordion-body" id="collapseGOne">
                                    <div class="widget-content">
                                        This is opened by default
                                    </div>
                                </div>
                            </div>
-->

<!--
                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse">
                                            <span class="icon"><i class="icon-circle-arrow-right"></i></span><h5>Accordion closed</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseGTwo">
                                    <div class="widget-content">
                                        Another is open
                                    </div>
                                </div>
                            </div>
-->

                            <div class="accordion-group widget-box">
                                <div class="accordion-heading">
                                    <div class="widget-title">
                                        <a data-parent="#collapse-group" href="#collapseGThree" data-toggle="collapse">
                                            <span class="icon"><i class="icon-eye-open"></i></span><h5>PATIENT MEDICAL RECORDS</h5>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse accordion-body" id="collapseGThree">
                                    <div class="widget-content">
										<?php
											//set variables to be useed..
										$username ='';
										$password = '';
											//get session username and password..
										$oldPass = $_SESSION['password'];
										$oldUNamee = $_SESSION['username'];

										if(isset($_POST['viewHistory'])){
										$username = trim(htmlspecialchars($_POST['username']));
										$password = trim(htmlspecialchars($_POST['password']));

											if($oldPass ===$password && $oldUNamee===$username ){
												$username = $oldUNamee;
												$password = $oldPass;
											}else{
												$username ='';
												$password = '';
											}

										}
										if(empty($username) && empty($password)){
										?>
										<form id="loginform" class="form-vertical" action="" method="post" style="">
										 <div class="control-group normal_text">
											 <h3 style="text-align:center;">SIGN IN TO PATIENT HISTORY</h3>
										</div>
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
										<div class="control-group" style="text-align:center;">
											<div class="controls">
												<div class="main_input_box">
													<input type="text" name="username" placeholder="User Name"/>
												</div>
											</div>
										</div>

										<div class="control-group" style="text-align:center;">
											<div class="controls">
												<div class="main_input_box">
													<input type="password" name="password" placeholder="Password" required/>
												</div>
											</div>
										</div>
										<div class="form-actions" style="text-align:center;">
											<input type="submit" name="viewHistory" class="btn btn-primary" value="View Records" />
										</div>
									</form>
										<?php }else{?>

								<table class="table table-stripped">
									<thead>
										<th> Date</th>
										<th> OPD</th>
										<th> CONSULTATION</th>
										<th> LABORATORY</th>
										<th> PHARMACY</th>
										<th> WARD</th>
									</thead>
								<?php
$record = select("SELECT * FROM consultation,labresults,prescriptions,wardassigns,doctorappointment WHERE consultation.patientID='$patientID'
AND labresults.patientID='$patientID' AND prescriptions.patientID='$patientID' AND wardassigns.patientID='$patientID' AND
doctorappointment.patientID='$patientID'");

											if($record){
									foreach($record as $recordRow){
								?>
									<tbody>
										<tr>
											<td> <?php echo date('D Y-m-d',strtotime($recordRow['doe']));?></td>
											<td>
												<?php
										echo "Pulse Rate - ".$recordRow['pulseRate']."<br>";
										echo "Respiration Rate - ".$recordRow['respirationRate']."<br>";
										echo "Blood Pressure - ".$recordRow['bloodPressure']."<br>";
										echo "Weight - ".$recordRow['weight']."<br>";
										echo "Other Details - ".$recordRow['otherHealth']."<br>";

												?></td>
											<td> <?php echo $recordRow['diagnose'];?></td>
											<td> <a href="<?php echo $recordRow['labResult']?>" target="popup"> <?php echo
													$recordRow['labResult'];?></a></td>
											<td>
												<?php
												$prescode = $recordRow['prescribeCode'];
												$meds = select("SELECT * FROM prescribedmeds WHERE prescribeCode='$prescode'");
												foreach($meds as $medRow){
													echo "Medication : ".$medRow['medicine']."<br> Dosage : ".$medRow['dosage']."<br>";
												}
												?>
											</td>
											<td>
												<?php
							$ward = select("select wardName from wardlist where wardID='".$recordRow['wardID']."'");
										foreach($ward as $wardrow){
										echo " Admitted to ".$wardrow['wardName']."<br> On ".$recordRow['admitDate']." to ".$recordRow['dischargeDate']." For ".$recordRow['admitDetails'];
										}
												?>
											</td>
										</tr>
									</tbody>

								<?php }}else{?>
									<tbody>
										<tr><td colspan="6"> No Patient Record Yet..</td></tr>
									</tbody>
									<?php }?>
							</table>

										<?php }?>

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
<!--<script src="js/maruti.chat.js"></script> -->
<script src="js/maruti.tables.js"></script>
<script src="js/maruti.dashboard.js"></script>
<!--<script src="js/maruti.chat.js"></script> -->
<script src="js/maruti.form_common.js"></script>

<!--<script src="js/maruti.js"></script> -->


<script>
function icd(val){
	// load the select option data into a div
        $('#loader').html("Please Wait...");
        $('#icd_load').load('loads/icd-load.php?id='+val, function(){
		$('#loader').html("");
       });
}
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
//    $(document).ready(function(){
        var i=1;
        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'"><td style="width:30%;"><select name="medName[]" class="span11"><?php $meds = select("SELECT * FROM pharmacy_inventory WHERE centerID='$centerID'"); if($meds){ foreach($meds as $medrow){ ?><option value="<?php echo $medrow['medicine_id']; ?>"> <?php echo $medrow['medicine_name'];?></option><?php }}?></select></td><td><input type="number" min="1" name="pieces[]" placeholder="e.g. 2" class="span11" required /></td><td><input type="number" min="1" name="aday[]" placeholder="e.g. 3" class="span11" required /></td><td><input type="number" min="1" name="totalDays[]" placeholder="e.g. 7" class="span11" required /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });

//    $(document).ready(function(){
        var i=1;
        $('#add2').click(function(){
            i++;
            $('#dynamic_field2').append('<tr id="row'+i+'"><td><input type="text" name="medicine[]" placeholder="Medicine" class="span11" /></td><td><input type="text" name="dosage[]" placeholder="Dosage" class="span11" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
</script>
<script>
function ward_id(val){
	// load the select option data into a div
        $('#loader').html("Please Wait...");
        $('#bedlist').load('ward-id.php?wid='+val, function(){
		$('#loader').html("");
       });
}
</script>
</body>
</html>

<?php }else{echo "<script>window.location='404'</script>";}?>
