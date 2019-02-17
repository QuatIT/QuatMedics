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

<!--highcharts-->
<script src="chart/plotly-latest.min.js"></script>
<script src="chart/highcharts.js"></script>
<script src="chart/series-label.js"></script>
<script src="chart/exporting.js"></script>
<script src="chart/export-data.js"></script>
    <script src="chart/jquery-3.1.1.min.js"></script>


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
$insertWardMeds = insert("INSERT INTO wardMeds(centerID,assignID,patientID,staffID,wardID,medicine,dosage,comment,paymode,confirm,paystatus,charge,dateInsert) VALUES('$centerID','$assignID','$patientID','$staffID','$wardID','$medicine','$dosage','$comments','".$pat['paymode']."','$confirm','$paystatus','$medprice','$dateToday')");

                    if($insertWardMeds){
                        echo "<script>window.location='".$_SESSION['current_page']."';</script>";
                    }else{
                        $error = "<script>document.write('MEDICATION PRESCRIPTION FAILED.');</script>";
                    }
                }
        }
}

// Body Temperature
$count = 0;

$count_row = select("SELECT COUNT(*) as row_tot FROM ward_vitals WHERE patientID = '".$patientID."' && dateRegistered = CURDATE() ");
foreach($count_row as $count_rows){}

$pat_vital = select("SELECT * FROM ward_vitals where patientID = '".$patientID."' && dateRegistered = CURDATE() ORDER BY doe ASC ");


foreach($pat_vital as $pat_vitals){
  $patTemp[$count] = $pat_vitals['bodyTemp'];
$count++;
}
$total_hours=24;

for($i=$count_rows['row_tot'];$i<$total_hours;$i++){
  $patTemp[$i]=0;
    // echo "<script>alert({$i})</script>";
}
    // echo "<script>alert('{$pat_vitals['bodyTemp']}')</script><br/>";
//   if($count > 0){
//   echo "<br>";
//}

// $count++;
// }
// else{
//   echo "<script>alert('no data')</script>";
// }

//BLOOD PRESSURE
$counter = 0;

$count_rox = select("SELECT COUNT(*) as row_tote FROM ward_vitals WHERE patientID = '$patientID' && dateRegistered = CURDATE() ");
foreach($count_rox as $count_roxs){}

$pressure_vital = select("SELECT * FROM ward_vitals where patientID = '$patientID' && dateRegistered = CURDATE() ORDER BY doe ASC ");


foreach($pressure_vital as $pressure_vitals){
  $patPressure[$counter] = $pressure_vitals['bloodPressure'];
$counter++;
}
$t_hours=24;

for($i=$count_roxs['row_tote'];$i<$t_hours;$i++){
  $patPressure[$i]=0;
}

//vital graph table
$g_table = select("SELECT * FROM ward_vitals WHERE patientID = '".$patientID."' ORDER BY id DESC");




 // fetch blood types
    $fet_type = select('SELECT * FROM bloodgroup_tb');
    foreach($fet_type as $fet_types){}

    $user_cred = select("SELECT * FROM centeruser WHERE username ='".$_SESSION['username']."'");
    foreach( $user_cred as  $user_creds){}

$bl_id = select("SELECT * FROM bloodgroup_tb WHERE bloodGroup='".$fet_types['bloodGroup']."'");
foreach($bl_id as $bl_ids){}


//if(isset($_POST['saveReview'])){
//      $review = filter_input(INPUT_POST,"review",FILTER_SANITIZE_STRING);
//$staff_ID = select("SELECT * FROM centeruser");
//if($staff_ID){
//    foreach($staff_ID as $staff_IDs){}
//$rev_iew= insert("INSERT INTO docreview_tb(assignID,WardID,PatientID,staffID,DocReview,dateInsert)VALUES('$assignID','$wardID','$patientID','".$staff_IDs['staffID']."','$review','$dateToday')");
////          header('location:ward-index.php');
//  }
//}

//$_GET['patient'];
//$_GET['bedNumber'];
//$_GET['Admitted'];



// fetch vitals
$get_vit = select("SELECT * FROM ward_vitals WHERE patientID ='$patientID' ORDER BY id DESC LIMIT 1");

  //request ID
  $request_blood = new B_Request();
    $r_blood = $request_blood->Request_blood()+1;
    $Request_id = 'REQ-WRD-'.substr($centerName['centerName'], 0, 3)."-".sprintf('%06s', $r_blood);

    //blood request action
