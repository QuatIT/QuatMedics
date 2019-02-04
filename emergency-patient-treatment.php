<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUATMEDIC</title>
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
<!--highcharts-->
<script src="chart/plotly-latest.min.js"></script>
<script src="chart/highcharts.js"></script>
<script src="chart/series-label.js"></script>
<script src="chart/exporting.js"></script>
<script src="chart/export-data.js"></script>

<style>
.active{
/*    background-color: #209fbf;*/
}
@media print{
  #printable{
    display:block;
  }
}
</style>
</head>
<body>

<?php
    include 'layout/head.php';
    //    error_reporting(0);

    $success = '';
    $error = '';
    $req_action='';

    $get_PID = $_GET['pid'];
    $emeid = $_GET['emeid'];
    $patient = select("SELECT * FROM emergency_patient WHERE patientID='$get_PID' AND emeid='$emeid' ORDER BY patientID ASC");
    foreach($patient as $pID){}

    $vit_sq = select("SELECT * FROM eme_vitals WHERE patientID='$get_PID' && emeID='".$_GET['emeid']."' ORDER BY id DESC LIMIT 1");
    foreach($vit_sq as $vitrow){}

//codes emergency medicine prescription..
if (isset($_POST['sub_mit'])){
	$medsNum = count($_POST['medicine']);
    $piecesNum = count( $_POST['pieces']);
    $adayNum = count( $_POST['aday']);
    $totalDaysNum = count( $_POST['totalDays']);
    $paystatus = "Not Paid";
	$medical_status = 'not attended to';
	$today_status = '0';

	$eme_medIDs = count(select("SELECT * FROM eme_ward GROUP BY eme_medID ")) + 1;
	$eme_medID = "EME-PRES-".sprintf('%06s',$eme_medIDs);

if($medsNum > 0 && $totalDaysNum > 0 ) {
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

            $crtgal = insert("INSERT INTO eme_ward(eme_medID,dateRegistered,prescrib_med,dosage,prescribed_by,patientID,emeID,med_status,today_status,centerID) VALUES('$eme_medID',CURDATE(),'$medicine','$dosage','".$_SESSION['username']."','".$_GET['pid']."','".$_GET['emeid']."','$medical_status','$today_status','".$_SESSION['centerID']."') ");

       }
}

}

}

//body temperature and blood pressure for vital(graphical)

// $graph_vit = select("SELECT * FROM ward_vitals WHERE patientID= 'Salia-000001' && dateRegistered=CURDATE() ORDER BY id DESC");
// $graph_temp=array();
// $graph_pressure='';
// foreach($graph_vit as $graph_vits){
//   $graph_temp[] = $graph_vits['bodyTemp'];
//   $graph_pressure[] = $graph_vits['bloodPressure'];
// }
// echo '<script>alert($graph_temp)<script>';
//	if(isset($_GET['id'])){rr
//
//		$med_status='administered';
//		$id=$_GET['id'];
//
//		$sqll = update("UPDATE eme_ward SET nurseID='".$_SESSION['username']."', med_status='".$med_status."' WHERE id='$id' ");
//		echo "<script>window.location.href='emergency-patient-treatment?emeid={$_GET['emeid']}&&pid={$_GET['pid']}'</script>";
//
//	}

// Body Temperature
$count = 0;

$count_row = select("SELECT COUNT(*) as row_tot FROM eme_vitals WHERE patientID = '".$get_PID."' && dateRegistered = CURDATE() ");
foreach($count_row as $count_rows){}

$pat_vital = select("SELECT * FROM eme_vitals where patientID = '".$get_PID."' && dateRegistered = CURDATE() ORDER BY doe ASC ");


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

$count_rox = select("SELECT COUNT(*) as row_tote FROM eme_vitals WHERE patientID = '$get_PID' && dateRegistered = CURDATE() ");
foreach($count_rox as $count_roxs){}

$pressure_vital = select("SELECT * FROM eme_vitals where patientID = '$get_PID' && dateRegistered = CURDATE() ORDER BY doe ASC ");


