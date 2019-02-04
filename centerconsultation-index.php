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
<link rel="stylesheet" href="assets/css/font-awesome2.css" />
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
    $consultation = new Consultation();
    //generate $PatientID
//    $consultRoomIDs = $consultation->loadConsultRoomByidd($centerID)+ 1;

    $success = '';
    $error = '';
if(isset($_POST['saveCon'])){
    $centerID = $_SESSION['centerID'];
    $numCon = count($_POST['consultName']);
    $status = FREE;

    if($numCon > 0){
            for($n=0; $n<$numCon; $n++){
                if($_POST['consultName'][$n] != ''){
                    $consultRoomIDs = $consultation->loadConsultRoomByidd($centerID)+ 1;
                    $consultRoomID =  "CR.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$consultRoomIDs);
                    $consultName = trim($_POST['consultName'][$n]);
                    //check if test exits already..
                    $chk = select("SELECT * FROM consultingroom WHERE roomName='$consultName' AND centerID='$centerID'");
                    if($chk){
                        $error = "<script>document.write('CONSULTING ROOM ALREADY EXITS.');</script>";
                    }else{
                        $wardsql = $consultation->createConsultRoom($consultRoomID,$centerID,$consultName,$status);
                        if($wardsql){
                            $success = "<script>document.write('CONSULTING ROOM CREATED SUCCESSFULL');window.location.href='centerconsultation-index';</script>";
                        }else{
                            $error = "<script>document.write('CONSULTING ROOM CREATION FAILED, TRY AGAIN');</script>";
                        }
                    }
                }else{
                    $error = "<script>document.write('EMPTY FIELD.');</script>";
                }
            }
    }else{
        $error = "<script>document.write('NO CONSULTING ROOM ENTERED.');</script>";
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
        <li><a href="medics-index"><i class="icon icon-home"></i> <span>DASHBOARD</span></a> </li>
        <li class="active"> <a href="centerconsultation-index"><i class="icon-th-list"></i> <span>CONSULTATION</span></a> </li>
        <li class=""> <a href="centerward-index"><i class="icon-folder-close"></i> <span>WARD</span></a> </li>
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
        <a title="Department Management" class="tip-bottom"><i class="icon-tasks"></i> CONSULTATION</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">CONSULTATION MANAGEMENT</h3>
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
                    <li class="active"><a data-toggle="tab" href="#tab1">Consultation Rooms</a></li>
<!--                    <li><a data-toggle="tab" href="#tab2">Add New Consulting Room</a></li>-->
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <form method="post" enctype="multipart/form-data" onsubmit="return confirm('CONFIRM SAVE.');">
                        <div class="span6">
                            <table class="table table-bordered" id="dynamic_field">
							  <tr>
							  	<td colspan="2" style="height:10px;">
								  	<h4 class="text-center" style="height:10px;"> CREATE CONSULTING ROOMS</h4>
								  </td>
							  </tr>
							<tr>
								<td>
									<input type="text" class="span11" name="consultName[]" placeholder="Room Name" required/>
								</td>
								<td>
                                    <button type="button" name="add" id="add" class="btn btn-primary btn-block labell">ADD ROOM</button>
                                </td>
							</tr>
						</table>
                          <div class="form-actions">
                              <i class="span6"></i>
                            <button type="submit" name="saveCon" class="btn btn-primary labell btn-block span5"><i class="
                                fa fa-save"></i> Save Room</button>
                          </div>

                        </div>
                    </form>

                    <div class="span6">
                        <div class="widget-box">
                          <div class="widget-title">
                             <span class="icon"><i class="icon-th"></i></span>
                            <h5 class="labell">List Of Consulting Rooms</h5>
                          </div>
                          <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                              <thead>
                                <tr class="labell">
                                  <th>Consulting Room ID</th>
                                  <th>Consulting Room Name</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody id="consultroom"></tbody>
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

    <script>
  function consult_Room(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/consultroom-load.php",false);
        xmlhttp.send(null);
        document.getElementById("consultroom").innerHTML=xmlhttp.responseText;
    }
        consult_Room();

        setInterval(function(){
            consult_Room();
        },3000);
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
<script>
//    $(document).ready(function(){
        var i=1;
        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" class="span11" name="consultName[]" placeholder="Room Name" required/></td><td style="text-align:center;"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
</script>
</body>
</html>
