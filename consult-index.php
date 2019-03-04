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


#modal {
    position: fixed;
    font-family: Arial, Helvetica, sans-serif;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.8);
    z-index: 99999;
    height: 100%;
    width: 100%;
}

.modalconent {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    width: 40%;
    padding: 20px;
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

$consultation = new Consultation;
$roomByID = $consultation->find_by_room_id($roomID);
foreach($roomByID as $room_id){}

if(!empty($roomID)){
    $update_room=update("UPDATE consultingroom SET status='".OCCUPIED."' WHERE roomID='$roomID' ");
}

//$room = Consultation::find_consultingroom();
$room = select("SELECT * FROM consultingroom WHERE centerID='".$_SESSION['centerID']."' && status='".FREE."' || status=''&& centerID='".$_SESSION['centerID']."'  || status='null' && centerID='".$_SESSION['centerID']."'  ");

?>

<?php if(empty($_GET['roomID'])){ ?>
    <div id="modal">
    <div class="modalconent text-center">
         <h4>Kindly Select Your Consulting Room Number</h4>
        <?php foreach($room as $roomno){ ?>
            <a href="consult-index?roomID=<?php echo $roomno['roomID'];?>" class="btn btn-warning"><?php echo $roomno['roomName'];?></a>
        <?php } ?>
    </div>
</div>

<?php } ?>
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"> <a href="consult-index?roomID=<?php echo $roomID;?>"><i class="icon icon-briefcase"></i><span>Consultation</span></a> </li>
    <li> <a href="consult-appointment?roomID=<?php echo $roomID;?>"><i class="icon icon-calendar"></i><span>Appointments</span></a> </li>
    <li> <a href="consult-inward?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Inpatients</span></a> </li>
    <li> <a href="consult-transfers?roomID=<?php echo $roomID;?>"><i class="icon-resize-horizontal"></i> <span>Transfers</span></a> </li>
    </ul>
</div>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Consultation" class="tip-bottom"><i class="icon-briefcase"></i> CONSULTATION</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">CONSULTING ROOM - <?php echo $r['roomName'];?></h3>
      <div class="row-fluid">
          <div class="span8">
                <div class="widget-box">
                  <div class="widget-title">
                  </div>
                  <div class="widget-content">
                    <table class="table table-bordered data-table">
                      <thead>
                        <tr>
                          <th>PATIENT ID</th>
                          <th>PATIENT NAME</th>
                          <th>OPD NURSE</th>
<!--                          <th>PAYMENT STATUS</th>-->
                          <th>STATUS</th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody id="consultindex">
                      </tbody>
                    </table>
                  </div>
                </div>
          </div>
          <div class="span4">
                <div class="widget-box">
                  <div class="widget-title"> <span class="icon"> <i class="icon-file"></i> </span>
                    <h5>Lab Results</h5>
                  </div>
                  <div class="widget-content nopadding updates">

                    <?php
                        $lab_update = select("SELECT * FROM labresults WHERE status='".SENT_TO_CONSULTING."' && consultingRoom='".$roomID."' && centerID='".$_SESSION['centerID']."' GROUP BY labRequestID ");
                        foreach($lab_update as $labupdate){
                            $getpat = select("SELECT * FROM patient WHERE patientID='".$labupdate['patientID']."'");
                            foreach($getpat as $labpatdet){
                      ?>
                    <div class="new-update clearfix">
                        <i class="icon-warning-sign"></i>
                        <div class="update-done">
 <a style="color:black;" href="consult-labreview?patientID=<?php echo $labupdate['patientID'];?>&roomID=<?php echo $roomID;?>&conid=<?php echo $labupdate['consultID'];?>&lbr=<?php echo $labupdate['labRequestID']; ?>" target="popup"  >

                                <strong>LAB RESULT FOR <?php echo $labpatdet['firstName']." ".$labpatdet['lastName']." ".$labpatdet['otherName']; ?> AVAILABLE.</strong>
                            </a>
                        </div>
                      <div class="update-date"><span class="update-day"><a href="#" class="label label-info">View</a></span></div>
                    </div>
                      <?php } } ?>
                  </div>
                </div>
          </div>
      </div>
  </div>
</div>
<div class="row-fluid">
  <div id="footer" class="span12"> 2018 &copy; QUATMEDIC BY  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a> </div>
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


<script>
    function dis(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/consultindex-load?roomID=<?php echo $roomID;?>",false);
        xmlhttp.send(null);
        document.getElementById("consultindex").innerHTML=xmlhttp.responseText;
    }
        dis();

        setInterval(function(){
            dis();
        },1000);
</script>

<script language="javascript" type="text/javascript">
    function popitup(url) {
    newwindow=window.open(url,'name','height=500,width=550');
    if (window.focus) {newwindow.focus()}
    return false;
    }
</script>

</body>
</html>
<?php }else{echo "<script>window.location='404'</script>";}?>
