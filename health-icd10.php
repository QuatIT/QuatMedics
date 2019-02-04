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
    <style>
        .active{
            background-color: #209fbf;
        }
    </style>
</head>
<body>
<?php
    include 'layout/head.php';

    if($_SESSION['accessLevel']=='CONSULTATION' || $_SESSION['username']=='rik'){

        $roomID = $_GET['roomID'];
?>
<!--
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
-->
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li> <a href="consult-index?roomID=<?php echo $roomID;?>"><i class="icon icon-briefcase"></i><span>Consultation</span></a> </li>
    <li> <a href="consult-appointment?roomID=<?php echo $roomID;?>"><i class="icon icon-calendar"></i><span>Appointments</span></a> </li>
    <li > <a href="consult-inward?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Inward</span></a> </li>
    <li> <a href="consult-transfers?roomID=<?php echo $roomID;?>"><i class="icon-resize-horizontal"></i> <span>Transfers</span></a> </li>
    <li class="active"> <a href="health-icd10?roomID=<?php echo $roomID;?>"> <span>ICD-10</span></a> </li>
    </ul>
</div>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Consultation" class="tip-bottom"><i class="icon-briefcase"></i> CONSULTATION</a>
        <a title="Inward Patients" class="tip-bottom"><i class="icon-home"></i> INWARD</a>
        <a title="ICD-10" class="tip-bottom"><i class="icon-home"></i> ICD-10</a>
    </div>
  </div>
  <div class="container">
      <br><br>
	  <form action="" method="post">
		  <input type="text" placeholder="ICD-10 SEARCH" class="class-form span12 text-center" style="height:30px;" name="search_icd" onkeyup="icd(this.value);">
	  </form>

      <div class="row-fluid">
        <div class="widget-box">
<!--
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Admitted Patient List</a></li>
                    <li><a data-toggle="tab" href="#tab2">Admit New Patient</a></li>
                </ul>
            </div>
-->
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box" style="height:300px; overflow-y: scroll;">
<!--
                      <div class="widget-title">
                      </div>
-->

						<span id="icd_load"></span>

<!--                      <div class="widget-content nopadding">-->

<!--                      </div>-->
                    </div>
                </div>
<!--
                <div id="tab2" class="tab-pane">
                    <form action="#" method="post" class="form-horizontal">
                    <div class="span6">
                        <div class="widget-box">
                          <div class="widget-title">
                              <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Admission Details</h5>
                          </div>
                          <div class="widget-content nopadding">
                               <div class="control-group">
                                <label class="control-label">Patient : </label>
                                <div class="controls">
                                  <select name="patientID" >
                                    <option value="default"> -- Select Patient --</option>
                                    <option value="patientID"> Patient Name</option>
                                    <option value="patientID"> Patient Name</option>
                                    <option value="patientID"> Patient Name</option>
                                  </select>
                                </div>
                              </div>
                               <div class="control-group">
                                <label class="control-label">Bed Number : </label>
                                <div class="controls">
                                  <select name="bedNumber" >
                                    <option value="default"> -- Select Bed --</option>
                                    <option value="bedNumber"> Bed Number</option>
                                    <option value="bedNumber"> Bed Number</option>
                                    <option value="bedNumber"> Bed Number</option>
                                  </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Admission Date :</label>
                                <div class="controls">
                                    <input name="admitDate" class="span11" type="datetime-local" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Description :</label>
                                <div class="controls">
                                    <textarea class="span11" name="description"></textarea>
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-title">
                          </div>
                          <div class="widget-content nopadding">
                               <div class="control-group">
                                <label class="control-label">Patient Status: </label>
                                <div class="controls">
                                  <select name="patientStatus" >
                                    <option value="default"> -- Select Status --</option>
                                    <option > Admit</option>
                                    <option > Under Treatment</option>
                                    <option > Operation</option>
                                  </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Bed Type :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Bed Type" name="bedType" required />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Discharge Date :</label>
                                <div class="controls">
                                  <input type="datetime-local" class="span11" name="dischargeDate" required />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Assign Nurse : </label>
                                <div class="controls">
                                  <select name="nurseID" >
                                    <option value="default"> -- Select Nurse --</option>
                                    <option value="nurseID"> Nurse Name</option>
                                    <option value="nurseID"> Nurse Name</option>
                                    <option value="nurseID"> Nurse Name</option>
                                  </select>
                                    <br/>
                                    <br/>
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" class="btn btn-primary btn-block span10">Admit Patient</button>
                              </div>
                          </div>
                      </div>
                    </form>
                </div>
-->
            </div>
        </div>
      </div>
  </div>
</div>
<div class="row-fluid">
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
</body>
</html>
<?php }else{echo "<script>window.location='404'</script>";}?>
