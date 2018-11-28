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
	$success='';
	$error='';
	if(isset($_POST['btnApt'])){
		$appointmentDate = $_POST['appointmentDate'];
		$appointmentTime = $_POST['appointmentTime'];
		$appointment_reason = $_POST['appointment_reason'];
		$patient = $_POST['patient'];
		$doctor = $_POST['doctor'];
		$sms = $_POST['radios'];
		$centerID = $_SESSION['centerID'];

		$appointNumber = "APTMNT-".count(select("select * from doctorappointment WHERE centerID='".$_SESSION['centerID']."' ")) + 1;

		$apt_sql = insert("INSERT INTO doctorappointment(appointNumber,staffID,patientID,appointmentDate,appointmentTime,sms,reason,centerID,status,dateInsert) VALUES('$appointNumber','$doctor','$patient','$appointmentDate','$appointmentTime','$sms','$appointment_reason','$centerID','pending',CURDATE()) ");

		if($apt_sql){
			$success = "APPOINTMENT SCHEDULED SUCCESSFULLY";
		}else{
			$error = "FAILED SCHEDULING APPOINTMENT";
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
    <li> <a href="medics-index"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li> <a href="opd-index"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
    <li> <a href="opd-patient?tab=opd-patient"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
    <li class="active"> <a href="opd-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
    </ul>
</div>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Out Patient Department" class="tip-bottom"><i class="icon-plus"></i> OPD</a>
        <a title="Doctor's Appointment" class="tip-bottom"><i class="icon-calendar"></i> DOCTOR APPOINTMENTS</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">DOCTOR'S APPOINTMENTS</h3>
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
                    <li class="active"><a data-toggle="tab" href="#tab1">Appointment List</a></li>
                    <li><a data-toggle="tab" href="#tab2">Add New Appointment</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>List Of Doctors Appointment</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Photo</th>
                              <th>Patient Number</th>
                              <th>Patient Name</th>
                              <th>Doctor Name</th>
                              <th>Reason</th>
                              <th>Status</th>
                              <th>Appointment Date</th>
                              <th>Appointment Time</th>
                            </tr>
                          </thead>
                          <tbody>
							  <?php
								  $apquery = select("select * from doctorappointment WHERE centerID='".$_SESSION['centerID']."' ");
							  foreach($apquery as $aprow){
								  $patquery = select("select * from patient where patientID='".$aprow['patientID']."' ");
								  foreach($patquery as $patrow){}

								  $staffquery = select("select * from staff where staffID='".$aprow['staffID']."'");
								  foreach($staffquery as $stafrow){}
							  ?>
                            <tr>
                              <td><img width="40px" src='<?php echo $PATIENT_UPLOAD.$patrow['patient_image'];?>'></td>
                              <td><?php echo $aprow['patientID']; ?></td>
                              <td><?php echo $patrow['firstName']." ".$patrow['otherName']." ".$patrow['lastName']; ?></td>
                              <td><?php echo $stafrow['firstName']." ".$stafrow['otherName']." ".$stafrow['lastName']; ?></td>
                              <td><?php echo $aprow['reason']; ?></td>
                              <td style="text-align: center;"><span class="btn btn-primary btn-block btn-mini"><?php echo $aprow['status']; ?></span></td>
                              <td><?php echo $aprow['appointmentDate']; ?></td>
                              <td><?php echo $aprow['appointmentTime']; ?></td>

<!--
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
-->
                            </tr>
							  <?php } ?>
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
                                  <input type="date" class="span6" name="appointmentDate" required/>
									 Time : <input type="time" class="span4" name="appointmentTime" required/>
                                </div>
                              </div>
                          </div>
<!--
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Appointment Date :</label>
                                <div class="controls">
                                  <input type="date" class="span6" name="appointmentDate" required/>
                                </div>
                              </div>
                          </div>
-->
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Reason :</label>
                                <div class="controls">
									<textarea class="span11" name="appointment_reason" ></textarea>
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
                                  <select name="patient" class="" >
                                    <option value="default"> -- Select Patient --</option>
									  <?php
										  $patient_sql = select("SELECT * FROM patient WHERE centerID='".$_SESSION['centerID']."' ");
									  foreach($patient_sql as $patient_row){
									  ?>
                                    <option value="<?php echo $patient_row['patientID']; ?>"> <?php echo $patient_row['firstName']." ".$patient_row['otherName']." ".$patient_row['lastName'];?></option>
									  <?php } ?>
                                  </select>
                                </div>
                              </div>


                             <div class="control-group">
                                <label class="control-label">Assign Doctor :</label>
                                <div class="controls">
                                  <select name="doctor" class="" >
                                    <option value="default"> -- Select Doctor --</option>
									  <?php
										  $doc_sql = select("SELECT * FROM staff WHERE centerID='".$_SESSION['centerID']."' ");
									  foreach($doc_sql as $doc_row){
									  ?>
                                    <option value="<?php echo $doc_row['staffID']; ?>"><?php echo $doc_row['firstName']." ".$doc_row['otherName']." ".$doc_row['lastName']; ?></option>
									  <?php } ?>
                                  </select>
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Send SMS :</label>
                                <div class="controls">
                                  <label>
                                    <input type="checkbox" name="radios" value="YES" />
                                </label>
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" class="btn btn-primary btn-block span10" name="btnApt">Save Appointment</button>
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
