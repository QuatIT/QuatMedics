<?php session_start(); ?>
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

?>

<div id="search">
  <input type="text" placeholder="Search here..." disabled/>
  <button type="submit" class="tip-left" title="Search" disabled><i class="icon-search icon-white"></i></button>
</div>

<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="finance-cash"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"> <a href="finance-cash"><i class="icon icon-briefcase"></i><span>CASH PAYMENT</span></a> </li>
    <li>
		<a href=""><i class="icon icon-calendar"></i><span>INSURANCE</span></a>
	</li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="CASH PAYMENT" class="tip-bottom"><i class="icon-briefcase"></i> CASH PAYMENT</a>
        <a title="CASH PAYMENT DETAILS" class="tip-bottom"><i class="icon-briefcase"></i> CASH PAYMENT DETAILS</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">CASH PAYMENT DETAILS</h3>

      <div class="row-fluid">
		  <div class="span6">
<!--            <div class="widget-content tab-content">-->
				<form action="#" method="post" class="form-horizontal">
					  <div class="widget-title">
						  <span class="icon"> <i class="icon-align-justify"></i> </span>
							<h5>Payment Details</h5>
					  </div>
					  <div class="widget-content nopadding">
						  <div class="control-group">
							<label class="control-label">Patient ID :</label>
							<div class="controls">
							  <input type="text" class="span11" name="patientID" readonly/>
							</div>
						  </div>
						  <div class="control-group">
							<label class="control-label">Patient Name :</label>
							<div class="controls">
							  <input type="text" class="span11" name="patientName" readonly/>
							</div>
						  </div>
						 <div class="control-group">
							<label class="control-label">OPD Charge :</label>
							<div class="controls">
							  <input type="text" class="span11" name="opdCharge" value="" readonly/>
							</div>
						  </div>
						 <div class="control-group">
							<label class="control-label">Consultation Charge :</label>
							<div class="controls">
							  <input type="text" class="span11" name="opdCharge" value="" readonly/>
							</div>
						  </div>
						 <div class="control-group">
							<label class="control-label">Lab Test Charge :</label>
							<div class="controls">
							  <input type="text" class="span11" name="opdCharge" value="" readonly/>
							</div>
						  </div>
					  </div>
				</form>
<!--            </div>-->
		</div>
		  <div class="span6">
<!--        <div class="widget-box">-->
<!--            <div class="widget-content tab-content">-->
<!--                <div id="tab1" class="tab-pane active">-->
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                         <h5>LAB and Other Prices</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>PID</th>
                              <th>LAB DETAILS</th>
                              <th>WARD DETAILS</th>
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
							  <tr>
							  	<td> Patient ID</td>
							  	<td> Malaria Test</td>
							  	<td> </td>
							  	<td> <a href="#"><i class="btn btn-success btn-md fa fa-eye-open">View</i></a></td>
							  </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
<!--            </div>-->
<!--        </div>		  -->
		  </div>

      </div>
<!--  </div>-->
</div>
<div class="row-fluid navbar-fixed-bottom">
 	<div id="footer" class="span12">
	  2018 &copy; QUAT MEDICS ADMIN By  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a>
	</div>
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

<!--
<script>
function dis(){
    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","loads/consultappoint-load?staffID=<?php // echo $staffID;?>",false);
    xmlhttp.send(null);
    document.getElementById("appointment").innerHTML=xmlhttp.responseText;
}
    dis();

    setInterval(function(){
        dis();
    },1000);
</script>
-->

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
