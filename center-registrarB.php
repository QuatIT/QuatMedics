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

    $success='';
    $error='';

//     $birthIDs = Birth::find_num_Birth() + 1;
    $PatientIDs = Patient::find_num_Patient() + 1;

    if(isset($_POST['addApptmnt'])){

        $babyID = substr(filter_input(INPUT_POST, "babylastName", FILTER_SANITIZE_STRING), 0, 5).date('y')."-".trim(sprintf('%06s',$PatientIDs));
//        $babyID = filter_input(INPUT_POST, "babyID", FILTER_SANITIZE_STRING);
        $babyFirstName = filter_input(INPUT_POST, "babyFirstName", FILTER_SANITIZE_STRING);
        $babyOtherName = filter_input(INPUT_POST, "babyOtherName", FILTER_SANITIZE_STRING);
        $babylastName = filter_input(INPUT_POST, "babylastName", FILTER_SANITIZE_STRING);
        $babyName = $babyFirstName.' '.$babyOtherName.' '.$babylastName;
        $dob = filter_input(INPUT_POST, "dob", FILTER_SANITIZE_STRING);
        $motherName = filter_input(INPUT_POST, "motherName", FILTER_SANITIZE_STRING);
        $fatherName = filter_input(INPUT_POST, "fatherName", FILTER_SANITIZE_STRING);
        $birthTime = filter_input(INPUT_POST, "birthTime", FILTER_SANITIZE_STRING);
        $country = filter_input(INPUT_POST, "country", FILTER_SANITIZE_STRING);
        $status = LIVING;

        $baby = Birth::RegisterBaby($babyID,$babyFirstName,$babyOtherName,$babylastName,$babyName,$dob,$motherName,$fatherName,$birthTime,$country,$status);

        if($baby){
           $centerID=$_SESSION['centerID'];

            $insert_baby = insert("INSERT INTO patient(centerID,patientID,firstName,otherName,lastName,dob,guardianName) VALUES('$centerID','$babyID','$babyFirstName','$babyOtherName','$babylastName','$dob','$motherName') ");
//            createPatient($centerID,$patientId,$firstName,$lastName,$otherName,$dob,$gender,$bloodGroup,$homeAddress,$phoneNumber,$guardianName,$guardianGender,$guardianPhone,$guardianRelation,$guardianAddress)

            $success="<script>document.write('Baby Registered Successfullly')
                        window.location.href='center-registrarB'</script>";
        }else{
            $error="Something Happened Somewhere";
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
    <li><a href=""><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"> <a href="center-registrarB"><i class="icon icon-file"></i><span>Birth Records</span></a> </li>
    <li> <a href="center-registrarD"><i class="icon icon-file"></i><span>Death Records</span></a> </li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Registrar" class="tip-bottom"><i class="icon-file"></i> REGISTRAR</a>
        <a title="Birth Records" class="tip-bottom"><i class="icon-file"></i> BIRTH RECORDS</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">BIRTH RECORDS</h3>
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
                    <li class="active"><a data-toggle="tab" href="#tab1">Birth List</a></li>
                    <li><a data-toggle="tab" href="#tab2">Add New Birth</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>List OF Tranfers</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th> Birth ID</th>
                              <th> Baby Name</th>
                              <th> Date Of Birth</th>
<!--                              <th>Action</th>-->
                            </tr>
                          </thead>
                          <tbody>
                              <?php
//                                    $fbirth = Patient::find_Patient();
//                                    $fbirth = Birth::find_birth();
                                    $fbirth = select("SELECT * FROM birth where centerID='".$_SESSION['centerID']."' ");
                                    foreach($fbirth as $frow){
                              ?>
                              <tr>
                                <td> <?php echo $frow['babyID']; ?></td>
                                <td> <?php echo $frow['fullname']; ?></td>
                                <td> <?php echo $frow['dob']; ?></td>
<!--                                <td> -->
<!--                                    <a href="#" class="btn btn-primary" title="View Record"><i class="fa fa-eye"></i></a>-->
<!--                                    <a href="#" class="btn btn-danger"  data-toggle="modal" data-target="#myModal" title="View Record">Dead</a></td>-->
                              </tr>

<!--
                              <tr>
                                <td> <?php #echo $frow['patientID']; ?></td>
                                <td> <?php #echo $frow['firstName'].' '.$frow['otherName'].' '.$frow['lastName']; ?></td>
                                <td> <?php #echo $frow['dob']; ?></td>
                                <td>
-->
<!--                                    <a href="#" class="btn btn-primary" title="View Record"><i class="fa fa-eye"></i></a>-->
<!--                                    <a href="#" class="btn btn-danger"  data-toggle="modal" data-target="#myModal<?php #echo $frow['patientID']; ?>" title="View Record">Dead</a></td>-->
<!--                              </tr>-->



<!-- Modal -->
<div id="myModal<?php echo $frow['patientID']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">RECORD DEATH</h4>
      </div>
      <div class="modal-body">
        <form action="" method="post" class="form-horizontal">
                    <div class="span6">
<!--                          <div class="widget-content nopadding">-->
                              <div class="control-group">
                                <label class="control-label">Death ID :</label>
                                <div class="controls">
                                  <input type="text" class="form-control" name="centerID" value="<?php echo $frow['patientID']; ?>" readonly required/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Date Of Death :</label>
                                <div class="controls">
                                  <input type="date" class="form-control" name="dob" required/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Reason Of Death :</label>
                                <div class="controls">
                                  <input type="text" class="form-control" name="reason" required/>
                                </div>
                              </div>
                          </div>
<!--                      </div>-->
<!--                    <div class="span6">-->
<!--                          <div class="widget-content nopadding">-->
                              <div class="control-group">
                                <label class="control-label">Name :</label>
                                <div class="controls">
                                  <input type="text" class="form-control" name="name" value="<?php echo $frow['firstName'].' '.$frow['otherName'].' '.$frow['lastName']; ?>" required readonly />
                                </div>
                              </div>
                             <div class="control-group">
                                <label class="control-label">Time Of Death :</label>
                                <div class="controls">
                                  <input type="time" class="form-control" name="birthTime" required/>
                                </div>
                              </div>
                              <div class="control-group">
                                  <i class="span1"></i>
                                <button type="submit" name="addApptmnt" class="btn btn-primary btn-block span6">Save Record</button>
                              </div>
<!--                          </div>-->
<!--                      </div>-->
                    </form>
      </div>
<!--
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
-->
    </div>

  </div>
</div>


                              <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <form action="" method="post" class="form-horizontal">
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Birth ID :</label>
                                <div class="controls">
                                  <input type="text" class="span11" name="centerID" value="<?php echo $PatientIDs; ?>" readonly required/>
                                </div>
                              </div>
                             <div class="control-group">
                                <label class="control-label">First Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" name="babyFirstName" required/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Other Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" name="babyOtherName" required/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Last Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" name="babylastName" required/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Date Of Birth :</label>
                                <div class="controls">
                                  <input type="date" class="span11" name="dob" required/>
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Country :</label>
                                <div class="controls">
                                  <select class="span11" name="country">
                                        <option></option>
                                        <option>GHANA</option>
                                    </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Mother's Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" name="motherName" required/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Father's Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" name="fatherName" required/>
                                </div>
                              </div>
                             <div class="control-group">
                                <label class="control-label">Time Of Birth :</label>
                                <div class="controls">
                                  <input type="time" class="span11" name="birthTime" required/>
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="addApptmnt" class="btn btn-primary btn-block span10">Save Record</button>
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
