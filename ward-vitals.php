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

    #if($_SESSION['accessLevel']=='OPD' || $_SESSION['username']=='rik'){

    $active2='';
    $active='';
    $success = '';
    $error = '';

    $tab = $_GET['tab'];
    $patientID=$_GET['patientID'];
		// $emeID = $_GET['emeid'];

    // if($tab == "vitals"){
    //     $active2 = "active";
    //     $get_PID = $_GET['pid'];
    //     $patient = select("SELECT * FROM emergency_patient WHERE patientID='".$_GET['pid']."' ORDER BY patientID ASC");
    //     foreach($patient as $pID){}

    // }elseif($tab == "opd-patient"){
    //     $active  = "active";
    // }

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
//      $otherHealth = filter_input(INPUT_POST, "otherHealth", FILTER_SANITIZE_STRING);

        $centerID=$_SESSION['centerID'];
//        $status = SENT_TO_CONSULTING;
//        $patient_busy = PATIENT_BUSY;

		$sql_vitals = insert("INSERT INTO ward_vitals(patientID,bodyTemp,pulseRate,respirationRate,bloodPressure,weight,dateRegistered) VALUES('$patientID','$bodyTemperature','$pulseRate','$respirationRate','$bloodPressure','$weight',CURDATE())");

if($sql_vitals){
  echo "<script>alert('Patient Vitals is Saved')</script>";
}
	}

    ?>





<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
<!--
    <ul>
    <li><a href="medics-index"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li> <a href="opd-index"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
    <li class="active"> <a href="opd-patient?tab=opd-patient"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
    <li><a href="opd-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
    <li><a href="consult-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
    </ul>
-->
</div>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="WARD" class="tip-bottom"><i class="icon-time"></i> WARD</a>
        <a title="WARD PATIENT VITALS" class="tip-bottom"><i class="icon-user"></i> PATIENT VITALS</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions"> WARD PATIENT VITALS</h3>
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
<!--                    <li class="<?php #echo $active; ?>"><a data-toggle="tab" href="#tab1">Out Patient List</a></li>-->
<!--                    <li class="active"><a data-toggle="tab" href="#tab1">Out Patient List</a></li>-->
                    <li class="<?php echo 'active'; ?> labell"><a data-toggle="tab" href="#tab2">Add Vitals </a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab2" class="tab-pane <?php echo 'active'; ?>">
                    <form action="" method="post" id="vitals" class="form-horizontal">
                    <div class="span6" id="vitals">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Patient :</label>
                               <div class="controls">
                                  <input name="patientID" id="patientId" class="span11" value="<?php echo $patientID; ?>" readonly/>
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Body Temperature:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Body Temperature" name="bodytemp" required />
                                </div>
                              </div>

							   <div class="control-group">
                                <label class="control-label">Pulse Rate :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Pulse Rate" name="pulseRate" />
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Weight</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="weight" placeholder="Weight" required />
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
                                  <input type="text" class="span11" placeholder="Respiration Rate" name="respirationRate" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Blood Pressure</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="bloodPressure" placeholder="Blood Pressure" required />
                                </div>
                              </div>

                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="btnSave" class="btn btn-primary labell btn-block span10">Save Vitals</button>
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
<div class="row-fluid navbar-fixed-bottom">
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
        xmlhttp.open("GET","loads/emepatientID-load.php",false);
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
                $('#fname').load('loads/emepname.php?id='+val, function(){
                $('#loader').html("");
               });
        }

    </script>
<?php } ?>

<script>

        function modey(val){
            // load the select option data into a div
                $('#loader').html("Please Wait...");
                $('#modeload').load('loads/mode.php?id='+val, function(){
                $('#loader').html("");
               });
        }

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
<?php #}else{echo "<script>window.location='404'</script>";}?>
