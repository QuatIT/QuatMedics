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
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
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

    if($_SESSION['accessLevel']=='PHARMACY' || $_SESSION['username']=='rik'){

    $code = $_GET['code'] ;

        //get patitent ID and PerscriptionID
        $search_code = select("SELECT * FROM prescriptions WHERE perscriptionCode='".$code."' ");
        foreach($search_code as $scode){
            $patcode = $scode['perscriptionCode'];
            $prescode = $scode['prescribeCode'];
            $pid = $scode['patientID'];
            $pharmid = $scode['pharmacyID'];
        }


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

    ?>
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
<!--    <li class="active"><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>-->
    <li class="active"> <a href="pharmacy-index.php"><i class="icon icon-briefcase"></i> <span>Pharmacy</span></a> </li>
    </ul>
</div>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Pharmacy Home" class="tip-bottom"><i class="icon-briefcase"></i> PHARMACY</a>
        <a title="Patient Prescriptions" class="tip-bottom"><i class="icon-briefcase"></i> PATIENT PRESCRIPTION</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">PATIENT PRESCRIPTION</h3>

      <div class="row-fluid">
          <div class="span5">
<!--                <div class="widget-box">-->
<!--
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab1"></a></li>
                        </ul>
                    </div>
-->
<!--                    <div class="widget-content tab-content">-->
<!--                        <div id="tab1" class="tab-pane active">-->
                            <form action="#" method="post" class="form-horizontal">
                                <div class="span12">
                                    <div class="widget-box">

                                    <div class="widget-title">
                                         <span class="icon"><i class="icon-th"></i></span>
                                        <h5>Prescription Details</h5>
                                      </div>
                                    <div class="widget-content nopadding">
                                    <div class="control-group">
                                        <label class="control-label"> Medical Center :</label>
                                        <div class="controls">
                                            <input type="text" name="consultingRoom" class="span11" value="<?php echo $center['centerName']; ?>" readonly/>
                                        </div>
                                      </div>
                                      <div class="control-group">
                                        <label class="control-label">Patient ID :</label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientID" value="<?php echo $pat['patientID']; ?>" readonly/>
                                        </div>
                                      </div>
                                        <div class="control-group">
                                        <label class="control-label">Patient Name :</label>
                                        <div class="controls">
                                          <input type="text" class="span11" name="patientName" value="<?php echo $pat['firstName'].' '.$pat['otherName'].' '.$pat['lastName']; ?>" readonly/>
                                        </div>
                                      </div>
<!--
                                        <div class="control-group">
                                        <label class="control-label"> Doctor Name :</label>
                                        <div class="controls">
                                            <input type="text" name="doctorName" class="span11" value="Mr Doctor" readonly/>
                                        </div>
                                      </div>
-->
                                  </div>
                                </div>
                                </div>
                            </form>
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
          </div>

          <div class="span7">
              <div class="widget-content">
                  <form action="" method="post">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Number</th>
                          <th>Medicine</th>
                          <th>Dosage</th>
                          <th colspan="2">Action | Price</th>
                        </tr>
                      </thead>
                      <tbody>

                          <?php foreach($pre_med as $med){ ?>

                             <tr>
                                  <td><?php echo $counter++; ?></td>
                                  <td><?php echo $med['medicine']; ?></td>
                                  <td><?php echo $med['dosage']; ?></td>
                                  <td style='text-align:center;'>
<!--                                      <label for="medstat1"><input id="medstat1" type='radio' name='medstat1' value='YES'> <i class='fa fa-check-circle fa-lg text-success'></i></label>-->

                                      <?php
//                                        if($med['prescribeStatus']!="served"){
                                        if($med['prescribeStatus']!="paid"){
                                      ?>

                                      <span class="switch">
  <label for="switch-id<?php echo $med['prescribeid']; ?>"><input type="checkbox"  value="served" name="prescribe<?php echo $med['prescribeid']; ?>" class="switch" id="switch-id<?php echo $med['prescribeid']; ?>"></label>
</span>



                                        <td><input type="number" min="0" <?php if($med['priceMed']){echo "readonly"; } ?> name="comment<?php echo $med['prescribeid']; ?>" value="<?php echo $med['comment']; ?>" placeholder="ENTER PRICE OF MEDICINE"></td>


                                      <?php }else{ ?>
                                                <span class="label label-success">Served</span>
                                             <td><input min="0" type="text" <?php if(!empty($med['comment'])){echo "readonly"; } ?> name="comment<?php echo $med['prescribeid']; ?>" value="<?php echo $med['priceMed']; ?>" placeholder="ENTER PRICE OF MEDICINE"></td>

<!--
                                 <script>
                                    function sum()
{
  var w = document.getElementById('num1').value || 0;
  var x = document.getElementById('num2').value || 0;
  var y = document.getElementById('num3').value || 0;

  var z=parseInt(w)+parseInt(x)+parseInt(y);

  document.getElementById('final').value=z;
};
                                 </script>
-->


                                     <?php   }


                                            if(isset($_POST['prescribe'.$med['prescribeid']])){
                                                $chkbox = $_POST['prescribe'.$med['prescribeid']];

                                                if($chkbox=='served'){
                                                    $checked = 'checked';

                                                    $chk_sql = update("UPDATE prescribedmeds SET prescribeStatus='$chkbox' WHERE prescribeid='".$med['prescribeid']."' ");
                                                    echo "<script>window.location.href='pharmacy-patient?code={$_GET['code']}'</script>";
                                                }else{
                                                    $checked = '';
                                                     $chk_sql = update("UPDATE prescribedmeds SET prescribeStatus='Prescibed' WHERE prescribeid='".$med['prescribeid']."' ");
                                                    echo "<script>window.location.href='pharmacy-patient?code={$_GET['code']}'</script>";
                                                }
                                            }


                                                  if(isset($_POST['comment'.$med['prescribeid']])){
                                                      $comment = $_POST['comment'.$med['prescribeid']];

                                                        $comment_sql = update("UPDATE prescribedmeds SET comment='$comment' WHERE prescribeid='".$med['prescribeid']."' ");
                                                      echo "<script>window.location.href='pharmacy-patient?code={$_GET['code']}'</script>";
                                                  }


                                      ?>


<!--
<label class="switch">
  <input type="checkbox" checked>
  <span class="slider round"></span>
</label>
-->


                                  </td>
                                </tr>
                 <?php   }?>
                      </tbody>
                  <tfoot style="font-weight:bolder;">
                    <tr>
                        <td colspan="4">TOTAL PRICE</td>
                        <td>GHC 1.00</td>
                      </tr>
                  </tfoot>
                    </table>
<!--
                      <div class="control-group">
                        <div class="controls">
                            <textarea class="span12" rows="5" placeholder="Notes On Prescription"></textarea>
                        </div>
                      </div>
-->

                      <div class="form-actions">
                          <i class="span6"></i>
                          <?php
                            $pres_btn = select("SELECT * FROM prescribedmeds WHERE prescribeCode='$prescode' AND prescribeStatus='served' ");
                            if(count($pres_btn)<= count(select("SELECT * FROM prescribedmeds WHERE prescribeCode='$prescode'"))){
                          ?>
                        <button type="submit" class="btn btn-primary btn-block span6">Pay</button>
                          <?php } ?>
                      </div>
                  </form>
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
