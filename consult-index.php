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

//        $room = Consultation::find_consultingroom();
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
    <li> <a href="consult-inward?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Inward</span></a> </li>
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
                          <th>Patient Number</th>
                          <th>Patient Name</th>
                          <th>Patient Age</th>
                          <th>Nurse Name</th>
                          <th>Status</th>
                          <th>Action</th>
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
                      ?>
                    <div class="new-update clearfix">
                        <i class="icon-warning-sign"></i>
                        <div class="update-done">
 <a href="consult-labreview?patientID=<?php echo $labupdate['patientID'];?>&roomID=<?php echo $roomID;?>&conid=<?php echo $labupdate['consultID'];?>" target="popup"  >
                                <strong>Lab Result For <?php echo $labupdate['patientID']; ?> Available</strong>
                            </a>

<!--
onclick="window.open('consult-labreview?patientID=<?php //echo $labupdate['patientID'];?>&roomID=<?php /// echo $roomID;?>&centerID=<?php // echo $_SESSION['centerID'];?>&labrslt=<?php // echo $labupdate['patientID']; ?>');"

-->

<!--                          <a href="#" title=""><strong>Lab Result For Patient PTN001 Available</strong></a>-->
                        </div>
                      <div class="update-date"><span class="update-day"><a href="#" class="label label-info">View</a></span></div>
                    </div>
                      <?php } ?>

<!--
                    <div class="new-update clearfix">
                        <i class="icon-user"></i>
                        <span class="update-notice">
                            <a href="#" title=""><strong>Patient PTN023 Assigned From OPD </strong></a>
                        </span>
                        <div class="update-date"><span class="update-day"><a href="#" class="label label-info">View</a></span></div>
                    </div>
                    <div class="new-update clearfix">
                        <i class="icon-home"></i>
                        <span class="update-alert">
                            <a href="#" title=""><strong>Patient PTN023 Admitted To Maternal Ward</strong></a>
                        </span>
                        <div class="update-date"><span class="update-day"><a href="#" class="label label-info">View</a></span></div>
                    </div>
                    <div class="new-update clearfix">
                        <i class="icon-plus-sign"></i>
                        <span class="update-done">
                            <a href="#" title=""><strong> Prescription For Patient PTN221 Given Out</strong></a>
                        </span>
                        <div class="update-date"><span class="update-day"><a href="#" class="label label-info">View</a></span></div>
                    </div>
                    <div class="new-update clearfix">
                        <i class="icon-user"></i>
                        <span class="update-notice">
                            <a href="#" title=""><strong>Patient PTN053 Assigned From OPD </strong></a>
                        </span>
                        <div class="update-date"><span class="update-day"><a href="#" class="label label-info">View</a></span></div>
                    </div>
-->
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
