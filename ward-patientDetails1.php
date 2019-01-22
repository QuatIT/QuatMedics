<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUAT MEDICS ADMIN</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/colorpicker.css" />
<link rel="stylesheet" href="css/datepicker.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/maruti-style.css" />
<link rel="stylesheet" href="css/maruti-media.css" class="skin-color" />
<link rel="stylesheet" href="assets/css/font-awesome.css" />
<link rel="icon" href="quatmedics.png" type="image/x-icon" style="width:50px;">
    <style>
        .active{
/*            background-color: #209fbf;*/
        }
    </style>
</head>
<body>
<?php
    include 'layout/head.php';

    if($_SESSION['accessLevel']=='WARD'){
    $patientID = $_GET['patid'];
    $wardID = $_REQUEST['wrdno'];
    $patient = Ward::find_by_wardPatient_id($patientID);
    foreach($patient as $pat){}
//    echo "<script>alert('{$pat['patientID']}')</script>";
    $pat_fxn = Patient::find_by_patient_id($patientID);
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
        $p_treatment= insert("INSERT INTO review_tb(patientID,wardID,comments,treatment,dosage)VALUES('$patientID','$wardID','".$comments."','".$treatment1."','".$dosage1."')");

    }

    if(isset($_POST['saveReview'])){

      $review = filter_input(INPUT_POST,"review",FILTER_SANITIZE_STRING);
$staff_ID = select("SELECT * FROM centeruser");
if($staff_ID){
    foreach($staff_ID as $staff_IDs){}

      $rev_iew= insert("INSERT INTO docreview_tb(WardID,PatientID,staffID,DocReview)VALUES('".$wardID."','".$patientID."','".$staff_IDs['staffID']."','".$review."')");
          header('location:ward-index.php');
  }

}

    ?>
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
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
                    <li><a data-toggle="tab" href="#tab2">Patient Treatment</a></li>
                    <li><a data-toggle="tab" href="#tab3"> Doctor's Review</a></li>
                    <li><a data-toggle="tab" href="#tab4">Treatment History</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <form action="#" method="post" class="form-horizontal">
                    <div class="span6">
<!--                        <div class="widget-box">-->
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
                      </div>
                    </form>
                </div>
<!--            </div>-->
<!--            <hr/>-->
<!--            <div class="widget-content tab-content">-->
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
                                    <td><button type="button" name="add" id="add" class="btn btn-primary">Add Treatement</button></td>
                                </tr>
                            </table>
                              <div class="form-actions" style="padding-left:0px;padding-right:0px;">
                                  <i class="span9"></i>
                                <button type="submit" name="saveTreatment" class="btn btn-primary"> Save Treatement</button>
                              </div>
                          </div>
                    </form>
                </div>

                <div id="tab3" class="tab-pane">
                                  <form action="#" method="post" class="form-horizontal">
                    <div class="span12">
                          <div class="widget-title">
                              <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5> Doctor's Review</h5>
                          </div>
                          <div class="widget-content nopadding">
                               <div class="control-group">
                                <label class="control-label">Review : </label>
                                <div class="controls">
                                    <textarea class="span12" rows="3" name="review" id="review"required></textarea>
                                </div>
                              </div>
                             <div class="form-actions">
                                  <i class="span8"></i>
                                <button type="submit" name="saveReview" class="btn btn-primary btn-block span4">Save Review</button>
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
                              <th> Comments</th>

                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $report = select("SELECT * FROM review_tb");
                                foreach($report as $reports){
                            echo "<tr>
                                <td>".$reports['doe']."</td>
                                <td>".$reports['treatment']."</td>
                                <td>".$reports['dosage']."</td>
                                <td>".$reports['comments']."</td>
                              </tr>";
                              }?>

                      </div> </tbody>
                        </table>
                    </div>




                    <div id="tab4" class="tab-pane">
                    <div class="widget-box">
                      <div class="widget-title">
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr><th> Date & Time</th>
                              <th> Doctor's Review</th>
                          </tr>
                          </thead>
                          <tbody>
                            <?php
                            $rev_iew = select("SELECT * FROM docreview_tb");
                                foreach($rev_iew as $rev_iews){
                            echo "<tr>
                                <td>".$rev_iews['doe']."</td>
                                <td>".$rev_iews['DocReview']."</td>

                              </tr>";
                              }?>

                      </div> </tbody>
                        </table>
                    </div>





                      </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
  </div>
</div>
<div class="row-fluid ">
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
