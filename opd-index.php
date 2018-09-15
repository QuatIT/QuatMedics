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
        <style>
        .active{
            background-color: #209fbf;
        }
    </style>
</head>
<body>

<?php
    include 'layout/head.php';

    //generate $PatientID
    $PatientIDs = Patient::find_num_Patient() + 1;

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
      $phoneNumber = filter_input(INPUT_POST, "mobileNumber", FILTER_SANITIZE_STRING);

      $guardianName = filter_input(INPUT_POST, "guardianName", FILTER_SANITIZE_STRING);
      $guardianGender = filter_input(INPUT_POST, "guardianGender", FILTER_SANITIZE_STRING);
      $guardianPhone = filter_input(INPUT_POST, "guardianPhone", FILTER_SANITIZE_STRING);
      $guardianRelation = filter_input(INPUT_POST, "guardianRelation", FILTER_SANITIZE_STRING);
      $guardianAddress = filter_input(INPUT_POST, "guardianAddress", FILTER_SANITIZE_STRING);

        $createPatient = Patient::createPatient($centerID,$patientId,$firstName,$lastName,$otherName,$dob,$gender,$bloodGroup,$homeAddress,$phoneNumber,$guardianName,$guardianGender,$guardianPhone,$guardianRelation,$guardianAddress);

        if($createPatient){
             $success = "<script>document.write('PATIENT DETAIL ADDED SUCCESSFULLY');
                                    window.location.href='opd-patient#tab2' </script>";
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
    <li><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"> <a href="opd-index.php"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
    <li> <a href="opd-patient.php"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
    <li><a href="opd-appointment.php"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a href="opd-index.php" title="" class="tip-bottom"><i class="icon-plus"></i> OPD</a>
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
                    <li class="active"><a data-toggle="tab" href="#tab1">Patient List</a></li>
                    <li><a data-toggle="tab" href="#tab2">Add New Patient</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>List Of Patients table</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Photo</th>
                              <th>Patient Number</th>
                              <th>Patient Name</th>
                              <th>Mobile Number</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="span2">
                                <a class="thumbnail lightbox_trigger" href="images/gallery/imgbox2.jpg">
                                    <img src="images/gallery/imgbox2.jpg" alt="" >
                                </a>
                              </td>
                              <td>PNT-HSP001</td>
                              <td>Kofi Mensah Addo</td>
                              <td>0541524233</td>
                              <td style="text-align: center;">
                                   <a href="opd-patientinfo.php"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                            <tr>
                              <td class="span2">
                                <a class="thumbnail lightbox_trigger" href="images/gallery/imgbox5.jpg">
                                    <img src="images/gallery/imgbox5.jpg" alt="" >
                                </a>
                              </td>
                              <td>PNT-HSP001</td>
                              <td>Kofi Mensah Addo</td>
                              <td>0541524233</td>
                              <td style="text-align: center;">
                                   <a href="opd-patientinfo.php"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                            <tr>
                              <td class="span2">
                                <a class="thumbnail lightbox_trigger" href="images/gallery/imgbox1.jpg">
                                    <img src="images/gallery/imgbox1.jpg" alt="" >
                                </a>
                              </td>
                              <td>PNT-HSP001</td>
                              <td>Kofi Mensah Addo</td>
                              <td>0541524233</td>
                              <td style="text-align: center;">
                                   <a href="opd-patientinfo.php"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>


                <div id="tab2" class="tab-pane">
                    <form action="" method="post" class="form-horizontal">
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
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-title">
                          </div>
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">First Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="First name" name="firstName" />
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
                                  <input type="text" class="span11" placeholder="Mobile Number" name="mobileNumber" />
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                  <a data-toggle="tab" href="#tab3" class="btn btn-primary btn-block" > Next Step >></a>
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

                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" class="btn btn-primary btn-block span10" name="btnSave">Save Patient</button>
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
