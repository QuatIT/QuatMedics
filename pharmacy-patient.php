<?php
require "assets/core/connection.php";
 $_GET['patientID'] ;


 // $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
 //    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);


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
    <style>
        .active{
            background-color: #209fbf;
        }

        .text-danger{
            color: #e01e1e;
        }

        label{
            display: inline;
        }
    </style>
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
<!--    <li class="active"><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>-->
    <li class="active"> <a href="pharmacy-index.php"><i class="icon icon-briefcase"></i> <span>Pharmacy</span></a> </li>
    </ul>
</div>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Pharmacy Home" class="tip-bottom"><i class="icon-briefcase"></i> PHARMACY</a>
        <a title="Patient Prescriptions" class="tip-bottom"><i class="icon-briefcase"></i> PATIENT PRESCRIPTION</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">PATIENT PRESCRIPTION</h3>

      <div class="row-fluid">
          <div class="span6">
<!--                <div class="widget-box">-->
<!--
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab1"></a></li>
                        </ul>
                    </div>
-->
<!--                    <div class="widget-content tab-content">-->
<!--                        <div id="tab1" class="tab-pane active">-->
                            <form action="#" method="post" class="form-horizontal">
                                <div class="span12">
                                    <div class="widget-box">

                                    <div class="widget-title">
                                         <span class="icon"><i class="icon-th"></i></span>
                                        <h5>Prescription Details</h5>
                                      </div>
                                    <div class="widget-content nopadding">
                                    <div class="control-group">
                                        <label class="control-label"> Consulting Room :</label>
                                        <div class="controls">
                                            <input type="text" name="consultingRoom" class="span11" value="Consulting Room 1" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Patient ID :</label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientID" value="<?php echo $_GET['patientID']?>" readonly/>
                                        </div>
                                      </div>
                                        <div class="control-group">
                                        <label class="control-label">Patient Name :</label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientName" value="Patient Name" readonly/>
                                        </div>
                                      </div>
                                        <div class="control-group">
                                        <label class="control-label"> Doctor Name :</label>
                                        <div class="controls">
                                            <input type="text" name="doctorName" class="span11" value="Mr Doctor" readonly/>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                </div>
                            </form>
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
          </div>

          <div class="span6">
              <div class="widget-content">
                  <form>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Number</th>
                          <th>Medicine</th>
                          <th>Dosage</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                          <?php
                            $pharm_pre=select("SELECT * FROM prescriptions");
                            foreach($pharm_pre as $pharm_pres){

                              echo  "<tr>
                          <td>'".$pharm_pres['prescribeID']."'</td>
                          <td> '".$pharm_pres['prescription']."'</td>
                          <td>'".$pharm_pres['prescribeStatus']."'</td>
                          <td style='text-align:center;'>
                              <label><input type='radio' name='medstat1' value='YES'> <i class='fa fa-check-circle fa-lg text-success'></i></label>
                              <label><input type='radio' name='medstat1' value='NO'> <i class='fa fa-times-circle fa-lg text-danger'></i></label>
                          </td>
                        </tr>";
                    }?>
                      </tbody>
                    </table>
                      <div class="control-group">
                        <div class="controls">
                            <textarea class="span12" rows="5" placeholder="Notes On Prescription"></textarea>
                        </div>
                      </div>

                      <div class="form-actions">
                          <i class="span6"></i>
                        <button type="submit" class="btn btn-primary btn-block span6">Save</button>
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
