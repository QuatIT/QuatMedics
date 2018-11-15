<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUAT MEDICS ADMIN</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="../assets/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="../assets/css/fullcalendar.css" />
<link rel="stylesheet" href="../assets/css/maruti-style.css" />
<link rel="stylesheet" href="../assets/css/maruti-media.css" class="skin-color" />
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

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
    include '../assets/core/connection.php';
    $centerID=$_SESSION['centerID'];
    @$roomID = $_GET['roomID'];

    $dashboard = new Dashboard;

//<!--    OPD DASHBOARD-->

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


            <div class="pie1"  id="chartContainer" style="height: 330px; width: 100%;border:2px solid red;"></div>


<script src="../assets/js/excanvas.min.js"></script>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/jquery.ui.custom.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/jquery.flot.min.js"></script>
<script src="../assets/js/jquery.flot.pie.min.js"></script>
<script src="../assets/js/jquery.flot.resize.min.js"></script>
<script src="../assets/js/maruti.js"></script>
<script src="../assets/js/maruti.charts.js"></script>
<script src="../assets/js/maruti.dashboard.js"></script>
<script src="../assets/js/jquery.peity.min.js"></script>
<script src="canvasjs.min.js"></script>

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