if(isset($_POST['send'])){
$request_id = filter_input(INPUT_POST,'request_id',FILTER_SANITIZE_STRING);
$blood_type= filter_input(INPUT_POST,'blood_type',FILTER_SANITIZE_STRING);
$blood_id= filter_input(INPUT_POST,'blood_id',FILTER_SANITIZE_STRING);
$request_from= filter_input(INPUT_POST,'request_from',FILTER_SANITIZE_STRING);
$staff_id = filter_input(INPUT_POST,'staff_id',FILTER_SANITIZE_STRING);
$patient_id = filter_input(INPUT_POST,'patient_id',FILTER_SANITIZE_STRING);
$quantity = filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_STRING);
// $dateInsert = filter_input(INPUT_POST,'dateInsert',FILTER_SANITIZE_STRING);

  $capture_request = insert("INSERT INTO bloodrequest(bloodID,requestID,request,patientID,quantity,staffID,status,approved_by,request_time,dateInsert,date_approved)VALUES('$blood_id','$Request_id','$request_from','$patient_id','$quantity','$staff_id','','','' ,CURDATE(),'')");
  if($capture_request){
    echo "<script>alert('Request Has Been Sent');window.location='emergency-index.php'</script>";
  }
}

$req_stat = select("SELECT * FROM bloodrequest WHERE patientID='".$patientID."' && flag=1 && confirm='' && dateInsert=CURDATE() ORDER BY id ASC LIMIT 1");
if($req_stat){
    foreach($req_stat as $req_status){}
    //$req_status['bloodID'];
}



$req_cnt = select("SELECT COUNT(*) as request_co FROM bloodrequest WHERE patientID='".$patientID."' && flag= 1 && confirm='' && dateInsert = CURDATE() ");
foreach($req_cnt as $req_cnts){$req_cnts['request_co'];}



//CONFIRM RECEIPT
if(isset($_POST['sub_mitx'])){
  $con_firm='confirmed';
  // $quan_tity = $req_status['quantity'];
  $quan_tity = $_POST['quant'];
  @$bd_id=$req_status['bloodID'];
   $quant = $_POST['quant'];
   $chingx='';


  $confirm = update("UPDATE bloodrequest SET confirm ='$con_firm' WHERE patientID='".$patientID."' && flag= 1 && confirm='' && dateInsert=CURDATE() ORDER BY id ASC LIMIT 1");

  $blood_chk = select("SELECT * FROM bloodgroup_tb WHERE bloodID = '$bd_id'");
  foreach( $blood_chk as  $blood_chks){$chingx=$blood_chks['bloodID'];}

$get_count = select("SELECT * FROM bloodgroup_tb WHERE bloodID ='".$blood_chks['bloodID']."' ");

  $reciep = select("SELECT * FROM bloodrequest WHERE status='APPROVED'  && confirm='confirmed' && dateInsert=CURDATE()");
  foreach($reciep as $recieps){$recieps['quantity'];}

  $con_deduct = update("UPDATE bloodgroup_tb SET bloodBags = bloodBags - '".$recieps['quantity']."' WHERE bloodID ='".$blood_chks['bloodID']."' ");


}



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

//    echo "<script>alert('{$patientID}')</script>";

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
                    <li><a data-toggle="tab" href="#tab9">GRAPHICALS</a></li>
                     <li><a data-toggle="tab" href="#tab6">VITALS</a></li>
                    <li><a data-toggle="tab" href="#tab2">TREATMENT</a></li>
                    <li><a data-toggle="tab" href="#tab5"> NURSE'S CHECKLIST</a></li>
                    <li><a data-toggle="tab" href="#tabRequest">BLOOD REQUEST</a></li>
                    <li><a data-toggle="tab" href="#tabAction">REQUEST ACTION - &nbsp;<?php echo $req_cnts['request_co'];?></a></li>
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


