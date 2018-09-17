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
<!--
    <style>
        .active{
            background-color: #209fbf;
        }
    </style>
-->
</head>
<body>


<?php
include 'layout/head.php';

    $conid = $_GET['conid'];

    $consultdet = select("SELECT * from consultation WHERE consultID='$conid'");
    foreach($consultdet as $consultrow){
           $patientID = $consultrow['patientID'];
        $fetchpatient = select("SELECT firstName,lastName,otherName from patient WHERE patientID='$patientID'");
        foreach($fetchpatient as $ptndetails){
            $name = $ptndetails['firstName']." ".$ptndetails['otherName']." ".$ptndetails['lastName'];
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
<!--    <li class="active"><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>-->
    <li class="active" style="background-color: #209fbf;"> <a href="consult-index.php"><i class="icon icon-briefcase"></i> <span>Consultation</span></a> </li>
    <li> <a href="consult-appointment.php"><i class="icon icon-calendar"></i> <span>Appointments</span></a> </li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="medics-index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="consult-index.php" title="Consultation" class="tip-bottom"><i class="icon-briefcase"></i> CONSULTATION</a>
        <a href="consult-patient.php" title="Consultation" class="tip-bottom"><i class="icon-user"></i> CONSULTATION ROOM</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">CONSULTATION ROOM</h3>

      <div class="row-fluid">
          <div class="span6">
                <div class="widget-box">
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab1">Patient Health Details</a></li>
                            <li><a data-toggle="tab" href="#tab2"> Request Lab</a></li>
                            <li><a data-toggle="tab" href="#tab3"> Admit To Ward</a></li>
                            <li><a data-toggle="tab" href="#tab4"> Prescribe Medication</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="tab1" class="tab-pane active">
                            <form action="#" method="post" class="form-horizontal">
                                  <div class="widget-content">
                                      <div class="control-group">
                                        <label class="control-label">Patient ID :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="patientID" value="<?php echo $patientID;?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Patient Name :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="patientName" value="<?php echo $name;?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Body Temperature :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="bodyTemp" value="<?php echo $consultrow['bodyTemperature'];?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Pulse Rate :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="bloodPressure" value="<?php echo $consultrow['pulseRate'];?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Respiration Rate :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="respirationRate" value="<?php echo $consultrow['respirationRate'];?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Blood Pressure :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="bloodPressure" value="<?php echo $consultrow['bloodPressure'];?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Weight :</label>
                                        <div class="controls">
                                          <input type="text" class="span12" name="weight" value="<?php echo $consultrow['weight'];?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Other Health Vitals :</label>
                                        <div class="controls">
                                            <textarea class="span12" name="healthVitals" readonly><?php echo $consultrow['otherHealth'];?></textarea>
                                        </div>
                                      </div>
                                  </div>
                            </form>
                        </div>
                        <div id="tab2" class="tab-pane">
                             <form action="#" method="post" class="form-horizontal">
                                  <div class="widget-content nopadding">
                                    <div class="control-group">
                                        <label class="control-label">Request lab</label>
                                        <div class="controls">
                                          <select multiple>
                                            <option>First option</option>
                                            <option>Second option</option>
                                            <option>Third option</option>
                                            <option>Fourth option</option>
                                            <option>Fifth option</option>
                                            <option>Sixth option</option>
                                            <option>Seventh option</option>
                                            <option>Eighth option</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-actions">
                                          <i class="span1"></i>
                                        <button type="submit" name="reqLab" class="btn btn-primary btn-block span10"> Request Lab</button>
                                      </div>
                                  </div>
                            </form>
                        </div>
                        <div id="tab3" class="tab-pane">
                             <form action="#" method="post" class="form-horizontal">
                                  <div class="widget-content nopadding">
                                       <div class="control-group">
                                        <label class="control-label">Admit To ward</label>
                                        <div class="controls">
                                          <select>
                                            <option value=""> </option>
                                            <option value="labName">Ward1 Name </option>
                                            <option value="labName">Ward2 Name </option>
                                            <option value="labName">Ward3 Name </option>
                                            <option value="labName">Ward4 Name </option>
                                            <option value="labName">Ward5 Name </option>
                                          </select>
                                        </div>
                                      </div>
                                       <div class="control-group">
                                        <label class="control-label">Admission Details</label>
                                        <div class="controls">
                                          <select>
                                            <option value=""> </option>
                                            <option value="admitDetails"> Treatment And Observation </option>
                                            <option value="admitDetails"> Operation</option>
                                            <option value="admitDetails"> Other Reasons</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="form-actions">
                                          <i class="span1"></i>
                                        <button type="submit" name="adWard" class="btn btn-primary btn-block span10"> Admit To Ward</button>
                                      </div>
                                  </div>
                            </form>
                        </div>
                        <div id="tab4" class="tab-pane">
                             <form action="#" method="post" id="add_name" class="form-horizontal">
                                  <div class="widget-content nopadding">
                                      <table class="table table-bordered" id="dynamic_field">
                                          <tr>
                                            <td colspan="3"><textarea class="span12" name="diagnoses" placeholder="Diagnosis"></textarea>  </td>
                                          </tr>
                                          <tr>
                                            <td colspan="3"><textarea class="span12" name="Symptoms" placeholder="Symptoms"></textarea>  </td>
                                          </tr>
                                        <tr>
                                            <td><input type="text" name="drugName[]" placeholder="Medicine" class="span11" /></td>
                                            <td><input type="text" name="dosage[]" placeholder="Dosage" class="span11" /></td>
                                            <td><button type="button" name="add" id="add" class="btn btn-primary">Add Medicine</button></td>
                                        </tr>
                                          <tr>
                                            <td></td>
                                            <td></td>
                                          </tr>
                                    </table>
                                      <div class="form-actions">
                                          <i class="span1"></i>
                                        <button type="submit" name="presMeds" class="btn btn-primary btn-block span10"> Save Prescription</button>
                                      </div>
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
          </div>
          <div class="span6">
              <div class="widget-box widget-chat" style="height: auto;">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-comment"></i>
                        </span>
                        <h5>Patient Medical Records</h5>
                    </div>
                    <div class="widget-content nopadding" style="height: auto;">
                        <div class="chat-users panel-right2">
                          <div class="panel-title">
                            <h5>BY DATE</h5>
                          </div>
                          <div class="panel-content nopadding">
                            <ul class="contact-list">
                              <li id="" class="online new"><a href=""><i class="fa fa-calendar fa-lg"></i>  <span> 13-05-2018</span></a></li>
                              <li id="" class=""><a href=""><i class="fa fa-calendar fa-lg"></i>  <span> 15-05-2018</span></a></li>
                              <li id="" class=""><a href=""><i class="fa fa-calendar fa-lg"></i>  <span> 18-05-2018</span></a></li>
                              <li id="" class=""><a href=""><i class="fa fa-calendar fa-lg"></i>  <span> 23-06-2018</span></a></li>
                              <li id="" class=""><a href=""><i class="fa fa-calendar fa-lg"></i>  <span> 12-07-2018</span></a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="chat-content panel-left2" style="height: auto;">
                          <div class="chat-messages" id="chat-messages" style="height: auto;">
                            <div id="chat-messages-inner">
                                <p id="'+id+'" class="user-'+idname+'">
                                    <span class="msg-block"><i class="fa fa-user"></i>
                                        <strong>OPD</strong> <span class="time">9:15 am</span>
                                        <span class="msg"> Vitals Checked, BP, TP, RR, PR</span>
                                    </span>
                                </p>
                                <p id="'+id+'" class="user-'+idname+'">
                                    <span class="msg-block"><i class="fa fa-user"></i>
                                        <strong>CONSULTATION</strong> <span class="time">9:15 am</span>
                                        <span class="msg"> What ever Happened in the consulting room</span>
                                    </span>
                                </p>
                                <p id="'+id+'" class="user-'+idname+'">
                                    <span class="msg-block"><i class="icon icon-plus-sign"></i>
                                        <strong>PHARMACY</strong> <span class="time">9:15 am</span>
                                        <span class="msg"> What ever Happened at the pharmacy</span>
                                    </span>
                                </p>
                                <p id="'+id+'" class="user-'+idname+'">
                                    <span class="msg-block"><i class="icon icon-plus-sign"></i>
                                        <strong>PHARMACY</strong> <span class="time">9:15 am</span>
                                        <span class="msg"> What ever Happened at the pharmacy</span>
                                    </span>
                                </p>
                            </div>
                          </div>
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
<!--<script src="js/maruti.chat.js"></script> -->
<script src="js/maruti.tables.js"></script>
<script src="js/maruti.dashboard.js"></script>
<!--<script src="js/maruti.chat.js"></script> -->
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
//    $(document).ready(function(){
        var i=1;
        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="drugName[]" placeholder="Medicine" class="span11" /></td><td><input type="text" name="dosage[]" placeholder="Dosage" class="span11" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });

        $('#submit').click(function(){
            $.ajax({
                url:"name.php",
                method:"POST",
                data:$('#add_name').serialize(),
                success:function(data)
                {
                    alert(data);
                    $('#add_name')[0].reset();
                }
            });
        });
//    });
</script>
</body>
</html>

