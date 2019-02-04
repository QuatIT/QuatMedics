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

//    if($_SESSION['accessLevel']=='OPD' || $_SESSION['username']=='rik'){

    //generate $PatientID
	$cpatient = new Patient;
    $PatientIDs = $cpatient->find_num_Patient() + 1;

    $success = '';
    $error = '';

    if(isset($_POST['btnSave'])){

      $centerID = $_SESSION['centerID'];
        $patientid =  filter_input(INPUT_POST, "patientid", FILTER_SANITIZE_STRING);
		$emeID = "EME.".sprintf('%06s',count(select("select * from emergency_patient")) + 1);

        $search_patient = select("SELECT * FROM patient WHERE patientID='".$patientid."' ");
        foreach($search_patient as $search_row){
            $patientName = $search_row['firstName']." ".$search_row['otherName']." ".$search_row['lastName'];
            $gender = $search_row['gender'];
            $gName = $search_row['guardianName'];
            $gMobile = $search_row['guardianPhone'];
            $gAddress = $search_row['guardianAddress'];
        }

        $insert_pat = insert("INSERT INTO emergency_patient(emeID,patientID,patientName,gender,centerID,gName,gMobile,gAddress,dateRegistered,dateAdmitted) VALUES('$emeID','$patientid','$patientName','$gender','$centerID','$gName','$gMobile','$gAddress',CURDATE(),CURDATE() )");



//      $patientId = substr(filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_STRING), 0, 5)."-".sprintf('%06s',$PatientIDs);
//      $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
//      $lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_STRING);
//      $otherName = filter_input(INPUT_POST, "otherName", FILTER_SANITIZE_STRING);
//      $dob = filter_input(INPUT_POST, "dob", FILTER_SANITIZE_STRING);
//      $gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_STRING);
//      $bloodGroup = filter_input(INPUT_POST, "bloodGroup", FILTER_SANITIZE_STRING);
//      $homeAddress = filter_input(INPUT_POST, "homeAddress", FILTER_SANITIZE_STRING);
//      $hometown = filter_input(INPUT_POST, "hometown", FILTER_SANITIZE_STRING);
//      $phoneNumber = filter_input(INPUT_POST, "mobileNumber", FILTER_SANITIZE_STRING);
//
//      $guardianName = filter_input(INPUT_POST, "guardianName", FILTER_SANITIZE_STRING);
//      $guardianGender = filter_input(INPUT_POST, "guardianGender", FILTER_SANITIZE_STRING);
//      $guardianPhone = filter_input(INPUT_POST, "guardianPhone", FILTER_SANITIZE_STRING);
//      $guardianRelation = filter_input(INPUT_POST, "guardianRelation", FILTER_SANITIZE_STRING);
//      $guardianAddress = filter_input(INPUT_POST, "guardianAddress", FILTER_SANITIZE_STRING);
//
//
//                    //image upload
//                  $fileName =trim($_FILES['image']['tmp_name']);
//                    $image = explode(".",trim($_FILES['image']['name']));
//                    $new_image = $patientId."_".round(microtime(true)) . '.' . end($image);
//                    $filedestination = $PATIENT_UPLOAD.$new_image;
////                  move_uploaded_file($fileName, "uploads/company/{$new_image}");
//                  move_uploaded_file($fileName, $filedestination);
//
//        $createPatient = Patient::createPatient($centerID,$patientId,$firstName,$lastName,$otherName,$dob,$gender,$bloodGroup,$homeAddress,$phoneNumber,$guardianName,$guardianGender,$guardianPhone,$guardianRelation,$guardianAddress,$filedestination,$hometown);

        if($insert_pat){
//             $success = "<script>document.write('PATIENT DETAIL ADDED SUCCESSFULLY');
//                                    window.location.href='opd-patient?tab=vitals&pid={$patientId}' </script>";
//            $success = $patientName." admitted successfully";
			 $success = "<script> document.write('<b>{$patientName}</b> admitted successfully')
                                 window.location.href='emergency-vitals?pid={$patientid}&tab=vitals&emeid={$emeID}';</script>";
        }
    }



    if(isset($_POST['btnNewSave'])){
        $centerID = $_SESSION['centerID'];
        $patientName =  filter_input(INPUT_POST, "patientname", FILTER_SANITIZE_STRING);
        $gender =  filter_input(INPUT_POST, "gender", FILTER_SANITIZE_STRING);
        $gName =  filter_input(INPUT_POST, "gName", FILTER_SANITIZE_STRING);
        $gMobile =  filter_input(INPUT_POST, "gMobile", FILTER_SANITIZE_STRING);
        $gAddress =  filter_input(INPUT_POST, "gAddress", FILTER_SANITIZE_STRING);
		$emeIDs = count(select("select * from emergency_patient")) + 1;
		$emeID = "EME.".sprintf('%06s',$emeIDs);

        if($gender == 'Male'){
            $count_emepatient = count(select("SELECT * FROM emergency_patient ")) + 1;
            $pName = "JOHN DOE-".sprintf('%06s',$count_emepatient);
            $patientid = "JOHN_DOE-".$centerID."-".sprintf('%06s',$count_emepatient);

            $em_insert = insert("INSERT INTO emergency_patient(emeID,patientID,patientName,gender,centerID,gName,gMobile,gAddress,dateRegistered,dateAdmitted) VALUES('$emeID','$patientid','$pName','$gender','$centerID','$gName','$gMobile','$gAddress',CURDATE(),CURDATE() ) ");

            if($em_insert){
                $success = "<script>document.write('{$pName} created successfully')
		                          window.location.href='emergency-vitals?pid={$patientid}&tab=vitals&emeid={$emeID}'</script>";
            }else{
                $error = "Failed to create ".$pName;
            }


        }elseif($gender == 'Female'){
             $count_emepatient = count(select("SELECT * FROM emergency_patient ")) + 1;
            $pName = "JANE DOE-".sprintf('%06s',$count_emepatient);
            $patientid = "JANE_DOE-".$centerID."-".sprintf('%06s',$count_emepatient);

            $em_insert = insert("INSERT INTO emergency_patient(emeID,patientID,patientName,gender,centerID,gName,gMobile,gAddress,dateRegistered,dateAdmitted) VALUES('$emeID','$patientid','$pName','$gender','$centerID','$gName','$gMobile','$gAddress',CURDATE(),CURDATE() ) ");


            if($em_insert){
                $success = "<script> document.write('<b>{$pName}</b> created successfully')
                                 window.location.href='emergency-vitals?pid={$patientid}&tab=vitals&emeid={$emeID}';</script>";
            }else{
                $error = "Failed to create <b>".$pName."</b>";
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
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">EMERGENCY WARD</h3>
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
<?php } ?>
      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs labell">
                    <li class="active"><a data-toggle="tab" href="#tab1">Patient List</a></li>
                    <li><a data-toggle="tab" href="#tab2">Add New Patient</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5 class="labell">List of Patients in Emergency Ward</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead class="labell">
                            <tr>
                              <th>Patient Name</th>
                              <th>Guardian Name</th>
                              <th>Guardian Mobile</th>
                              <th>Date Admitted</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="emepatient1"></tbody>
                        </table>
                      </div>
                    </div>
                </div>


                <div id="tab2" class="tab-pane">
                    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="span5">
                          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Patient Info</h5>
                          </div>
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Search Patient :</label>
                                <div class="controls">
                                  <input type="text" autofocus class="span11" value="New_Patient" name="patientId" placeholder="" onblur="emPat(this.value);" /> <a href="#"><i class="fa fa-search"></i></a>
                                </div>
                              </div>

                              <span id="empatient"></span>
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
  function newpatient(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/emepatient.php",false);
        xmlhttp.send(null);
        document.getElementById("emepatient1").innerHTML=xmlhttp.responseText;
    }
        newpatient();

        setInterval(function(){
            newpatient();
        },3000);
    </script>

    <script>
    function emPat(val){
	// load the select option data into a div
        $('#loader').html("Please Wait...");
        $('#empatient').load('emepatient.php?id='+val, function(){
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
<?php #}else{echo "<script>window.location='404'</script>";}?>