<!-- ============================== START OF VITALS GRAPH TAB ==================================-->

    <div id="tab9" class="tab-pane">
        <div class="widget-box">
          <div class="widget-title">
             <span class="icon"><i class="icon-th"></i></span>
            <h5 class="labell">Patient's Vitals (Graphical)</h5>
          </div>

            <div class="widget-content nopadding" id='printable'>

             <span style="margin-left:300px;font-weight:bolder;">BODY TEMPERATURE HOURLY CHART</span>
            <span><input type='button' class='btn btn-info' style='width:12px;height:12px;margin-left:280px;'>&nbsp;&nbsp;HOURS</span>
            <div id='myDiv' style="height:350px; min-width:100px;"></div>
           <!--  <div style='margin-to'>
            <table class = 'table table-bordered'style='margin-left:640px;margin-top:-800px;width:200px;'> -->

              <table class='table' style='width:100px; border-style:solid; margin-left:740px;margin-top:-350px;'>

              <tr>
                <td class='btn-info'>1</td><td><?php echo $patTemp[0];?></td>
                <td class='btn-info'>2</td><td><?php echo $patTemp[1];?></td>
                <td class='btn-info'>3</td><td><?php echo $patTemp[2];?></td>
                <td class='btn-info'>4</td><td><?php echo $patTemp[3];?></td>

               </tr>
               <tr>
                <td class='btn-info'>5</td><td><?php echo $patTemp[4];?></td>
                 <td class='btn-info'>6</td><td><?php echo $patTemp[5];?></td>
                <td class='btn-info'>7</td><td><?php echo $patTemp[6];?></td>
                <td class='btn-info'>8</td><td><?php echo $patTemp[7];?></td>

              </tr>
              <tr>
                <td class='btn-info'>9</td><td><?php echo $patTemp[8];?></td>
                <td class='btn-info'>10</td><td><?php echo $patTemp[9];?></td>
                 <td class='btn-info'>11</td><td><?php echo $patTemp[10];?></td>
                <td class='btn-info'>12</td><td><?php echo $patTemp[11];?></td>

              </tr>
              <tr>
                <td class='btn-info'>13</td><td><?php echo $patTemp[12];?></td>
              <td class='btn-info'>14</td><td><?php echo $patTemp[13];?></td>
              <td class='btn-info'>15</td><td><?php echo $patTemp[14];?></td>
              <td class='btn-info'>16</td><td><?php echo $patTemp[15];?></td>
            </tr>
            <tr>
                <td class='btn-info'>17</td><td><?php echo $patTemp[16];?></td>
                <td class='btn-info'>18</td><td><?php echo $patTemp[17];?></td>
                <td class='btn-info'>19</td><td><?php echo $patTemp[18];?></td>
                <td class='btn-info'>20</td><td><?php echo $patTemp[19];?></td>
              </tr>
              <tr>
                <td class='btn-info'>21</td><td><?php echo $patTemp[20];?></td>
                <td class='btn-info'>22</td><td><?php echo $patTemp[21];?></td>
                <td class='btn-info'>23</td><td><?php echo $patTemp[22];?></td>
                <td class='btn-info'>24</td><td><?php echo $patTemp[23];?></td>
                  </tr>


            </table>



