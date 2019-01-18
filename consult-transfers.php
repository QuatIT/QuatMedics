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
$roomID = $_GET['roomID'];
$consultation = new Consultation();

    $success='';
    $error ='';

//fetch all patients
$patient = select("SELECT * FROM patient ORDER BY patientID ASC");

//staffID
$staff = select("SELECT staffID from centeruser where userName='".$_SESSION['username']."' AND password='".$_SESSION['password']."'");
foreach($staff as $staffrow){
    $staffID = $staffrow['staffID'];
}

    //fetch all centerID
$center = select("SELECT * FROM medicalcenter WHERE centerID !='".$_SESSION['centerID']."' ");

    //fetch patient
    $patient = select("SELECT * FROM patient WHERE centerID='".$_SESSION['centerID']."' && status !='".DEAD."'  ");

    //fetch transfers
    $tran=select("SELECT * FROM transfer WHERE from_centerID='".$_SESSION['centerID']."' ");

    //transferID
    $transID = $consultation->find_num_transfer() + 1;

    if(isset($_POST['addApptmnt'])){
      $centerID = $_SESSION['centerID'];
      $transferID =  "TRANS.".sprintf('%06s',$transID);
      $from_center =  filter_input(INPUT_POST, "fc", FILTER_SANITIZE_STRING);
      $from_user =  filter_input(INPUT_POST, "fu", FILTER_SANITIZE_STRING);
      $to_center =  filter_input(INPUT_POST, "newCenter", FILTER_SANITIZE_STRING);
      $to_user =  filter_input(INPUT_POST, "staffName", FILTER_SANITIZE_STRING);
      $reason =  filter_input(INPUT_POST, "transferReason", FILTER_SANITIZE_STRING);
      $patientID =  filter_input(INPUT_POST, "patientID", FILTER_SANITIZE_STRING);

        $transfer_query = insert("INSERT INTO transfer(transferID,from_centerID,to_centerID,from_staffID,to_staffID,reason,patientID,dateRegistered) VALUES('$transferID','$from_center','$to_center','$from_user','$to_user','$reason','$patientID',CURDATE() ) ");

        if($transfer_query){

            //from doctor
            $cent_fuser = select("SELECT * FROM staff WHERE staffID='$from_user' ");
            foreach($cent_fuser as $centfrow){
                $des_fuser = $centfrow['email'];
                $des_fuserName = $centfrow['firstName']." ".$centfrow['otherName']." ".$centfrow['lastName'];
            }

            //from center
            $cent_femail = select("SELECT * FROM medicalcenter WHERE centerID='$from_center' ");
            foreach($cent_femail as $centfmail){
                $des_fName = $centfmail['centerName'];
            }

            //send to mail
            $cent_user = select("SELECT * FROM staff WHERE staffID='$to_user' ");
            foreach($cent_user as $centrow){
                $des_user = $centrow['email'];
            }

            //center mail
            $cent_email = select("SELECT * FROM medicalcenter WHERE centerID='$to_center' ");
            foreach($cent_email as $centmail){
                $des_cent = $centmail['centerEmail'];
            }

            //patient
            $pati = select("SELECT * FROM patient WHERE patientID='$patientID' ");
            foreach($pati as $patty){
                $pat_ID = $patty['patientID'];
                $pat_Name = $patty['firstName']." ".$patty['otherName']." ".$patty['lastName'];
            }

            $send_to = $des_user;
            $body = "Hello, <br> ".$pat_Name." (".$pat_ID.") has been transfer to your facility.<br> Kindly find below reason of transfer. <br><br> ".$reason."<br><br> Thank you. <br>FROM: ".$des_fuserName."<br>FACILITY: ".$des_fName;
            $subj = "QUATMEDIC PATIENT TRANSFER";
            $copy = $des_cent;

            //send mail
            echo send_mail($send_to,$copy,$body,$subj);


            $success="<script>document.wrtie('PATIENT TRANSFERED SUCCESSFULLY')
                                window.location.href='consult-transfers'; </script>";
        }else{
            $error = "PATIENT TRANSFER FAILED";
        }

    }

?>

<div id="search">
  <input type="text" placeholder="Search here..." disabled/>
  <button type="submit" class="tip-left" title="Search" disabled><i class="icon-search icon-white"></i></button>
</div>

