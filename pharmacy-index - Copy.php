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

    if($_SESSION['accessLevel']=='PHARMACY'){

        $get_pharm= select("SELECT * FROM patient");

    ?>
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"> <a href="pharmacy-index.php"><i class="icon icon-briefcase"></i> <span>Pharmacy</span></a> </li>
<!--    <li> <a href="consult-appointment.php"><i class="icon icon-calendar"></i> <span>Appointments</span></a> </li>-->
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Pharmacy Home" class="tip-bottom"><i class="icon-briefcase"></i> PHARMACY</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">PATIENT PRESCRIPTION LIST</h3>

          <div class="row-fluid">
             <div class="widget-box">
                  <div class="widget-title">
                  </div>
                  <div class="widget-content">
                    <table class="table table-bordered data-table">
                      <thead>
                        <tr>
                          <th>Patient Number</th>
                          <th>Patient Name</th>
                          <th>Doctor Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      
                          <?php
                         
                            foreach($get_pharm as $get_pharms){

                          echo"<tr>
                          <td>".$get_pharms['patientID']."</td>
                          <td>".$get_pharms['firstName']." ".$get_pharms['otherName']." ".$get_pharms['lastName']."</td>
                          <td>--------</td>
                          <td style='text-align: center;'>
                               <a href='pharmacy-patient.php?patientID=".$get_pharms['patientID']."'><span class='btn btn-primary fa fa-eye'></span></a>
                          </td>
                        </tr>";
                      }?>
                      </tbody>
                    </table>
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
