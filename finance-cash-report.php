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
    <style>
        .active{
            background-color: #209fbf;
        }
    </style>
</head>
<body>

<?php
include 'layout/head.php';
$_SESSION['current_page']=$_SERVER['REQUEST_URI'];
?>

<div id="search">
  <input type="text" placeholder="Search here..." disabled/>
  <button type="submit" class="tip-left" title="Search" disabled><i class="icon-search icon-white"></i></button>
</div>

<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li> <a href="finance-cash"><i class="icon icon-briefcase"></i><span>CASH PAYMENT</span></a> </li>
    <li><a href="finance-insurance"><i class="icon icon-file"></i><span>INSURANCE</span></a></li>
    <li class="active"><a href="finance-cash-report"><i class="icon-list-alt"></i><span>REPORT</span></a></li>
    </ul>
</div>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="CASH PAYMENT" class="tip-bottom"><i class="icon-briefcase"></i> CASH PAYMENT</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">ACCOUNT TRANSACTION</h3>

      <div class="row-fluid">
        <div class="widget-box">
          <div class="widget-title">
             <span class="icon"><i class="icon-th"></i></span>
            <h5>TRANSACTION TABLE</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>CREDIT ACCOUNT</th>
                  <th>DEBIT ACCOUNT(s)</th>
                  <th>AMOUNT</th>
                  <th>TRANSACTION</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                  $trans = SELECT("SELECT * FROM accounttransaction WHERE centerID='$centerID' ORDER BY id ASC");
                  if($trans){
                      foreach($trans as $transRow){
                  ?>
                  <tr>
                    <td><?php echo $transRow['id'];?></td>
                    <td><?php echo $transRow['creditAcc'];?></td>
                    <td><?php echo $transRow['debitAcc'];?></td>
                    <td><?php echo $transRow['Amount'];?></td>
                    <td><?php echo $transRow['activity'];?></td>
                  </tr>
                  <?php }}else{?>
                  <tr><td colspan="5"> NO ACCOUNT TRANSACTION SAVED.</td></tr>
                  <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="row-fluid ">
 	<div id="footer" class="span12">
	  2018 &copy; QUAT MEDICS ADMIN BY  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a>
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

<script>
function dis(){
    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","loads/consultappoint-load?staffID=<?php echo $staffID;?>",false);
    xmlhttp.send(null);
    document.getElementById("appointment").innerHTML=xmlhttp.responseText;
}
    dis();

    setInterval(function(){
        dis();
    },1000);
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
