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
<!--
    <style>
        .active{
            background-color: #209fbf;
        }
    </style>
-->

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
          <div class="span12">
              <div class="widget-box widget-chat">
                    <div class="widget-title">
                        <span class="icon">
                            <i class="icon-comment"></i>
                        </span>
                        <h5>Patient Medical Records</h5>
                    </div>
                    <div class="widget-content nopadding">
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
                        <div class="chat-content panel-left2">
                          <div class="chat-messages" id="chat-messages">
                            <div id="chat-messages-inner"></div>
                          </div>
                            <div class="chat-message well">
                            <button class="btn btn-primary">Send</button>
                            <span class="input-box">
                            <input type="text" name="msg-box" id="msg-box" />
                            </span>
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
