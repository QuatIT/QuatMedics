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

    if($_SESSION['accessLevel']=='LABORATORY' || $_SESSION['username']=='rik'){

    $fet_pat=select("SELECT * FROM labresults WHERE status='".SENT_TO_LAB."' && centerID='".$_SESSION['centerID']."' GROUP BY patientID");

    ?>
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"><a href="lab-index.php"><i class="icon icon-warning-sign"></i> <span>Laboratory</span></a></li>
    <li> <a href="lab-bloodbank.php"><i class="icon icon-tint"></i> <span>Blood Bank</span></a> </li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Laboratory" class="tip-bottom"><i class="icon-warning-sign"></i> LABORATORY</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">LAB REQUEST LIST</h3>

          <div class="row-fluid">
             <div class="widget-box">
                  <div class="widget-title">
                  </div>
                  <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                      <thead>
                        <tr>
                          <th>PATIENT ID</th>
                          <th>PATIENT NAME</th>
                          <th>DOCTOR</th>
                          <th>LAB TYPE</th>
                          <th>PAYMENT STATUS</th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody>

			  <?php
					foreach($fet_pat as $fet_pats){
					$pat_sql = select("SELECT firstName,otherName,lastName FROM patient WHERE patientID='".$fet_pats['patientID']."' ");
						foreach($pat_sql as $pname){}
				?>
                        <tr>
                          <td><?php echo $fet_pats['patientID']; ?></td>
                          <td><?php echo $pname['firstName']." ".$pname['otherName']." ".$pname['lastName']; ?></td>
                          <td>
                              <?php
                                    $stafSQl = select("select * From staff where staffID='".$fet_pats['staffID']."'");
                                    foreach($stafSQl as $staffRow){}
                                    echo $staffRow['lastName'].' '.$staffRow['firstName'].' '.$staffRow['otherName'];
                              ?>
                            </td>
                          <td>
							  <?php
								$LabNm = select("SELECT * FROM lablist WHERE labID='".$fet_pats['labID']."' ");
								foreach($LabNm as $labRow){
									echo $labRow['labName'];
								}?>
                         </td>
						<td style="text-align:center;">
							<?php
								if($fet_pats['paymode'] == 'Private'){
									if($fet_pats['paystatus'] == 'Not Paid'){?>
											<span style="background-color:#c92929;" class="label label-danger text-center"><?php  echo $fet_pats['paystatus'];?></span>
										<?php }
								}else{ ?>
									<span style="background-color:#c92929;" class="label btn-warning text-center"><?php  echo $fet_pats['paymode'];?></span>
								<?php }
							?>

							<?php if($fet_pats['paystatus'] == 'Paid'){?>
								<span class="label label-success text-center"><?php  echo $fet_pats['paystatus'];?></span>
							<?php }?>
						</td>
					  <td style='text-align: center;'>
						  <a href='lab-patient.php?patientID=<?php echo $fet_pats['patientID']."&rID=".$fet_pats['labRequestID']; ?>'>
							  <span class='btn btn-primary fa fa-eye'></span>
						  </a>
					  </td>
                        </tr>
                     <?php } ?>
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
