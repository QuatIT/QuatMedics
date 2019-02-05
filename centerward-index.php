<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUATMEDIC ADMIN</title>
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
<link rel="icon" href="quatmedics.png" type="image/x-icon" style="width:50px;">
<style>
.active{
    background-color: #209fbf;
}
</style>
</head>
<body>


<?php
include 'layout/head.php';
$centerID = $_SESSION['centerID'];

//generate $PatientID
$ward = new Ward();
//    $wardIDs = $ward->find_num_ward($centerID) + 1;

$success = '';
$error = '';

if(isset($_POST['btnSave'])){
    $centerID = $_SESSION['centerID'];
    $numward = count($_POST['wardName']);
    $numbed = count($_POST['numOfBeds']);

//    $string1 = trim('emegency');
//    $string2 = trim('emergency ward');

    if(($numward > 0) && ($numbed > 0)){
            for($n=0,$b=0; $n<$numward,$b<$numbed; $n++,$b++){
                if(($_POST['wardName'][$n] != '') && ($_POST['numOfBeds'][$b] != '')){
                    $wardIDs = $ward->find_num_ward($centerID) + 1;
                    $WardID =  "WD.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$wardIDs);
                    $wardName = trim($_POST['wardName'][$n]);
                    $numOfBeds = trim($_POST['numOfBeds'][$b]);

                        //check if test exits already..
                        $chk = select("SELECT * FROM wardlist WHERE wardName='$wardName' AND centerID='$centerID'");
                        if($chk){
                            $error = "<script>document.write('WARD NAME ALREADY EXITS.');</script>";
                        }else{
                             $wardRoom = $ward->createWard($WardID,$centerID,$wardName,$numOfBeds);
                            if($wardRoom){
                                $success = "<script>document.write('WARD CREATED SUCCESSFULL');window.location.href='centerward-index';</script>";
                            }else{
                                $error = "<script>document.write('WARD CREATION FAILED, TRY AGAIN');</script>";
                            }
                        }
//                    }

                }else{
                    $error = "<script>document.write('EMPTY FIELDS.');</script>";
                }
            }
    }else{
        $error = "<script>document.write('NO WARD ENTERED.');</script>";
    }
}
//
//
//if(isset($_POST['btnSave'])){
//    $centerID = $_SESSION['centerID'];
//    $numward = count($_POST['wardName']);
//    $numbed = count($_POST['numOfBeds']);
//
//    $string1 = trim('emegency');
//    $string2 = trim('emergency ward');
//
//    if(($numward > 0) && ($numbed > 0)){
//            for($n=0,$b=0; $n<$numward,$b<$numbed; $n++,$b++){
//                if(($_POST['wardName'][$n] != '') && ($_POST['numOfBeds'][$b] != '')){
//                    $wardIDs = $ward->find_num_ward($centerID) + 1;
//                    $WardID =  "WD.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$wardIDs);
//                    $wardName = trim($_POST['wardName'][$n]);
//                    $numOfBeds = trim($_POST['numOfBeds'][$b]);
//
//                    if( (strcmp($string1,$wardName) != 0 ) || (strcasecmp($string2,$wardName) != 0)){
//                        $error = "<script>document.write('EMERGENCY MODULE ALREADY EXIST');</script>";
//                    }else{
//                        //check if test exits already..
//                        $chk = select("SELECT * FROM wardlist WHERE wardName='$wardName' AND centerID='$centerID'");
//                        if($chk){
//                            $error = "<script>document.write('WARD NAME ALREADY EXITS.');</script>";
//                        }else{
//                             $wardRoom = $ward->createWard($WardID,$centerID,$wardName,$numOfBeds);
//                            if($wardRoom){
//                                $success = "<script>document.write('WARD CREATED SUCCESSFULL');window.location.href='centerward-index';</script>";
//                            }else{
//                                $error = "<script>document.write('WARD CREATION FAILED, TRY AGAIN');</script>";
//                            }
//                        }
//                    }
//
//                }else{
//                    $error = "<script>document.write('EMPTY FIELDS.');</script>";
//                }
//            }
//    }else{
//        $error = "<script>document.write('NO WARD ENTERED.');</script>";
//    }
//}

    ?>

