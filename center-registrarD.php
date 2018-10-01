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

//    $tab = $_GET['tab'];
//
//
//    if($tab == 'tab'){
//        $active='active';
//        $bid = $_GET['bid'];
//        //get individual by id
//        $b_sql = select("SELECT * FROM birth WHERE babyID='$bid' ");
//        foreach($b_sql as $b_row){}
//
//    }elseif($tab == 'tab1'){
//        $active1='active';
//    }
//
//    if(empty($tab)){
//        $active1='active';
//    }

    $deathIDs = Death::find_num_Death() + 1;


// function createNewDirectory1()
//
//{
//
//	$sCurrDate = date("Y-m-d"); //Current Date
//     $centerID = $_SESSION['centerID'];
//
//// 	$sDirPath = 'http://quatitsolutions.com/try/'.$sCurrDate.'/'; //Specified Pathname
//	$sDirPath = './'.$centerID.'/'; //Specified Pathname
//
//	if (!file_exists ($centerID))
//
//   	{
//
//	    	mkdir($centerID,0777,true);
//
//    	}
//
//}
//echo createNewDirectory1();


  if(isset($_POST['addApptmnt'])){      $centerID = $_SESSION['centerID'];
        $deathId = substr(filter_input(INPUT_POST, "patientID", FILTER_SANITIZE_STRING), 0, 5)."-".sprintf('%06s',$deathIDs);
        $patientID = filter_input(INPUT_POST, "patientID", FILTER_SANITIZE_STRING);
        $deathDate = filter_input(INPUT_POST, "dod", FILTER_SANITIZE_STRING);
        $deathTime = filter_input(INPUT_POST, "deathTime", FILTER_SANITIZE_STRING);
        $reason = filter_input(INPUT_POST, "reason", FILTER_SANITIZE_STRING);

      $insert_death = insert("INSERT INTO death(deathID,patientID,deathDate,deathTime,reason,dateRegistered,centerID) VALUES('$deathId','$patientID','$deathDate','$deathTime','$reason',CURDATE(),'$centerID' ) ");

      if($insert_death){
          $update_patient = update("UPDATE patient SET status='".DEAD."' WHERE patientID='$patientID' ");

           $success = "<script>document.write('DEATH RECORD REGISTERED');
                                    window.location.href='center-registrarD' </script>";
      }
    }

?>

<div id="search">
  <input type="text" placeholder="Search here..." disabled/>
  <button type="submit" class="tip-left" title="Search" disabled><i class="icon-search icon-white"></i></button>
</div>

<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href=""><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li> <a href="center-registrarB"><i class="icon icon-file"></i><span>Birth Records</span></a> </li>
    <li class="active"> <a href="center-registrarD"><i class="icon icon-file"></i><span>Death Records</span></a> </li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Registrar" class="tip-bottom"><i class="icon-file"></i> REGISTRAR</a>
        <a title="Death Records" class="tip-bottom"><i class="icon-file"></i> DEATH RECORDS</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">DEATH RECORDS</h3>

      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Death List</a></li>
                    <li><a data-toggle="tab" href="#tab2">Add New Death</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>List Of Death</h5>
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th> Death ID</th>
                              <th> Name</th>
                              <th> Date Of Death</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                              <?php
                                $dsql = select("SELECT * FROM death WHERE centerID='$centerID' ");
                                foreach($dsql as $drow){
                              ?>
                              <tr>
                                <td> <?php echo $drow['deathID']; ?></td>
                                <td> <?php echo $drow['patientID']; ?></td>
                                <td> <?php echo $drow['deathDate']; ?></td>
                                <td> <a href="#" class="btn btn-primary" title="View"><i class="fa fa-eye"></i></a></td>
                              </tr>
                              <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <form action="" method="post" class="form-horizontal">
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Patient ID :</label>
                                <div class="controls">
<!--                                  <input type="text" class="span11" name="centerID" value="<?php #echo $bid; ?>" readonly required/>-->
                                    <select name="patientID" >
                                        <option value="default"> -- Select ID --</option>
                                        <?php
                                            $patient=Patient::find_patient();
                                            foreach($patient as $patID){ ?>
                                            <option value="<?php echo $patID['patientID']; ?>"><?php echo $patID['firstName'].' '.$patID['otherName'].' '.$patID['lastName'];?> (<?php echo $patID['patientID']; ?>)</option>
                                        <?php } ?>
                                  </select>
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Reason Of Death :</label>
                                <div class="controls">
                                  <input type="text" class="span11" name="reason" required/>
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">
<!--
                              <div class="control-group">
                                <label class="control-label">Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" name="name" required/>
                                  <input type="text" class="span11" name="name" value="<?php #echo $b_row['fullname']; ?>" required readonly />
                                </div>
                              </div>
-->
                              <div class="control-group">
                                <label class="control-label">Date Of Death :</label>
                                <div class="controls">
                                  <input type="date" class="span11" name="dod" required/>
                                </div>
                              </div>
                             <div class="control-group">
                                <label class="control-label">Time Of Death :</label>
                                <div class="controls">
                                  <input type="time" class="span11" name="deathTime" required/>
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="addApptmnt" class="btn btn-primary btn-block span10">Save Record</button>
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
<div class="row-fluid navbar-fixed-bottom">
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