<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li> <a href="medics-index?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li> <a href="consult-index?roomID=<?php echo $roomID;?>"><i class="icon icon-briefcase"></i><span>Consultation</span></a> </li>
    <li> <a href="consult-appointment?roomID=<?php echo $roomID;?>"><i class="icon icon-calendar"></i><span>Appointments</span></a> </li>
    <li> <a href="consult-inward?roomID=<?php echo $roomID;?>"><i class="icon icon-home"></i> <span>Inward</span></a> </li>
    <li class="active"> <a href="consult-transfers?roomID=<?php echo $roomID;?>"><i class="icon-resize-horizontal"></i> <span>Transfers</span></a> </li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Consultation" class="tip-bottom"><i class="icon-briefcase"></i> CONSULTATION</a>
        <a title="Transfers" class="tip-bottom"><i class="icon-resize-horizontal"></i> TRANSFERS</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">PATIENT TRANSFERS</h3>
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
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Transfer List</a></li>
                    <li><a data-toggle="tab" href="#tab2">New Transfer</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>List OF Transfers</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Patient ID</th>
                              <th>Patient Name</th>
                              <th>New Center Name</th>
                              <th>Date Tranferred</th>
<!--                              <th>Action</th>-->
                            </tr>
                          </thead>
                          <tbody>
                              <?php
                                foreach($tran as $trans){
                                $patt = select("SELECT * FROM patient WHERE patientID = '".$trans['patientID']."' ");
                                    foreach($patt as $trans_p){}

                                    $cen = select("SELECT * FROM medicalcenter WHERE centerID='".$trans['to_centerID']."' ");
                                    foreach($cen as $centa){}
                              ?>
                              <tr>
                                <td><?php echo $trans['patientID']; ?></td>
                                <td><?php echo $trans_p['firstName']." ".$trans_p['otherName']." ".$trans_p['lastName'];?></td>
                                <td><?php echo $centa['centerName']; ?></td>
                                <td><?php echo $trans['dateRegistered']; ?></td>
<!--                                <td></td>-->
                              </tr>
                              <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <form action="#" method="post" class="form-horizontal">
                    <div class="span6">
<!--                        <div class="widget-box">-->
<!--
                          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Make Appointment</h5>
                          </div>
-->
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Center ID :</label>
                                <div class="controls">
                                  <input type="text" class="span11" name="fc" value="<?php echo $_SESSION['centerID'];?>" readonly required/>
                                </div>
                              </div>
                             <div class="control-group">
                                <label class="control-label">Staff :</label>
                                <div class="controls">
                                  <input type="text" class="span11" name="fu" value="<?php echo $staffID;?>" readonly/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Transfer To :</label>
                                <div class="controls">
                                    <select name="newCenter" onchange="transfer(this.value);">
                                        <option value=""> -- New Center --</option>
                                        <?php foreach($center as $centerID){ ?>
                                            <option value="<?php echo $centerID['centerID']; ?>"> <?php echo $centerID['centerName']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                              </div>
                             <div class="control-group">
                                <label class="control-label">Reason For Transfer :</label>
                                <div class="controls">
                                    <textarea class="span11" name="transferReason"></textarea>
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <span id="transfer"></span>

                             <div class="control-group">
                                <label class="control-label">Patient :</label>
                                <div class="controls">
                                  <select name="patientID" class="" >
                                    <option value="default"> -- Select Patient --</option>
                                      <?php
                                        if(!empty($patient)){
                                            foreach($patient as $patientrow){
                                      ?>
                                    <option value="<?php echo $patientrow['patientID'];?>"><?php echo $patientrow['firstName']." ".$patientrow['otherName']." ".$patientrow['lastName'];?> (<?php echo $patientrow['patientID'];?>)</option>
                                      <?php }}?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="addApptmnt" class="btn btn-primary btn-block span10">Transfer Patient</button>
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
function dis(){
    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","loads/consultappoint-load?staffID=<?php echo $staffID;?>",false);
    xmlhttp.send(null);
    document.getElementById("appointment").innerHTML=xmlhttp.responseText;
}
    dis();

    setInterval(function(){
        dis();
    },1000);
</script>


<script>

        function transfer(val){
            // load the select option data into a div
                $('#loader').html("Please wait...");
                $('#transfer').load('loads/transfer.php?id='+val, function(){
                $('#loader').html("");
               });
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
