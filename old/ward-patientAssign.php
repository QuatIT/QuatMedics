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
    <style>
        .active{
            background-color: #209fbf;
        }
    </style>
    <style>
    #modal {
    position: fixed;
    font-family: Arial, Helvetica, sans-serif;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.8);
    z-index: 99997;
    height: 100%;
    width: 100%;
}
.modalconent {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    width: 20%;
    padding: 20px;
    z-index: 999999 !important;
}
    </style>
</head>
<body>
<?php

    include 'layout/head.php';

    if($_SESSION['accessLevel']=="CONSULTATION" || $_SESSION['accessLevel']=='WARD'){

        $patientID = $_GET['patid'];
        $wardID = $_GET['wrdno'];

        $get_patient = select("SELECT * FROM patient WHERE patientID='$patientID' ");
        foreach($get_patient as $pat){}

?>

<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
        <?php
        if($_SESSION['accessLevel']=='WARD'){ ?>
    <li> <a href="ward-index?wrdno=<?php echo $wardID;?>"><i class="icon icon-plus"></i> <span>Bed Management</span></a> </li>
        <?php } ?>
        <?php
            if($_SESSION['accessLevel']=='CONSULTATION'){
        ?>
    <li> <a href="consult-index"><i class="icon icon-briefcase"></i><span>Consultation</span></a> </li>
    <li> <a href="consult-appointment"><i class="icon icon-calendar"></i><span>Appointments</span></a> </li>
        <?php } ?>
    <li class="active"> <a href="ward-patient?wrdno=<?php echo $wardID;?>"><i class="icon icon-user"></i> <span>Patient Management</span></a></li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a href="ward-index?wrdno=<?php echo $wardID;?>" title="" class="tip-bottom"><i class="icon-plus"></i> WARD</a>
        <a href="ward-patient?wrdno=<?php echo $wardID;?>" title="" class="tip-bottom"><i class="icon-user"></i> WARD PATIENTS</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">WARD PATIENT MANAGEMENT</h3>

      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Assign Patient To Staff</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <form action="" method="post" class="form-horizontal">
                    <div class="span6">
                          <div class="widget-title">
                              <span class="icon"> <i class="icon-align-justify"></i> </span>
                                <h5>Patient Details</h5>
                          </div>
                          <div class="widget-content nopadding">
                             <div class="control-group">
                                <label class="control-label">Patient ID :</label>
                                <div class="controls">
                                  <input type="text" class="span11" value="<?php echo $pat['patientID']; ?>" name="patientID" readonly/>
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Patient Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" value="<?php echo $pat['firstName'].' '.$pat['otherName'].' '.$pat['lastName']; ?>" name="patientName" readonly/>
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-title">
                              <span class="icon"> <i class="icon-align-justify"></i> </span>
                                <h5>Assignment Details</h5>
                          </div>
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Assign To :</label>
                                <div class="controls">
                                    <select name="assignTo" onchange="staff_diff(this.value);">
                                        <option value=""> </option>
                                        <option value="Staff"> Staff </option>
                                        <option value="Consulting"> Consulting Room </option>
                                    </select>
                                </div>
                              </div>
<!--                              <span id="cde"></span>-->
                              <div class="control-group">
                                <label class="control-label"> Staff / Consulting Room :</label>
                                <div class="controls">
                                    <select name="assignTo" id="cde">
                                        <option value=""> </option>
<!--                                        <option value="option1" > Option 1 </option>-->
<!--                                        <option value="option2"> Option 2 </option>-->
                                    </select>
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="btnSave" class="btn btn-primary btn-block span10">Assign Patient</button>
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
<!--<script src="js/maruti.js"></script> -->



<script>
window.onload = function () {
    document.getElementById('button').onclick = function () {
        document.getElementById('modal').style.display = "none"
    };
};
</script>

    <script>
        function staff_diff(val){
            // load the select option data into a div
                $('#loader').html("Please Wait...");
                $('#cde').load('staff_diff.php?id='+val, function(){
                $('#loader').html("");
               });
        }
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
<?php }else{echo "<script>window.location='404'</script>";}?>