foreach($pressure_vital as $pressure_vitals){
  $patPressure[$counter] = $pressure_vitals['bloodPressure'];
$counter++;
}
$t_hours=24;

for($i=$count_roxs['row_tote'];$i<$t_hours;$i++){
  $patPressure[$i]=0;
}

//vital graph table
$g_table = select("SELECT * FROM eme_vitals WHERE patientID = '".$get_PID."' ORDER BY id DESC");



 // fetch blood types
    $fet_type = select('SELECT * FROM bloodgroup_tb');
    foreach($fet_type as $fet_types){}

    $user_cred = select("SELECT * FROM centeruser WHERE username ='".$_SESSION['username']."'");
    foreach( $user_cred as  $user_creds){}

$bl_id = select("SELECT * FROM bloodgroup_tb WHERE bloodGroup='".$fet_types['bloodGroup']."'");
foreach($bl_id as $bl_ids){}


    //request ID
  $request_blood = new B_Request();
    $r_blood = $request_blood->Request_blood()+1;
    $Request_id = 'REQ-EME-'.substr($centerName['centerName'], 0, 3)."-".sprintf('%06s', $r_blood);




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

$req_stat = select("SELECT * FROM bloodrequest WHERE patientID='".$get_PID."' && flag=1 && confirm='' && dateInsert=CURDATE() ORDER BY id ASC LIMIT 1");
if($req_stat){
    foreach($req_stat as $req_status){}
    //$req_status['bloodID'];
}



$req_cnt = select("SELECT COUNT(*) as request_co FROM bloodrequest WHERE patientID='".$get_PID."' && flag= 1 && confirm='' && dateInsert = CURDATE() ");
foreach($req_cnt as $req_cnts){$req_cnts['request_co'];}



//CONFIRM RECEIPT
if(isset($_POST['sub_mitx'])){
  $con_firm='confirmed';
  // $quan_tity = $req_status['quantity'];
  $quan_tity = $_POST['quant'];
  @$bd_id=$req_status['bloodID'];
   $quant = $_POST['quant'];
   $chingx='';


  $confirm = update("UPDATE bloodrequest SET confirm ='$con_firm' WHERE patientID='".$get_PID."' && flag= 1 && confirm='' && dateInsert=CURDATE() ORDER BY id ASC LIMIT 1");

  $blood_chk = select("SELECT * FROM bloodgroup_tb WHERE bloodID = '$bd_id'");
  foreach( $blood_chk as  $blood_chks){$chingx=$blood_chks['bloodID'];}

$get_count = select("SELECT * FROM bloodgroup_tb WHERE bloodID ='".$blood_chks['bloodID']."' ");

  $reciep = select("SELECT * FROM bloodrequest WHERE status='APPROVED'  && confirm='confirmed' && dateInsert=CURDATE()");
  foreach($reciep as $recieps){$recieps['quantity'];}

  $con_deduct = update("UPDATE bloodgroup_tb SET bloodBags = bloodBags - '".$recieps['quantity']."' WHERE bloodID ='".$blood_chks['bloodID']."' ");


}



    ?>

<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
<!--    <li><a href="medics-index"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>-->
<!--
    <li class="active"> <a href="opd-index"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
    <li> <a href="opd-patient?tab=opd-patient"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
    <li><a href="opd-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
-->
    </ul>
</div>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a href="emergency-index" title="" class="tip-bottom"><i class="icon icon-exclamation-sign"></i> EMERGENCY</a>
        <a href="emergency-index" title="" class="tip-bottom"><i class="icon icon-user"></i> EMERGENCY PATIENT</a>
    </div>
  </div>
  <div class="container-fluid">
