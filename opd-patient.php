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
<!--<link rel="stylesheet" href="assets/css/font-awesome.css" />-->
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

        <style>
        .active{
            background-color: #209fbf;
        }
            label{
                font-weight: bolder;
            }
    </style>
  <style type="text/css">
        .center {
    margin-top:50px;
}

.modal-header {
	padding-bottom: 5px;
}

.modal-footer {
    	padding: 0;
	}

.modal-footer .btn-group button {
	height:40px;
	border-top-left-radius : 0;
	border-top-right-radius : 0;
	border: none;
	border-right: 1px solid #ddd;
}

.modal-footer .btn-group:last-child > button {
	border-right: 0;
}
    </style>

</head>
<body>


<?php
    include 'layout/head.php';

    if($_SESSION['accessLevel']=='OPD' || $_SESSION['username']=='rik'){

    $active2='';
    $active='';
    $success = '';
    $error = '';

    $tab = $_GET['tab'];

    if($tab == "vitals"){
        $active2 = "active";
        $get_PID = $_GET['pid'];
        $patient = select("SELECT * FROM patient WHERE patientID='".$_GET['pid']."' ORDER BY patientID ASC");
        foreach($patient as $pID){}

    }elseif($tab == "opd-patient"){
        $active  = "active";
    }

//    echo "<script>alert('{$_GET['pid']}')</script>";
//    exit;

    //generate consultID
        $consultation = new Consultation;
    $consultIDs = $consultation->find_num_consults() + 1;

    //get StaffID
    $staffIDss = select("SELECT * FROM centeruser WHERE userName='".$_SESSION['username']."' AND  password='".$_SESSION['password']."'  AND  centerID='".$_SESSION['centerID']."' ");
   foreach($staffIDss as $staffIDy){}

    if(isset($_POST['btnSave'])){
      $consultID = "CON-".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$consultIDs);
      $staffID = $staffIDy['userID'];
      $patientID = filter_input(INPUT_POST, "patientID", FILTER_SANITIZE_STRING);
      $bodyTemperature = filter_input(INPUT_POST, "bodytemp", FILTER_SANITIZE_STRING);
      $pulseRate = filter_input(INPUT_POST, "pulseRate", FILTER_SANITIZE_STRING);
      $respirationRate = filter_input(INPUT_POST, "respirationRate", FILTER_SANITIZE_STRING);
      $bloodPressure = filter_input(INPUT_POST, "bloodPressure", FILTER_SANITIZE_STRING);
      $weight = filter_input(INPUT_POST, "weight", FILTER_SANITIZE_STRING);
      $otherHealth = filter_input(INPUT_POST, "otherHealth", FILTER_SANITIZE_STRING);
      $roomID = filter_input(INPUT_POST, "consultRoom", FILTER_SANITIZE_STRING);
      $mode = filter_input(INPUT_POST, "mode", FILTER_SANITIZE_STRING);
      $insuranceType = filter_input(INPUT_POST, "insuranceType", FILTER_SANITIZE_STRING);
      $insuranceNumber = filter_input(INPUT_POST, "insuranceNumber", FILTER_SANITIZE_STRING);
      $ccNumber = filter_input(INPUT_POST, "ccNumber", FILTER_SANITIZE_STRING);
      $company = filter_input(INPUT_POST, "company", FILTER_SANITIZE_STRING);
      // $insurance_number = filter_input(INPUT_POST, "insurance_number", FILTER_SANITIZE_STRING);
      $insurance_exp = filter_input(INPUT_POST, "insurance_exp", FILTER_SANITIZE_STRING);
      $centerID=$_SESSION['centerID'];
      $status = SENT_TO_CONSULTING;
      $lab_status1 = SENT_TO_LAB;
      $patient_busy = PATIENT_BUSY;
      @$assign_lab = $_POST['assign_lab'];


if($assign_lab == "sent_to_lab"){
      $consultAssignPatient1 = $consultation->consultAssignPatient($consultID,$staffID,$bodyTemperature,$pulseRate,$respirationRate,$bloodPressure,$weight,$otherHealth,$roomID,$patientID,$mode,$insuranceType,$insuranceNumber,$ccNumber,$company,$lab_status1,$centerID,$dateToday);
}else{

//        $consultAssignPatient1 = Consultation::consultAssignPatient($consultID,$staffID,$bodyTemperature,$pulseRate,$respirationRate,$bloodPressure,$weight,$otherHealth,$roomID,$patientID);
        $consultAssignPatient1 = $consultation->consultAssignPatient($consultID,$staffID,$bodyTemperature,$pulseRate,$respirationRate,$bloodPressure,$weight,$otherHealth,$roomID,$patientID,$mode,$insuranceType,$insuranceNumber,$ccNumber,$company,$status,$centerID,$dateToday);
}

    if($consultAssignPatient1){
            $update_patient_status = update("UPDATE patient SET patient_status = '$patient_busy',lock_center='".$_SESSION['centerID']."', insurance_number='$insuranceNumber',insurance_exp='$insurance_exp' WHERE patientID='$patientID' ");

		//select opd price..
//		$opdPrice = select("SELECT * FROM prices WHERE serviceName='OPD' AND centerID='".$_SESSION['centerID']."'");
//		foreach($opdPrice as $priceRow){}

            $labNumber = count($_POST['labName']);
            // echo "<script>alert('{$labNumber}')</script>";exit;

            $labReq_ID = count(select("select * from labresults")) + 1;
            $labReqID = "LABREQ.".$_SESSION['centerID']."-".$labReq_ID;
            // echo "<script>alert('{$labReqID}')</script>";exit;

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

            $insertLabReq = insert("INSERT INTO labresults(labRequestID,consultID,labID,centerID,patientID,staffID,consultingRoom,status,paymode,paystatus,labprice,dateInsert) VALUES('$labReqID','".$consultID."','$labID','".$_SESSION['centerID']."','$patientID','$staffID','$roomID','$assign_lab','$mode','$paystatus','".$labPrice['servicePrice']."',CURDATE())");

                                if($insertLabReq){
                                     $success =  "LAB REQUEST SENT SUCCESSFULLY";
                $updatePatient = update("UPDATE consultation set status='$assign_lab' where patientID='$patientID' AND consultID='$consultID'");
                                    #echo "<script>window.location='opd-patient?tab=opd-patient';</script>";
                                }else{
                                    $error =  "ERROR: LAB REQUEST NOT SENT";
                                }
                            }
                }
            }else{
               $error =  "ERROR: NO LAB REQUEST MADE";
            }