<br><br><br><br><br><br><br><br>
             <span style="margin-left:300px;font-weight:bolder;">BLOOD PRESSURE HOURLY CHART</span><span><input type='button' class='btn btn-primary' style='width:14px;height:14px;background:#ABC2C4;margin-left:280px;'>&nbsp;&nbsp;HOURS </span>

            <div id="myDivPressure" style="min-width: 100px; height: 400px; margin: 0 auto"></div>

            <table class='table' style='width:100px; border-style:solid; margin-left:740px;margin-top:-350px;'>

              <tr>
                <td style='background-color:#ABC2C4'>1</td><td><?php echo $patPressure[0];?></td>
                <td style='background-color:#ABC2C4'>2</td><td><?php echo $patPressure[1];?></td>
                <td style='background-color:#ABC2C4'>3</td><td><?php echo $patPressure[2];?></td>
                <td style='background-color:#ABC2C4'>4</td><td><?php echo $patPressure[3];?></td>

               </tr>
               <tr>
                <td style='background-color:#ABC2C4'>5</td><td><?php echo $patPressure[4];?></td>
                 <td style='background-color:#ABC2C4'>6</td><td><?php echo $patPressure[5];?></td>
                <td style='background-color:#ABC2C4'>7</td><td><?php echo $patPressure[6];?></td>
                <td style='background-color:#ABC2C4'>8</td><td><?php echo $patPressure[7];?></td>

              </tr>
              <tr>
                <td style='background-color:#ABC2C4'>9</td><td><?php echo $patPressure[8];?></td>
                <td style='background-color:#ABC2C4'>10</td><td><?php echo $patPressure[9];?></td>
                 <td style='background-color:#ABC2C4'>11</td><td><?php echo $patPressure[10];?></td>
                <td style='background-color:#ABC2C4'>12</td><td><?php echo $patPressure[11];?></td>

              </tr>
              <tr>
                <td style='background-color:#ABC2C4'>13</td><td><?php echo $patPressure[12];?></td>
              <td style='background-color:#ABC2C4'>14</td><td><?php echo $patPressure[13];?></td>
              <td style='background-color:#ABC2C4'>15</td><td><?php echo $patPressure[14];?></td>
              <td style='background-color:#ABC2C4'>16</td><td><?php echo $patPressure[15];?></td>
            </tr>
            <tr>
                <td style='background-color:#ABC2C4'>17</td><td><?php echo $patPressure[16];?></td>
                <td style='background-color:#ABC2C4'>18</td><td><?php echo $patPressure[17];?></td>
                <td style='background-color:#ABC2C4'>19</td><td><?php echo $patPressure[18];?></td>
                <td style='background-color:#ABC2C4'>20</td><td><?php echo $patPressure[19];?></td>
              </tr>
              <tr>
                <td style='background-color:#ABC2C4'>21</td><td><?php echo $patPressure[20];?></td>
                <td style='background-color:#ABC2C4'>22</td><td><?php echo $patPressure[21];?></td>
                <td style='background-color:#ABC2C4'>23</td><td><?php echo $patPressure[22];?></td>
                <td style='background-color:#ABC2C4'>24</td><td><?php echo $patPressure[23];?></td>
                  </tr>


            </table>
<br><br>
<!--<input type='submit' class='btn btn-primary' name='printer' id='printer' style='margin-left:740px;width:240px;' onclick='printer()' value="PRINT DOCUMENT">-->


  <script>


  let data = [
  {
    x: ['1', '2', '3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'],
    y: [<?php echo $patTemp[0];?>,<?php echo $patTemp[1]; ?>,<?php echo $patTemp[2]; ?>,<?php echo $patTemp[3]; ?>,<?php echo $patTemp[4]; ?>,<?php echo $patTemp[5]; ?>,<?php echo $patTemp[6]; ?>,<?php echo $patTemp[7]; ?>,<?php echo $patTemp[8]; ?>,<?php echo $patTemp[9]; ?>,<?php echo $patTemp[10]; ?>,<?php echo $patTemp[11]; ?>,<?php echo $patTemp[12]; ?>,<?php echo $patTemp[13]; ?>,<?php echo $patTemp[14]; ?>,<?php echo $patTemp[15]; ?>,<?php echo $patTemp[16]; ?>,<?php echo $patTemp[17]; ?>,<?php echo $patTemp[18]; ?>,<?php echo $patTemp[19]; ?>,<?php echo $patTemp[20]; ?>,<?php echo $patTemp[21]; ?>,<?php echo $patTemp[22]; ?>,<?php echo $patTemp[23]; ?>],
    type: 'line'
  }
];

Plotly.newPlot('myDiv', data);

  </script>

  <script>
  //blood pressure
  let num = [
  {
    x: ['1', '2', '3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'],
    y: [<?php echo $patPressure[0];?>,<?php echo $patPressure[1];?>,<?php echo $patPressure[2];?>,<?php echo $patPressure[3];?>,<?php echo $patPressure[4];?>,<?php echo $patPressure[5];?>,<?php echo $patPressure[6];?>,<?php echo $patPressure[7];?>,<?php echo $patPressure[8];?>,<?php echo $patPressure[9];?>,<?php echo $patPressure[10];?>,<?php echo $patPressure[11];?>,<?php echo $patPressure[12];?>,<?php echo $patPressure[13];?>,<?php echo $patPressure[14];?>,<?php echo $patPressure[15];?>,<?php echo $patPressure[16];?>,<?php echo $patPressure[17];?>,<?php echo $patPressure[18];?>,<?php echo $patPressure[19];?>,<?php echo $patPressure[20];?>,<?php echo $patPressure[21];?>,<?php echo $patPressure[22];?>,<?php echo $patPressure[23];?>],
    type: 'line'
  }
];