<!--      <h3 class="quick-actions">EMERGENCY</h3>-->
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
      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">VITALS</a></li>
                    <li><a data-toggle="tab" href="#tab5">VITALS (GRAPHICAL)</a></li>
                    <li><a data-toggle="tab" href="#tab2">PRESCRIPTION</a></li>
                    <li><a data-toggle="tab" href="#tabRequest">BLOOD REQUEST</a></li>
                    <li><a data-toggle="tab" href="#tabAction">BLOOD REQUEST ACTION - &nbsp;<?php echo $req_cnts['request_co'];?></a></li>
                    <li><a data-toggle="tab" href="#tab3">NURSE'S CHECKLIST</a></li>
                    <li><a data-toggle="tab" href="#tab4">WARD HISTORY</a></li>

                </ul>
            </div>
            <div class="widget-content tab-content">
    <!-- ========================= VITALS TAB ======================================= -->
                <div id="tab1" class="tab-pane active">
                    <form action="" method="post" id="vitals" class="form-horizontal">
                    <div class="span6" id="vitals">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Patient :</label>
                               <div class="controls">
                                  <select name="patientID" id="patientId" class="selectpicker" onchange="pname(this.value);" class='form-control' style='width:320px;' readonly>
                                        <?php
                                        if(!empty($_GET['pid'])){
                                        ?>
                                        <option value="<?php echo $get_PID; ?>"><?php echo $get_PID; ?></option>
                                        <?php } ?>
                                   </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Body Temperature:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Body Temperature" value="<?php echo @$vitrow['bodyTemp']; ?>" name="bodytemp" readonly />
                                </div>
                              </div>
							   <div class="control-group">
                                <label class="control-label">Pulse Rate :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Pulse Rate" value="<?php echo @$vitrow['pulseRate']; ?>"  name="pulseRate" readonly/>
                                </div>
                              </div>


                              <div class="control-group">
                                <label class="control-label">Weight</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="weight" placeholder="Weight" value="<?php echo @$vitrow['weight']; ?>"  readonly />
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">

                              <?php if(!empty($_GET['pid'])){ ?>
                               <div class="control-group">
                                <label class="control-label">Full Name :</label>
                                <div class="controls">
                                  <input type="text" required readonly value="<?php echo $pID['patientName']; ?>" id="FullName" class="span11" placeholder="Full name" name="FullName" />
                                </div>
                              </div>
                          <?php }else{echo '<span id="fname"></span>';} ?>

                              <div class="control-group">
                                <label class="control-label">Respiration Rate :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Respiration Rate" name="respirationRate" value="<?php echo @$vitrow['respirationRate']; ?>" readonly/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Blood Pressure</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="bloodPressure" placeholder="Blood Pressure" value="<?php echo @$vitrow['bloodPressure']; ?>" readonly />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">As AT</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="" placeholder="AS AT TODAY" value="<?php echo @$vitrow['doe']; ?>" readonly />
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <a href="emergency-vitals?emeid=<?php echo $_GET['emeid']; ?>&pid=<?php echo $_GET['pid']; ?>&tab=vitals" class="btn btn-primary btn-block labell span10">Register New Vitals</a>
                              </div>
                          </div>
                      </div>
                    </form>
                </div>
<!-- ============================== END OF VITALS TAB ==================================-->


<!-- ============================== START OF VITALS GRAPH TAB ==================================-->

    <div id="tab5" class="tab-pane">
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


<div id="tab2" class="tab-pane">
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon"><i class="icon-th"></i></span>
            <h5>DOCTOR' PRESCRIPTION</h5>
        </div>
        <div class="widget-content nopadding">
            <form action="" method="post" enctype="multipart/form-data">
            <table class="table table-bordered" id="dynamic_field2">
                <tr>
                    <th style="width:60%;"> MEDICINE NAME</th>
                    <th> INTAKES</th>
                    <th> / DAY</th>
                    <th> No.OF DAYS</th>
                </tr>
                  <?php
                  $total = 5;
                    for($i=0;$i<$total;$i++){
                  ?>

                <tr>
                    <td>
				        <?php
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
                                <?php }?>
                            </select>
							<?php }?>

                    </td>
                        <td><input type="number" min="1" name="pieces[]" placeholder="e.g. 2" class="span11" /></td>
						<td><input type="number" min="1" name="aday[]" placeholder="e.g. 3" class="span11" /></td>
						<td><input type="number" min="1" name="totalDays[]" placeholder="e.g. 7" class="span11" /></td>
                </tr>
                  <?php }?>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">
                    <button type="submit" name="sub_mit" style="width:100%;" id="sub_mit" class="btn btn-primary btn-block labell span10"> SUBMIT</button>
                    </td>
                </tr>
                </table>
            </form>
        </div>
    </div>