//select consultaion price..
    if($mode == "Private"){
		$conPrice = select("SELECT * FROM prices WHERE serviceName='CONSULTATION' AND centerID='".$_SESSION['centerID']."' AND modePayment='$mode'");
		foreach($conPrice as $conRow){}
    }else{
        $conPrice = select("SELECT * FROM prices WHERE serviceName='CONSULTATION' AND centerID='".$_SESSION['centerID']."' AND modePayment='$insuranceType'");

//generate claim number and insert into consultation tables
$claim_number = sprintf('%10s',count(select("select * from consultation where claimNumber='NULL' || claimNumber='' ")) + 1);
$insert_claimNumber = update("update consultation set claimNumber='$claim_number' where patientID='$patientID' && consultID='$consultID' ");

		foreach($conPrice as $conRow){}
        $mode = $insuranceType;
    }

			//insert opd price....
//$insertOPD = insert("INSERT INTO paymentfixed (patientID,centerID,paymode,serviceName,servicePrice,serviceType,status,dateInsert) VALUES('$patientID','".$_SESSION['centerID']."','$mode','".$priceRow['serviceName']."','".$priceRow['servicePrice']."','".$priceRow['serviceType']."','Not Paid','$dateToday')");

//insert consultation.. price....
$insertCON = insert("INSERT INTO paymentfixed (patientID,centerID,paymode,seviceID,serviceName,servicePrice,serviceType,status,dateInsert) VALUES('$patientID','".$_SESSION['centerID']."','$mode','$consultID','".$conRow['serviceName']."','".$conRow['servicePrice']."','".$conRow['serviceType']."','Not Paid','$dateToday')");
			 if($insertCON){
				if($update_patient_status){
					$success = "<script>document.write('PATIENT ASSIGNED TO CONSULTING ROOM')
									window.location.href='opd-patient?tab=opd-patient' </script>";
				}
			}

        }else{
            $error = "PATIENT NOT ASSIGNED";
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
    <li> <a href="opd-index"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
    <li class="active"> <a href="opd-patient?tab=opd-patient"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
<!--    <li><a href="opd-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>-->
    <li><a href="opd-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
    </ul>
</div>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Out Patient Department" class="tip-bottom"><i class="icon-plus"></i> OPD</a>
        <a title="Old Patients" class="tip-bottom"><i class="icon-user"></i> OPD OLD PATIENTS</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">OUT PATIENT DEPARTMENT</h3>
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
                    <li class="<?php echo $active; ?>"><a data-toggle="tab" href="#tab1">Out Patient List</a></li>
<!--                    <li class="active"><a data-toggle="tab" href="#tab1">Out Patient List</a></li>-->
                    <li class="<?php echo $active2; ?>"><a data-toggle="tab" href="#tab2">Add Vitals </a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane <?php echo $active; ?>">
<!--                <div id="tab1" class="tab-pane active">-->
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>List Of Patients</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Patient ID</th>
                              <th>Patient Name</th>
                              <th>Mobile Number</th>
                              <th>Date of Birth</th>
                              <th>Action</th>
                            </tr>
                          </thead>
<!--                          <tbody id="outpatientlist"></tbody>-->
                          <tbody id="outpatientlist11">
                  <?php
                        $load_patient = select("SELECT * FROM patient WHERE centerID='".$_SESSION['centerID']."' && patient_status !='".PATIENT_BUSY."' && status != 'dead' ORDER BY patientID ASC");

                            foreach($load_patient as $patient){

                            ?>

                            <tr>
                              <td><?php echo $patient['patientID']; ?></td>
                              <td> <?php echo $patient['firstName']." ".$patient['otherName']." ".$patient['lastName']; ?></td>
                              <td> <?php echo $patient['phoneNumber']; ?></td>
                              <td style="text-align: center;"> <?php echo $patient['dob']; ?></td>
                              <td style="text-align: center;">
                                   <a href="#" data-toggle="modal" data-target="#squarespaceModal<?php echo $patient['patientID']; ?>"> <span class="btn btn-primary fa fa-eye"></span></a>
                                   <a href="id-card?pid=<?php echo $patient['patientID'];?>" title="Patient Card"> <span class="btn btn-success fa fa-vcard"></span></a>
                              </td>
                            </tr>





                            <!-- line modal -->
                            <div class="modal fade" id="squarespaceModal<?php echo $patient['patientID']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                        <h3 class="modal-title" id="lineModalLabel"><?php echo $patient['firstName']." ".$patient['otherName']." ".$patient['lastName']; ?> (<?php echo $patient['patientID']; ?>)</h3>
                                    </div>
                                    <div class="modal-body">

                                        <!-- content goes here -->
                                        <form>
                                            <div class="span6">

                                                  <div class="form-group">
                                                    <label for="exampleInputEmail1">Date of Brith</label>
                                                    <input type="text" class="form-control" value="<?php echo $patient['dob']; ?>" id="exampleInputEmail1" readonly >
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="exampleInputPassword1">Blood Group</label>
                                                    <input type="text" class="form-control" value="<?php echo $patient['bloodGroup']?>" id="exampleInputPassword1" readonly >
                                                  </div>

                                                  <div class="form-group">
                                                    <label for="exampleInputEmail1">Phone Number</label>
                                                    <input type="text" class="form-control" value="<?php echo $patient['phoneNumber']; ?>" id="exampleInputEmail1" readonly >
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="exampleInputPassword1">Guardian Name</label>
                                                    <input type="text" class="form-control" value="<?php echo $patient['guardianName']?>" id="exampleInputPassword1" readonly >
                                                  </div>

                                                  <div class="form-group">
                                                    <label for="exampleInputPassword1">Guardian Phone Number</label>
                                                    <input type="text" class="form-control" value="<?php echo $patient['guardianPhone']?>" id="exampleInputPassword1" readonly >
                                                  </div>

                                                  <div class="form-group">
                                                    <label for="exampleInputEmail1">Guardian Address</label>
                                                    <input type="text" class="form-control" value="<?php echo $patient['guardianAddress']; ?>" id="exampleInputEmail1" readonly >
                                                  </div>

                                            </div>


                                                  <div class="form-group">
                                                    <label for="exampleInputEmail1">Gender</label>
                                                    <input type="text" class="form-control" value="<?php echo $patient['gender']; ?>" id="exampleInputEmail1" readonly >
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="exampleInputPassword1">Home Address</label>
                                                    <input type="text" class="form-control" value="<?php echo $patient['homeAddress']?>" id="exampleInputPassword1" readonly >
                                                  </div>

                                                  <div class="form-group">
                                                    <label for="exampleInputEmail1">Home Town</label>
                                                    <input type="text" class="form-control" value="<?php echo $patient['hometown']; ?>" id="exampleInputEmail1" readonly >
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="exampleInputPassword1">Guardian Gender</label>
                                                    <input type="text" class="form-control" value="<?php echo $patient['guardianGender']?>" id="exampleInputPassword1" readonly >
                                                  </div>

                                                  <div class="form-group">
                                                    <label for="exampleInputPassword1">Guardian Relation</label>
                                                    <input type="text" class="form-control" value="<?php echo $patient['guardianRelation']?>" id="exampleInputPassword1" readonly >
                                                  </div>


<!--
                                                  <div class="form-group">
                                                    <label for="exampleInputPassword1">&nbsp;</label>
                                                    <a class="btn btn-primary pull-right" style="margin-right:40px;" href="opd-patient?tab=vitals&pid=<?php //echo $patient['patientID']; ?>" >Check Vitals <i class="fa fa-arrow-right"></i></a>
                                                  </div>
-->

<!--                                        <hr/>-->

                                                <img src='<?php echo $patient['patient_image']; ?>' width=120 height=350 ><br><br>

                                                         <a class="btn btn-primary pull-right" style="margin-right:40px;" href="opd-patient?tab=vitals&pid=<?php echo $patient['patientID']; ?>" >Check Vitals <i class="fa fa-arrow-right"></i></a>
                                                    </div>
<!--                                                </div>-->
<!--                                                <div class="span6">-->
<!--
                                                   <div class="form-group">
                                                    <label for="exampleInputPassword1">&nbsp;</label>
                                                    <a class="btn btn-primary" style="margin-right:40px;" href="opd-patient?tab=vitals&pid=<?php #echo $patient['patientID']; ?>" >Check Vitals <i class="fa fa-arrow-right"></i></a>
                                                  </div>
-->
<!--                                                </div>-->
                                            </div>
                                        </form>

                                    </div>

                                </div>
                              </div>
                            </div>



                               <?php } ?>


                            </tbody>
                        </table>






                      </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane <?php echo $active2; ?>">
                    <form action="" method="post" id="vitals" class="form-horizontal">
                    <div class="span6" id="vitals">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Patient :</label>
                               <div class="controls">
                                  <select name="patientID" id="patientId" class="" onchange="pname(this.value);">
                                        <?php
                                        if(!empty($_GET['pid'])){
                                        ?>
                                        <option value="<?php echo $get_PID; ?>"><?php echo $get_PID; ?></option>
                                        <?php } ?>
                                   </select>
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Mode of Payment:</label>
                                <div class="controls">
                                  <select class="span11" name="mode" onchange="modey(this.value);">
                                        <option value=""></option>
                                        <option value="Private">Private</option>
                                        <option value="Insurance">Health Insurance</option>
                                        <option value="Company">Company</option>
                                    </select>
                                </div>
                              </div>

                             <span id="modeload"></span>

                                     <!-- <div class="control-group">
                                       <label class="control-label">Expire Date:</label>
                                       <div class="controls">
                                         <input type="date" id="modeload" class="span11" placeholder="Expire Date" value="<?php #echo $_SESSION['exp_date']; ?>" name="exp_date" readonly />
                                       </div>
                                     </div> -->

                              <div class="control-group">
                                <label class="control-label">Body Temperature:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Body Temperature" name="bodytemp" required />
                                </div>
                              </div>
							  <div class="control-group">
                                <label class="control-label">Weight</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="weight" placeholder="Weight" required />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Other Health Details :</label>
                                <div class="controls">
                                    <textarea class="span11" name="otherHealth"></textarea>
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
                                  <input type="text" required readonly value="<?php echo $pID['firstName']." ".$pID['otherName']." ".$pID['lastName']; ?>" id="FullName" class="span11" placeholder="Full name" name="FullName" />
                                </div>
                              </div>
                          <?php }else{echo '<span id="fname"></span>';} ?>
                              <div class="control-group">
                                <label class="control-label">Pulse Rate :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Pulse Rate" name="pulseRate" />
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Respiration Rate :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Respiration Rate" name="respirationRate" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Blood Pressure</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="bloodPressure" placeholder="Blood Pressure" required />
                                </div>
                              </div>


                               <div class="control-group">
                                <label class="control-label">Assign Consulting Room</label>
                                <div class="controls">
                                  <select name="consultRoom" >
                                    <option value="default"> -- Select Consulting Room --</option>
                                    <optgroup label="Consulting Room"> Consulting Room
                                      <?php
                                        $consultingroom = $consultation->loadConsultRoomByID($centerID);
                                        foreach($consultingroom as $roomRow){
                                      ?>
                                    <option value="<?php echo $roomRow['roomID'];?>"> <?php echo $roomRow['roomName'];?></option>
                                      <?php } ?>

                                    </optgroup>
                                    <!-- <optgroup label="Laboratory">Laboratory
                                        <option value="sent_to_lab">Laboratory</option>
                                    </optgroup> -->

                                  </select>
                                </div>
                                  <div class="controls"></div>
                              </div>

                              <div class="control-group">
                                <label class="control-label"> Assign Lab: </label>
                                  <div class="controls">
                                    <input type="checkbox" value="sent_to_lab" name="assign_lab" onchange="labchk(this.value);">
                                  </div>
                              </div>

                               <div class="control-group">
                                <label class="control-label">Select Lab Request: </label>
                                <div class="controls">
                                  <select multiple name="labName[]" id="labchkload">
                                    <option></option>
                                  </select>
                                </div>
                                  <div class="controls"></div>
                              </div>

                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="btnSave" class="btn btn-primary btn-block span10">Save Out Patient</button>
                              </div>
                          </div>
                      </div>
                    </form>
                </div>
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

