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

    <style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

</head>
<body>

<?php
    include 'layout/head.php';
    $_SESSION['current_page']=$_SERVER['REQUEST_URI'];

    if($_SESSION['accessLevel']=='PHARMACY' || $_SESSION['username']=='rik'){

    $code = $_GET['code'] ;

        //get patitent ID and PerscriptionID
        $search_code = select("SELECT * FROM prescriptions WHERE perscriptionCode='".$code."' ");
        foreach($search_code as $scode){
            $patcode = $scode['perscriptionCode'];
            $prescode = $scode['prescribeCode'];
            $pid = $scode['patientID'];
            $pharmid = $scode['pharmacyID'];
            $presdate = $scode['dateInsert'];
        }

        //search prescription doctor/staff
        $staff = select("SELECT * FROM staff WHERE staffID='".$scode['staffID']."' && centerID='".$_SESSION['centerID']."'");
        foreach($staff as $staffrow){}


        //search medicine
        $pre_med = select("SELECT * FROM prescribedmeds WHERE prescribeCode='$prescode' ");


        //search patient
        $patient_sql = select("SELECT * FROM patient WHERE patientID='".$pid."' ");
        foreach($patient_sql as $pat){}


        //search pharmacy
        $pharmacy_sql = select("SELECT * FROM pharmacy WHERE pharmacyID='$pharmid' ");
        foreach($pharmacy_sql as $cenID){
            $centID = $cenID['centerID'];
        }


        //search medcenter
        $medcenter = select("SELECT * FROM medicalcenter WHERE centerID='".$centID."' ");
        foreach($medcenter as $center){}


          //SERVE Medicine

if(isset($_POST['btnServe'])){
		//count number of service entered..
		$pres = count($_POST['prescribe']);

		//check number of services..
		if($pres > 0 ){
			//saving services into database...
            for($n=0; $n<$pres; $n++){
                    if(trim($_POST['prescribe'][$n] != '') ) {
                        $presName = trim($_POST["prescribe"][$n]);

                        $att_mrk = explode("*", $presName);
                        $serve = $att_mrk[0];
                        $patid = $att_mrk[1];
                        $price_px = $att_mrk[2];
                        $dosage= $att_mrk[3];
                        $medicine_name= $att_mrk[4];
                        $prescribeid= $att_mrk[5];
echo "<script>alert('{$serve}--{$patid}--{$price_px}--{$dosage}--{$medicine_name}--{$prescribeid}')</script>";
// exit();
                        //get ministry detail
                        // $min_det = select("select * from ministry_tb where group_id='$min_grp' ");
                        // foreach($min_det as $mindet_row){}
                        //
                        // //get group detail
                        // $grp_det = select("select * from g_ministry_tb where g_id='$min_grp' ");
                        // foreach($grp_det as $gdet_row){}
                        //
                        // if(empty($mindet_row['group_name'])){
                        //     $ministry_name = $g_min = $gdet_row['g_name'];
                        // }elseif(empty($gdet_row['g_name'])){
                        //     $ministry_name = $mindet_row['group_name'];
                        // }

                        $chk_sql = update("UPDATE prescribedmeds SET prescribeStatus='$serve' WHERE prescribeid='".$prescribeid."' ");

                        $chk_sql2 = update("UPDATE prescriptions SET prescribeStatus='$serve' WHERE prescribeCode='".$code."' ");


                        $med = select("select * from prescribedmeds where prescribeid='".$prescribeid."' ");
                        foreach($med as $medic_row){}

                        $phinven = select("select * from pharmacy_inventory where mode_of_payment='".$medic_row['paymode']."' && medicine_name='".$medic_row['medicine']."' ");
                        foreach($phinven as $phinven_row){}

                        if($phinven_row['no_of_bottles']=="NULL" || $phinven_row['no_of_bottles']=="0" || empty($phinven_row['no_of_bottles'])){
                          $remaining_med = $phinven_row['no_of_piece'] - $medic_row['totalMed'];

                          $up_medic = update("update pharmacy_inventory set no_of_piece='$remaining_med' where mode_of_payment='".$medic_row['paymode']."' && medicine_name='".$medic_row['medicine']."' ");
                        }else{
                        $remaining_med = $phinven_row['no_of_bottles'] - $medic_row['totalMed'];

                          $up_medic = update("update pharmacy_inventory set no_of_piece='$remaining_med' where mode_of_payment='".$medic_row['paymode']."' && medicine_name='".$medic_row['medicine']."' ");
                        }


                        $release_patient = update("update patient set patient_status='' where patientID='$patid'");

                                                  echo "<script>window.location.href='pharmacy-patient?code={$_GET['code']}'</script>";

                        //get members detail
                        // $mem_det = select("select * from membership_tb where member_id='$memb' ");
                        // foreach($mem_det as $mem_row){}
                        //
                        // $mark_attendance_min = insert("insert into min_grp_attend(member_id,group_id,group_name,full_name,gender,status,date_reg,flag1,phone) values('$memb','$min_grp','$ministry_name','".$mem_row['full_name']."','".$mem_row['gender']."','".$att."',CURDATE(),'1','".$mem_row['phone_number']."')");
//                        $mrkk = $att.'---'.$memb.'---'.$min_grp;
//                        echo "<script>alert('{$mrkk}')</script>";

//                        if(empty($checked))

                           $msg = '<div class="alert alert-dismissible alert-success">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Success!</strong> Attendance Marked.
                </div>';

               		}
            }
		}else{
			$error = "<script>document.write('Empty Fields, Try Again.');</script>";
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
    <li> <a href="pharmacy-index.php"><i class="icon icon-briefcase"></i> <span>Pharmacy</span></a> </li>
    <li class="active"> <a href="pharmacy-index2"><i class="icon icon-briefcase"></i> <span>Pharmacy2</span></a> </li>
    <li> <a href="dispensary?tab=admed"><span>Dispensary</span></a> </li>
    <li> <a href="pharmacy-inventory?tab=tab2"> <span>Inventory (Pharmacy)</span></a> </li>
    </ul>
</div>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Pharmacy Home" class="tip-bottom"><i class="icon-briefcase"></i> PHARMACY 2</a>
        <a title="Patient Prescriptions" class="tip-bottom"><i class="icon-briefcase"></i> PATIENT PRESCRIPTION</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">PATIENT PRESCRIPTION</h3>

      <div class="row-fluid" style="margin:0px; padding:0px;">
          <div class="span12">
<!--                <div class="widget-box">-->
<!--
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab1"></a></li>
                        </ul>
                    </div>
-->
                    <div class="widget-content tab-content">
<!--                        <div id="tab1" class="tab-pane active">-->
                            <form action="#" method="post" class="form-horizontal">
                                <div class="span6">
                                    <div class="widget-box">

                                    <div class="widget-title">
                                         <span class="icon"><i class="icon-th"></i></span>
                                        <h5 class="labell">Patient Details</h5>
                                      </div>

                                    <div class="widget-content nopadding">
                                    <div class="control-group">
                                        <label class="control-label"> Medical Center </label>
                                        <div class="controls">
                                            <input type="text" name="consultingRoom" class="span11" value="<?php echo $center['centerName']; ?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Patient ID </label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientID" value="<?php echo $pat['patientID']; ?>" readonly/>
                                        </div>
                                      </div>
                                        <div class="control-group">
                                        <label class="control-label">Patient Name </label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientName" value="<?php echo $pat['firstName'].' '.$pat['otherName'].' '.$pat['lastName']; ?>" readonly/>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                </div>
                                <div class="span6">
                                    <div class="widget-box">

                                    <div class="widget-title">
                                         <span class="icon"><i class="icon-th"></i></span>
                                        <h5 class="labell">Prescription Details</h5>
                                      </div>

                                    <div class="widget-content nopadding">
                                    <div class="control-group">
                                        <label class="control-label"> Prescription Code </label>
                                        <div class="controls">
                                            <input type="text" name="consultingRoom" class="span11" value="<?php echo $patcode; ?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">PRESCRIPTION DATE </label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientID" value="<?php echo $presdate; ?>" readonly/>
                                        </div>
                                      </div>
                                        <div class="control-group">
                                        <label class="control-label">PRESCRIBED BY </label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientName" value="<?php echo $staffrow['firstName'].' '.$staffrow['otherName'].' '.$staffrow['lastName']; ?>" readonly/>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                </div>
                            </form>
<!--                        </div>-->
<!--                    </div>-->
                </div>
          </div>

          <div class="span12" style="margin:0px;">
              <div class="widget-content">
                  <form action="" method="post">
                    <table class="table table-bordered">
                      <thead class="labell">
                          <th>Number</th>
                          <th>Medicine</th>
                          <th>Dosage</th>
                          <th>Price</th>
                          <th style="width:15%;">Action</th>
                          <th>comment</th>
                      </thead>
                      <tbody>

                          <?php
                                foreach($pre_med as $med){
                                @$medtotal+=$med['medprice'];
                          ?>

                             <tr>
                                  <td><?php echo $counter++; ?></td>
                                  <td><?php echo $med['medicine']; ?></td>
                                  <td><?php echo $med['dosage']; ?></td>
                                  <td style="text-align:center;"><?php echo "Ghc ".$med['medprice']; ?></td>

                                 <?php if($med['confirm']=='UNCONFIRMED'){ ?>
                                    <td colspan="2" style="text-align:center;">
                                        <span class="btn btn-warning btn-sm btn-block"> AWAITING PAYMENT</span>
                                    </td>
                                 <?php }
                                 if($med['confirm']=='CONFIRMED'){
                                 ?>
                                  <td style='text-align:center;'>

                                      <?php
                                        if($med['prescribeStatus']!="served"){
                                      ?>

                                      <span class="switch">
  <!-- <label for="switch-id<?php #echo $med['prescribeid']; ?>"><input type="checkbox"  value="served*<?php #echo $pat['patientID']; ?>*<?php #echo $med['medprice']; ?>*<?php #echo $med['dosage']; ?>*<?php #echo $med['medicine']; ?>" name="prescribe[]" >Serve</label> -->


             <select name="prescribe[]">
                <option></option>
                <option value="served*<?php echo $pat['patientID']; ?>*<?php echo $med['medprice']; ?>*<?php echo $med['dosage']; ?>*<?php echo $med['medicine']; ?>*<?php echo $med['prescribeid']; ?>">Serve</option>
                <!-- <option value="Absent <?php #echo $attendancex['member_id'].' '.$_POST['sel_grp']; ?>">Absent</option> -->
</select>
</span>

                                        <td><input type="text" <?php if($med['comment']){echo "readonly"; } ?> name="comment<?php echo $med['prescribeid']; ?>" value="<?php if($med['comment']!='NULL'){echo $med['comment'];}else{echo "";} ?>" placeholder="ENTER COMMENT / NOTE"></td>


                                      <?php }else{ ?>
                                                <span class="label label-success">Served</span>
                                             <td><input type="text" <?php if(!empty($med['comment']) || $med['comment']='null'){echo "readonly"; } ?> name="comment<?php echo $med['prescribeid']; ?>" value="" placeholder="ENTER COMMENT / NOTE"></td>

                                     <?php  }


                                      ?>
                                  </td>
                                <?php } ?>

                                </tr>
                 <?php   }?>
                      <tr><td colspan="6"></td></tr>
                      <tr>
                        <td colspan="2"></td>
                        <td style="font-weight:bolder; text-align:right;">TOTAL</td>
                        <td style="font-weight:bolder; text-align:center;"><?php echo "Ghc ".@$medtotal;?></td>
                        <td colspan="2"></td>
                      </tr>
                      </tbody>
                    </table>
                      <div class="form-actions">
                          <i class="span9"></i>
                          <?php
                            $pres_btn = select("SELECT * FROM prescribedmeds WHERE prescribeCode='$prescode' AND prescribeStatus='served' ");
                            if(count($pres_btn)<= count(select("SELECT * FROM prescribedmeds WHERE prescribeCode='$prescode'"))){
                          ?>
                        <button type="submit" name="btnServe" class="btn btn-primary btn-block labell span3">Serve</button>
                          <?php } ?>
                      </div>
                  </form>
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
<?php }else{echo "<script>window.location='404'</script>";}?>
