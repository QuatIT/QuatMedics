<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUATMEDIC</title>
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
<link rel="stylesheet" href="assets/css/font-awesome2.css" />
<link rel="icon" href="quatmedics.png" type="image/x-icon" style="width:50px;">
</head>

        <style>
        .active{
            background-color: #209fbf;
        }
    </style>
<body>

<?php
    include 'layout/head.php';
$_SESSION['current_page']=$_SERVER['REQUEST_URI'];
//require_once 'assets/core/connection.php';
    if($_SESSION['accessLevel']=='LABORATORY' || $_SESSION['username']=='rik'){

 $success = '';
 $error = '';

$patientID=$_REQUEST['patientID'];
$labRequestID=$_REQUEST['rID'];
//avoid undefined index msg


//extract patient name
$pat = select("SELECT * FROM patient WHERE centerID='".$_SESSION['centerID']."' && patientID='".$patientID."' ");
foreach($pat as $patname){}

//generate labResultID
//$labResultID = substr("donor",0,3);
$labResultID = mt_rand(0,99).mt_rand(101,998);
//$labResultID= $labResultID1;


if(isset($_POST['lab_result'])){
    $patient_ID = filter_input(INPUT_POST, "patientID", FILTER_SANITIZE_STRING);
    $labResults=filter_input(INPUT_POST, "labResults", FILTER_SANITIZE_STRING);
    //fetching uder status 1=uploaded  0=pending

//$numFile = count($_FILES['file']);
//$numText = count($_POST['txtresults']);
$numLab = count($_POST['labID']);

for($l=0; $l<$numLab; $l++){
    $labID = $_POST['labID'][$l];

    if(isset($_POST['txtresult'][$l])){
        $labresult = $_POST['txtresult'][$l];
    }else{
        $labresult = '';
    }

    if(isset($_FILES['file']['name'][$l])){
        $file = $_FILES['file']['name'][$l];
    }else{
        $file = '';
    }

if(!empty($file) and empty($labresult)){
    //file properties
    $file_name=$_FILES['file']['name'][$l];
    $file_tmp=$_FILES['file']['tmp_name'][$l];
    $file_size= $_FILES['file']['size'][$l];
    $file_error = $_FILES['file']['error'][$l];
    //etract extension
    $file_ext =explode('.',$file_name);
    $file_ext = strtolower(end($file_ext));
    $allowed = array('application','pdf');

    if(in_array($file_ext, $allowed)){
        if($file_error===0){
            if($file_size <= 4097152){
             $file_name_new=uniqid('', true).'.'.$file_ext;
                $file_destination = $LAB_RESULT_UPLOAD.$file_name_new;
                //check if file has been loaded earlier and move it from temporary location into folder
                if(move_uploaded_file($file_tmp,$file_destination)){
    $qry =update("UPDATE labresults SET labResult='$file_destination',status='".SENT_TO_CONSULTING."',type='1' WHERE labRequestID='".$labRequestID."' AND labID='$labID' ");
    if($qry){
        $success = "<script>document.write('FILE UPLOAD SUCCESSFULL.');</script>";
    }
                }else{
                   $error = "<script>document.write('FILE NOT MOVED, TRY AGAIN');</script>";
                }
            }

        }
    }
}

if(!empty($labresult) and empty($file)){
    $qry =update("UPDATE labresults SET labResult='$labresult',status='".SENT_TO_CONSULTING."', type='2' WHERE labRequestID='$labRequestID' AND labID='$labID' ");
    if($qry){
        $success = "<script>document.write('RESULT SENT SUCCESSFULLY.');</script>";
    }
}

if(empty($labresult) && empty($file)){
     $error = "<script>document.write('EMPTY RESULT FIELDS.');</script>";
}
    if(!empty($labresult) && !empty($file)){
     $error = "<script>document.write('ONE FIELD CAN ONLY BE USED.');</script>";
}


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
    <li><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"><a href="lab-index.php"><i class="icon icon-filter"></i> <span>Laboratory</span></a></li>
    <li> <a href="lab-bloodbank.php"><i class="icon icon-tint"></i> <span>Blood Bank</span></a> </li>
    </ul>
</div>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="laboratory" href="lab-index" class="tip-bottom"><i class="icon-filter"></i> LABORATORY</a>
        <a title="Patient lab Result" class="tip-bottom"><i class="icon-user"></i> LAB RESULTS</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">PATIENT LAB RESULTS</h3>

<?php
  if($success){ ?>
  <div class="alert alert-success">
      <strong>Success!</strong> <?php echo $success; ?>
    </div>
  <?php } if($error){ ?>
  <div class="alert alert-danger">
      <strong>Error!</strong> <?php echo $error; ?>
    </div>
<?php } ?>


      <div class="row-fluid">
          <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab1">PATIENT LAB DETAILS</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="tab1" class="tab-pane active">
                            <form action="#" method="post" class="form-horizontal" enctype="multipart/form-data">
<!--
                                <div class="span4">
                                    <div class="widget-content nopadding">
                                      <div class="control-group">
                                        <label class="control-label">PATIENT ID :</label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientID" id="patientID" value="<?php// echo $patientID;?>" readonly/>
                                        </div>
                                      </div>
									<div class="control-group">
                                        <label class="control-label">PATIENT NAME :</label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientName" value="<?php //echo $patname['firstName'].' '.$patname['otherName'].' '.$patname['lastName']; ?>" readonly/>
                                        </div>
                                      </div>
                                  </div>
                                </div>
-->
                                <div class="span12">
                                    <div class="widget-content nopadding">
										<table class="table table-bordered">
                                            <tr>
                                                <th class="labell" style="text-align:center;"> PATIENT ID</th>
                                                <th>
                                                    <input type="text" style="border-style:none;" class="span11" name="patientID" id="patientID" value="<?php echo $patientID;?>" readonly/>
                                                </th>
                                                <th class="labell" style="text-align:center;">PATIENT NAME</th>
                                                <th colspan="3">
                                                    <input style="border-style:none;" type="text" class="span11" name="patientName" value="<?php echo $patname['firstName'].' '.$patname['otherName'].' '.$patname['lastName']; ?>" readonly/>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td colspan="6"></td>
                                            </tr>
											<tr class="labell">
												<th>LAB NAME</th>
												<th>LAB UPLOAD</th>
												<th>LAB RESULTS</th>
												<th>LAB PRICE</th>
												<th>PAY STATUS</th>
												<th>CONFIRM</th>
											</tr>
											<tbody>
												<?php
				$ltest = select("SELECT * FROM labresults WHERE labRequestID='".$labRequestID."' AND labResult=''");
									foreach($ltest as $labtxt){
												?>
												<tr>
												<td>
													<select class="span11" name="labID[]">
								<?php
				   $labnam = select("SELECT labName FROM lablist WHERE labID='".$labtxt['labID']."' ");
										foreach($labnam as $labname){ ?>
											<option value="<?php echo $labtxt['labID'];?>"> <?php echo $labname['labName'];?></option>
														<?php }?>
													</select>
												</td>
												<td>
                                                    <?php if($labtxt['type']=='0'){?>
<input type="file" class="span11" name="file[]" accept="application/pdf" <?php if($labtxt['confirm']=='UNCONFIRMED'){ echo 'disabled';}?>/>
                                                    <?php }
                                                     if($labtxt['type']=='1'){
                                                    ?>
                                                    <a><?php echo $labtxt['labResult']; ?></a>
                                                    <?php } ?>
                                                </td>

												<td>
                                                    <?php if($labtxt['type']=='0'){?>
                                                    <textarea class="span11" rows="2" cols="25" name="txtresult[]" <?php if($labtxt['confirm']=='UNCONFIRMED'){ echo 'readonly';}?>></textarea>
                                                    <?php }
                                                     if($labtxt['type']=='2'){
                                                    ?>
                                                    <textarea class="span11" rows="2" cols="25" name="txtresult[]" readonly><?php echo $labtxt['labResult']; ?></textarea>
                                                    <?php } ?>
                                                </td>
                                                <td style="text-align:center;">
                                                    <?php echo $labtxt['labprice']; ?>
                                                </td>

                                                <td style="text-align:center;">
                                                    <?php
                                                        if($labtxt['paymode'] == 'CASH'){
                                                            if($labtxt['paystatus'] == 'Not Paid'){?>
                                                                    <span style="background-color:#c92929;" class="label label-danger labell text-center"><?php  echo $labtxt['paystatus'];?></span>
                                                                <?php }
                                                        }else{ ?>
                                                            <span style="background-color:#c92929;" class="label btn-warning text-center labell"><?php  echo $labtxt['paymode'];?></span>
                                                        <?php }
                                                    ?>

                                                    <?php if($labtxt['paystatus'] == 'Paid'){?>
                                                        <span class="label label-success text-center"><?php  echo $labtxt['paystatus'];?></span>
                                                    <?php }?>
                                                </td>

                                                <td style="text-align:center;">
                                                    <?php if($labtxt['confirm']=='UNCONFIRMED'){ ?>
                                                    <a href="lab-confirm?id=<?php echo $labtxt['id']; ?>" onclick="return confirm('CONFIRM LAB');" class="btn btn-primary btn-sm labell"><i class="fa fa-check fa-sm"> Confirm</i></a>
                                                    <?php } ?>
                                                    <?php if($labtxt['confirm']=='CONFIRMED'){ ?>
                                                    <label class="btn btn-success btn-sm"><i class="fa fa-check-circle fa-sm"></i></label>
                                                    <?php } ?>
                                                </td>

												</tr>
												<?php }?>
                                                <tr><td colspan="6"></td></tr>
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td colspan="2">
                            <button type="submit" class="btn btn-primary btn-block labell span5" name="lab_result" style="width:100%;">SEND RESULTS</button></td>
                                                </tr>
											</tbody>
										</table>
                                  </div>
                                </div>

                            </form>
                        </div>
                    </div>
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
<script>
$(".alert").delay(7000).slideUp(1000, function() {
    $(this).alert('close');
});
</script>
</body>
</html>
<?php }else{echo "<script>window.location='404'</script>";}?>
