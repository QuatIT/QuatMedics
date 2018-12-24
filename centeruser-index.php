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
$centerID = $_SESSION['centerID'];
    $success = '';
    $error = '';

    $user = new User();
    //generate centerID
    $staffIDs = $user->find_num_staffID($centerID) + 1;

    if(isset($_POST['btnSave'])){

        $staffID = ucwords(substr(filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_STRING), 0, 5)."-".sprintf('%06s',$staffIDs));
        $firstName = ucwords(filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_STRING));
        $lastName = ucwords(filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_STRING));
        $otherName = ucwords(filter_input(INPUT_POST, "otherName", FILTER_SANITIZE_STRING));
        $gender = ucwords(filter_input(INPUT_POST, "gender", FILTER_SANITIZE_STRING));
        $dob = ucwords(filter_input(INPUT_POST, "dob", FILTER_SANITIZE_STRING));
        $specialty = ucwords(filter_input(INPUT_POST, "specialty", FILTER_SANITIZE_STRING));
        $staffCategory = ucwords(filter_input(INPUT_POST, "staffCategory", FILTER_SANITIZE_STRING));
        $staffDepartment = ucwords(filter_input(INPUT_POST, "staffDepartment", FILTER_SANITIZE_STRING));
        $email = ucwords(filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING));

        $username = ucwords(filter_input(INPUT_POST, "userName", FILTER_SANITIZE_STRING));
        $password = ucwords(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING));
        $userID = $staffID;

        $centerID = $_SESSION['centerID'];

		$sql_user = select("SELECT * FROM staff WHERE email='$email' ");
		if(count($sql_user) < 1){

        $centerUser = $user->saveUserData($staffID,$firstName,$lastName,$otherName,$gender,$dob,$specialty,$staffCategory,$staffDepartment,$email,$centerID);

        if($centerUser){

            $accessLevel = $staffDepartment;


//            $userCredential = User::centerUserLogin($staffID,$username,$password,$accessLevel,$centerID);
            $userCredential = User::saveUserCredential($staffID,$username,$password,$accessLevel,$centerID,$userID);

            $send_to = $email;
            $body = "Dear ".$firstName.", <br> Kindly find below your access to QUATMedic. <br><br> Username: ".$username."<br>Password: ".$password."<br><br> Thank you.";
            $subj = "QUATMEDIC LOGIN ACCESS";
            $copy = '';

            //send mail
            echo send_mail($send_to,$copy,$body,$subj);

            $success = "USER DATA CREATED SUCCESSFULLY";
        }else{
            $error = "FAILED TO CREATE USER DATA";
        }
		}else{
			$error = "USER DATA ALREADY EXIST";
		}
    }

	// fetch vitals

//$get_vit = select("SELECT * FROM ward_vitals WHERE patientID ='$patientID' ORDER BY id DESC LIMIT 1");

//NURSE CHECKLIST
//$checklist=select("SELECT * FROM review_tb WHERE patientID = '$patientID'");


?>


<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"><a href="centeruser-index.php"><i class="icon icon-user"></i> <span>Staff Management</span></a> </li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Staff Management" class="tip-bottom"><i class="icon-user"></i> STAFF</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">STAFF MANAGEMENT</h3>

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
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">MedCenter Staff</a></li>
                    <li><a data-toggle="tab" href="#tab2">Add New Staff</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>List Of Patients</h5>

                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Staff ID</th>
                              <th>Staff Name</th>
                              <th>Department</th>
                              <th>Number</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="centeruser"></tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Staff ID :</label>
                               <div class="controls">
                                  <input type="text" class="span11" name="staffID" value="<?php echo $staffIDs; ?>" required readonly/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">First Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="First Name" name="firstName" required/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Other Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Other Name(s)" name="otherName" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Date Of Birth</label>
                                <div class="controls">
                                  <input type="date" class="span11" name="dob" required />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label"> Email</label>
                                <div class="controls">
                                  <input type="email" class="span11" name="email" placeholder="Email" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label"> Specialty</label>
                                <div class="controls">
                                  <input type="text" class="span11" name="specialty" placeholder="specialized In..." />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label"> User Name</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="userName" placeholder="User Name..." required />
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">
                               <div class="control-group">
                                <label class="control-label"> Staff Category</label>
                                <div class="controls">
                                  <select name="staffCategory" >
                                    <option value="default"> </option>
                                    <option value="Doctor"> Doctor</option>
                                    <option value="Nurse"> Nurse</option>
                                    <option value="Midwife"> Midwife</option>
                                    <option value="Psychologist"> Psychologist</option>
                                    <option value="Therapist"> Therapist</option>
                                    <option value="Acountant"> Acountant</option>
                                  </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Last Name :</label>
                               <div class="controls">
                                  <input type="text" class="span11" name="lastName" placeholder="Last Name" required/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label"> Gender</label>
                                <div class="controls">
                                  <select name="gender" >
                                        <option value="default"> </option>
                                        <option value="Male"> Male</option>
                                        <option value="Female"> Female</option>
                                    </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label"> Staff Department</label>
                                <div class="controls">
                                  <select name="staffDepartment" >
                                    <option value="default"> </option>
                                      <?php
                                        $dep = select("SELECT * FROM department ");
                                        foreach($dep as $dept){
                                      ?>
                                        <option value="<?php echo $dept['departmentID']; ?>"> <?php echo $dept['departmentName']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label"> Work License</label>
                                <div class="controls">
                                  <input type="file" accept="application/pdf" class="span11" name="license"  />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Password</label>
                                <div class="controls">
                                  <input type="password"  class="span11" name="password" placeholder="Password..." required />
                                </div>
                              </div>

                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="btnSave" class="btn btn-primary btn-block span10">Save Staff</button>
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
  function newpatient(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/centeruser-load.php",false);
        xmlhttp.send(null);
        document.getElementById("centeruser").innerHTML=xmlhttp.responseText;
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
