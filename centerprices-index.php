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
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style>
.active{
    background-color: #209fbf;
}
</style>
</head>
<body>

<?php
    include 'layout/head.php';

    $consultation = new Consultation;
    //generate $PatientID
    $consultRoomIDs = $consultation->loadConsultRoom() + 1;

    $success = '';
    $error = '';

    if(isset($_POST['btnSave'])){

      $centerID = $_SESSION['centerID'];
      $consultRoomID = "CR-".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$consultRoomIDs);
      $roomName = filter_input(INPUT_POST, "departmentName", FILTER_SANITIZE_STRING);
        $status = FREE;

        $consultRoom = $consultation->createConsultRoom($consultRoomID,$centerID,$roomName,$status);

        if($consultRoom){
            $success = "CONSULTING ROOM CREATED";
        }else{
            $error = "CONSULTING ROOM FAILED";
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
    <li class="active"><a href="centerprices-index"><i class="icon icon-list-alt"></i> <span>Charge Management</span></a> </li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="PRICING" class="tip-bottom"><i class="icon-tasks"></i> PRICING</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">SERVICES CHARGES</h3>

      <div class="row-fluid">
        <div class="widget-box">
<!--
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Patient List</a></li>
                </ul>
            </div>
-->


            <div class="widget-content tab-content">
				<div class="span6">
                    <form action="#" method="post" class="form-horizontal">

						  <table class="table table-bordered" id="dynamic_field2">
							  <tr>
							  	<td colspan="3" style="height:10px;">
								  	<h4 class="text-center" style="height:10px;"> SERVICE PRICING</h4>
								  </td>
							  </tr>
							<tr>
								<td>
									<select class="span" name="ServiceName[]">
										<option value="CONSULATION">CONSULTATION</option>
										<option value="OPD">OUT PATIENT(OPD)</option>
									</select>
								</td>
								<td><input type="number" min="1" name="servicePrice[]" placeholder="Price" class="span11" required /></td>
								<td><button type="button" name="add" id="add2" class="btn btn-primary">Add Service</button></td>
							</tr>
						</table>
						  <div class="form-actions">
							  <i class="span5"></i>
							  <button type="submit" name="saveServiceprices" class="btn btn-primary btn-block span6"> Save Prices</button>
						  </div>

              </form>
			</div>

				<div class="span6">
                    <form action="#" method="post" class="form-horizontal">
						  <table class="table table-bordered" id="dynamic_field">
							  <tr>
							  	<td colspan="3" style="height:10px;">
								  	<h4 class="text-center" style="height:10px;"> LAB PRICING</h4>
								  </td>
							  </tr>
							<tr>
								<td>
									<select class="span" name="ServiceName[]">
										<?php
											$lablist = select("SELECT * FROM lablist");
										if($lablist){
											foreach($lablist as $labRow){
										?>
										<option value="<?php echo $labRow['labID']?>"><?php echo $labRow['labName'];?></option>
										<?php }}?>
									</select>
								</td>
								<td><input type="number" min="1" name="servicePrice[]" placeholder="Price" class="span11" required/></td>
								<td><button type="button" name="add" id="add" class="btn btn-primary">Add Service</button></td>
							</tr>
						</table>
						  <div class="form-actions">
							  <i class="span5"></i>
							  <button type="submit" name="saveLabPrices" class="btn btn-primary btn-block span6"> Save Prices</button>
						  </div>

              	</form>
				</div>
			</div>
		  </div>
	  </div>
    </div>
</div>
<div class="row-fluid">
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
        $('#add2').click(function(){
            i++;
            $('#dynamic_field2').append('<tr id="row'+i+'"><td><select class="span" name="serviceName[]"><option value="CONSULTAION">CONSULTAION</option><option value="OPD">OUT PATIENT(OPD)</option></select></td><td><input type="number" min="1"  name="servicePrice[]" placeholder="Price" class="span11" required /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
</script>

<script>
//    $(document).ready(function(){
        var i=1;
        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'"><td><select class="span" name="ServiceName[]"><?php $lablist = select("SELECT * FROM lablist");if($lablist){foreach($lablist as $labRow){?><option value="<?php echo $labRow['labID']?>"><?php echo $labRow['labName'];?></option><?php }}?></select></td><td><input type="number" min="1" name="servicePrice[]" placeholder="Price" class="span11" required /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
</script>
</body>
</html>
