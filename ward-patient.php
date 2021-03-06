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
if($_SESSION['accessLevel']=='WARD' || $_SESSION['username']=='rik'){
    $wardc = new Ward;
    $wardID = $_GET['wrdno'];
    $wardByID = $wardc->find_by_ward_id($wardID);
    foreach($wardByID as $ward_id){}
    $ward = $wardc->find_ward($centerID);
    ?>
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index?wrdno=<?php echo $wardID;?>"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li> <a href="ward-index?wrdno=<?php echo $wardID;?>"><i class="icon icon-plus"></i> <span>Bed Management</span></a> </li>
    <li class="active"> <a href="ward-patient?wrdno=<?php echo $wardID;?>"><i class="icon icon-user"></i> <span>Patient Management</span></a></li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index?wrdno=<?php echo $wardID;?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a href="ward-index?wrdno=<?php echo $wardID;?>" title="" class="tip-bottom"><i class="icon-time"></i> WARD</a>
        <a href="ward-patient?wrdno=<?php echo $wardID;?>" title="" class="tip-bottom"><i class="icon-user"></i> WARD PATIENTS</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">WARD PATIENT MANAGEMENT</h3>

      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">ADMITTED PATIENTS</a></li>
<!--                    <li><a data-toggle="tab" href="#tab2">Admit New Patient</a></li>-->
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>PATIENT ID</th>
                              <th>ADMITTED FOR</th>
                              <th>ADMITTED BY</th>
                              <th>ADMITTED</th>
                              <th>DISCHARGE</th>
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
                              <?php
                                $wrd=$wardc->find_by_wardAssign_id($wardID);
                                foreach($wrd as $wrd_assign){ ?>
                            <tr>
                              <td><?php echo $wrd_assign['patientID']; ?></td>
                              <td><?php echo $wrd_assign['admitDetails']; ?></td>
                              <td>
                                  <?php
                                    $doc = select("SELECT * FROM staff where staffID='".$wrd_assign['staffID']."'");
                                     foreach($doc as $docrow){}
                                    echo $docrow['lastName'].' '.$docrow['firstName'].' '.$docrow['otherName'];
                                  ?>
                                </td>
                              <td><?php echo $wrd_assign['admitDate']; ?></td>
                              <td> <?php echo $wrd_assign['dischargeDate']; ?></td>
                              <td style="text-align: center;">
            <a href="ward-patientDetails?patid=<?php echo $wrd_assign['patientID'].'&wrdno='.$wardID.'&assign='.$wrd_assign['assignID']; ?>"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                              <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
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