</div>



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
                <input type="submit" class="btn btn-primary" style='width:360px;'name="sub_mitx" id="sub_mitx" value="CONFIRM RECEIPT">
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
                          <input type="text" class="span11" name="patient_name" id="patient_name" value='<?php echo $pID['patientName'];?>' readonly>
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
                          <input type="text" class="span11" name="patient_id" id="patient_id" value='<?php echo $get_PID;?>' readonly>
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
                        <button type="submit" name="send" id='send' class="btn btn-primary labell span8">SEND REQUEST</button>
                      </div>
                    </div>
                </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>

<div id="tab3" class="tab-pane">
     <div class="widget-box">
      <div class="widget-title">
         <span class="icon"><i class="icon-th"></i></span>
<!--        <h5 class="labell">Patient's Name</h5>-->
      </div>
      <div class="widget-content nopadding">
        <table class="table table-bordered data-table">
          <thead class="labell">
            <tr>
              <th>Date</th>
              <th>Prescription</th>
              <th>Dosage</th>
              <th>Prescibed By</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
<!--          <tbody id="emepatienttreat11"></tbody>-->
          <tbody id="emepatienttreat11">
        <?php
            $load_newpatient = select("SELECT * FROM eme_ward WHERE emeID='$emeid' AND patientID='$get_PID' ORDER BY dateRegistered ASC");

foreach($load_newpatient as $newpatient){

?>


<tr>
  <td> <?php echo $newpatient['dateRegistered']; ?></td>
<!--  <td> <?php #echo $newpatient['patientID']; ?></td>-->
  <td> <?php echo $newpatient['prescrib_med']; ?></td>
  <td> <?php echo $newpatient['dosage']; ?></td>
  <td> <?php echo $newpatient['prescribed_by']; ?></td>
  <td> <?php echo $newpatient['med_status']; ?></td>
  <td style="text-align: center;">
	  <?php if($newpatient['med_status']=="administered"){echo '';}else{ ?>
       <a href="nursecheck?emeid=<?php echo $_GET['emeid'];?>&pid=<?php echo $_GET['pid']; ?>&id=<?php echo $newpatient['id']; ?>"> Administered</a><?php } ?>
  </td>
</tr>


<?php  } ?>
            </tbody>
        </table>
      </div>
    </div>
</div>


<div id="tab4" class="tab-pane">
     <div class="widget-box">
      <div class="widget-title">
         <span class="icon"><i class="icon-th"></i></span>
        <h5>Patient's History</h5>
      </div>
      <div class="widget-content nopadding">
        <table class="table table-bordered data-table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Vitals</th>
              <th>Prescription</th>
              <th>Dosage</th>
              <th>Prescibed By</th>
<!--                              <th>Status</th>-->
              <th>Doctor's Comment</th>
            </tr>
          </thead>
          <tbody id="emepatienttreathistory">
