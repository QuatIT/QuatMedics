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
            background-color: #209fbf;
        }
    </style>
</head>
<body>

<?php
    include 'layout/head.php';


    $success = '';
    $error = '';

	$get_PID = $_GET['pid'];
	 $patient = select("SELECT * FROM emergency_patient WHERE patientID='".$_GET['pid']."' ORDER BY patientID ASC");
        foreach($patient as $pID){}

	$vit_sq = select("SELECT * FROM eme_vitals WHERE patientID='$get_PID' && emeID='".$_GET['emeid']."' ORDER BY id DESC LIMIT 1");
	foreach($vit_sq as $vitrow){}

//codes for the gallary creation..
if (isset($_POST['sub_mit'])){
    $medicine = count($_POST["medicine"]);
    $dosage = count($_POST["dosage"]);
	$medical_status = 'not attended to';
	$today_status = '0';

	$eme_medIDs = count(select("SELECT * FROM eme_ward GROUP BY eme_medID ")) + 1;
	$eme_medID = "EME.PRES.".sprintf('%06s',$eme_medIDs);

//    $search_sq = select("SELECT * FROM schedule_loan_detail_old WHERE loan_no='".$loan_no."' && branch_code='".$_SESSION['branch_code']."' ");
//    foreach($search_sq as $s_row){}


    //creating sequence number
//    $sq_no = @$s_row['sq_no'] + $sq;

    if($medicine > 0 && $dosage > 0 ) {
        for( $i=0 , $n=0; $i<$medicine , $n<$dosage; $i++ , $n++) {
                if(trim(htmlspecialchars($_POST['medicine'][$i] != ''))  && trim(htmlspecialchars($_POST['dosage'][$n] != '')) ) {

                    $medicine1 = trim(htmlspecialchars($_POST['medicine'][$i]));
                    $dosage1 = trim(htmlspecialchars($_POST['dosage'][$n]));



                $crtgal = insert("INSERT INTO eme_ward(eme_medID,dateRegistered,prescrib_med,dosage,prescribed_by,patientID,emeID,med_status,today_status,centerID) VALUES('$eme_medID',CURDATE(),'$medicine1','$dosage1','".$_SESSION['username']."','".$_GET['pid']."','".$_GET['emeid']."','$medical_status','$today_status','".$_SESSION['centerID']."') ");

           }
}

}

}

//	if(isset($_GET['id'])){rr
//
//		$med_status='administered';
//		$id=$_GET['id'];
//
//		$sqll = update("UPDATE eme_ward SET nurseID='".$_SESSION['username']."', med_status='".$med_status."' WHERE id='$id' ");
//		echo "<script>window.location.href='emergency-patient-treatment?emeid={$_GET['emeid']}&&pid={$_GET['pid']}'</script>";
//
//	}

    ?>

<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
<!--    <li><a href="medics-index"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>-->
<!--
    <li class="active"> <a href="opd-index"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
    <li> <a href="opd-patient?tab=opd-patient"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
    <li><a href="opd-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
-->
    </ul>
</div>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a href="opd-index.php" title="" class="tip-bottom"><i class="icon-plus"></i> EMERGENCY</a>
    </div>
  </div>
  <div class="container">
<!--      <h3 class="quick-actions">EMERGENCY</h3>-->
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
                    <li class="active"><a data-toggle="tab" href="#tab1">Patient Vitals</a></li>
                    <li><a data-toggle="tab" href="#tab5">Vitals (Graphical)</a></li>
                    <li><a data-toggle="tab" href="#tab2">Doctor's Prescription</a></li>
                    <li><a data-toggle="tab" href="#tab3">Nurse's Checklist</a></li>
                    <li><a data-toggle="tab" href="#tab4">Patient's Ward History</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <form action="" method="post" id="vitals" class="form-horizontal">
                    <div class="span6" id="vitals">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Patient :</label>
                               <div class="controls">
                                  <select name="patientID" id="patientId" class="selectpicker" onchange="pname(this.value);" readonly>
                                        <?php
                                        if(!empty($_GET['pid'])){
                                        ?>
                                        <option value="<?php echo $get_PID; ?>"><?php echo $get_PID; ?></option>
                                        <?php } ?>
                                   </select>
                                </div>
                              </div>

<!--
                              <div class="control-group">
                                <label class="control-label">Mode of Payment:</label>
                                <div class="controls">
                                  <select class="span11" name="mode" onchange="modey(this.value);">
                                        <option value=""></option>
                                        <option value="Private">Private</option>
                                        <option value="Insurance">Health Insurance</option>
                                        <option value="Company">Company</option>
                                    </select>
                                </div>
                              </div>
                             <span id="modeload"></span>
