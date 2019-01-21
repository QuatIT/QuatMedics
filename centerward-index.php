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

    //generate $PatientID
    $ward = new Ward();
    $wardIDs = $ward->find_num_ward($centerID) + 1;

    $success = '';
    $error = '';

    if(isset($_POST['btnSave'])){

      $centerID = $_SESSION['centerID'];
      $WardID =  "WD.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$wardIDs);
      $wardName =  filter_input(INPUT_POST, "WardName", FILTER_SANITIZE_STRING);
      $numOfBeds =  filter_input(INPUT_POST, "numOfBeds", FILTER_SANITIZE_STRING);

        $wardRoom = $ward->createWard($WardID,$centerID,$wardName,$numOfBeds);

        if($wardRoom){
            $success = "WARD CREATED";
        }else{
            $error = "WARD NOT CREATED";
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
        <li><a href="medics-index"><i class="icon icon-home"></i> <span>DASHBOARD</span></a> </li>
        <li class=""> <a href="centerconsultation-index"><i class="icon-th-list"></i> <span>CONSULTATION</span></a> </li>
        <li class="active"> <a href="centerward-index"><i class="icon-folder-close"></i> <span>WARD</span></a> </li>
        <li class=""> <a href="centerlab-index"> <i class="icon-search"></i> <span>LABORATORY</span></a> </li>
        <li class=""> <a href="centeruser-index"> <i class="icon-user"></i> <span>STAFF</span></a> </li>
        <li class=""> <a href="centerpharmacy-index"> <i class="icon-plus-sign"></i> <span>PHARMACY</span></a> </li>
        <li class=""> <a href="center-account"> <i class="icon-list-alt"></i> <span>ACCOUNTS</span></a> </li>
        <li class=""> <a href="smsrequest-index"> <i class="icon-envelope"></i> <span>ACCOUNTS</span></a> </li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Ward Management" class="tip-bottom"><i class="icon-folder-open"></i> Ward</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">WARD MANAGEMENT</h3>
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
                <ul class="nav nav-tabs labell">
                    <li class="active"><a data-toggle="tab" href="#tab1">MedCenter Ward</a></li>
                    <li><a data-toggle="tab" href="#tab2">Add New Ward</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5 class="labell">List Of Ward</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr class="labell">
                              <th>Ward ID</th>
                              <th>Ward Name</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="ward_room"></tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <form action="" method="post" class="form-horizontal">
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Ward ID :</label>
                               <div class="controls">
                                  <input type="text" class="span11" name="WardID" value="<?php echo $wardIDs; ?>" required readonly/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Number OF Beds :</label>
                               <div class="controls">
                                  <input type="number" min="0" class="span11" name="numOfBeds" required/>
                                </div>
                                  <div class="controls"></div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Ward Name :</label>
                               <div class="controls">
                                  <input type="text" class="span11" name="WardName" placeholder="Ward Name" required/>
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="btnSave" class="btn btn-primary labell btn-block span10">Save Ward</button>
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
  function ward_Room(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/wardroom-load.php",false);
        xmlhttp.send(null);
        document.getElementById("ward_room").innerHTML=xmlhttp.responseText;
    }
        ward_Room();

        setInterval(function(){
            ward_Room();
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
