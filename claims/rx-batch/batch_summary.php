<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Batch Summary</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap-4.0.0.css" rel="stylesheet">

  </head>
  <body>
    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
       <a class="navbar-brand" href="#">Navbar</a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
             <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
             </li>
             <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
             </li>
             <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                   <a class="dropdown-item" href="#">Action</a>
                   <a class="dropdown-item" href="#">Another action</a>
                   <div class="dropdown-divider"></div>
                   <a class="dropdown-item" href="#">Something else here</a>
                </div>
             </li>
             <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
             </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
             <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
             <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
       </div>
    </nav> -->

    <br>
	  <br>
    <div class="container-fluid">

       <!-- <div class="row">

          <div class="col-md-12">
             <div class="card">
                <div class="card-body">
                   <h5 class="card-title">Claims</h5>
                   <a href="cosmopolitan.html" target="_blank" class="card-link">COSMOPOLITAN</a>
                   <a href="acacia.html" target="_blank" class="card-link">ACACIA</a>
                   <a href="nationwide.html" target="_blank" class="card-link">NATIONWIDE</a>
                   <a href="momentum.html" target="_blank" class="card-link">MOMENTUM</a>
                   <a href="premier.html" target="_blank" class="card-link">PREMERE</a>
                </div>
             </div>


          </div>

       </div> -->
<?php

include '../../assets/core/connection.php';
@session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
echo "<script>window.location.href='index'</script>";
}else{
$staff = select("SELECT * from centeruser WHERE username='".$_SESSION['username']."' AND password='".$_SESSION['password']."'");
foreach($staff as $staffrow){
    $staffID = $staffrow['staffID'];
}
}

header('Content-Type: application/force-download');
header('Content-disposition: attachment; filename=export.xls');
// Fix for crappy IE bug in download.
header("Pragma: private");
// Clearing Cache
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

$datefrom = $_GET['df'];
$dateto = $_GET['dt'];
$insurance = $_GET['insurance'];

$counter_batch = '1';

$batch_claim_query = select("select * from insure_data where insurancetype='$insurance' AND dateinsert between '$datefrom' and '$dateto'");


?>

        <div class="row">

           <div class="col-md-12">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Surname</th>
                          <th>Other Names</th>
                          <th>Date of Birth</th>
                          <th>Gender</th>
                          <th>Attendance Date</th>
                          <th>Discharge Date</th>
                          <th>Hospital Records Number</th>
                          <th>Membership Number</th>
                          <!-- <th>ICD10</th> -->
                          <th>Diagnosis</th>
                          <th>G-DRG</th>
                          <th>Service</th>
                          <th>Medicine</th>
                          <th>Other Service</th>
                          <th>Total Claimed</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php
                        $drug = array();
                        $tariff_all = array();
                        $total = array();
                          foreach($batch_claim_query as $batch_claim_row){
                            $batch_count = $counter_batch++;
                            // echo "<script>alert('{$batch_count}')</script>";

                            //get diagnose detail
                            $diagnose_details = select("select * from diagnose_tb where patientID='".$batch_claim_row['patientid']."' && dateRegistered='".$batch_claim_row['dateinsert']."' ");
                            foreach($diagnose_details as $diagnose_detail){}

                            //check description for icd10
                            $icd_details = select("select * from diseases where code='".$diagnose_detail['icd10']."'");
                            foreach($icd_details as $icd_detail){}

                              //check tariff
                              $tariffs = select("select * from nhis_tariff where  	patientid='".$batch_claim_row['patientid']."' ");
                              foreach($tariffs as $tariff){}

                                //summation
                                $drug[] = $tariff['Drug'];
                                $tariff_all[] = $tariff['Tariff'];
                                $total[] = $tariff['Total'];

                        ?>
                        <tr>
                          <td><?php echo @$batch_count; ?></td>
                          <td><?php echo @$batch_claim_row['lastname']; ?></td>
                          <td><?php echo @$batch_claim_row['firstname']; ?> <?php echo @$batch_claim_row['othername']; ?></td>
                          <td><?php echo @$batch_claim_row['dob']; ?></td>
                          <td><?php echo @$batch_claim_row['gender']; ?></td>
                          <td><?php echo @$batch_claim_row['dateinsert']; ?></td>
                          <td><?php echo @$batch_claim_row['dateinsert']; ?></td>
                          <td><?php echo @$batch_claim_row['patientid']; ?></td>
                          <td><?php echo @$batch_claim_row['patientid']; ?></td>
                          <td><?php echo @$diagnose_detail['icd10']; ?></td>
                          <td><?php echo @$icd_detail['name']; ?></td>
                          <td><?php echo @$batch_claim_row['gdrgcode']; ?></td>
                          <td><?php echo @number_format((float)$tariff['Drug'], 2, '.', ''); ?></td>
                          <td><?php echo @number_format((float)$tariff['Tariff'], 2, '.', ''); ?></td>
                          <td><?php echo @number_format((float)$tariff['Total'], 2, '.', ''); ?></td>
                          <!-- <td></td> -->
                        </tr>
                      <?php } ?>
                      <tr style="font-weight:bolder;">
                        <td colspan="12">TOTAL</td>
                        <td><?php echo array_sum($drug);?>
                        <td ><?php echo array_sum($tariff_all);?>
                        <td ><?php echo array_sum($total);?>
                      </tr>
                      </tbody>
                    </table>


           </div>

        </div>


       <br>
       <hr>

    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.2.1.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.0.0.js"></script>
  </body>
</html>
