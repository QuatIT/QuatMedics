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

    $tab = $_GET['tab'];
    ?>
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
<!--    <li class="active"><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>-->
    <li> <a href="opd-index.php"><i class="icon icon-plus"></i> <span>New Patient</span></a> </li>
    <li class="active"> <a href="opd-patient.php"><i class="icon icon-user"></i> <span>Old Patient</span></a> </li>
    <li><a href="opd-appointment.php"><i class="icon icon-calendar"></i> <span>Appointments</span></a></li>
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
      <h3 class="quick-actions">OUT PATIENT DEPARTMENT</h3>

      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class=""><a data-toggle="tab" href="#tab1">Out Patient List</a></li>
<!--                    <li class="active"><a data-toggle="tab" href="#tab1">Out Patient List</a></li>-->
                    <li class="<?php echo $tab; ?>"><a data-toggle="tab" href="#tab2">Add Vitals </a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane ">
<!--                <div id="tab1" class="tab-pane active">-->
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>List Of Patients</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Patient ID</th>
                              <th>Patient Name</th>
                              <th>Mobile Number</th>
                              <th>Consulting Room</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>

                              <td>PNT-HSP001</td>
                              <td>Kofi Mensah Addo</td>
                              <td>0541524233</td>
                              <td style="text-align: center;"> Conssulting Room 1</td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                            <tr>
                              <td>PNT-HSP001</td>
                              <td>Kofi Mensah Addo</td>
                              <td>0541524233</td>
                              <td style="text-align: center;"> Conssulting Room 2</td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                            <tr>
                              <td>PNT-HSP001</td>
                              <td>Kofi Mensah Addo</td>
                              <td>0541524233</td>
                              <td style="text-align: center;"> Conssulting Room 4</td>
                              <td style="text-align: center;">
                                   <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane <?php echo $tab; ?>">
                    <form action="" method="post" id="vitals" class="form-horizontal">
                    <div class="span6" id="vitals">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Patient :</label>
                               <div class="controls">
                                  <select name="patientId" >
                                    <option value="default"> -- Select Patient ID --</option>
                                    <option value="patientId"> Patient ID 1 </option>
                                    <option value="patientId"> Patient ID 2 </option>
                                    <option value="patientId"> Patient DI 3 </option>
                                    <option value="patientId"> Patient DI 4 </option>
                                  </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Body Temperature:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Body Temperature" name="bodytemp" required />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Respiration Rate :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Respiration Rate" name="respirationRate" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Other Health Details :</label>
                                <div class="controls">
                                    <textarea class="span11" name="otherHealth"></textarea>
                                </div>
                              </div>
                               <div class="control-group">
                                <label class="control-label">Assign Consulting Room</label>
                                <div class="controls">
                                  <select name="consultRoom" >
                                    <option value="default"> -- Select Consulting Room --</option>
                                    <option value="consultRoom"> Consulting Room 1 Name</option>
                                    <option value="consultRoom"> Consulting Room 2 Name</option>
                                    <option value="consultRoom"> Consulting Room 3 Name</option>
                                    <option value="consultRoom"> Consulting Room 4 Name</option>
                                  </select>
                                </div>
                                   <div class="controls"></div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Full Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Full name" name="FullName" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Pulse Rate :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Pulse Rate" name="pulseRate" />
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Blood Pressure</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="bloodPressure" placeholder="Blood Pressure" required />
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Weight</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="weight" placeholder="Weight" required />
                                </div>
                                  <div class="controls"></div>
                              </div>

                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" class="btn btn-primary btn-block span10">Save Out Patient</button>
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
