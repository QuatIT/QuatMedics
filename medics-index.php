<?php
session_start();
// error_reporting(0);
?>
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
<link rel="stylesheet" href="css/maruti-style.css" />
<link rel="stylesheet" href="css/maruti-media.css" class="skin-color" />
<!--<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">-->
<!--<script src="https://code.highcharts.com/highcharts.js"></script>-->
<script src="chart/highcharts.js"></script>
<!--<script src="https://code.highcharts.com/modules/series-label.js"></script>-->
<script src="chart/series-label.js"></script>
<!--<script src="https://code.highcharts.com/modules/exporting.js"></script>-->
<script src="chart/exporting.js"></script>
<!--<script src="https://code.highcharts.com/modules/export-data.js"></script>-->
<script src="chart/export-data.js"></script>
<!--<script src="https://code.highcharts.com/highcharts-3d.js"></script>-->
<script src="chart/highcharts-3d.js"></script>
<script src="chart/jquery-3.1.1.min.js"></script>
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

#container, #sliders {
    min-width: 310px;
    max-width: 800px;
    margin: 0 auto;
}
#container {
    height: 400px;
}

#result {
    text-align: right;
    color: gray;
    min-height: 2em;
}
#table-sparkline {
    margin: 0 auto;
    border-collapse: collapse;
}
th {
    font-weight: bold;
    text-align: left;
}
td, th {
    padding: 5px;
    border-bottom: 1px solid silver;
    height: 20px;
}

thead th {
    border-top: 2px solid gray;
    border-bottom: 2px solid gray;
}
.highcharts-tooltip>span {
    background: white;
    border: 1px solid silver;
    border-radius: 3px;
    box-shadow: 1px 1px 2px #888;
    padding: 8px;
}

#containerWARD {
/*  min-width: 310px;
  max-width: 800px;*/
  height: 400px;
  margin: 0 auto
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
$update_consulting = update("UPDATE consultingroom SET status='free' WHERE roomID='$roomID'");
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

<?php } ?>



<?php
$date = date('Y-m-d');

//consultation
 $get_pat = select("SELECT COUNT(*) as allx FROM consultation WHERE dateInsert = CURDATE()");
foreach($get_pat as $get_pats){
  $all_consult=$get_pats['allx'];
}

  $get_insurance = select("SELECT COUNT(mode) as insurance FROM consultation WHERE mode ='Insurance'&& dateInsert=CURDATE() && insuranceType='NHIS'");
  foreach($get_insurance as $get_insurances){
    $nhis = $get_insurances['insurance'];
  }

    $get_insurance2 = select("SELECT COUNT(mode) as insurances FROM consultation WHERE mode ='Insurance'&& dateInsert=CURDATE() && insuranceType='Acacia'");
  foreach($get_insurance2 as $get_insurances2){
    $acaia=$get_insurances2['insurances'];
  }

     $get_company = select("SELECT COUNT(mode) as comp FROM consultation WHERE mode ='Company' && dateInsert=CURDATE() ");
  foreach($get_company as $get_companyx){
    $company = $get_companyx['comp'];
  }

     $get_private = select("SELECT COUNT(mode) as priva FROM consultation WHERE mode ='Private' && dateInsert=CURDATE()");
  foreach( $get_private as $get_privates){
    $private = $get_privates['priva'];
  }

//consultation calculation
$percentile=100;

// nhis percentage
  @$cal_nhis = ($nhis)/($all_consult)* ($percentile);


//nhis Acacia
@$cal_acacia = ($acacia)/($all_consult)* ($percentile);

  //company percentage
@$cal_company = ($company)/($all_consult)*($percentile);

  //private percentage
@$cal_private = ($private)/($all_consult)*($percentile);

//WARD
$room_ward = select("SELECT * FROM wardlist");
foreach($room_ward as $room_wards){}

?>


<!--    CONSULTATION DASHBOARD-->
  <?php if($_SESSION['accessLevel']=='LABORATORY'){ ?>
<script>

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

<?php } ?>


