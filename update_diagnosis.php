<?php session_start(); ?>
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
<link rel="stylesheet" href="css/colorpicker.css" />
<link rel="stylesheet" href="css/datepicker.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/maruti-style.css" />
<link rel="stylesheet" href="css/maruti-media.css" class="skin-color" />
<link rel="stylesheet" href="assets/css/font-awesome2.css" />
<link rel="icon" href="quatmedics.png" type="image/x-icon" style="width:50px;">
    <style>
        table thead tr td{font-weight: bolder;}
    </style>
</head>
<body>

<?php
	include 'layout/head.php';

	$id = $_GET['id'];
	$pid = $_GET['pid'];
  $claim_date = $_GET['dinst'];
  $insurance = $_GET['insurance'];

  $success='';
  $error='';

    $count = 1;


    //fetch nhis clients from consultation
    $diagnosis_sql = select("select * from diagnose_tb where id='$id' && patientID='$pid' && centerID='".$_SESSION['centerID']."' ");
    foreach ($diagnosis_sql as $diagnosis_row) {}

    if(isset($_POST['btnUpdate'])){

      $diagnosis = $_POST['diagnosis'];
      $icd = $_POST['icd'];
      $gdrg = $_POST['gdrg'];

      $update_nhis = update("update diagnose_tb set diagnosis='$diagnosis' , icd10='$icd' , gdrg='$gdrg' where id='$id' ");

      if($update_nhis){
        $success =  "<script>document.write('DIAGNOSIS UPDATED SUCCESSFULLY')
                      window.location.href='claimform?pid={$pid}&insurance={$insurance}&dinst={$claim_date}'</script>";
      }else{
        $error = "DIAGNOSIS UPDATE FAILED";
      }

    }

	?>

<!-- <div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div> -->

<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
<!--    <li class="active"><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>-->
<!--
    <li> <a href="opd-index.php"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
    <li> <a href="opd-patient.php"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
    <li><a href="opd-appointment.php"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
-->
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
<!--
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="" class="tip-bottom"><i class="icon-plus"></i> OPD</a>
        <a title="" class="tip-bottom"><i class="icon-plus"></i> PATIENT INFORMATION</a>
-->
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">CLAIM FORM (NHIS)</h3>

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
<!--
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Patient List</a></li>
                </ul>
            </div>
-->
            <div class="widget-content tab-content" style="">

				<div class="container row">
                    <form action="" method="post">
                        <div class="span3" style="padding-left:20px">
                            <label>Diagnosis</label>
                                <input class="form-control span11" type="text" autofocus value="<?php echo $diagnosis_row['diagnosis']; ?>" name="diagnosis" onblur="diagno(this.value);">
                            </div>
                        <div class="span3">

                            <label>ICD-10</label>
                                <select class="form-control span11" id="diagn" name="icd">
                                  <option></option>

                                </select>

                            </div>
                        <div class="span3">

                            <label>G-DRG</label>
                                <input class="form-control" type="text" name="gdrg" value="<?php echo $diagnosis_row['gdrg']; ?>">
                            </div>
                        <div class="span10 text-center">

                            <label>&nbsp;</label>
                                <input class="btn btn-primary" type="submit" name="btnUpdate" value="Update">
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

        function diagno(val){
            // load the select option data into a div
                $('#loader').html("Please Wait...");
                $('#diagn').load('loads/diagnosis.php?id='+val, function(){
                $('#loader').html("");
               });
        }

</script>


<script>
//    $(document).ready(function(){
        var i=1;
        $('#add2').click(function(){
            i++;
            $('#dynamic_field2').append('<tr id="row'+i+'"><td><select class="span" name="serviceType"><option value="Service">Service</option><option value="Lab"> Lab Test</option></select></td><td><input type="text" name="ServiceName[]" placeholder="Service or Lab Name" class="span11" required /></td><td><input type="text" name="servicePrice[]" placeholder="Price" class="span11" required /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
</script>
</body>
</html>