-->
                              <div class="control-group">
                                <label class="control-label">Body Temperature:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Body Temperature" value="<?php echo @$vitrow['bodyTemp']; ?>" name="bodytemp" readonly />
                                </div>
                              </div>
							   <div class="control-group">
                                <label class="control-label">Pulse Rate :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Pulse Rate" value="<?php echo @$vitrow['pulseRate']; ?>"  name="pulseRate" readonly/>
                                </div>
                              </div>


                              <div class="control-group">
                                <label class="control-label">Weight</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="weight" placeholder="Weight" value="<?php echo @$vitrow['weight']; ?>"  readonly />
                                </div>
                              </div>

<!--
                              <div class="control-group">
                                <label class="control-label">Other Health Details :</label>
                                <div class="controls">
                                    <textarea class="span11" name="otherHealth"></textarea>
                                </div>
                              </div>
-->
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">

                              <?php if(!empty($_GET['pid'])){ ?>
                               <div class="control-group">
                                <label class="control-label">Full Name :</label>
                                <div class="controls">
                                  <input type="text" required readonly value="<?php echo $pID['patientName']; ?>" id="FullName" class="span11" placeholder="Full name" name="FullName" />
                                </div>
                              </div>
                          <?php }else{echo '<span id="fname"></span>';} ?>

                              <div class="control-group">
                                <label class="control-label">Respiration Rate :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Respiration Rate" name="respirationRate" value="<?php echo @$vitrow['respirationRate']; ?>" readonly/>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Blood Pressure</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="bloodPressure" placeholder="Blood Pressure" value="<?php echo @$vitrow['bloodPressure']; ?>" readonly />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">As AT</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="" placeholder="AS AT TODAY" value="<?php echo @$vitrow['doe']; ?>" readonly />
                                </div>
                              </div>

<!--
                               <div class="control-group">
                                <label class="control-label">Assign Consulting Room</label>
                                <div class="controls">
                                  <select name="consultRoom">
                                    <option value="default"> -- Select Consulting Room --</option>
                                      <?php
//                                        $consultingroom = Consultation::find_consultingroom();
//                                        foreach($consultingroom as $roomRow){
                                      ?>
                                    <option value="<?php #echo $roomRow['roomID'];?>"> <?php #echo $roomRow['roomName'];?></option>
                                      <?php #}?>
                                  </select>
                                </div>
                                  <div class="controls"></div>
                              </div>
-->

                              <div class="form-actions">
                                  <i class="span1"></i>
                                <a href="emergency-vitals?emeid=<?php echo $_GET['emeid']; ?>&pid=<?php echo $_GET['pid']; ?>&tab=vitals" class="btn btn-primary btn-block span10">Register New Vitals</a>
                              </div>
                          </div>
                      </div>
                    </form>
                </div>


                <div id="tab5" class="tab-pane">
					<div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>Patient's Vitals (Graphical)</h5>
                      </div>
                      <div class="widget-content nopadding">

						 <div class="span6 container" id="temperature"></div>
						 <div class="span6" id="respiration"></div>

                      </div>
                      </div>
                      </div>


                <div id="tab2" class="tab-pane">
					<div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>Patient's Name</h5>
                      </div>
                      <div class="widget-content nopadding">
                    <form action="" method="post">
<!--                            <h3 class="text-primary">Create Cheque Schedule</h3>-->
                            <table border="0" class="" id="dynamic_field" style="margin-top:20px;">
                                <tr>

                                    <td>
										<label>Medicine / Prescription</label>
                                        <input type="text" name="medicine[]" placeholder="Medicine / Prescription" class="form-control">
                                    </td>
                                    <td>
										<label>Dosage</label>
                                        <input type="text" name="dosage[]" placeholder="Dosage" class="form-control">
                                    </td>
<!--
                                    <td>
                                        Repayment Amount
                                        <input type="text" name="amount[]" placeholder="Amount" class="form-control">
                                    </td>
                                    <td>
                                        Due Date
                                        <input type="date" name="chq_rdate[]" placeholder="Repayment Date" class="form-control" required>
                                    </td>
-->
                                    <td><br>
                                        <button type="button" name="add" id="add" class="btn btn-success">+</button>
                                    </td>
                                </tr>
                            </table>

                            <p class="text-left" style="margin-top: 20px;margin-left: 60px;"><input type="submit" class="btn btn-primary" name="sub_mit" id="sub_mit" value="Submit"></p>
                        </form>
                      </div>
                      </div>
                      </div>



                <div id="tab3" class="tab-pane">
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
                          <tbody id="emepatienttreat11"></tbody>
                        </table>
                      </div>
                    </div>

                      </div>




                <div id="tab4" class="tab-pane">
                     <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>Patient's History</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Date</th>
                              <th>Vitals</th>
                              <th>Prescription</th>
                              <th>Dosage</th>
                              <th>Prescibed By</th>
<!--                              <th>Status</th>-->
                              <th>Doctor's Comment</th>
                            </tr>
                          </thead>
                          <tbody id="emepatienttreathistory">