<!--    CONSULTATION DASHBOARD-->
<?php if($_SESSION['accessLevel']=='CONSULTATION'){ ?>
<script>




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

        <?php if($_SESSION['accessLevel'] == 'FINANCE'){ ?>
        <li> <a href="finance-cash"><i class="icon icon-briefcase"></i><span>CASH PAYMENT</span></a> </li>
        <li><a href="finance-insurance"><i class="icon icon-file"></i><span>INSURANCE</span></a></li>
        <li><a href="finance-cash-report"><i class="icon-list-alt"></i><span>REPORT</span></a></li>
        <?php } ?>

        <?php if($_SESSION['accessLevel'] == 'WARD'){ ?>
        <li><a href="ward-index?wrdno=<?php echo $wardID;?>"><i class="icon icon-plus"></i> <span>Bed Management</span></a></li>
        <li> <a href="ward-patient?wrdno=<?php echo $wardID;?>"><i class="icon icon-user"></i> <span>Patient Management</span></a></li>
        <?php } ?>

        <?php if($_SESSION['accessLevel'] == 'PHARMACY'){ ?>
        <li class=""> <a href="pharmacy-index"><i class="icon icon-briefcase"></i> <span>Pharmacy</span></a> </li>
        <li> <a href="pharmacy-index2"><i class="icon icon-briefcase"></i> <span>Pharmacy2</span></a> </li>
        <li> <a href="dispensary?tab=admed"><span>Dispensary</span></a> </li>
        <li> <a href="pharmacy-inventory?tab=tab2"> <span>Inventory (Pharmacy)</span></a> </li>
        <?php } ?>


        <?php if($_SESSION['accessLevel']=='center_admin'){ ?>
        <li class=""> <a href="centerconsultation-index"><i class="icon-th-list"></i> <span>CONSULTATION</span></a> </li>
        <li class=""> <a href="centerward-index"><i class="icon-folder-close"></i> <span>WARD</span></a> </li>
        <li class=""> <a href="centerlab-index"> <i class="icon-search"></i> <span>LABORATORY</span></a> </li>
        <li class=""> <a href="centeruser-index"> <i class="icon-user"></i> <span>STAFF</span></a> </li>
        <li class=""> <a href="centerpharmacy-index"> <i class="icon-plus-sign"></i> <span>PHARMACY</span></a> </li>
        <li class=""> <a href="center-account"> <i class="icon-list-alt"></i> <span>ACCOUNTS</span></a> </li>
        <li class=""> <a href="smsrequest-index"> <i class="icon-envelope"></i> <span>SMS REQUEST</span></a> </li>
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
<!--   	<div class="quick-actions_homepage">-->
<!--    <ul class="quick-actions">-->
<!--          <li> <a href="centerconsultation-index"> <i class="icon-cabinet"></i> CONSULTATION</a></li>-->
<!--          <li> <a href="centeruser-index"> <i class="icon-people"></i> STAFF </a> </li>-->
<!--          <li> <a href="centerward-index"> <i class="fa fa-folder-open fa-3x"></i> <br/> WARD </a> </li>-->
<!--          <li> <a href="centerpharmacy-index"> <i class="fa fa-plus-square fa-3x"></i> <br/> PHARMACY</a> </li>-->
<!--          <li> <a href="centerlab-index"> <i class="icon-search"></i> LABORATORY </a> </li>-->
<!--          <li> <a href="smsrequest-index"> <i class="fa fa-envelope fa-3x"></i><br> SMS REQUEST </a> </li>-->
<!--          <li> <a href="center-account"> <i class="icon-survey"></i>ACCOUNTS </a> </li>-->
<!--        </ul>-->
<!--   </div>-->
<?php }

      if($_SESSION['accessLevel']=='CONSULTATION'){
//        $room = Consultation::find_consultingroom();
        $room = select("SELECT * FROM consultingroom WHERE centerID='$centerID' AND status='".FREE."' || status='' ");

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




<?php if($_SESSION['accessLevel']=='CONSULTATION'){

  $consult_all = select("SELECT COUNT(*) as c_all FROM consultation WHERE dateInsert = CURDATE()");
  foreach($consult_all as $consult_allx){$consult_total= $consult_allx['c_all'];}

$consult_wait = select("SELECT COUNT(*) as con1 FROM consultation WHERE status !='sent_to_pharmacy' && dateInsert = CURDATE() ");
foreach($consult_wait as $consult_waitx){$waiting = $consult_waitx['con1'];}

$consult_discharge = select("SELECT COUNT(*) con2 FROM consultation WHERE status = 'sent_to_pharmacy' && dateInsert = CURDATE()");
foreach($consult_discharge as $consult_discharges){$discharged = $consult_discharges['con2'];}

// consultation calculation
//waiting patients
@$wait_pat =($waiting)/($consult_total)*100;

//discharged patients
@$disch_pat =($discharged)/($consult_total)*100;




// echo "<script>alert({$disch_pat})</script>";

  ?>
<?php $Nome = $_SESSION['username']; echo 'Welcome'.' '. strtoupper($Nome); ?>
<br>
  <div id="containerCON" style="min-width: 310px; height: 320px; margin: 0 auto;" ></div>

<script>

  // Radialize the colors
Highcharts.setOptions({
  colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
    return {
      radialGradient: {
        cx: 0.5,
        cy: 0.3,
        r: 0.7
      },
      stops: [
        [0, color],
        [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
      ]
    };
  })
});

// Build the chart
Highcharts.chart('containerCON', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: true,
    type: 'pie'
  },
  title: {
    text: 'CONSULTATION DEPARTMENT '
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
        style: {
          color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
        },
        connectorColor: 'red'
      }
    }
  },
  series: [{
    name: 'Share',
    data: [
      { name: 'Waiting Patients', y:<?php echo $wait_pat;?> },
      { name: 'Discharged Patients', y:<?php echo $disch_pat;?>}



    ]
  }]
});



