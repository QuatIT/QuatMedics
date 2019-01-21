<?php
session_start();
error_reporting(0);
?>
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
<link rel="stylesheet" href="css/maruti-style.css" />
<link rel="stylesheet" href="css/maruti-media.css" class="skin-color" />
<link rel="stylesheet" href="assets/css/font-awesome.css" />
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

<?php include 'layout/head.php';

	if($_SESSION['username'] ==''){
		echo "<script>window.location.href='logout'</script>";
	}

    $centerID=$_SESSION['centerID'];
    @$roomID = $_GET['roomID'];
$update_consulting = update("UPDATE consultingroom SET status='free' WHERE roomID='$roommID'");
    $dashboard = new Dashboard;

 ?>



    <?php
    if($_SESSION['accessLevel']=='LABORATORY'){
     //totalLabRequest
        $labRequest = $dashboard->numLabRequests($centerID);
    //totalBloodDonor
        $BloodDonor = $dashboard->numBloodDonor($centerID);

$dataPoints = array(
	array("label"=>"No. of Lab Request", "y"=>$labRequest),
	array("label"=>"No. of Blood Donors", "y"=>$BloodDonor)
//	array("label"=>"No. of Patients in Ward", "y"=>$wardPatient)
//	array("label"=>"No. of Compay Patient", "y"=>$companyPatient),
//	array("label"=>"No. of Free Consulting Room", "y"=>$availableConsultingRoom),
//	array("label"=>"No. of Free Consulting Room", "y"=>$occupiedConsultingRoom)
)
 ?>

   <?php }

?>


