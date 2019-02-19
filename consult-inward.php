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
        $rm = select("SELECT * FROM consultingroom WHERE roomID='$roomID' ");
        foreach($rm as $r){}
?>
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li> <a href="consult-index?roomID=<?php echo $roomID;?>"><i class="icon icon-briefcase"></i><span>Consultation</span></a> </li>
    <li> <a href="consult-appointment?roomID=<?php echo $roomID;?>"><i class="icon icon-calendar"></i><span>Appointments</span></a> </li>
    <li class="active"> <a href="consult-inward?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Inpatients</span></a> </li>
    <li> <a href="consult-transfers?roomID=<?php echo $roomID;?>"><i class="icon-resize-horizontal"></i> <span>Transfers</span></a> </li>
    </ul>
</div>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Consultation" class="tip-bottom"><i class="icon-briefcase"></i> CONSULTATION</a>
        <a title="Inward Patients" class="tip-bottom"><i class="icon-home"></i> INWARD</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">INWARD FROM CONSULTING ROOM - <?php echo $r['roomName'];?></h3>

      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs labell">
                    <li class="active"><a data-toggle="tab" href="#tab1">Admitted Patient List</a></li>
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
                          <thead class="labell">
                              <th>WardID</th>
                              <th>Bed Number</th>
                              <th>Patient</th>
                              <th>Admitted</th>
                              <th>Discharged</th>
                              <th>Action</th>
                          </thead>
                            <tbody>
                                <?php
                                $inwards = select("SELECT * FROM wardassigns WHERE staffID='$staffID'");
                                if($inwards){
                                    foreach($inwards as $inwardrow){
                                        //get ward Name
                                        $wardnm = select("SELECT * From wardlist where wardID='".$inwardrow['wardID']."'");
                                        foreach($wardnm as $warddet){}

                                        //get bed details
                                        $bednm = select("SELECT * From bedlist where bedID='".$inwardrow['bedID']."'");
                                        foreach($bednm as $beddet){}

                                        //get patient details
                                        $patient = select("SELECT * From patient where patientID='".$inwardrow['patientID']."'");
                                        foreach($patient as $pdet){}

                                ?>
                                <tr>
                                    <td><?php echo $warddet['wardName']; ?></td>
                                    <td><?php echo $beddet['bedNumber']; ?></td>
                                    <td><?php echo $pdet['lastName'].' '.$pdet['firstName'].' '.$pdet['otherName']; ?></td>
                                    <td><?php echo $inwardrow['admitDate'];?></td>
                                    <td><?php echo $inwardrow['dischargeDate'];?></td>
                                    <td>
                                        <a href="ward-patientAssign?wrdno=<?php echo $inwardrow['wardID'];?>&patid=<?php echo $inwardrow['patientID']; ?>&assign=<?php echo $inwardrow['assignID'];?>"> <span class="btn btn-danger fa fa-file-text" title="Assign"></span></a>

                                        <a href="ward-patientDetails?patid=<?php echo urlencode($inwardrow['patientID'])?>&wrdno=<?php echo urlencode($inwardrow['wardID'])?>&assign=<?php echo urlencode($inwardrow['assignID'])?>"> <span class="btn btn-info fa fa-link"></span></a>

                                    </td>
                                </tr>
                                <?php }}?>
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