<script>
window.onload = function () {
    document.getElementById('button').onclick = function () {
        document.getElementById('modal').style.display = "none"
    };
};
</script>


     <?php if(empty($_GET['pid'])){  ?>
       <script>
    function dis(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/patientID-load.php",false);
        xmlhttp.send(null);
        document.getElementById("patientId").innerHTML=xmlhttp.responseText;
    }
        dis();

        setInterval(function(){
            dis();
        },1000);


        function pname(val){
            // load the select option data into a div
                $('#loader').html("Please Wait...");
                $('#fname').load('loads/pname.php?id='+val, function(){
                $('#loader').html("");
               });
        }

    </script>
<?php } ?>

<script>

        function modey(val){
            // load the select option data into a div
                $('#loader').html("Please Wait...");
                $('#modeload').load('loads/mode.php?id='+val+'&pid=<?php echo $_GET["pid"]; ?>', function(){
                $('#loader').html("");
               });
        }

</script>

<script>

        function labchk(val){
            // load the select option data into a div
                $('#loader').html("Please Wait...");
                $('#labchkload').load('loads/labchk.php?id='+val, function(){
                $('#loader').html("");
               });
        }

</script>

<script>


        function ccInsure(val){
            // load the select option data into a div
                $('#loader').html("Please Wait...");
                $('#ccmodeload').load('loads/ccmode.php?id='+val+'&pid=<?php echo $_GET["pid"]; ?>', function(){
                $('#loader').html("");
               });
        }

// function ccInsure(val){
//     // load the select option data into a div
//         $('#loader').html("Please Wait...");
//         $('#ccmodeload').load('loads/ccmode.php?id='+val, function(){
//         $('#loader').html("");
//        });
// }


</script>

<!--
       <script>
    function out_patient_list(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/oldpatient-load.php",false);
        xmlhttp.send(null);
        document.getElementById("outpatientlist").innerHTML=xmlhttp.responseText;
    }
        out_patient_list();

        setInterval(function(){
            out_patient_list();
        },1000);
    </script>
-->

<script type="text/javascript">
setInterval("my_function();",5000);
function my_function(){
//      $('#outpatientlist').load('loads/oldpatient-load.php');
    document.getElementById("outpatientlist").innerHTML
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
</body>
</html>
<?php }else{echo "<script>window.location='404'</script>";}?>