<?php
$load_newpatient = select("SELECT * FROM eme_ward WHERE centerID='".$_SESSION['centerID']."' && patientID='".$_GET['pid']."'  GROUP BY dateRegistered ORDER BY dateRegistered ASC");

foreach($load_newpatient as $newpatient){

?>


<tr>
  <td> <?php echo $newpatient['dateRegistered']; ?></td>
  <td>
	<?php
	  $em_vn = select("select * from eme_vitals where dateRegistered='".$newpatient['dateRegistered']."' ");
		foreach($em_vn as $emv_row){}
	  ?>
	<ol>
	  <li><b>Body Temperature: </b> <?php echo $emv_row['bodyTemp']; ?></li>
	  <li><b>Pulse Rate : </b> <?php echo $emv_row['pulseRate']; ?></li>
	  <li><b>Weight : </b> <?php echo $emv_row['weight']; ?></li>
	  <li><b>Respiration Rate : </b> <?php echo $emv_row['respirationRate']; ?></li>
	  <li><b>Blood Pressure : </b> <?php echo $emv_row['bloodPressure']; ?></li>
	  </ol>

	</td>
  <td>
	  <?php
		  $sql = select("SELECT * FROM eme_ward WHERE eme_medID='".$newpatient['eme_medID']."' ORDER BY dateRegistered ASC");

	  ?>
	  <ol>
		  <?php  foreach($sql as $srow){ ?>
		  <li><?php echo $srow['prescrib_med']; ?></li>
		  <?php } ?>
	  </ol>


	</td>
  <td>

	  <?php
		  $sqls = select("SELECT * FROM eme_ward WHERE eme_medID='".$newpatient['eme_medID']."' ORDER BY dateRegistered ASC");

	  ?>
	  <ol>
		  <?php  foreach($sqls as $srows){ ?>
		  <li>
			  <?php echo $srows['dosage']; ?> ( <?php if($srows['med_status']=="administered"){ ?> <span class='' style='color:green;'>administered</span> <?php }else{ ?><span class='' style='color:red;'>not administered</span> <?php } ?> )

		  </li>

		  <?php } ?>
	  </ol>



	</td>
<!--  <td> <?php #echo $newpatient['med_status']; ?></td>-->
  <td> <?php echo $newpatient['prescribed_by']; ?></td>
  <td> <?php if(empty($newpatient['doc_comment']) || $newpatient['doc_comment'] == 'NULL'){
		  echo "<form action='' method='post'><input type='text' name='comment".$newpatient['eme_medID']."' ><input type='submit' name='btncomment".$newpatient['eme_medID']."' class='btn btn-primary'></form> "; ?>

	  <?php

		  if(isset($_POST['btncomment'.$newpatient['eme_medID']])){
			  $cm = $_POST['comment'.$newpatient['eme_medID']];

			  $sqq = update("UPDATE eme_ward SET doc_comment='$cm' WHERE eme_medID='".$newpatient['eme_medID']."' ");
			  echo "<script>window.location.href='{$_SERVER['REQUEST_URI']}'</script>";
		  }

	  ?>


	  <?php }else{ echo $newpatient['doc_comment']; } ?></td>
</tr>

<?php } ?>


							</tbody>
                        </table>
                      </div>
                    </div>

                      </div>


<!--                </div>-->
            </div>

        </div>
      </div>
  </div>
</div>
<div class="row-fluid ">
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
<script src="js/highcharts.js"></script>
<!--<script src="js/maruti.js"></script> -->
<script>
  function newpatient(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/emenursechecklist.php?emeid=<?php echo $_GET['emeid']; ?>&&pid=<?php echo $_GET['pid']; ?>",false);
        xmlhttp.send(null);
        document.getElementById("emepatienttreat11").innerHTML=xmlhttp.responseText;
    }
        newpatient();

        setInterval(function(){
            newpatient();
        },3000);
    </script>

<!--
<script>
  function emehistory(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/emehistory.php?emeid=<?php echo $_GET['emeid']; ?>&&pid=<?php echo $_GET['pid']; ?>",false);
        xmlhttp.send(null);
        document.getElementById("emepatienttreathistory").innerHTML=xmlhttp.responseText;
    }
        emehistory();

        setInterval(function(){
            emehistory();
        },300000000000);
    </script>
-->

    <script>
    function emPat(val){
	// load the select option data into a div
        $('#loader').html("Please Wait...");
        $('#empatient').load('emepatient.php?id='+val, function(){
		$('#loader').html("");
       });
}
    </script>



        <script>
            //    $(document).ready(function(){
            var i = 1;
            $('#add').click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i + '"> <td><input type="text" name="medicine[]" placeholder="Medicine / Prescription" class="form-control"></td><td><input type="text" name="dosage[]" placeholder="Dosage" class="form-control"></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });

            //    });

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

