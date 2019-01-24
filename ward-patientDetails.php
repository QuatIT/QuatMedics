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
<link rel="icon" href="quatmedics.png" type="image/x-icon" style="width:50px;">
    <style>
        .control-label{
            font-weight: bolder;
        }
    </style>
</head>
<body>
<?php
include 'layout/head.php';
$_SESSION['current_page']=$_SERVER['REQUEST_URI'];
 //include 'status_administered.php';
    $success = '';
    $error = '';
//error_reporting(0);
if($_SESSION['accessLevel']=='WARD' || $_SESSION['accessLevel']=='CONSULTATION' || $_SESSION['username']=='rik'){

    $patientID = $_GET['patid'];
    $wardID = $_GET['wrdno'];
    $assignID = $_GET['assign'];
    $wardc = new Ward();
    $patien = new Patient();
    //fetch assign details......
    $patient = $wardc->find_by_assign_id($assignID);
    foreach($patient as $pat){}

//echo "<script>alert('{$pat['patientID']}')</script>";
    $pat_fxn = $patien->find_by_patient_id($patientID);
    foreach($pat_fxn as $patDetails){}
//get ward details..
    $wardDet = select("SELECT * FROM wardlist where wardID='$wardID'");
    foreach($wardDet as $wardRw){}


//patient treatment
if(isset($_POST['saveTreatment'])){
    $comments= filter_input(INPUT_POST,"comment",FILTER_SANITIZE_STRING);
	$medsNum = count($_POST['medicine']);
//	$dosagesNum = count($_POST['dosage']);
    $piecesNum = count( $_POST['pieces']);
    $adayNum = count( $_POST['aday']);
    $totalDaysNum = count( $_POST['totalDays']);
    $paystatus = "Not Paid";
//    $paymode =  filter_input(INPUT_POST, "paymode", FILTER_SANITIZE_STRING);

    //INSERT MEDICINE AS PATIENT IS ADMITTED..
		for($m=0, $p=0, $a=0, $t=0; $m<$medsNum, $p<$piecesNum, $a<$adayNum, $t<$totalDaysNum; $m++,$p++,$a++,$t++){
				if(trim($_POST['medicine'][$m] != '') && trim($_POST['pieces'][$p] != '') && trim($_POST['aday'][$a] != '') && trim($_POST['totalDays'][$t] != '') ) {
					$medicineID = trim( $_POST['medicine'][$m]);
					$pieces = trim( $_POST['pieces'][$p]);
					$aday = trim( $_POST['aday'][$a]);
					$totalDays = trim( $_POST['totalDays'][$t]);

        //get medicine name for insert qeury...
		$findmedname = select("SELECT * FROM pharmacy_inventory WHERE medicine_id='$medicineID'");
        foreach($findmedname as $nameRow){
            $medicine = $nameRow['medicine_name'];
            $medFrom = $nameRow['medFrom'];
            $medicinetype = $nameRow['Type'];
            $unitPrice = $nameRow['price'];

        //set dosage..
        $dosage = $pieces." X ".$aday." For ".$totalDays." Day(s)";
            if($medicinetype=='solid'){
                //medicine price calculation..
                $totalMeds = ($pieces*$aday)*$totalDays;
                $medprice = trim($unitPrice*$totalMeds);
            }else{
                //medicine price calculation..
                $totalMeds = 1;
                $medprice = trim($unitPrice);
            }
        }

$confirm = trim('CONFIRMED');
$insertWardMeds = insert("INSERT INTO wardMeds(assignID,patientID,staffID,wardID,medicine,dosage,comment,paymode,confirm,paystatus,charge,dateInsert) VALUES('$assignID','$patientID','$staffID','$wardID','$medicine','$dosage','$comments','".$pat['paymode']."','$confirm','$paystatus','$medprice','$dateToday')");

                    if($insertWardMeds){
                        echo "<script>window.location='".$_SESSION['current_page']."';</script>";
                    }else{
                        $error = "<script>document.write('MEDICATION PRESCRIPTION FAILED.');</script>";
                    }
                }
        }
}


if(isset($_POST['saveReview'])){
      $review = filter_input(INPUT_POST,"review",FILTER_SANITIZE_STRING);
$staff_ID = select("SELECT * FROM centeruser");
if($staff_ID){
    foreach($staff_ID as $staff_IDs){}
$rev_iew= insert("INSERT INTO docreview_tb(assignID,WardID,PatientID,staffID,DocReview,dateInsert)VALUES('$assignID','$wardID','$patientID','".$staff_IDs['staffID']."','$review','$dateToday')");
//          header('location:ward-index.php');
  }
}

//$_GET['patient'];
//$_GET['bedNumber'];
//$_GET['Admitted'];



// fetch vitals
$get_vit = select("SELECT * FROM ward_vitals WHERE patientID ='$patientID' ORDER BY id DESC LIMIT 1");

//NURSE CHECKLIST
//$checklist=select("SELECT * FROM review_tb WHERE patientID = '$patientID'");
$checklist=select("SELECT * FROM wardmeds WHERE patientID = '$patientID' AND assignID='$assignID'");

//GET ADMISSION STAFF DETAILS
$staffDet = select("SELECT * FROM staff WHERE staffID='".$pat['staffID']."'");
if($staffDet){
    foreach($staffDet as $staffRow){
        $staffName = $staffRow['lastName'].' '.$staffRow['firstName'].' '.$staffRow['otherName'];
    }
}


//Move Patient TO Account For Discharge Payment..
if(isset($_POST['moveToAcc'])){
    $patientID = trim(htmlentities($_POST['patientID']));
    $patientName = trim(htmlentities($_POST['patientName']));
    $admitDate = trim(htmlentities($_POST['admitDate']));
    $NoOfDays = trim(htmlentities($_POST['NoOfDays']));
    if($NoOfDays == '0'){
        $NoOfDays = 1;
    }
    //Get price for ward..
    $WardPricing = select("SELECT * FROM prices WHERE serviceType='Ward' AND centerID='$centerID' AND serviceName='".$wardRw['wardName']."'");
    foreach($WardPricing as $priceRow){
        $wardCharge = $priceRow['servicePrice'];
    }

    //calculate the total charge with days admitted..
    $totalWardCharge = ($wardCharge*$NoOfDays);

    //update ward assign row with new price..
    $update = update("UPDATE wardassigns SET charge='$totalWardCharge' WHERE assignID='$assignID'");
    if($update){
        $success = "<script>document.write('Moved To Account For Payment');window.location='ward-patient?wrdno=$wardID';</script>";
    }
}


//DISCHARGE PATIENT FROM WARD, AFTER FINANCE PAYMENT.
    if(isset($_POST['DischargePatient'])){
        $patientID = trim(htmlentities($_POST['patientID']));

        //SET DISCHARGE DATE..
        $dischargedate = update("UPDATE wardassigns SET dischargeDate='$dateToday',admitstatus='DISCHARGED' WHERE assignID='$assignID'");
        if($dischargedate){
            //SET PATIENT TO DISCHARGED.
                $updatePatient = update("UPDATE consultation SET status='DONE' WHERE patientID='$patientID' AND consultID='".$pat['consultID']."'");
            if($updatePatient){
                //RELEASE PATIENT..
                $releasePatient = ("UPDATE patient SET patient_status ='' WHERE patientID='$patientID'");
                if($releasePatient){
                    $success = "<script>document.write('PATIENT DISCHARGED.');window.location='ward-patient?wrdno=$wardID';</script>";
                }else{
                   $error = "<script>document.write('PATIENT DISCHARGED FAILED, TRY AGAIN.');window.location='ward-patient?wrdno=$wardID';</script>";
                }
            }
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
        <li><a href="ward-index?wrdno=<?php echo $wardID;?>"><i class="icon icon-plus"></i> <span>Bed Management</span></a></li>
        <li class="active" style="background-color:#209fbf;">
            <a href="ward-patient?wrdno=<?php echo $wardID;?>"><i class="icon icon-user"></i> <span>Patient Management</span></a>
        </li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a href="ward-index" title="" class="tip-bottom"><i class="icon-time"></i> WARD</a>
        <a href="ward-patient" title="" class="tip-bottom"><i class="icon-user"></i> WARD PATIENTS</a>
        <a href="#" title="" class="tip-bottom"><i class="icon-user"></i>PATIENTS ADMISSION</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">PATIENT MANAGEMENT</h3>
        <?php if($success){ ?>
              <div class="alert alert-success">
                  <strong>Success!</strong> <?php echo $success; ?>
                </div>
        <?php } if($error){ ?>
              <div class="alert alert-danger">
                  <strong>Error!</strong> <?php echo $error; ?>
                </div>
              <?php
            } ?>
      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs lae=bell">
                    <li class="active"><a data-toggle="tab" href="#tab1">ADMISSION DETAILS</a></li>
                 <?php if($_SESSION['accessLevel']=='WARD' || $_SESSION['accessLevel']=='CONSULTATION' || $_SESSION['username']=='rik'){ ?>
                    <li><a data-toggle="tab" href="#tab6">PATIENT VITALS</a></li>
                    <li><a data-toggle="tab" href="#tab2">PATIENT TREATMENT</a></li>
                    <li><a data-toggle="tab" href="#tab5"> NURSE'S CHECKLIST</a></li>
                    <!-- <li><a data-toggle="tab" href="#tab3">Doctor's Remarks</a></li> -->
                    <li><a data-toggle="tab" href="#tab4">TREATEMENT HISTORY</a></li>
                    <li><a data-toggle="tab" href="#tab7">PATIENT DISCHARGE</a></li>
                    <?php } ?>
                </ul>
            </div>

<div class="widget-content tab-content">

<!-- =========================  START OF TAB 1 ================================   -->
 <div id="tab1" class="tab-pane active">
    <form action="#" method="post" class="form-horizontal">
    <div class="span6">

          <div class="widget-content nopadding">
               <div class="control-group">
                <label class="control-label">Patient : </label>
                <div class="controls">
                    <input type="text" value="<?php echo $patDetails['firstName'].' '.$patDetails['otherName'].' '.$patDetails['lastName']; ?>" name="patientName" class="span11" readonly>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Admission Date :</label>
                <div class="controls">
                    <input name="admitDate" value="<?php echo $pat['admitDate']; ?>" class="span11" type="text" readonly/>
                </div>
                  <div class="controls"></div>
              </div>
          </div>
      </div>
    <div class="span6">

          <div class="widget-content nopadding">
               <div class="control-group">
                    <label class="control-label">ADMITTED BY: </label>
                    <div class="controls">
                    <input type="text" value="<?php echo $pat['staffID']; ?>" name="AssignedNurse" class="span11" readonly>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">ADMITTED FOR :</label>
                    <div class="controls">
                        <textarea class="span11" name="description" readonly><?php echo $pat['admitDetails']; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
     </form>
</div>
<!-- =========================  END OF TAB 1 ============================   -->



<!-- =========================  START OF TAB 6 ============================   -->
<div id="tab6" class="tab-pane">
    <form action="" method="post" id="vitals" class="form-horizontal">

    <div class="span6" id="vitals">
          <div class="widget-content nopadding">
              <div class="control-group">
                <label class="control-label">PATIENT ID :</label>
               <div class="controls">
                  <input type="text" name="patientID" id="patientId" class="span11" value="<?php echo $patDetails['patientID'];?>"  readonly>
                </div>
              </div>

            <?php
              if(is_array($get_vit)){
              foreach($get_vit as $get_vits){}}
              ?>

               <div class="control-group">
                <label class="control-label">BODY TEMPORATURE :</label>
                <div class="controls">
                  <input type="text" class="span11" placeholder="Body Temperature" value="<?php echo @$get_vits['bodyTemp']; ?>" name="bodytemp" readonly />
                </div>
              </div>

            <div class="control-group">
                <label class="control-label">PULSE RATE :</label>
                <div class="controls">
                  <input type="text" class="span11" placeholder="Pulse Rate" value="<?php echo @$get_vits['pulseRate']; ?>"  name="pulseRate" readonly/>
                </div>
              </div>


              <div class="control-group">
                <label class="control-label">WEIGHT : </label>
                <div class="controls">
                  <input type="text"  class="span11" name="weight" placeholder="Weight" value="<?php echo @$get_vits['weight']; ?>"  readonly />
                </div>
              </div>

              </div>
          </div>

        <div class="span6">
            <div class="widget-content nopadding">

               <div class="control-group">
                <label class="control-label">FULL NAME :</label>
                <div class="controls">
                    <input type="text" required readonly value="<?php echo $patDetails['lastName'].' '.$patDetails['firstName'].' '.$patDetails['otherName']; ?>" id="FullName" class="span11" placeholder="Full name" name="FullName"  />
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">RESPIRATION RATE :</label>
                <div class="controls">
                  <input type="text" class="span11" placeholder="Respiration Rate" name="respirationRate" value="<?php echo @$get_vits['respirationRate']; ?>" readonly/>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">BLOOD PRESSURE :</label>
                <div class="controls">
                  <input type="text"  class="span11" name="bloodPressure" placeholder="Blood Pressure" value="<?php echo @$get_vits['bloodPressure']; ?>" readonly />
                </div>
              </div>

              <div class="control-group">
                <label class="control-label">DATE RECORDED :</label>
                <div class="controls">
                  <input type="text"  class="span11" name="" placeholder="AS AT TODAY" value="<?php echo @$get_vits['dateRegistered']; ?>" readonly />
                </div>
              </div>

              <div class="form-actions">
                  <i class="span1"></i>
                <a href="ward-vitals?patientID=<?php echo $patientID; ?>&tab=vitals" class="btn btn-primary btn-block labell span10">Register New Vitals</a>
              </div>
          </div>
        </div>
    </form>
</div>
<!-- =========================  END OF TAB 6 ============================   -->



<!-- =========================  START OF TAB 2 ============================   -->

<div id="tab2" class="tab-pane">
    <form action="#" method="post" id="add_name" enctype="multipart/form-data" class="form-horizontal">
          <div class="widget-content nopadding">
              <table class="table table-bordered" id="dynamic_field">
                  <tr>
                      <td colspan="4"><textarea style="width:100%;" rows="3" placeholder="Comments" name="comment"></textarea></td>
                  </tr>

                  <tr class="labell">
						<th style="width:40%;"> Medicine Name</th>
						<th> No of intakes / Pieces</th>
						<th> Intakes Per Day</th>
						<th> Number Of Days</th>
					</tr>
                		<?php
					$num = 6;
					if(!empty($num)){
					  for($i=0; $i<$num;$i++){
					?>
					<tr>
						<td style="width:40%;">
							<?php
							if($pat['paymode'] == 'Insurance'){
                                $insuranceType = $pat['insuranceType'];
							?>
							<select name="medName[]" class="span11">
								<option></option>
							 <?php

						  	$centerNHISLevel = $centerName['centerNhisLevel'];
//						  	$level = explode(" ",$centerNHISLevel);
$meds = select("SELECT * FROM pharmacy_inventory WHERE centerID='$centerID' AND medFrom='$insuranceType' OR  medFrom='Private'");
								if($meds){
									foreach($meds as $medrow){
							?>
							<option value="<?php echo $medrow['medicine_id']; ?>"> <?php echo $medrow['medicine_name']; ?></option>
							 <?php }} ?>
							</select>
							<?php }else{
                            $medsx = select("SELECT * FROM pharmacy_inventory WHERE centerID='$centerID' AND medFrom='Private'");
							?>
                              <select name="medicine[]" class="span11">
                                <option></option>
                                <?php
                                if($medsx){
                            foreach($medsx as $medrowx){
                                ?>
                            <option value="<?php echo $medrowx['medicine_id']; ?>">
                        <?php
                                if($medrowx['Type']=='solid'){
                                    $stockleft = $medrowx['no_of_piece'];
                                }
                                if($medrowx['Type']=='liquid'){
                                    $stockleft = $medrowx['no_of_bottles'];
                                }
                                echo $medrowx['medicine_name'].' -- '.$stockleft.' Left'; ?>
                                </option>
                                <?php }}?>
                            </select>
							<?php }?>
						</td>
						<td><input type="number" min="1" name="pieces[]" placeholder="e.g. 2" class="span11" /></td>
						<td><input type="number" min="1" name="aday[]" placeholder="e.g. 3" class="span11" /></td>
						<td><input type="number" min="1" name="totalDays[]" placeholder="e.g. 7" class="span11" /></td>
					</tr>
						  <?php }} ?>
                  <tr><td colspan="4"></td></tr>
                  <tr>
                      <td colspan="3"></td>
                      <td><button type="submit" name="saveTreatment" class="btn btn-primary btn-block labell"> SAVE TREATMENT</button></td>
                  </tr>
            </table>
          </div>
    </form>
</div>
<!-- =========================  END OF TAB 2 ============================   -->



<!-- =========================  START OF TAB 5 ============================   -->
<div id="tab5" class="tab-pane">
    <div class="widget-box">
      <div class="widget-title">
         <span class="icon"><i class="icon-th"></i></span>
      </div>
      <div class="widget-content nopadding">
        <table class="table table-bordered data-table">
          <thead>
            <tr>
              <th>DATE</th>
              <th>PRESCRIPTION</th>
              <th>DOSAGE</th>
              <th>PRESCRIBED BY</th>
              <th>STATUS</th>
              <th>ACTION</th>
            </tr>
          </thead>
          <tbody >
          <?php if(is_array($checklist)){ foreach($checklist as $checklists){?>
            <tr>
                <td><?php echo $checklists['dateInsert']; ?></td>
<!--                <td><?php //echo $checklists['treatment']; ?></td>-->
                <td><?php echo $checklists['medicine']; ?></td>
                <td><?php echo $checklists['dosage'];?></td>
              <td><?php echo $pat['staffID'];?></td>
                <td style="text-align:center;">
                    <?php if($checklists['status'] == '' || $checklists['status']=='null'){?>
                    <span class="label btn-danger label-sm">NOT ADMINISTERED</span>
                    <?php }?>

                    <?php if($checklists['status'] == 'Administered'){?>
                    <span class="label btn-success label-sm">ADMINISTERED</span>
                    <?php }?>
                </td>
              <td style="text-align:center;">
                  <?php if($checklists['status']!='Administered'){ ?>
                  <a title="Administered" class="btn btn-primary btn-sm" onclick="return confirm('CONFIRM ADMINISTER.');" href="status_administered?rid=<?php echo $checklists['medID'];?>&patid=<?php echo $patientID;?>&wardID=<?php echo $wardID;?>" ><i class="fa fa-check"></i></a>
                  <?php } ?>
                </td>
              <!-- hide administered link after click-->
            </tr>
          <?php }} ?>
          </tbody>
        </table>
      </div>
    </div>
</div>
<!-- =========================  END OF TAB 5 ============================   -->


<!-- =========================  START OF TAB 3 ==========================   -->
<div id="tab3" class="tab-pane">
    <form action="#" method="post" class="form-horizontal">
        <div class="span12">
          <div class="widget-title">
              <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5> DOCTORS'S REMARKS</h5>
          </div>
          <div class="widget-content nopadding">
               <div class="control-group">
                <label class="control-label">DOCTOR'S REMARKS : </label>
                <div class="controls">
<!--                    <input type='text' class="form-control span5"  name="review" id="review"required/>&nbsp;<button type="submit" name="saveReview" class="btn btn-primary labell">SAVE REMARKS</button>-->
                </div>
              </div>
             <!-- <div class="form-actions">
                  <i class="span8"></i>
                <button type="submit" name="saveReview" class="btn btn-primary btn-block span4">Save Remarks</button>
              </div> -->
          </div>
        </div>
    </form>
</div>
<!-- =========================  END OF TAB 3 =========================   -->


<!-- =========================  START OF TAB 5 ============================   -->
    <div id="tab4" class="tab-pane">
        <div class="widget-box">
          <div class="widget-title">
          </div>
          <div class="widget-content nopadding">
              <form class="form" method="post" enctype="multipart/form-data">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th> DATE & TIME</th>
                  <th> PRESCRIPTION</th>
                  <th> DETAILS / DOSAGE</th>
                  <th> PRESCRIBED BY</th>
                  <th> STATUS</th>
                  <th> DOCTOR'S COMMENT</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // $report = select("SELECT * FROM review_tb WHERE patientID='$patDetails'");
                $report = select("SELECT * FROM wardmeds WHERE patientID='$patientID' AND assignID='$assignID'");
                    foreach($report as $reports){
                      $rev_iew = select("SELECT * FROM docreview_tb");
                    foreach($rev_iew as $rev_iews){}?>
                <tr>
                    <td><?php echo $reports['doe'];?></td>
                    <td><?php echo $reports['medicine'];?></td>
                    <td><?php echo $reports['dosage'];?></td>
                    <td><?php echo $reports['staffID'];?></td>

                    <td style="text-align:center;">
                    <?php if($reports['status'] == '' || $reports['status']=='null'){?>
                    <span class="label btn-danger label-sm">NOT ADMINISTERED</span>
                    <?php }?>

                    <?php if($reports['status'] == 'Administered'){?>
                    <span class="label btn-success label-sm">ADMINISTERED</span>
                    <?php }?>
                    </td>
                    <td>
                        <input type='text' class="form-control span6"  name="review" id="review"required/>&nbsp;
                        <button type="submit" name="saveReview" class="btn btn-primary labell" style="margin-top:-10px;">Save Remarks</button>
                    </td>
                  </tr>
                 <?php }?>

           </tbody>
            </table>
              </form>
            </div>
        </div>
    </div>
<!-- =========================  START OF TAB 5 ============================   -->

<!-- =========================  START OF TAB 7 ================================   -->
<div id="tab7" class="tab-pane">
    <form action="#" method="post" class="form-horizontal" enctype="multipart/form-data">
    <div class="span6">
          <div class="widget-content">
              <div class="control-group">
                <label class="control-label">PATIENT ID :</label>
               <div class="controls">
                  <input type="text" name="patientID" id="patientId" class="span11" value="<?php echo $patDetails['patientID'];?>"  readonly>
                </div>
              </div>

               <div class="control-group">
                <label class="control-label">PATIENT NAME : </label>
                <div class="controls">
                    <input type="text" value="<?php echo $patDetails['lastName'].' '.$patDetails['firstName'].' '.$patDetails['otherName']; ?>" name="patientName" class="span11" readonly>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">ADMITTED ON :</label>
                <div class="controls">
                    <input name="admitDate" value="<?php echo $pat['admitDate']; ?>" class="span11" type="text" readonly/>
                </div>
              </div>
          </div>
      </div>
        <div class="span6">
            <div class="widget-content nopadding">
                <div class="control-group">
                    <label class="control-label">ADMITTED BY: </label>
                    <div class="controls">
                    <input type="text" value="<?php echo $staffName; ?>" name="AssignedNurse" class="span11" readonly>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">ADMITTED FOR :</label>
                    <div class="controls">
                        <textarea class="span11" name="description" readonly><?php echo $pat['admitDetails']; ?></textarea>
                    </div>
                </div>
              <div class="control-group">
                <label class="control-label">NO. OF DAYS ADMITTED :</label>
                <div class="controls">
                    <?php
                       $days = (strtotime($dateToday) - strtotime($pat['admitDate'])) / (60 * 60 * 24);
                        if($days == 0){
                            $days = 1;
                        }
                    ?>
                    <input name="NoOfDays" value="<?php echo $days.' day(s)'; ?>" class="span11" type="text" readonly/>
                </div>
              </div>

                <div class="form-actions">

                    <i class="span1"></i>
                <?php
                if($pat['paystatus'] =='Not Paid'){ ?>
    <input type="submit" name="moveToAcc" value="MOVE TO ACCOUNT" onclick="return confirm('Move To Account For Payment.');"  class="btn btn-primary btn-block labell span10" />

                <?php }else{ ?>
    <input type="submit" name="DischargePatient" onclick="return confirm('CONFIRM DISCHARGE.');" value="DISCHARGE PATIENT" onclick="return confirm('Confirm Patient Discharge.');"  class="btn btn-primary btn-block labell span10" />

                <?php }?>
                    </div>
            </div>
        </div>
     </form>
</div>
<!-- =========================  END OF TAB 7 ============================   -->
            </div>
        </div>
      </div>
  </div>
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
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="treatment[]" placeholder="Treatment / Medicine"  class="span11" /></td><td><input type="text" name="dosage[]" placeholder="Dosage / Details" class="span11" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });
        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//        $('#submit').click(function(){
//            $.ajax({
//                url:"name.php",
//                method:"POST",
//                data:$('#add_name').serialize(),
//                success:function(data)
//                {
//                    alert(data);
//                    $('#add_name')[0].reset();
//                }
//            });
//        });
//    });
</script>
</body>
</html>
<?php }else{echo "<script>window.location='404'</script>";}?>
