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
    include 'layout/idhead.php';

    if(isset($_GET['pid'])){
        $patientID = $_GET['pid'];
        $sql = select("SELECT * from patient WHERE patientID='$patientID'");
        foreach($sql as $patientrow){}
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
    <li> <a href="opd-index"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
    <li class="active"> <a href="opd-patient?tab=opd-patient"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
    <li><a href="opd-appointment"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
    </ul>
</div>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Out Patient Department" class="tip-bottom"><i class="icon-plus"></i> OPD</a>
        <a title="Old Patients" class="tip-bottom"><i class="icon-user"></i> OPD OLD PATIENTS</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">PATIENT IDENTITY CARD</h3>

      <div class="row-fluid">
        <div class="widget-box">

            <div class="widget-content tab-content">

                <table class="table" width="100%" border="1" cellpadding="0" >
                    <tbody>
                        <tr class="text-center">
                        <td colspan="3">
                            <h4 class="text-center">
                                <span style="color:#1860c3;">QUAT</span>MEDIC | <span style="color:#49cced;"><?php echo $centerName['centerName']; ?></span>
                            </h4>
                        </td>
                        </tr>
                        <tr class="text-center">
                        <td colspan="3">
                            <h5 class="text-center"> PATIENT IDENTITY CARD</h5>
                        </td>
                        </tr>
                        <tr>
                            <td style="width:20%; text-align:center;" rowspan="5">
								<?php if(empty($patientrow['patient_image']) || $patientrow['patient_image']='null'){?>
								<span class="text-center"> No Photo</span>
								<?php }else{?>
								<img src="<?php echo $patientrow['patient_image'];?>" style="width:320px; height:200px;" />
								<?php }?>
							</td>
                            <td> ID Number : </td>
                            <td><?php echo $patientrow['patientID'];?></td>
                        </tr>
                        <tr>
                            <td> Name : </td>
                            <td><?php echo $patientrow['lastName']." ".$patientrow['firstName']." ".$patientrow['otherName'];?></td>
                        </tr>
                        <tr> <td> DOB : </td><td><?php echo $patientrow['dob'];?></td></tr>
                        <tr> <td> Gender : </td><td><?php echo $patientrow['gender'];?></td></tr>
                        <tr> <td> Phone : </td><td><?php echo $patientrow['phoneNumber'];?></td></tr>
                    </tbody>
                </table>

<!--                <div id="tab1" class="tab-pane active">-->
                    <form action="#" method="post" class="form-horizontal">
                    <div class="span12">
                          <div class="widget-content nopadding">
                              <div class="form-actions">
                                  <i class="span8"></i>
                                  <a href="id-card-print?pid=<?php echo $patientrow['patientID'];?>" target="_blank" class="btn btn-primary btn-block span4"><i class="fa fa-print"></i> PRINT CARD</a>
<!--                                <button type="submit" class="btn btn-primary btn-block span4">  <i class="fa fa-print"></i></button>-->
                              </div>
                          </div>
                      </div>

                    </form>
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
</body>
</html>
