<?php
include "assets/core/connection.php";





$patientID=$_REQUEST['patientID'];
 //$patientID = filter_input(INPUT_POST, "patientID", FILTER_SANITIZE_STRING);
 //$labResults=filter_input(INPUT_POST, "labResults", FILTER_SANITIZE_STRING);


 
if(isset($_POST['lab_result'])){
 //$labResults=filter_input(INPUT_POST, "labResults", FILTER_SANITIZE_STRING);

// File upload path
$targetDir = "uploads/";
$fileName = basename($_FILES["labResults"]["name"]);
//$targetFilePath = $targetDir . $fileName;
$targetFilePath = "uploads";
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

// if(isset($_POST["lab_result"]) && !empty($_FILES["labResults"]["name"])){
    // Allow certain file formats
    $allowTypes = array('application','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["labResults"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = insert("INSERT INTO labresults(labResult) VALUES ('".$fileName."'");



}}}


?>



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
</head>
<body>

<?php include 'layout/head.php'; ?>
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li class="active"><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li><a href="lab-index.php"><i class="icon icon-filter"></i> <span>Laboratory</span></a></li>
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
                            <form action="#" method="post" class="form-horizontal">
                                <div class="span6">
                                    <div class="widget-content nopadding">
                                      <div class="control-group">
                                        <label class="control-label">Patient ID :</label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientID" id="patientID" value="<?php echo $patientID;  ?>" readonly/>
                                        </div>
                                      </div>
                                    <div class="control-group">
                                        <label class="control-label"> Lab Type :</label>
                                        <div class="controls">
                                            <textarea class="span11" name="healthVitals"></textarea>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                <div class="span6">
                                    <div class="widget-content nopadding">
                                      <div class="control-group">
                                        <label class="control-label">Patient Name :</label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientName"value=""readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Patient Lab Result :</label>
                                        <div class="controls">
                                          <input type="file" class="span11" name="labResults" accept="application/pdf" required/>
                                        </div>
                                          <div class="controls"></div>
                                      </div>
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