Plotly.newPlot('myDivPressure', num);


  </script>

        </div>
    </div>
</div>

<!-- ============================== END OF VITALS GRAPH TAB ==================================-->

<!-- ============START BLOOD REQUEST AND ACTION==================================-->


<div id="tabAction" class="tab-pane">
<!--  <form action='' method='post'>-->
    <div class="widget-box">
      <div class="widget-title">
         <span class="icon"><i class="icon-th"></i></span>
        <h5>BLOOD REQUEST ACTION</h5>
      </div>
      <div class="widget-content nopadding">
    <form action="" method="post">
      <br>
       <div class="control-group" style='text-align:center';>
                <label class="control-label">Request ID </label>
                <div class="controls">
<input type="text" style='text-align:center;' class="span4" value='<?php echo @$req_status['requestID'];  ?>' name="req_id" id="req_id"  readonly>
                </div>
              </div>

               <div class="control-group" style='text-align:center';>
                <label class="control-label">Action By </label>
                <div class="controls">
                  <input type="text" class="span4" style='text-align:center;' value='<?php echo @$req_status['approved_by'];  ?>' name="act_by" id="act_by" readonly>
                </div>
              </div>

                <div class="control-group" style='text-align:center;'>
                <label class="control-label">Time Of Action </label>
                <div class="controls">
                  <input type="text" class="span4" style='text-align:center;' value='<?php echo @$req_status['request_time']; ?>' name="time_act" id="time_act" readonly>
                </div>
              </div>

                <div class="control-group" style='text-align:center';>
                <label class="control-label">Status</label>
                <div class="controls">
                  <input type="text" style='text-align:center;' class="span4" value='<?php echo @$req_status['status']; ?>' name="stat" id="stat" readonly>
                    <!-- <p class="text-left" style="margin-top: 20px;margin-left: 400px;"><input type="reset" class="btn btn-primary" style='width:340px;' name="accept" id="accept" value="ACCEPT STATUS"></p>  -->

                </div>
              </div>

            <p class="text-left" style="margin-top: 20px;margin-left: 390px;">
                <input type="submit" class="btn btn-primary" style='width:360px;margin-left:70px;'name="sub_mitx" id="sub_mitx" value="CONFIRM RECEIPT">
            </p>
          </form>
        </div>
    </div>
</div>



<div id="tabRequest" class="tab-pane">
    <div class="row-fluid" style="margin:0px;">
          <div class="span12">
            <div class="widget-box">
              <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                <h5 class="labell">BLOOD REQUEST FORM</h5>
              </div>
              <div class="widget-content nopadding">
                <form action="#" method="get" class="form-horizontal">
                <div class="row">
                    <div class="span6">
                      <div class="control-group">
                        <label class="control-label">Blood Type :</label>
                        <div class="controls">
                          <select name="blood_type" id="blood_type" class="span11">
                                <option value=""></option>
                                <?php foreach($fet_type as $fet_types){ ?>
                                <option value="<?php echo $fet_types['bloodID'];?>"><?php echo $fet_types['bloodGroup']; ?></option>
                                <?php }?>
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="span6">
                        <div class="control-group" >
                        <label class="control-label">Request ID</label>
                        <div class="controls">
                            <input type='text' class='span11' name='' id='' value='<?php  echo $Request_id; ?>' readonly>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="span6">
                       <div class="control-group">
                        <label class="control-label">Blood ID </label>
                        <div class="controls">
                          <input type="text" class="span11" name="blood_id" id="blood_id" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="span6">
                        <div class="control-group" >
                        <label class="control-label">Patient Name</label>
                        <div class="controls">
                          <input type="text" class="span11" name="patient_name" id="patient_name" value='<?php echo $patDetails['firstName'].' '.$patDetails['otherName'].' '.$patDetails['lastName'];?>' readonly>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="span6">
                     <div class="control-group">
                        <label class="control-label">Request From </label>
                        <div class="controls">
                          <input type="text" class="span11" value='<?php echo $user_creds['accessLevel']; ?>' name="request_from" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="span6">
                     <div class="control-group">
                        <label class="control-label">Blood Quantity</label>
                        <div class="controls">
                          <input type="number" min="1" class="span11" name="quantity" id="quantity" >
                        </div>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="span6">
                        <div class="control-group">
                        <label class="control-label">Staff ID </label>
                        <div class="controls">
                          <input type="text" class="span11" value='<?php echo $user_creds['staffID'];?>' name="staff_id" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="span6">
                         <div class="control-group">
                        <label class="control-label">Date:</label>
                        <div class="controls">
                          <input type="date" class="span11" value='<?php echo date('Y-m-d') ?>' name="dateInsert" readonly>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="span6">
                        <div class="control-group">
                        <label class="control-label">Patient ID </label>
                        <div class="controls">
                          <input type="text" class="span11" name="patient_id" id="patient_id" value='<?php echo  $patientID;?>' readonly>
                        </div>
                      </div>
                    </div>
                    <div class="span6">
                        <div class="control-group">
                        <label class="control-label">Request Action:</label>
                        <div class="controls">
                      <input type="text" class="span11" value='<?php  echo $req_action; ?>' name="req_action" id="req_action" readonly>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="row">
                    <div class="span6"></div>
                    <div class="span6">
                      <div class="form-actions" style="margin:0px;">
                          <div class="span2"></div>
                        <button type="submit" name="send" id='send'  class="btn btn-primary labell span8">SEND REQUEST</button>
                      </div>
                    </div>
                </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>