</script>

<?php } ?>



             <?php if($_SESSION['accessLevel']=='OPD'){?>

            <?php $Nome = $_SESSION['username']; echo 'Welcome'.' '. strtoupper($Nome); ?>

<div id="containerOPD" style="min-width: 310px; height: 300px; margin: 0 auto;" ></div>
<script>
// Radialize the colors
Highcharts.setOptions({
  colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
    return {
      radialGradient: {
        cx: 0.5,
        cy: 0.3,
        r: 0.7
      },
      stops: [
        [0, color],
        [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
      ]
    };
  })
});

// Build the chart
Highcharts.chart('containerOPD', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'OUT PATIENT DEPARTMENT INSURANCE'
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
        style: {
          color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
        },
        connectorColor: 'silver'
      }
    }
  },
  series: [{
    name: 'Share',
    data: [
      { name: 'NHIS', y:<?php echo $cal_nhis;?> },
      { name: 'ACACIA', y: <?php echo $cal_acacia;?> },
      { name: 'COMPANY', y: <?php echo $cal_company;?> },
      { name: 'PRIVATE', y: <?php echo $cal_private;?> }


    ]
  }]
});



</script>






              <?php } ?>


              <?php
              $phar_count = select("SELECT COUNT(*) as phar_all FROM prescribedmeds");
              foreach($phar_count as $phar_counts){ $phar_all=$phar_counts['phar_all'];}

              $pharma = select("SELECT COUNT(*) as pharma_served FROM prescribedmeds WHERE prescribeStatus='served'");
              foreach($pharma as $pharmas){
                $served = $pharmas['pharma_served'];}

                 $pharma_not = select("SELECT COUNT(*) as pharma_non FROM prescribedmeds WHERE prescribeStatus !='served'");
              foreach($pharma_not as $pharma_notx){
                $unserved = $pharma_notx['pharma_non'];}

                //PHARMACY CALCULATION

                $cal_served = ($served/$phar_all) * $percentile;


                $cal_unserved = ($unserved/$phar_all)*$percentile;


 // echo "<script>alert('{$cal_unserved}')</script>";
              ?>

              <?php if($_SESSION['accessLevel']=='PHARMACY'){?>

<?php $Nome = $_SESSION['username']; echo 'Welcome'.' '. strtoupper($Nome); ?>
              <div id="containerPHARMA" style="min-width: 300px; height: 350px; margin: 0 auto"></div>
                <script>

Highcharts.chart('containerPHARMA', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'PHARMACY DEPARTMENT'
    },
    subtitle: {
        text: 'Served and Unserved Drug Prescriptions'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        max: 100,
        title: {
            text: 'Quantity'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Drug Amount: <b>{point.y:.100f} %</b>'
    },
    series: [{
        name: 'Population',
        data: [
            ['Served Prescriptions', <?php echo $cal_served;?>],
            ['Unserved Prescriptions', <?php echo $cal_unserved;?>]

        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: 'red',
            align: 'right',
            format: '{point.y:.100f}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});


                </script>

              <?php } ?>


<?php if($_SESSION['accessLevel']=='INVENTORY'){?>


    <div id="containerINVENT" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<table id="datatable">
    <thead>
        <tr>
            <th></th>
            <th>Jane</th>
            <th>John</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Apples</th>
            <td>3</td>
            <td>4</td>
        </tr>
        <tr>
            <th>Pears</th>
            <td>2</td>
            <td>0</td>
        </tr>
        <tr>
            <th>Plums</th>
            <td>5</td>
            <td>11</td>
        </tr>
        <tr>
            <th>Bananas</th>
            <td>1</td>
            <td>1</td>
        </tr>
        <tr>
            <th>Oranges</th>
            <td>2</td>
            <td>4</td>
        </tr>
    </tbody>
</table>

<script>


Highcharts.chart('containerINVENT', {
    data: {
        table: 'datatable'
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'Data extracted from a HTML table in the page'
    },
    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Units'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.series.name + '</b><br/>' +
                this.point.y + ' ' + this.point.name.toLowerCase();
        }
    }
});

</script>


<?php } ?>

<?php if($_SESSION['accessLevel']=='WARD'){?>

  <span style="margin-left:500px;font-size:22px;">WARD DEPARTMENT</span><br>

 <?php $Nome = $_SESSION['username']; echo 'Welcome'.' '. strtoupper($Nome); ?>

  <div id="containerWARD" style="width:1000px;">
<br>
    <table class="table table-bordered" style="">
      <thead>
        <tr>
        <th>WARD NAME</th>
        <th>NUMBER OF BEDS</th>
      </tr>
      </thead>
      <tbody>
        <tr>
        <?php
        $ward_detail = select("SELECT * FROM wardlist");
        foreach($ward_detail as $ward_details){

          ?>

          <td style="background-color:lightblue;"><?php echo $ward_details['wardName']; ?></td>
          <td style="background-color:lightyellow;"><?php echo $ward_details['numOfBeds']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>


  </div>



<?php } ?>

<?php if($_SESSION['accessLevel']=='FINANCE'){?>

<div id="containerFIN"></div>

  <script>


Highcharts.chart('containerFIN', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
        text: 'FINANCE DEPARTMENT'
    },
    subtitle: {
        text: '3D donut in Highcharts'
    },
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
        }
    },
    series: [{
        name: 'Delivered amount',
        data: [
            ['Bananas', 8],
            ['Kiwi', 3],
            ['Mixed nuts', 1]
        ]
    }]
});

  </script>

