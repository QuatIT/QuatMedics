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
    <style>
        .active{
            background-color: #209fbf;
        }
    </style>
</head>
<body>

<?php
include 'layout/head.php';
$roomID = $_GET['roomID'];
$consultation = new Consultation();
$_SESSION['current_page']=$_SERVER['REQUEST_URI'];
//fetch all patients
$patient = select("SELECT * FROM patient ORDER BY patientID ASC");

//staffID
$staff = select("SELECT staffID from centeruser where userName='".$_SESSION['username']."' AND password='".$_SESSION['password']."'");
foreach($staff as $staffrow){
    $staffID = $staffrow['staffID'];
}

//generate presciptionCode
$codesql = select("SELECT * From doctorappointment order by appointNumber DESC limit 1");
if(count($codesql) >=1){
foreach($codesql as $coderow){
    $code = $coderow['appointNumber'];
    $oldcode = explode("-",$code);
    $newID = $oldcode[1]+1;
    $appointNumber = $oldcode[0]."-".$newID;
}
}else{
$appointNumber = "APTMNT-1";
}


if(isset($_POST['addApptmnt'])){
        $patientID = filter_input(INPUT_POST, "patientID", FILTER_SANITIZE_STRING);
        $appointDate = filter_input(INPUT_POST, "appointDate", FILTER_SANITIZE_STRING);
        $appointTime = filter_input(INPUT_POST, "appointTime", FILTER_SANITIZE_STRING);
        $reason = filter_input(INPUT_POST, "reason", FILTER_SANITIZE_STRING);
        $sms = filter_input(INPUT_POST, "sms", FILTER_SANITIZE_STRING);
		$status = trim("PENDIND");
	$centerID = $_SESSION['centerID'];
    $addapointment = $consultation->createAppointment($appointNumber,$staffID,$patientID,$appointDate,$appointTime,$status,$reason,$sms,$centerID);
    if($addapointment){
        $success =  "APPOINTMENT SAVED SUCCESSFULLY";
    }else{
        $error =  "ERROR : APPOINTMENT NOT SAVED";
    }
}

?>

<div id="search">
  <input type="text" placeholder="Search here..." disabled/>
  <button type="submit" class="tip-left" title="Search" disabled><i class="icon-search icon-white"></i></button>
</div>

<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li> <a href="consult-index?roomID=<?php echo $roomID;?>"><i class="icon icon-briefcase"></i><span>Consultation</span></a> </li>
    <li class="active"> <a href="consult-appointment?roomID=<?php echo $roomID;?>"><i class="icon icon-calendar"></i><span>Appointments</span></a> </li>
    <li> <a href="consult-inward?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Inward</span></a> </li>
    <li> <a href="consult-transfers?roomID=<?php echo $roomID;?>"><i class="icon-resize-horizontal"></i> <span>Transfers</span></a> </li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Consultation" class="tip-bottom"><i class="icon-briefcase"></i> CONSULTATION</a>
        <a title="Consultation" class="tip-bottom"><i class="icon-calendar"></i> APPOINTMENTS</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">CONSULTATION APPOINTMENTS</h3>

      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Appointment List</a></li>
                    <li><a data-toggle="tab" href="#tab2">Add New Appointment</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>List Of Doctor's Appointment</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Number</th>
                              <th>Patient Name</th>
                              <th>Date</th>
                              <th>Time</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="appointment">
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <form action="#" method="post" class="form-horizontal">
                    <div class="span6">
<!--                        <div class="widget-box">-->
                          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Make Appointment</h5>
                          </div>
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Appointment Date :</label>
                                <div class="controls">
                                  <input type="date" class="span11" name="appointDate" required/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Appointment Time :</label>
                                <div class="controls">
                                  <input type="time" class="span11" name="appointTime" required/>
                                </div>
                              </div>
                             <div class="control-group">
                                <label class="control-label">Staff :</label>
                                <div class="controls">
                                  <input type="text" class="span11" value="<?php echo $staffID;?>" readonly/>
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-title">
<!--                              <span class="icon"> <i class="icon-align-justify"></i> </span>-->
<!--                            <h5>Make Appointment</h5>-->
                          </div>
                          <div class="widget-content nopadding">
                             <div class="control-group">
                                <label class="control-label">Patient :</label>
                                <div class="controls">
                                  <select name="patientID" class="" >
                                    <option value="default"> -- Select Patient --</option>
                                      <?php
                                        if(!empty($patient)){
                                            foreach($patient as $patientrow){

                                      ?>
                                    <option value="<?php echo $patientrow['patientID'];?>"><?php echo $patientrow['firstName']." ".$patientrow['otherName']." ".$patientrow['lastName'];?></option>
                                      <?php }}?>
                                  </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Send SMS :</label>
                                <div class="controls">
                                  <label>
									  <textarea name="reason" class="span11"></textarea>
                                </label>
                                </div>
                              </div>
							  <div class="control-group">
                                <label class="control-label">Send SMS :</label>
                                <div class="controls">
                                  <label>
                                    <input type="checkbox" name="sms" value="YES"/>
                                </label>
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="addApptmnt" class="btn btn-primary btn-block span10">Save Appointment</button>
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

<script>
function dis(){
    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","loads/consultappoint-load?staffID=<?php echo $staffID;?>",false);
    xmlhttp.send(null);
    document.getElementById("appointment").innerHTML=xmlhttp.responseText;
}
    dis();

    setInterval(function(){
        dis();
    },1000);
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