<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
        <li><a href="medics-index"><i class="icon icon-home"></i> <span>DASHBOARD</span></a> </li>
        <li class=""> <a href="centerconsultation-index"><i class="icon-th-list"></i> <span>CONSULTATION</span></a> </li>
        <li class="active"> <a href="centerward-index"><i class="icon-folder-close"></i> <span>WARD</span></a> </li>
        <li class=""> <a href="centerlab-index"> <i class="icon-search"></i> <span>LABORATORY</span></a> </li>
        <li class=""> <a href="centeruser-index"> <i class="icon-user"></i> <span>STAFF</span></a> </li>
        <li class=""> <a href="centerpharmacy-index"> <i class="icon-plus-sign"></i> <span>PHARMACY</span></a> </li>
        <li class=""> <a href="center-account"> <i class="icon-list-alt"></i> <span>ACCOUNTS</span></a> </li>
        <li class=""> <a href="smsrequest-index"> <i class="icon-envelope"></i> <span>SMS REQUEST</span></a> </li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Ward Management" class="tip-bottom"><i class="icon-folder-close"></i> WARD</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">WARD MANAGEMENT</h3>
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
                <ul class="nav nav-tabs labell">
                    <li class="active"><a data-toggle="tab" href="#tab1">Center Wards</a></li>
<!--                    <li><a data-toggle="tab" href="#tab2">Add New Ward</a></li>-->
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <form method="post" enctype="multipart/form-data" onsubmit="return confirm('CONFIRM SAVE.');">
                        <div class="span6">
                            <table class="table table-bordered" id="dynamic_field">
                                  <tr>
                                    <td colspan="2" style="height:10px;">
                                        <h4 class="text-center" style="height:10px;"> CREATE WARDS</h4>
                                      </td>
                                  </tr>
                                <tr class="labell">
                                    <th>Ward Name</th>
                                    <th>No. Of Beds</th>
                                    <th> Action</th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="span11" name="wardName[]" placeholder="Ward Name" required/>
                                    </td>
                                    <td>
                                        <input type="number" min="1" class="span11" name="numOfBeds[]" placeholder="Number Of Beds" required/>
                                    </td>
                                    <td>
                                        <button type="button" name="add" id="add" class="btn btn-primary btn-block labell">ADD WARD</button>
                                    </td>
                                </tr>
                            </table>
                            <div class="widget-content nopadding">
                              <div class="form-actions">
                                  <i class="span6"></i>
                                <button type="submit" name="btnSave" class="btn btn-primary labell btn-block span5"><i class="fa fa-save"></i> Save Ward</button>
                              </div>
                          </div>
                        </div>
                    </form>

                    <div class="span6">
                        <div class="widget-box" style="margin:0px;">
                          <div class="widget-title">
                             <span class="icon"><i class="icon-th"></i></span>
                            <h5 class="labell">List Of Ward</h5>
                          </div>
                          <div class="widget-content nopadding">
                            <table id="example" class="table table-bordered data-table">
                              <thead>
                                <tr class="labell">
<!--                                  <th>Ward ID</th>-->
                                  <th>Ward Name</th>
                                  <th>No. Of Beds</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                            <?php
                        $load_wardroom = select("SELECT * FROM wardlist WHERE centerID='".$_SESSION['centerID']."' ORDER BY centerID ASC");

                                foreach($load_wardroom as $ward){

                                ?>

                                <tr>
                                  <td> <?php echo $ward['wardName']; ?></td>
                                  <td> <?php echo $ward['numOfBeds']; ?></td>
                                  <td style="text-align: center;">
                                       <a href="updateward?wid=<?php echo $ward['wardID'];?>"> <span class="btn btn-info labell fa fa-edit"> Edit</span></a>
                                  </td>
                                </tr>

                                <?php  } ?>
                            </tbody>
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
<script src="js/bootstrap-colorpicker.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.uniform.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/maruti.js"></script>
<script src="js/maruti.tables.js"></script>
<script src="js/maruti.dashboard.js"></script>
<script src="js/maruti.chat.js"></script>
<script src="js/maruti.form_common.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<!--<script src="js/maruti.js"></script> -->

<!--

<script>
function ward_Room(){
    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","loads/wardroom-load.php",false);
    xmlhttp.send(null);
    document.getElementById("ward_room").innerHTML=xmlhttp.responseText;
}
    ward_Room();

    setInterval(function(){
        ward_Room();
    },3000);
</script>
-->

<script>
//    $(document).ready(function(){
        var i=1;
        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" class="span11" name="wardName[]" placeholder="Ward Name" required/></td><td><input type="number" min="1" class="span11" name="numOfBeds[]" placeholder="Number Of Beds" required/></td><td style="text-align:center;"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });

//$(document).ready(function() {
$('#example').DataTable({
"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
//});

</script>
</body>
</html>
