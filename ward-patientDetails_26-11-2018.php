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
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .active{
/*            background-color: #209fbf;*/
        }
    </style>
</head>
<body>
<?php
//    include 'layout/head.php';
//    if($_SESSION['accessLevel']=='WARD' || $_SESSION['accessLevel']=='CONSULTATION'){
//    $patientID = $_GET['patid'];
//    $wardID = $_REQUEST['wrdno'];
//    $patient = Ward::find_by_wardPatient_id($patientID);
//    foreach($patient as $pat){}
////    echo "<script>alert('{$pat['patientID']}')</script>";
//    $pat_fxn = Patient::find_by_patient_id($patientID);
//    foreach($pat_fxn as $patDetails){}
//
//
////patient treatment
//
//    if(isset($_POST['saveTreatment'])){
//    $comments= filter_input(INPUT_POST,"comment",FILTER_SANITIZE_STRING);
//
//    // filter_input method is not helpful when it comes to textbox arrays
//    $dosage1="";
//    $dosage=($_POST['dosage']);
//    $treatment1 ="";
//    $treatment=($_POST['treatment']);
//
//    foreach($dosage as $dosages){
//      $dosage1.="$dosages.<br>";
//    }
//
//    foreach( $treatment as  $treatments){
//      $treatment1.="$treatments.<br>";
//    }
//        $p_treatment= insert("INSERT INTO review_tb(patientID,wardID,comments,treatment,dosage)VALUES('$patientID','$wardID','".$comments."','".$treatment1."','".$dosage1."')");
//
//
//
//    }
//
//
//    if(isset($_POST['saveReview'])){
//      $review = filter_input(INPUT_POST,"review",FILTER_SANITIZE_STRING);
//        $staff_ID = select("SELECT * FROM centeruser");
//        if($staff_ID){
//            foreach($staff_ID as $staff_IDs){}
//            $rev_iew = insert("INSERT INTO docreview_tb(WardID,PatientID,staffID,DocReview)VALUES('".$wardID."','".$patientID."','".$staff_IDs['staffID']."','".$review."')");
////            header('location:ward-index.php');
////            echo "<script>window.location.href='ward-patientDetails.php'</script>";
//}
//
//
//    }


     include 'layout/head.php';
     //include 'status_administered.php';

    if($_SESSION['accessLevel']=='WARD' || $_SESSION['accessLevel']=='CONSULTATION' || $_SESSION['username']=='rik'){
    $patientID = $_GET['patid'];
    $wardID = $_REQUEST['wrdno'];
        $wardc = new Ward;
        $patien = new Patient;
    $patient = $wardc->find_by_wardPatient_id($patientID);
    foreach($patient as $pat){}
//    echo "<script>alert('{$pat['patientID']}')</script>";
    $pat_fxn = $patien->find_by_patient_id($patientID);
    foreach($pat_fxn as $patDetails){}

//patient treatment

    if(isset($_POST['saveTreatment'])){
    $comments= filter_input(INPUT_POST,"comment",FILTER_SANITIZE_STRING);

    // filter_input method is not helpful when it comes to textbox arrays
    $dosage1="";
    $dosage=($_POST['dosage']);
    $treatment1 ="";
    $treatment=($_POST['treatment']);

    foreach($dosage as $dosages){
      $dosage1.="$dosages.<br>";
    }

    foreach( $treatment as  $treatments){
      $treatment1.="$treatments.<br>";
    }
        $p_treatment= insert("INSERT INTO review_tb(patientID,wardID,comments,treatment,dosage,dateInsert,status)VALUES('$patientID','$wardID','".$comments."','".$treatment1."','".$dosage1."',CURDATE(),'$status')");

    }

    if(isset($_POST['saveReview'])){

      $review = filter_input(INPUT_POST,"review",FILTER_SANITIZE_STRING);
$staff_ID = select("SELECT * FROM centeruser");
if($staff_ID){
    foreach($staff_ID as $staff_IDs){}

      $rev_iew= insert("INSERT INTO docreview_tb(WardID,PatientID,staffID,DocReview)VALUES('".$wardID."','".$patientID."','".$staff_IDs['staffID']."','".$review."')");
//          header('location:ward-index.php');
  }

}


//$_GET['patient'];
//$_GET['bedNumber'];
//$_GET['Admitted'];



// fetch vitals

$get_vit = select("SELECT * FROM ward_vitals WHERE patientID ='$patientID' ORDER BY id DESC LIMIT 1");

//NURSE CHECKLIST
$checklist=select("SELECT * FROM review_tb WHERE patientID = '$patientID'");


?>


<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li> <a href="ward-index"><i class="icon icon-plus"></i> <span>Bed Management</span></a> </li>
    <li class="active" style="background-color:#209fbf;"> <a href="ward-patient"><i class="icon icon-user"></i> <span>Patient Management</span></a></li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a href="ward-index" title="" class="tip-bottom"><i class="icon-plus"></i> WARD</a>
        <a href="ward-patient" title="" class="tip-bottom"><i class="icon-user"></i> WARD PATIENTS</a>
        <a href="#" title="" class="tip-bottom"><i class="icon-user"></i>PATIENTS ADMISSION</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">PATIENT MANAGEMENT</h3>

      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Patient Admission Details</a></li>
                 <?php if($_SESSION['accessLevel']=='WARD' || $_SESSION['accessLevel']=='CONSULTATION' || $_SESSION['username']=='rik'){ ?>

                  <li><a data-toggle="tab" href="#tab6">Vitals</a></li>
                  <li><a data-toggle="tab" href="#tab2">Patient Treatment</a></li>
                 <li><a data-toggle="tab" href="#tab5"> Nurse's Checklist</a></li>
                    <li><a data-toggle="tab" href="#tab3">Doctor's Remarks</a></li>
                    <li><a data-toggle="tab" href="#tab4">Treatment History</a></li><?php #} ?>
                </ul>
            </div>
                 <?php } ?>
<div class="widget-content tab-content">
                 <div id="tab1" class="tab-pane active">

                    <form action="#" method="post" class="form-horizontal">
                    <div class="span6">
                          <div class="widget-title">
                              <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Admission Details</h5>
                          </div>
                          <div class="widget-content nopadding">
                               <div class="control-group">
                                <label class="control-label">Patient : </label>
                                <div class="controls">
                                    <input type="text" value="<?php echo $patDetails['firstName'].' '.$patDetails['otherName'].' '.$patDetails['lastName']; ?>" name="patientName" class="span11" readonly>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Admission Date :</label>
                                <div class="controls">
                                    <input name="admitDate" value="<?php echo $pat['admitDate']; ?>" class="span11" type="text" readonly/>
                                </div>
                                  <div class="controls"></div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-title">
                          </div>
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Discharge Date :</label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $pat['dischargeDate']; ?>"  class="span11" name="dischargeDate" readonly />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Assign Nurse : </label>
                                <div class="controls">
                                  <input type="text" value="<?php echo $pat['staffID']; ?>"  name="AssignedNurse" class="span11" readonly>
                                    <br/>
                                    <br/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Description :</label>
                                <div class="controls">
                                    <textarea class="span11" name="description" readonly><?php echo $pat['admitDetails']; ?></textarea>
                                </div>
                                </div>
                                </div>
                    </form>
                </div>
             </div>




                <div id="tab6" class="tab-pane">
                    <form action="" method="post" id="vitals" class="form-horizontal">
                    <div class="span6" id="vitals">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Patient :</label>
                               <div class="controls">
                                  <input type="text" name="patientID" id="patientId" class="span11" value="<?php echo $patDetails['patientID'];?>"  readonly>

                                </div>
                              </div>
                              <?php
                              if(is_array($get_vit)){
                              foreach($get_vit as $get_vits){}}?>

                               <div class="control-group">
                                <label class="control-label">Body Temperature:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Body Temperature" value="<?php echo $get_vits['bodyTemp']; ?>" name="bodytemp" readonly />
                                </div>
                              </div>
                 <div class="control-group">
                                <label class="control-label">Pulse Rate :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Pulse Rate" value="<?php echo $get_vits['pulseRate']; ?>"  name="pulseRate" readonly/>
                                </div>
                              </div>


                              <div class="control-group">
                                <label class="control-label">Weight</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="weight" placeholder="Weight" value="<?php echo $get_vits['weight']; ?>"  readonly />
                                </div>
                              </div>

                              </div>
                          </div>

   <div class="span6">
                          <div class="widget-content nopadding">

                              <?php #if(!empty($_GET['pid'])){ ?>
                               <div class="control-group">
                                <label class="control-label">Full Name :</label>
                                <div class="controls">
                                  <input type="text" required readonly value="<?php echo $patDetails['firstName'].' '.$patDetails['otherName'].' '.$patDetails['lastName']; ?>" id="FullName" class="span11" placeholder="Full name" name="FullName"  />
                                </div>
                              </div>
                          <?php #}else{echo '<span id="fname"></span>';} ?>

                              <div class="control-group">
                                <label class="control-label">Respiration Rate :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Respiration Rate" name="respirationRate" value="<?php echo $get_vits['respirationRate']; ?>" readonly/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Blood Pressure</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="bloodPressure" placeholder="Blood Pressure" value="<?php echo $get_vits['bloodPressure']; ?>" readonly />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">As AT</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="" placeholder="AS AT TODAY" value="<?php echo $get_vits['dateRegistered']; ?>" readonly />
                                </div>
                              </div>


                              <div class="form-actions">
                                  <i class="span1"></i>
                                <a href="ward-vitals?patientID=<?php echo $patientID; ?>&tab=vitals" class="btn btn-primary btn-block span10">Register New Vitals</a>
                              </div>
  </div>
</div>

                            </form>
                </div>


                <div id="tab2" class="tab-pane">
                    <form action="#" method="post" id="add_name" class="form-horizontal">
                          <div class="widget-content nopadding">
                              <table class="table table-bordered" id="dynamic_field">
                                  <tr>
                                      <td colspan="2"><textarea style="width:100%;" placeholder="Comments" name="comment"></textarea></td>
                                  </tr>
                                <tr>
                                    <td><input type="text" name="treatment[]" placeholder="Treatment / Medicine" class="span11" required /></td>
                                    <td><input type="text" name="dosage[]" placeholder="Dosage / Details" class="span11" required /></td>
                                    <td><button type="button" name="add" id="add" class="btn btn-primary">Add Treatment</button></td>
                                </tr>
                            </table>
                              <div class="form-actions" style="padding-left:0px;padding-right:0px;">
                                  <i class="span9"></i>
                                <button type="submit" name="saveTreatment" class="btn btn-primary"> Save Treatment</button>
                              </div>
                          </div>
                    </form>
                </div>

 <div id="tab5" class="tab-pane">
                     <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>Patient's Name</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Prescription</th>
                              <th>Dosage</th>
                              <th>Prescibed By</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody >
                          <?php if(is_array($checklist)){ foreach($checklist as $checklists){?>
                            <tr>
                              <td><?php echo $checklists['dateInsert']; ?></td><td><?php echo $checklists['treatment']; ?><td><?php echo $checklists['dosage'];?></td><td></td>
                              <td><?php echo $checklists['status'];?></td>
                              <td><?php if($checklists['status']!='Administered'){ ?><a href="status_administered?rid=<?php echo $checklists['reviewID'];?>&patid=<?php echo $patientID;?>&wardID=<?php echo $_REQUEST['wrdno'];?>" > Administered</a><?php } ?></td>
                              <!-- hide administered link after click-->
                            </tr>
                          <?php }} ?>
                          </tbody>
                        </table>
                      </div>
                    </div>

                      </div>



                <div id="tab3" class="tab-pane">
                                  <form action="#" method="post" class="form-horizontal">
                    <div class="span12">
                          <div class="widget-title">
                              <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5> Doctor's Remarks</h5>
                          </div>
                          <div class="widget-content nopadding">
                               <div class="control-group">
                                <label class="control-label">Doctor's Remarks : </label>
                                <div class="controls">
                                    <textarea class="span12" rows="3" name="review" id="review"required></textarea>
                                </div>
                              </div>
                             <div class="form-actions">
                                  <i class="span8"></i>
                                <button type="submit" name="saveReview" class="btn btn-primary btn-block span4">Save Remarks</button>
                              </div>
                          </div>
                      </div>
                    </form>
                </div>
                <div id="tab4" class="tab-pane">
                    <div class="widget-box">
                      <div class="widget-title">
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th> Date & Time</th>
                              <th> Treatment</th>
                              <th> Details / Dosage</th>
                              <th> Recommendatiosn</th>
                              <th> Doctor's Review</th>

                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $report = select("SELECT * FROM review_tb");
                                foreach($report as $reports){
                                  $rev_iew = select("SELECT * FROM docreview_tb");
                                foreach($rev_iew as $rev_iews){}
                            echo "<tr>
                                <td>".$reports['doe']."</td>
                                <td>".$reports['treatment']."</td>
                                <td>".$reports['dosage']."</td>
                                <td>".$reports['comments']."</td>
                                <td>".$rev_iews['DocReview']."</td>
                              </tr>";
                              }?>

                      </tbody>
                        </table>
                    </div>
                    </div>






            </div>
        </div>
      </div>
  </div>
</div>
<div class="row-fluid navbar-fixed-bottom">
  <div id="footer" class="span12"> 2018 &copy; QUAT MEDICS ADMIN By  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a> </div>
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

<script>
//    $(document).ready(function(){
        var i=1;
        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="treatment[]" placeholder="Treatment / Medicine"  class="span11" /></td><td><input type="text" name="dosage[]" placeholder="Dosage / Details" class="span11" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });
        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//        $('#submit').click(function(){
//            $.ajax({
//                url:"name.php",
//                method:"POST",
//                data:$('#add_name').serialize(),
//                success:function(data)
//                {
//                    alert(data);
//                    $('#add_name')[0].reset();
//                }
//            });
//        });
//    });
</script>
</body>
</html>
<?php }else{echo "<script>window.location='404'</script>";}?>