<!--    CONSULTATION DASHBOARD-->
  <?php if($_SESSION['accessLevel']=='LABORATORY'){ ?>
<script>
window.onload = function() {


var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
    exportEnabled: true,
	title: {
		text: "DASHBOARD SUMMARY"
	},
    legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	subtitles: [{
		text: "As At <?php echo date('D, d M Y'); ?>"
	}],
	data: [{
		type: "column",
//		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

}
</script>
<?php } ?>



    <?php
    if($_SESSION['accessLevel']=='CONSULTATION'){
     //totalAwaiting
        $totalAwaiting = $dashboard->awaitingPatient($centerID,$roomID);
    //private patient
        $LabResults = $dashboard->numLabResults($centerID,$roomID);
    //insurance patient
        $wardPatient = $dashboard->numWardPatient($centerID,$roomID);

$dataPoints = array(
	array("label"=>"No. of Awaiting Patients", "y"=>$totalAwaiting),
	array("label"=>"No. of Lab Results", "y"=>$LabResults),
	array("label"=>"No. of Patients in Ward", "y"=>$wardPatient)
//	array("label"=>"No. of Compay Patient", "y"=>$companyPatient),
//	array("label"=>"No. of Free Consulting Room", "y"=>$availableConsultingRoom),
//	array("label"=>"No. of Free Consulting Room", "y"=>$occupiedConsultingRoom)
)
 ?>

   <?php }

?>


<!--    CONSULTATION DASHBOARD-->
  <?php if($_SESSION['accessLevel']=='CONSULTATION'){ ?>
<script>
window.onload = function() {


var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
    exportEnabled: true,
	title: {
		text: "DASHBOARD SUMMARY"
	},
    legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	subtitles: [{
		text: "As At <?php echo date('D, d M Y'); ?>"
	}],
	data: [{
		type: "column",
//		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

}
</script>
<?php } ?>



<!--    OPD DASHBOARD-->
    <?php
    if($_SESSION['accessLevel']=='OPD'){
     //totalPatient
        $totalPatient = $dashboard->totalPatient($centerID);
    //private patient
        $privatePatient = $dashboard->privatePatient($centerID);
    //insurance patient
        $insurancePatient = $dashboard->insurancePatient($centerID);
    //company patient
        $companyPatient = $dashboard->companyPatient($centerID);
    //free consultingRoom
        $availableConsultingRoom = $dashboard->availableConsultingRoom($centerID);
    //occupied consultingRoom
        $occupiedConsultingRoom = $dashboard->occupiedConsultingRoom($centerID);

$dataPoints = array(
	array("label"=>"No. of Patient", "y"=>$totalPatient),
	array("label"=>"No. of Private Patient", "y"=>$privatePatient),
	array("label"=>"No. of Insurance Patient", "y"=>$insurancePatient),
	array("label"=>"No. of Compay Patient", "y"=>$companyPatient),
	array("label"=>"No. of Free Consulting Room", "y"=>$availableConsultingRoom),
	array("label"=>"No. of Occupied Consulting Room", "y"=>$occupiedConsultingRoom)
)

 ?>

   <?php }

?>



  <?php if($_SESSION['accessLevel']=='OPD'){ ?>
<script>
window.onload = function() {


var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
    exportEnabled: true,
	title: {
		text: "DASHBOARD SUMMARY"
	},
    legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	subtitles: [{
		text: "As At <?php echo date('D, d M Y'); ?>"
	}],
	data: [{
		type: "column",
//		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

}
</script>

<?php } ?>


<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li class="active"><a href="medics-index"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>

        <?php if($_SESSION['accessLevel'] == 'OPD'){ ?>
        <li> <a href="opd-index"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
        <li> <a href="opd-patient?tab=opd-patient"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
<!--        <li><a href="opd-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>-->
        <li> <a href="consult-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
        <?php } ?>

        <?php if($_SESSION['accessLevel'] == 'CONSULTATION'){ ?>
        <li> <a href="consult-index?roomID=<?php echo $roomID;?>"><i class="icon icon-briefcase"></i><span>Consultation</span></a> </li>
        <li> <a href="consult-appointment?roomID=<?php echo $roomID;?>"><i class="icon icon-calendar"></i><span>Appointments</span></a> </li>
        <li> <a href="consult-inward?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Inward</span></a> </li>
        <li> <a href="consult-transfers?roomID=<?php echo $roomID;?>"><i class="icon-resize-horizontal"></i> <span>Transfers</span></a> </li>
        <?php } ?>

        <?php if($_SESSION['accessLevel'] == 'LABORATORY'){ ?>
        <li><a href="lab-index.php"><i class="icon icon-warning-sign"></i> <span>Laboratory</span></a></li>
        <li> <a href="lab-bloodbank.php"><i class="icon icon-tint"></i> <span>Blood Bank</span></a> </li>
        <?php } ?>

    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="" class="tip-bottom"><i class="icon-piechart"></i> STATISTICS</a>
    </div>
  </div>
  <div class="container-fluid">
<?php if($_SESSION['accessLevel']=='center_admin'){ ?>
   	<div class="quick-actions_homepage">
    <ul class="quick-actions">
          <li> <a href="centerdepartment-index"> <i class="icon-cabinet"></i> DEPARTMENTS</a></li>
          <li> <a href="centeruser-index"> <i class="icon-people"></i> STAFF </a> </li>
          <li> <a href="center-account"> <i class="icon-survey"></i>ACCOUNTS </a> </li>
          <li> <a href="centerconsultation-index"> <i class="icon-cabinet"></i> CONSULTATION</a></li>
          <li> <a href="centerward-index"> <i class="fa fa-folder-open fa-3x"></i> <br/> WARD </a> </li>
          <li> <a href="centerpharmacy-index"> <i class="fa fa-plus-square fa-3x"></i> <br/> PHARMACY</a> </li>
          <li> <a href="centerlab-index"> <i class="icon-search"></i> LABORATORY </a> </li>
          <li> <a href="smsrequest-index"> <i class="fa fa-envelope fa-3x"></i><br> SMS REQUEST </a> </li>
        </ul>
   </div>
<?php }
      if($_SESSION['accessLevel']=='CONSULTATION'){
//        $room = Consultation::find_consultingroom();
        $room = select("SELECT * FROM consultingroom WHERE status='".FREE."' && centerID='".$_SESSION['centerID']."' || status='' && centerID='".$_SESSION['centerID']."'  || status='null' && centerID='".$_SESSION['centerID']."' ");

      ?>



<?php if(empty($_GET['roomID'])){ ?>
    <div id="modal">
    <div class="modalconent text-center">
         <h4>Kindly Select Your Consulting Room Number</h4>
        <?php foreach($room as $roomno){ ?>
            <a href="medics-index?roomID=<?php echo $roomno['roomID'];?>" class="btn btn-warning"><?php echo $roomno['roomName'];?></a>
        <?php } ?>

    </div>
</div>

<?php }} ?>


        <div class="row-fluid">
<!--
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5>Line chart</h5>
          </div>
          <div class="widget-content">
            <div class="chart"></div>
          </div>
        </div>
      </div>
-->
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
<!--            <h5>Pie chart</h5>-->
          </div>
          <div class="widget-content">
              <?php if($_SESSION['accessLevel']=='OPD'){ ?>
            <div class="pie1"  id="chartContainer" style="height: 330px; width: 100%;"></div>
<!--            <div class="pie1"  id="chartContainer21" style="height: 330px; width: 100%;"></div>-->
              <?php } ?>
              <?php if($_SESSION['accessLevel']=='CONSULTATION'){ ?>
            <div class="pie1"  id="chartContainer" style="height: 330px; width: 100%;"></div>
              <?php } ?>
              <?php if($_SESSION['accessLevel']=='LABORATORY'){ ?>
            <div class="pie1"  id="chartContainer" style="height: 330px; width: 100%;"></div>
              <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<!--</div>-->
<!--</div>-->
</div>
<div class="row-fluid">
  <div id="footer" class="span12"> 2018 &copy; QUAT MEDICS ADMIN BY  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a> </div>
</div>
<script src="js/excanvas.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.ui.custom.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.flot.min.js"></script>
<script src="js/jquery.flot.pie.min.js"></script>
<script src="js/jquery.flot.resize.min.js"></script>
<script src="js/maruti.js"></script>
<script src="js/maruti.charts.js"></script>
<script src="js/maruti.dashboard.js"></script>
<script src="js/jquery.peity.min.js"></script>
<script src="js/canvasjs.min.js"></script>

    <script>
window.onload = function () {
    document.getElementById('button').onclick = function () {
        document.getElementById('modal').style.display = "none"
    };
};
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
