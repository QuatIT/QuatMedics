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
</head>
<body>

<?php
    include 'layout/head.php';

    if($_SESSION['accessLevel']=='LABORATORY' || $_SESSION['username']=='rik'){

 $success = '';
 $error = '';

$patientID=$_REQUEST['patientID'];
$labRequestID=$_REQUEST['rID'];
//avoid undefined index msg


//extract patient name
$pat = select("SELECT * FROM patient WHERE centerID='".$_SESSION['centerID']."' && patientID='".$patientID."' ");
foreach($pat as $patname){}





//generate labResultID
//$labResultID = substr("donor",0,3);
$labResultID = mt_rand(0,99).mt_rand(101,998);
//$labResultID= $labResultID1;


if(isset($_POST['lab_result'])){

$patient_ID = filter_input(INPUT_POST, "patientID", FILTER_SANITIZE_STRING);
$labResults=filter_input(INPUT_POST, "labResults", FILTER_SANITIZE_STRING);



//fetching uder status 1=uploaded  0=pending


if(isset($_FILES['file'])){
	$file = $_FILES['file'];

	//file properties
	$file_name=$file['name'];
	$file_tmp=$file['tmp_name'];
	$file_size= $file['size'];
	$file_error = $file['error'];

	//etract extension
	$file_ext =explode('.',$file_name);
	$file_ext = strtolower(end($file_ext));
//	$allowed = array("pdf","doc","docx","png","jpg","jpeg","gif");
	$allowed = array('application','pdf');

	if(in_array($file_ext, $allowed)){
		if($file_error===0){
			if($file_size <= 4097152){

			 $file_name_new=uniqid('', true).'.'.$file_ext;
                  $file_destination = $LAB_RESULT_UPLOAD.$file_name_new;

			 	//check if file has been loaded earlier and move it from temporary location into folder
			 	if(move_uploaded_file($file_tmp,$file_destination)){
                    // echo $file_destination;
            $qry =update("UPDATE labresults SET labResult='$file_destination',status='".SENT_TO_CONSULTING."' WHERE labRequestID='".$labRequestID."' ");
//            $qry =insert("INSERT INTO labresults(labResultID,patientID,labResult,status)VALUES('$labResultID','".$patient_ID."','".$file_destination."','')");
            if($qry){

                $success = "<script>document.write('File Upload Successful');
                                window.location.href='lab-index'</script>";
            }
			 	}
			}

		}
	}
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
    <li><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"><a href="lab-index.php"><i class="icon icon-filter"></i> <span>Laboratory</span></a></li>
    <li> <a href="lab-bloodbank.php"><i class="icon icon-tint"></i> <span>Blood Bank</span></a> </li>
    </ul>
</div>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="laboratory" class="tip-bottom"><i class="icon-filter"></i> LABORATORY</a>
        <a title="Patient lab Result" class="tip-bottom"><i class="icon-user"></i> LAB RESULTS</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">PATIENT LAB RESULTS</h3>

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
          <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab1">Patient Lab Details</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="tab1" class="tab-pane active">
                            <form action="#" method="post" class="form-horizontal" enctype="multipart/form-data">
                                <div class="span6">
                                    <div class="widget-content nopadding">
                                      <div class="control-group">
                                        <label class="control-label">PATIENT ID :</label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientID" id="patientID" value="<?php echo $patientID;?>" readonly/>
                                        </div>
                                      </div>
									<div class="control-group">
                                        <label class="control-label">PATIENT NAME :</label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientName" value="<?php echo $patname['firstName'].' '.$patname['otherName'].' '.$patname['lastName']; ?>" readonly/>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                <div class="span6">
                                    <div class="widget-content nopadding">

										<table class="table table-stripped">
											<thead>
												<th>LAB NAME</th>
												<th>LAB RESULT UPLOAD</th>
											</thead>
											<tbody>
												<?php
												$ltest = select("SELECT * FROM labresults WHERE labRequestID='".$labRequestID."' ");
									foreach($ltest as $labtxt){
												?>
												<tr>
												<td>
													<select class="span11" name="labID[]">
								<?php
				   $labnam = select("SELECT labName FROM lablist WHERE labID='".$labtxt['labID']."' ");
										foreach($labnam as $labname){ ?>
											<option value="<?php echo $labtxt['labID'];?>"> <?php echo $labname['labName'];?></option>
														<?php }?>
													</select>
												</td>
												<td><input type="file" class="span11" name="file" accept="application/pdf" required/></td>
												</tr>
												<?php }?>
											</tbody>
										</table>
                                      <div class="form-actions">
                                          <i class="span1"></i>
                                        <button type="submit" class="btn btn-primary btn-block span10" name="lab_result" >Send Lab Results</button>
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
<script src="js/maruti.chat.js"></script>
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
</body>
</html>
<?php }else{echo "<script>window.location='404'</script>";}?>