<!-- ============END BLOOD REQUEST AND ACTION==================================-->




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
                        <?php
                        if($reports['review'] == '' || $reports['review']=='NULL'){
                            echo "<form method='post'><textarea class='span11' name='review".$reports['medID']."' rows='2' id='review' required></textarea><button type='submit' name='saveReview".$reports['medID']."' class='btn btn-primary labell' style='margin-top:-10px;'>Save Review</button></form>";
                        ?>
                          <?php
                              if(isset($_POST['saveReview'.$reports['medID']])){
                                  $revw = $_POST['review'.$reports['medID']];
                                  $sqq = update("UPDATE wardmeds SET review='$revw' WHERE medID='".$reports['medID']."' ");
                                  echo "<script>window.location.href='{$_SERVER['REQUEST_URI']}'</script>";
                              }
                          ?>

                <?php }else{?>
                <textarea class="span11" name="review" readonly><?php echo $reports['review'];?></textarea>
                <?php }?>
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
<script src="js/highcharts.js"></script>
<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>


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

<script>

  Highcharts.chart('container', {
  chart: {
    type: 'spline'
  },
  title: {
    text: 'Patient Vitals'
  },
  subtitle: {
    text: 'Source: Quat IT Solution'
  },
  xAxis: {
    categories: ['0', '2', '4', '6', '8', '10','12', '14', '16', '18', '20', '22', '24']
  },
  yAxis: {
    title: {
      text: ''
    },
    labels: {
      formatter: function () {
        return this.value + '°';
      }
    }
  },
  tooltip: {
    crosshairs: true,
    shared: true
  },
  plotOptions: {
    spline: {
      marker: {
        radius: 4,
        lineColor: '#666666',
        lineWidth: 1
      }
    }
  },
  series: [{
    name: 'Temperature',
    marker: {
      symbol: 'square'
    },
    data: [<?php echo  $graph_temp;?>,<?php echo  $graph_temp;?>,<?php echo  $graph_temp;?>, {
      // y: 26.5,
        // y: 24,
      marker: {
        symbol: 'url(https://www.highcharts.com/samples/graphics/sun.png)'
      }
    }, ]

  }, {
    name: 'Blood Pressure',
    marker: {
      symbol: 'diamond'
    },
    data: [{

      // y: 3.9,
        // y:50,
      marker: {
        symbol: 'url(https://www.highcharts.com/samples/graphics/snow.png)'
      }
    }, <?php echo  $graph_pressure;?>,<?php echo  $graph_pressure;?>,<?php echo  $graph_pressure;?>,]
  }]
});


</script>



</script>
</body>
</html>
<?php }else{echo "<script>window.location='404'</script>";}?>
<script>
  //select list
  $(document).ready(function(){
    $('#blood_type').change(function(){
     let txtbox = $('#blood_type option:selected');

     document.getElementById('blood_id').value = txtbox.val();
 });

  });


</script>
