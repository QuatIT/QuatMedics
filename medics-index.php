<!DOCTYPE html>
<html lang="en">
<head>
<title>QUAT MEDICS ADMIN</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/maruti-style.css" />
<link rel="stylesheet" href="css/maruti-media.css" class="skin-color" />
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

<?php include 'layout/head.php';
    $centerID=$_SESSION['centerID'];
    @$roomID = $_GET['roomID'];

 ?>



    <?php
    if($_SESSION['accessLevel']=='CONSULTATION'){
     //totalAwaiting
        $totalAwaiting = Dashboard::awaitingPatient($centerID,$roomID);
    //private patient
        $LabResults = Dashboard::numLabResults($centerID,$roomID);
    //insurance patient
        $wardPatient = Dashboard::numWardPatient($centerID,$roomID);

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
        $totalPatient = Dashboard::totalPatient($centerID);
    //private patient
        $privatePatient = Dashboard::privatePatient($centerID);
    //insurance patient
        $insurancePatient = Dashboard::insurancePatient($centerID);
    //company patient
        $companyPatient = Dashboard::companyPatient($centerID);
    //free consultingRoom
        $availableConsultingRoom = Dashboard::availableConsultingRoom($centerID);
    //occupied consultingRoom
        $occupiedConsultingRoom = Dashboard::occupiedConsultingRoom($centerID);

$dataPoints = array(
	array("label"=>"No. of Patient", "y"=>$totalPatient),
	array("label"=>"No. of Private Patient", "y"=>$privatePatient),
	array("label"=>"No. of Insurance Patient", "y"=>$insurancePatient),
	array("label"=>"No. of Compay Patient", "y"=>$companyPatient),
	array("label"=>"No. of Free Consulting Room", "y"=>$availableConsultingRoom),
	array("label"=>"No. of Free Consulting Room", "y"=>$occupiedConsultingRoom)
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
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="" class="tip-bottom"><i class="icon-piechart"></i> STATISTICS</a>
    </div>
  </div>
  <div class="container">
<?php if($_SESSION['accessLevel']=='center_admin'){ ?>
   	<div class="quick-actions_homepage">
    <ul class="quick-actions">
          <li> <a href="centerconsultation-index"> <i class="icon-cabinet"></i> Consultation</a></li>
          <li> <a href="centeruser-index"> <i class="icon-people"></i> Staff </a> </li>
          <li> <a href="centerward-index"> <i class="icon-graph"></i> Ward </a> </li>
          <li> <a href="#"> <i class="icon-home"></i> Pharmacy</a> </li>
          <li> <a href="centerlab-index"> <i class="icon-search"></i> Laboratory </a> </li>
          <li> <a href="smsrequest-index"> <i class="icon-envelope"></i> SMS Request </a> </li>
        </ul>
   </div>
<?php } ?>
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
              <?php } ?>
              <?php if($_SESSION['accessLevel']=='CONSULTATION'){ ?>
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
<div class="row-fluid navbar-fixed-bottom" >
  <div id="footer" class="span12"> 2018 &copy; QUAT MEDICS ADMIN By  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a> </div>
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
