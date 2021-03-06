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
//    $pharmacy = new Pharmacy;
    //generate $PatientID
    $pharmacyIDs =count(select("SELECT * FROM pharmacy WHERE centerID='$centerID'")) + 1;

    $success = '';
    $error = '';

//    if(isset($_POST['btnSave'])){
//
//      $centerID = $_SESSION['centerID'];
//      $pharmacyID =  "PH.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$pharmacyIDs);
//      $pharmacyName =  filter_input(INPUT_POST, "pharmacyName", FILTER_SANITIZE_STRING);
////        $status = FREE;
//
//        $pharm = insert("INSERT INTO pharmacy(pharmacyID,pharmacyName,centerID,dateregistered) VALUES('$pharmacyID','$pharmacyName','$centerID',CURDATE())");
//
//        if($pharm){
//            $success = "PHARMACY CREATED";
//        }else{
//            $error = "PHARMACY CREATION FAILED";
//        }
//
//    }


if(isset($_POST['btnSave'])){
    $centerID = $_SESSION['centerID'];
    $numCon = count($_POST['pharmacyName']);
//    $status = FREE;

    if($numCon > 0){
            for($n=0; $n<$numCon; $n++){
                if($_POST['pharmacyName'][$n] != ''){
                    $pharmacyIDs =count(select("SELECT * FROM pharmacy WHERE centerID='$centerID'")) + 1;
                    $pharmacyID =  "PH.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$pharmacyIDs);
                    $pharmacyName = trim($_POST['pharmacyName'][$n]);
                    //check if test exits already..
                    $chk = select("SELECT * FROM pharmacy WHERE pharmacyName='$pharmacyName' AND centerID='$centerID'");
                    if($chk){
                        $error = "<script>document.write('PHARMACY ALREADY EXITS.');</script>";
                    }else{
                         $pharm = insert("INSERT INTO pharmacy(pharmacyID,pharmacyName,centerID,dateregistered) VALUES('$pharmacyID','$pharmacyName','$centerID',CURDATE())");
                        if($pharm){
                            $success = "<script>document.write('PHARMACY CREATED SUCCESSFULL');window.location.href='centerpharmacy-index';</script>";
                        }else{
                            $error = "<script>document.write('PHARMACY CREATION FAILED, TRY AGAIN');</script>";
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
        <li class=""> <a href="centerconsultation-index"><i class="icon-th-list"></i> <span>CONSULTATION</span></a> </li>
        <li class=""> <a href="centerward-index"><i class="icon-folder-close"></i> <span>WARD</span></a> </li>
        <li class=""> <a href="centerlab-index"> <i class="icon-search"></i> <span>LABORATORY</span></a> </li>
        <li class=""> <a href="centeruser-index"> <i class="icon-user"></i> <span>STAFF</span></a> </li>
        <li class="active"> <a href="centerpharmacy-index"> <i class="icon-plus-sign"></i> <span>PHARMACY</span></a> </li>
        <li class=""> <a href="center-account"> <i class="icon-list-alt"></i> <span>ACCOUNTS</span></a> </li>
        <li class=""> <a href="smsrequest-index"> <i class="icon-envelope"></i> <span>SMS REQUEST</span></a> </li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Department Management" class="tip-bottom"><i class="icon-plus-sign"></i> PHARMACY</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">PHARMACY MANAGEMENT</h3>
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
                    <li class="active"><a data-toggle="tab" href="#tab1">Pharmacies</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">

                    <form method="post" enctype="multipart/form-data">
                        <div class="span6">
<!--                          <div class="widget-content nopadding">-->
                               <table class="table table-bordered" id="dynamic_field">
							  <tr>
							  	<td colspan="2" style="height:10px;">
								  	<h4 class="text-center" style="height:10px;"> CREATE PHARMACY / DISPENSARY</h4>
								  </td>
							  </tr>
							<tr>
								<td>
									<input type="text" class="span11" name="pharmacyName[]" placeholder="Pharmacy / Dispensary Name" required/>
								</td>
								<td>
                                    <button type="button" name="add" id="add" class="btn btn-primary btn-block labell">ADD MORE</button>
                                </td>
							</tr>
						</table>
                              <div class="form-actions">
                                  <i class="span6"></i>
                                <button type="submit" name="btnSave" class="btn btn-primary labell btn-block span5"><i class="
                                    fa fa-save"></i> Save Pharmacy</button>
                              </div>
<!--                          </div>-->
                        </div>
                    </form>

                    <div class="span6">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5 class="labell">List Of Pharmacies</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead class="labell">
                            <tr>
                              <th>Pharmacy ID</th>
                              <th>Pharmacy Name</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="pharmacy"></tbody>
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
        xmlhttp.open("GET","loads/centerpharm-load.php",false);
        xmlhttp.send(null);
        document.getElementById("pharmacy").innerHTML=xmlhttp.responseText;
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
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" class="span11" name="pharmacyName[]" placeholder="Pharmacy / Dispensary Name" required/></td><td style="text-align:center;"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
</script>
</body>
</html>