<?php } ?>


              <?php if($_SESSION['accessLevel']=='LABORATORY'){ ?>

                <?php $Nome = $_SESSION['username']; echo 'Welcome'.' '. strtoupper($Nome); ?>
                <div id="result"></div>
<table id="table-sparkline" style="width:1100px;">
    <thead >
        <tr style="background-color:skyblue;">
            <th>LABORATORY TYPE</th>
            <th>LABORATORY ID</th>
            <th>FACILITY ID</th>

        </tr>
    </thead>
    <tbody id="tbody-sparkline">
  <tr>
      <?php
      $lab_type = select("SELECT * FROM lablist");
      foreach($lab_type as $lab_types){


 //        $lab_count = select("SELECT COUNT(patientID) as lab_num FROM labresult WHERE labID='".$lab_types['labID']."'");
 // foreach($lab_count as $lab_counts){}
        ?>
<!--</tr>-->
      <td><?php echo $lab_types['labName'];?></td>
      <td><?php echo $lab_types['labID'];?></td>
      <td><?php echo $centerID;?></td>



</tr>
    <?php }  ?>


    </tbody>
</table>


                <script>
Highcharts.SparkLine = function (a, b, c) {
    var hasRenderToArg = typeof a === 'string' || a.nodeName,
        options = arguments[hasRenderToArg ? 1 : 0],
        defaultOptions = {
            chart: {
                renderTo: (options.chart && options.chart.renderTo) || this,
                backgroundColor: null,
                borderWidth: 0,
                type: 'area',
                margin: [2, 0, 2, 0],
                width: 120,
                height: 20,
                style: {
                    overflow: 'visible'
                },

                // small optimalization, saves 1-2 ms each sparkline
                skipClone: true
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            xAxis: {
                labels: {
                    enabled: false
                },
                title: {
                    text: null
                },
                startOnTick: false,
                endOnTick: false,
                tickPositions: []
            },
            yAxis: {
                endOnTick: false,
                startOnTick: false,
                labels: {
                    enabled: false
                },
                title: {
                    text: null
                },
                tickPositions: [0]
            },
            legend: {
                enabled: false
            },
            tooltip: {
                backgroundColor: null,
                borderWidth: 0,
                shadow: false,
                useHTML: true,
                hideDelay: 0,
                shared: true,
                padding: 0,
                positioner: function (w, h, point) {
                    return { x: point.plotX - w / 2, y: point.plotY - h };
                }
            },
            plotOptions: {
                series: {
                    animation: false,
                    lineWidth: 1,
                    shadow: false,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    marker: {
                        radius: 1,
                        states: {
                            hover: {
                                radius: 2
                            }
                        }
                    },
                    fillOpacity: 0.25
                },
                column: {
                    negativeColor: '#910000',
                    borderColor: 'silver'
                }
            }
        };

    options = Highcharts.merge(defaultOptions, options);

    return hasRenderToArg ?
        new Highcharts.Chart(a, options, c) :
        new Highcharts.Chart(options, b);
};

var start = +new Date(),
    $tds = $('td[data-sparkline]'),
    fullLen = $tds.length,
    n = 0;

// Creating 153 sparkline charts is quite fast in modern browsers, but IE8 and mobile
// can take some seconds, so we split the input into chunks and apply them in timeouts
// in order avoid locking up the browser process and allow interaction.
function doChunk() {
    var time = +new Date(),
        i,
        len = $tds.length,
        $td,
        stringdata,
        arr,
        data,
        chart;

    for (i = 0; i < len; i += 1) {
        $td = $($tds[i]);
        stringdata = $td.data('sparkline');
        arr = stringdata.split('; ');
        data = $.map(arr[0].split(', '), parseFloat);
        chart = {};

        if (arr[1]) {
            chart.type = arr[1];
        }
        $td.highcharts('SparkLine', {
            series: [{
                data: data,
                pointStart: 1
            }],
            tooltip: {
                headerFormat: '<span style="font-size: 10px">' + $td.parent().find('th').html() + ', Q{point.x}:</span><br/>',
                pointFormat: '<b>{point.y}.000</b> USD'
            },
            chart: chart
        });

        n += 1;

        // If the process takes too much time, run a timeout to allow interaction with the browser
        if (new Date() - time > 500) {
            $tds.splice(0, i + 1);
            setTimeout(doChunk, 0);
            break;
        }

        // Print a feedback on the performance
        if (n === fullLen) {
            $('#result').html('Generated ' + fullLen + ' sparklines in ' + (new Date() - start) + ' ms');
        }
    }
}
doChunk();



                </script>


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
<!-- <script src="js/canvasjs.min.js"></script> -->

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