<?php
$load_newpatient = select("SELECT * FROM eme_ward WHERE emeID='$emeid' && patientID='".$_GET['pid']."'  GROUP BY dateRegistered ORDER BY dateRegistered ASC");
              foreach($load_newpatient as $newpatient){
?>
<tr>
  <td> <?php echo $newpatient['dateRegistered']; ?></td>
  <td>
	<?php
	  $em_vn = select("select * from eme_vitals where dateRegistered='".$newpatient['dateRegistered']."' ");
		foreach($em_vn as $emv_row){
	  ?>
	<ol>
	  <li><b>Body Temperature: </b> <?php echo $emv_row['bodyTemp']; ?></li>
	  <li><b>Pulse Rate : </b> <?php echo $emv_row['pulseRate']; ?></li>
	  <li><b>Weight : </b> <?php echo $emv_row['weight']; ?></li>
	  <li><b>Respiration Rate : </b> <?php echo $emv_row['respirationRate']; ?></li>
	  <li><b>Blood Pressure : </b> <?php echo $emv_row['bloodPressure']; ?></li>
	  </ol>
<?php }?>
	</td>
  <td>
	  <?php
		  $sql = select("SELECT * FROM eme_ward WHERE eme_medID='".$newpatient['eme_medID']."' ORDER BY dateRegistered ASC");
	  ?>
	  <ol>
		  <?php  foreach($sql as $srow){ ?>
		  <li><?php echo $srow['prescrib_med']; ?></li>
		  <?php } ?>
	  </ol>
	</td>
  <td>
	  <?php
		  $sqls = select("SELECT * FROM eme_ward WHERE eme_medID='".$newpatient['eme_medID']."' ORDER BY dateRegistered ASC");
	  ?>
	  <ol>
		  <?php  foreach($sqls as $srows){ ?>
		  <li>
			  <?php echo $srows['dosage']; ?> ( <?php if($srows['med_status']=="administered"){ ?> <span class='' style='color:green;'>administered</span> <?php }else{ ?><span class='' style='color:red;'>not administered</span> <?php } ?> )
		  </li>
		  <?php } ?>
	  </ol>
	</td>
<!--  <td> <?php #echo $newpatient['med_status']; ?></td>-->
  <td> <?php echo $newpatient['prescribed_by']; ?></td>
  <td> <?php if(empty($newpatient['doc_comment']) || $newpatient['doc_comment'] == 'NULL'){
		  echo "<form action='' method='post'><input type='text' name='comment".$newpatient['eme_medID']."' ><input type='submit' name='btncomment".$newpatient['eme_medID']."' class='btn btn-primary'></form> "; ?>
	  <?php
		  if(isset($_POST['btncomment'.$newpatient['eme_medID']])){
			  $cm = $_POST['comment'.$newpatient['eme_medID']];
			  $sqq = update("UPDATE eme_ward SET doc_comment='$cm' WHERE eme_medID='".$newpatient['eme_medID']."' ");
			  echo "<script>window.location.href='{$_SERVER['REQUEST_URI']}'</script>";
		  }
	  ?>
	  <?php }else{ echo $newpatient['doc_comment']; } ?>
    </td>
</tr>

<?php } ?>


							</tbody>
                        </table>
                      </div>
                    </div>
              </div>
            </div>
        </div>
      </div>
  </div>
</div>
<div class="row-fluid ">
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
<script src="js/highcharts.js"></script>
<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script>
<!--<script src="js/maruti.js"></script> -->
<script>
  function newpatient(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/emenursechecklist.php?emeid=<?php echo $_GET['emeid']; ?>&&pid=<?php echo $_GET['pid']; ?>",false);
        xmlhttp.send(null);
        document.getElementById("emepatienttreat11").innerHTML=xmlhttp.responseText;
    }
        newpatient();

        setInterval(function(){
            newpatient();
        },3000);
    </script>

<!--
<script>
  function emehistory(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/emehistory.php?emeid=<?php #echo $_GET['emeid']; ?>&&pid=<?php echo $_GET#['pid']; ?>",false);
        xmlhttp.send(null);
        document.getElementById("emepatienttreathistory").innerHTML=xmlhttp.responseText;
    }
        emehistory();

        setInterval(function(){
            emehistory();
        },300000000000);
    </script>
-->

    <script>
    function emPat(val){
	// load the select option data into a div
        $('#loader').html("Please Wait...");
        $('#empatient').load('emepatient.php?id='+val, function(){
		$('#loader').html("");
       });
}
    </script>


<!--

        <script>
            //    $(document).ready(function(){
            var i = 1;
            $('#add').click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i + '"> <td><input type="text" name="medicine[]" placeholder="Medicine / Prescription" class="form-control"></td><td><input type="text" name="dosage[]" placeholder="Dosage" class="form-control"></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });

            //    });

        </script>
-->


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




</body>
</html>


<script>
function printer() {
    window.print();
}
</script>

<script>
  //select list
  $(document).ready(function(){
    $('#blood_type').change(function(){
     let txtbox = $('#blood_type option:selected');

     document.getElementById('blood_id').value = txtbox.val();
 });

  });


</script>
