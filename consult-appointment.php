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

<?php include 'layout/head.php'; ?>

<div id="search">
  <input type="text" placeholder="Search here..." disabled/>
  <button type="submit" class="tip-left" title="Search" disabled><i class="icon-search icon-white"></i></button>
</div>

<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li> <a href="consult-index.php"><i class="icon icon-briefcase"></i> <span>Consultation</span></a> </li>
    <li class="active"> <a href="consult-appointment.php"><i class="icon icon-calendar"></i> <span>Appointments</span></a> </li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a href="consult-index.php" title="Consultation" class="tip-bottom"><i class="icon-briefcase"></i> CONSULTATION</a>
        <a href="consult-appointment.php" title="Consultation" class="tip-bottom"><i class="icon-calendar"></i> APPOINTMENTS</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">CONSULTATION APPOINTMENTS</h3>

      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Appointment List</a></li>
                    <li><a data-toggle="tab" href="#tab2">Add New Appointment</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>List Of Doctors Appointment</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Photo</th>
                              <th>Patient Number</th>
                              <th>Patient Name</th>
                              <th>Mobile Number</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Photo</td>
                              <td>PNT-HSP001</td>
                              <td>Kofi Mensah Addo</td>
                              <td>0541524233</td>
                              <td style="text-align: center;"><span class="btn btn-primary btn-block btn-mini">Status</span></td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                            <tr>
                              <td>Photo</td>
                              <td>PNT-HSP001</td>
                              <td>Kofi Mensah Addo</td>
                              <td>0541524233</td>
                              <td style="text-align: center;"><span class="btn btn-primary btn-block btn-mini">Status</span></td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                            <tr>
                              <td>Photo</td>
                              <td>PNT-HSP001</td>
                              <td>Kofi Mensah Addo</td>
                              <td>0541524233</td>
                              <td style="text-align: center;"><span class="btn btn-primary btn-block btn-mini">Status</span></td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <form action="#" method="post" class="form-horizontal">
                    <div class="span6">
<!--                        <div class="widget-box">-->
                          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                            <h5>Make Appointment</h5>
                          </div>
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Appointment Date :</label>
                                <div class="controls">
                                  <input type="date" class="span11" name="appointmentDate" required/>
                                </div>
                              </div>
                             <div class="control-group">
                                <label class="control-label">Assign Doctor :</label>
                                <div class="controls">
                                  <select name="bloodGroup" class="" >
                                    <option value="default"> -- Select Doctor --</option>
                                    <option value="doctorName"> Doctor Name</option>
                                    <option value="doctorName"> Doctor Name</option>
                                    <option value="doctorName"> Doctor Name</option>
                                    <option value="doctorName"> Doctor Name</option>
                                  </select>
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-title">
<!--                              <span class="icon"> <i class="icon-align-justify"></i> </span>-->
<!--                            <h5>Make Appointment</h5>-->
                          </div>
                          <div class="widget-content nopadding">
                             <div class="control-group">
                                <label class="control-label">Patient :</label>
                                <div class="controls">
                                  <select name="bloodGroup" class="" >
                                    <option value="default"> -- Select Patient --</option>
                                    <option value="patientID"> Patient Name</option>
                                    <option value="patientID"> Patient Name</option>
                                    <option value="patientID"> Patient Name</option>
                                    <option value="patientID"> Patient Name</option>
                                  </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Send SMS :</label>
                                <div class="controls">
                                  <label>
                                    <input type="checkbox" name="radios" />
                                </label>
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" class="btn btn-primary btn-block span10">Save Appointment</button>
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
