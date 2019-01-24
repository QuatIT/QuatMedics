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
<link rel="stylesheet" href="assets/css/font-awesome.css" />
        <style>
        .active{
            background-color: #209fbf;
        }
    </style>
</head>
<body>

<?php
    include 'layout/head.php';

    if($_SESSION['accessLevel']=='OPD' || $_SESSION['username']=='rik'){

    //generate $PatientID
    $PatientIDs = Patient::find_num_PatientBYID($centerID) + 1;

    $success = '';
    $error = '';

    if(isset($_POST['btnSave'])){

      $centerID = $_SESSION['centerID'];
      $patientId = substr(filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_STRING), 0, 5)."-".sprintf('%06s',$PatientIDs);
      $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
      $lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_STRING);
      $otherName = filter_input(INPUT_POST, "otherName", FILTER_SANITIZE_STRING);
      $dob = filter_input(INPUT_POST, "dob", FILTER_SANITIZE_STRING);
      $gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_STRING);
      $bloodGroup = filter_input(INPUT_POST, "bloodGroup", FILTER_SANITIZE_STRING);
      $homeAddress = filter_input(INPUT_POST, "homeAddress", FILTER_SANITIZE_STRING);
      $hometown = filter_input(INPUT_POST, "hometown", FILTER_SANITIZE_STRING);
      $phoneNumber = filter_input(INPUT_POST, "mobileNumber", FILTER_SANITIZE_STRING);

      $guardianName = filter_input(INPUT_POST, "guardianName", FILTER_SANITIZE_STRING);
      $guardianGender = filter_input(INPUT_POST, "guardianGender", FILTER_SANITIZE_STRING);
      $guardianPhone = filter_input(INPUT_POST, "guardianPhone", FILTER_SANITIZE_STRING);
      $guardianRelation = filter_input(INPUT_POST, "guardianRelation", FILTER_SANITIZE_STRING);
      $guardianAddress = filter_input(INPUT_POST, "guardianAddress", FILTER_SANITIZE_STRING);
      $tin = filter_input(INPUT_POST, "TIN", FILTER_SANITIZE_STRING);


		//image upload
		$fileName =trim($_FILES['image']['tmp_name']);
		$image = explode(".",trim($_FILES['image']['name']));
		$new_image = $patientId."_".round(microtime(true)) . '.' . end($image);
		$filedestination = $PATIENT_UPLOAD.$new_image;
		//                  move_uploaded_file($fileName, "uploads/company/{$new_image}");
		move_uploaded_file($fileName, $filedestination);

		$pat_sql = select("SELECT * FROM patient WHERE firstName='$firstName' && otherName='$otherName' && lastName='$lastName' && gender='$gender' && phoneNumber='$phoneNumber' && homeAddress='$homeAddress' && dob='$dob' && tin='$tin' ");

		if(count($pat_sql) < 1){

        $createPatient = Patient::createPatient($centerID,$patientId,$firstName,$lastName,$otherName,$dob,$gender,$bloodGroup,$homeAddress,$phoneNumber,$guardianName,$guardianGender,$guardianPhone,$guardianRelation,$guardianAddress,$filedestination,$hometown,$tin);

        if($createPatient){
             $success = "<script>document.write('PATIENT DETAIL ADDED SUCCESSFULLY');
                                    window.location.href='opd-patient?tab=vitals&pid={$patientId}' </script>";
        }
		}else{
			$error = "PATIENT ALREADY EXIST";
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
    <li class="active"> <a href="opd-index"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
    <li> <a href="opd-patient?tab=opd-patient"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
    <li><a href="opd-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
    </ul>
</div>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a href="opd-index.php" title="" class="tip-bottom"><i class="icon-plus"></i> OPD</a>
    </div>
  </div>
  <div class="container-fluid">
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
                    <li class="active"><a data-toggle="tab" href="#tab1">PATIENT LIST</a></li>
                    <li><a data-toggle="tab" href="#tab2">ADD NEW PATIENT</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>PATIENT TABLE</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>PHOTO</th>
                              <th>ID</th>
                              <th>FULL NAME</th>
                              <th>MOBILE NUMBER</th>
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody id="newpatient"></tbody>
                        </table>
                      </div>
                    </div>
                </div>


                <div id="tab2" class="tab-pane">
                    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="span6">
                          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Personal-info</h5>
                          </div>
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Patient ID :</label>
                                <div class="controls">
                                  <input type="text" class="span11" value="<?php echo $PatientIDs; ?>" name="patientId" required readonly />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Last Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Last Name" name="lastName" required />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Gender:</label>
                                <div class="controls">
                                  <label>
                                    <input type="radio" name="gender" value="Male" /> Male
                                    </label>
                                  <label>
                                    <input type="radio" name="gender" value="Female" /> Female
                                    </label>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Blood Group</label>
                                <div class="controls">
                                  <select name="bloodGroup" >
                                    <option value="default"> -- Blood Group --</option>
                                    <option value="O-positive">O-positive</option>
                                    <option value="O-negative">O-negative</option>
                                    <option value="A-positive">A-positive</option>
                                    <option value="A-negative">A-negative</option>
                                    <option value="B-positive">B-positive</option>
                                    <option value="B-negative">B-negative</option>
                                    <option value="AB-positive">AB-positive</option>
                                    <option value="AB-negative">AB-negative</option>
                                  </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Home Address :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Home Address" name="homeAddress" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Upload Image :</label>
                                <div class="controls">
                                  <input type="file" class="span11" placeholder="Home Address" name="image" />
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-title">
                          </div>
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">First Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="First name" name="firstName" required/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Other Name(s) :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Other names" name="otherName" />
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Date Of Birth</label>
                                <div class="controls">
                                  <input type="date"  class="span11" name="dob" required />
                                </div>
                                <div class="controls">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Home Town Address:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Home Town Address" name="hometown" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Mobile Number:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Mobile Number" name="mobileNumber"/>
                                </div>
                              </div>

                              <div class="form-actions">
                                  <i class="span1"></i>
                                  <a data-toggle="tab" href="#tab3" class="btn btn-primary btn-block labell" > Next Step >></a>
                              </div>
                          </div>
                      </div>
                </div>

                <div id="tab3" class="tab-pane">
                    <div class="span6">
                          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Guardian-info</h5>
                          </div>
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Guardian Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Guardian Name" name="guardianName" required />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Gender:</label>
                                <div class="controls">
                                  <label>
                                    <input type="radio" name="guardianGender" value="Male" /> Male
                                    </label>
                                  <label>
                                    <input type="radio" name="guardianGender" value="Female" /> Female
                                    </label>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Mobile Number :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Active Mobile Number" name="guardianPhone" />
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-title">
                          </div>
                          <div class="widget-content nopadding">

                              <div class="control-group">
                                <label class="control-label">Relationship</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="guardianRelation" placeholder="Relationship with Guardian" required />
                                </div>
                                <div class="controls">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Home Address :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Home Address" name="guardianAddress" />
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">TIN Number :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="TAX ID NUMBER" name="tin" />
                                </div>
                              </div>

                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" class="btn btn-primary btn-block labell span10" name="btnSave">Save Patient</button>
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
  function newpatient(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/newpatient-load.php",false);
        xmlhttp.send(null);
        document.getElementById("newpatient").innerHTML=xmlhttp.responseText;
    }
        newpatient();

        setInterval(function(){
            newpatient();
        },3000);
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
