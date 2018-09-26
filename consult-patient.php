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

    if($_SESSION['accessLevel']=='CONSULTATION'){

    $success = "";
    $error = "";
    $conid = $_GET['conid'];
    $roomID = $_GET['roomID'];
    $consultdet = select("SELECT * from consultation WHERE consultID='$conid'");

    $staff = select("SELECT staffID from centeruser where userName='".$_SESSION['username']."' AND password='".$_SESSION['password']."'");
    foreach($staff as $staffrow){
        $staffID = $staffrow['staffID'];
    }

    foreach($consultdet as $consultrow){
           $patientID = $consultrow['patientID'];
        $fetchpatient = select("SELECT firstName,lastName,otherName from patient WHERE patientID='$patientID' && lock_center='".$_SESSION['centerID']."' ");
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
            $prescribeCode = "PRSCB-1";
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
            $labReqID = "LABREQ-1";
        }


if(isset($_POST['reqLab'])){
    $labNumber = count($_POST['labName']);

    if($labNumber > 0) {
        for($i=0; $i<$labNumber; $i++){
                if(trim($_POST["labName"][$i] != '')) {
                    $labID = trim($_POST["labName"][$i]);
                    $status = SENT_TO_LAB;
$insertLabReq = insert("INSERT INTO labresults(labRequestID,consultID,labID,centerID,patientID,staffID,consultingRoom,status) VALUES('$labReqID','".$_GET['conid']."','$labID','".$_SESSION['centerID']."','$patientID','$staffID','$roomID','$status')");

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


if(isset($_POST['adWard'])){
    $wardID = filter_input(INPUT_POST, "wardID", FILTER_SANITIZE_STRING);
    $admitDetails = filter_input(INPUT_POST, "admitDetails", FILTER_SANITIZE_STRING);
    $admitDate = filter_input(INPUT_POST, "admitDate", FILTER_SANITIZE_STRING);
    $dischargeDate = filter_input(INPUT_POST, "dischargeDate", FILTER_SANITIZE_STRING);
    $status = SENT_TO_WARD;
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
        $assignID = "ASSIGN-1";
    }

    $insertassign = insert("INSERT INTO wardassigns(assignID,wardID,patientID,staffID,admitDate,dischargeDate,admitDetails) VALUES('$assignID','$wardID','$patientID','$staffID','$admitDate','$dischargeDate','$admitDetails')");

    if($insertassign){
        $success =  "PATIENT ADMITTION SAVE SUCCESSFULLY";
        $updatePatient = update("UPDATE consultation set status='$status' where patientID='$patientID' AND consultID='$conid'");
        echo "<script>window.location='consult-index?roomID={$roomID}'';</script>";
    }else{
        $error =  "ERROR: PATIENT ADMITTION NOT SAVED";
    }
}

    if(isset($_POST['presMeds'])){
        $diagnoses = filter_input(INPUT_POST, "diagnoses", FILTER_SANITIZE_STRING);
        $symptoms = filter_input(INPUT_POST, "symptoms", FILTER_SANITIZE_STRING);
        $pharmacyID = filter_input(INPUT_POST, "pharmacyID", FILTER_SANITIZE_STRING);
        $status = SENT_TO_PHARMACY;
        $prescribeStatus = trim("Prescibed");
        $datePrescribe = trim(date("Y-m-d"));
        $prescriptionCode = randomString('8');

        $medNum = count($_POST['medicine']);
        $dosageNum = count($_POST['dosage']);

        if($medNum > 0 && $dosageNum > 0) {

        $insertpresciption = insert("INSERT INTO prescriptions(patientID,prescribeCode,staffID,pharmacyID,symptoms,diagnose,prescribeStatus,datePrescribe,perscriptionCode) VALUES('$patientID','$prescribeCode','$staffID','$pharmacyID','$symptoms','$diagnoses','$prescribeStatus','$datePrescribe','$prescriptionCode')");


            for($m=0, $d=0; $m<$medNum, $d<$dosageNum; $m++,$d++){
                    if(trim($_POST["medicine"][$m] != '') && trim($_POST['dosage'][$d] != '')) {
                        $medicine = trim($_POST["medicine"][$m]);
                        $dosage = trim($_POST["dosage"][$d]);

                $insertMeds = insert("INSERT INTO prescribedmeds(prescribeCode,medicine,dosage,prescribeStatus) VALUES('$prescribeCode','$medicine','$dosage','$prescribeStatus')");
                        }

            }

              if($insertpresciption && $insertMeds){
                    $success =  "PRESCRIPTION SENT SUCCESSFULLY";
                    $updatePatient = update("UPDATE consultation set status='$status' where patientID='$patientID' AND consultID='$conid'");
                    echo "<script>window.location='consult-index?roomID={$roomID}';</script>";
                }else{
                    $error =  "ERROR: PRESCRIPTION NOT SENT";
                }
        }else{
            $error =  "ERROR: NO PRESCRIPTION RECORED";
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
<!--    <li class="active"><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>-->
    <li class="active" style="background-color: #209fbf;"> <a href="consult-index?roomID=<?php echo $roomID;?>"><i class="icon icon-briefcase"></i> <span>Consultation</span></a> </li>
    <li> <a href="consult-appointment?roomID=<?php echo $roomID;?>"><i class="icon icon-calendar"></i> <span>Appointments</span></a> </li>
    <li> <a href="consult-inward?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Inward</span></a> </li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="consult-index.php" title="Consultation" class="tip-bottom"><i class="icon-briefcase"></i> CONSULTATION</a>
        <a href="consult-patient.php" title="Consultation" class="tip-bottom"><i class="icon-user"></i> CONSULTATION ROOM</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">CONSULTATION ROOM <?php echo $roomID;?></h3>
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
      <div class="row-fluid">
          <div class="span6">
                <div class="widget-box">
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab1">Patient Health Details</a></li>
                            <li><a data-toggle="tab" href="#tab2"> Request Lab</a></li>
                            <li><a data-toggle="tab" href="#tab3"> Admit To Ward</a></li>
                            <li><a data-toggle="tab" href="#tab4"> Prescribe Medication</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="tab1" class="tab-pane active">
                            <form action="#" method="post" class="form-horizontal">
                                  <div class="widget-content">
                                      <div class="control-group">
                                        <label class="control-label">Patient ID :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="patientID" value="<?php echo $patientID;?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Patient Name :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="patientName" value="<?php echo $name;?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Body Temperature :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="bodyTemp" value="<?php echo $consultrow['bodyTemperature'];?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Pulse Rate :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="bloodPressure" value="<?php echo $consultrow['pulseRate'];?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Respiration Rate :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="respirationRate" value="<?php echo $consultrow['respirationRate'];?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Blood Pressure :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="bloodPressure" value="<?php echo $consultrow['bloodPressure'];?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Weight :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="weight" value="<?php echo $consultrow['weight'];?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Other Health Vitals :</label>
                                        <div class="controls">
                                            <textarea class="span12" name="healthVitals" readonly><?php echo $consultrow['otherHealth'];?></textarea>
                                        </div>
                                      </div>
                                  </div>
                            </form>
                        </div>
                        <div id="tab2" class="tab-pane">
                             <form action="#" method="post" class="form-horizontal">
                                  <div class="widget-content nopadding">
                                      <div class="control-group">
                                        <label class="control-label"> Consulting Room</label>
                                          <div class="controls">
                                            <input type="text" name="consultroom" class="span11" value="<?php echo $roomID?>" readonly>
                                          </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label"> Staff ID</label>
                                          <div class="controls">
                                            <input type="text" name="consultroom" class="span11" value="<?php echo $staffID;?>" readonly>
                                          </div>
                                      </div>
                                    <div class="control-group">
                                        <label class="control-label">Request lab</label>
                                        <div class="controls">

                                          <select multiple name="labName[]">
                                              <option></option>
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
                                  <div class="widget-content nopadding">
                                       <div class="control-group">
                                        <label class="control-label">Admit To ward</label>
                                        <div class="controls">
                                          <select name="wardID">
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
                                            <input type="date" class="span11" name="dischargeDate" required/>
                                          </div>
                                      </div>
                                      <div class="form-actions">
                                          <i class="span1"></i>
                                        <button type="submit" name="adWard" class="btn btn-primary btn-block span10"> Admit To Ward</button>
                                      </div>
                                  </div>
                            </form>
                        </div>
                        <div id="tab4" class="tab-pane">
                             <form action="#" method="post" id="add_name" class="form-horizontal">
                                  <div class="widget-content nopadding">
                                      <table class="table table-bordered" id="dynamic_field">
                                          <tr>
                                              <td> Presciption Code</td>
                                              <td colspan="2">  <input type="text" name="prescribeCode" value="<?php echo $prescribeCode;?>" readonly class="span11" /></td>
                                          </tr>
                                          <tr>
                                            <td> Pharmacy</td>
                                            <td colspan="2">
                                              <select name="pharmacyID" required>
                                                    <option value=""></option>
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
                                        <tr>
                                            <td><input type="text" name="medicine[]" placeholder="Medicine" class="span11" required /></td>
                                            <td><input type="text" name="dosage[]" placeholder="Dosage" class="span11" required /></td>
                                            <td><button type="button" name="add" id="add" class="btn btn-primary">Add Medicine</button></td>
                                        </tr>
                                          <tr>
                                            <td></td>
                                            <td></td>
                                          </tr>
                                    </table>
                                      <div class="form-actions">
                                          <i class="span1"></i>
                                        <button type="submit" name="presMeds" class="btn btn-primary btn-block span10"> Save Prescription</button>
                                      </div>
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
          </div>
          <div class="span6">
              <div class="widget-box widget-chat" style="height: auto;">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-comment"></i>
                        </span>
                        <h5>Patient Medical Records</h5>
                    </div>
                    <div class="widget-content nopadding" style="height: auto;">
                        <div class="chat-users panel-right2">
                          <div class="panel-title">
                            <h5>BY DATE</h5>
                          </div>
                          <div class="panel-content nopadding">
                            <ul class="contact-list">
                                <li id="" class="online newbtn btn-primary">
                                  <a href=""><i class="fa fa-calendar"></i><span> Medical Records</span></a>
                                </li>
                              <li id="" class=""><a href=""><i class="fa fa-calendar fa-lg"></i>  <span> 15-05-2018</span></a></li>
                              <li id="" class=""><a href=""><i class="fa fa-calendar fa-lg"></i>  <span> 18-05-2018</span></a></li>
                              <li id="" class=""><a href=""><i class="fa fa-calendar fa-lg"></i>  <span> 23-06-2018</span></a></li>
                              <li id="" class=""><a href=""><i class="fa fa-calendar fa-lg"></i>  <span> 12-07-2018</span></a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="chat-content panel-left2" style="height: auto;">
                          <div class="chat-messages" id="chat-messages" style="height: auto;">
                            <div id="chat-messages-inner">
                                <p id="'+id+'" class="user-'+idname+'">
                                    <span class="msg-block"><i class="fa fa-user"></i>
                                        <strong>OPD</strong> <span class="time">9:15 am</span>
                                        <span class="msg"> Vitals Checked, BP, TP, RR, PR</span>
                                    </span>
                                </p>
                                <p id="'+id+'" class="user-'+idname+'">
                                    <span class="msg-block"><i class="fa fa-user"></i>
                                        <strong>CONSULTATION</strong> <span class="time">9:15 am</span>
                                        <span class="msg"> What ever Happened in the consulting room</span>
                                    </span>
                                </p>
                                <p id="'+id+'" class="user-'+idname+'">
                                    <span class="msg-block"><i class="icon icon-plus-sign"></i>
                                        <strong>PHARMACY</strong> <span class="time">9:15 am</span>
                                        <span class="msg"> What ever Happened at the pharmacy</span>
                                    </span>
                                </p>
                                <p id="'+id+'" class="user-'+idname+'">
                                    <span class="msg-block"><i class="icon icon-plus-sign"></i>
                                        <strong>PHARMACY</strong> <span class="time">9:15 am</span>
                                        <span class="msg"> What ever Happened at the pharmacy</span>
                                    </span>
                                </p>
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
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="medicine[]" placeholder="Medicine" class="span11" /></td><td><input type="text" name="dosage[]" placeholder="Dosage" class="span11" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
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
<!--
<script>
function dis(){
    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","loads/prescribeCode.php",false);
    xmlhttp.send(null);
    document.getElementById("prescribeCode").innerHTML=xmlhttp.responseText;
}
    dis();

    setInterval(function(){
        dis();
    },1000);
</script>
-->
</body>
</html>

<?php }else{echo "<script>window.location='404'</script>";}?>
