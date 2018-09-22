<?php
require "assets/core/connection.php";




//echo $bloodGroup;




//generate blood id
$bloodID ='BD - '.mt_rand(1,77).mt_rand(89,1992);

//save into bloodGroup_tb
if(isset($_POST['save_blood'])){

  $bloodGroup = filter_input(INPUT_POST, 'bloodGroup',FILTER_SANITIZE_STRING);
  $numberOfBags = filter_input(INPUT_POST, 'numberOfBags',FILTER_SANITIZE_STRING);


  $group_insert=insert("INSERT INTO bloodgroup_tb(bloodID,bloodGroup,bloodbags)VALUES('$bloodID','".$bloodGroup."','".$numberOfBags."')");
  if($group_insert){
    echo "<script>alert('Entry Was Successful');
    document.location.assign('lab-bloodbank.php')</script>";
  }
}

//generate donor id
function generateDonorID(){
  $prefix = "don - ";
$nums = (mt_rand(0,90).mt_rand(111,998));
$name = $prefix.$nums;
$donor_id = strtoupper($name);
return $donor_id;
}
$donorID=generateDonorID();


  //save into bloodBank
  if(isset($_POST['save_group'])){

    $fullname = filter_input(INPUT_POST, 'fullName',FILTER_SANITIZE_STRING);
    $dob = filter_input(INPUT_POST, 'dob',FILTER_SANITIZE_STRING);
    $bloodGroup = filter_input(INPUT_POST, 'bloodGroup',FILTER_SANITIZE_STRING);
    $bloodGender = filter_input(INPUT_POST, 'bloodGender',FILTER_SANITIZE_STRING);
    $phoneNumber = filter_input(INPUT_POST, 'phoneNumber',FILTER_SANITIZE_STRING);
    $lastDonate = filter_input(INPUT_POST, 'lastDonate',FILTER_SANITIZE_STRING);

    $bank_insert=insert("INSERT INTO bloodBank(bloodID,donorID,donorName,gender,bloodGroup,phoneNumber,lastDonate,dob)VALUES('$bloodID','$donorID','".$fullname."','".$bloodGender."','".$bloodGroup."','".$phoneNumber."','".$dob."','".$lastDonate."')");
  if($bank_insert){
    echo "<script>alert('Entry Was Successful');
    document.location.assign('lab-bloodbank.php')</script>";
  }

  }



?>


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


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
    <style>
        .active{
            background-color: #209fbf;
        }
       .modal-header{ background-color: #209fbf}
        .modal-footer{ background-color: #209fbf}
      .modal-title{color:white; font-weight:bolder;}
    </style>
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
    <li> <a href="lab-index.php"><i class="icon icon-warning-sign"></i> <span>Laboratory</span></a></li>
    <li class="active"><a href="lab-bloodbank.php"><i class="icon icon-tint"></i> <span>Blood Bank</span></a> </li>
    </ul>
</div>

<div id="content">
<form action="" method="post" class="form-horizontal">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Laboratory" class="tip-bottom"><i class="icon-warning-sign"></i> LABORATORY</a>
        <a title="Blood Bank" class="tip-bottom"><i class="icon-tint"></i> BLOOD BANK</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">LAB BLOOD BANK INFORMATION</h3>

      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Blood Group List</a></li>
                    <li><a data-toggle="tab" href="#tab2">Add New Blood Group</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Blood ID</th>
                              <th>Blood Type</th>
                              <th>Charge</th>
                              <th>Amount Available</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php


                          $blood_group=select("SELECT * FROM bloodgroup_tb");
                          foreach($blood_group as $blood_groups){

                            echo "<tr>
                              <td>".$blood_groups['bloodID']."</td>
                              <td>".$blood_groups['bloodGroup']."</td>
                              <td>".$blood_groups['charge']."</td>
                              <td>".$blood_groups['bloodBags']."</td>
                              <td style='text-align: center;'>
                              <a href='lab-bloodbank.php?bloodGroup= hifriends'><span class='btn btn-primary fa fa-eye' data-toggle='modal' data-target='#myModal'></span></a></td>

                                   <!-- modal for changin charge amount-->
                                   <div class='modal fade' id='myModal' name='myModal' role='dialog'>
                                     <div class='modal-dialog'>


                                     //modal

                                   if(isset($_POST['ch_sub'])){

                                       $eff_chng = filter_input(INPUT_POST,'eff_chng',FILTER_SANITIZE_STRING);

                                        $eff_chngx= update("UPDATE bloodgroup_tb SET charge ='".$eff_chng."' WHERE bloodID= ");

                                        //$eff_ch= insert("INSERT INTO bloodgroup_tb(charge)VALUES('2345'");
                                         if($eff_chngx){

                                            echo "<script>alert('Update Is Effected');
                                          document.location.assign('lab-bloodbank.php')</script>";
                                           exit();


                                        }

                                       }



                                     <!--  content-->
                                     <div class='modal-content'>
                                       <div class='modal-header'name='mod_header' id='mod_header'>
                                         <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                         <h4 class='modal-title text-center' name='' id=''>QuatMedic </h4>
                                       </div>
                                       <div class='modal-body'>
                                         <center><p>RESET CHARGE&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name='eff_chng' id='eff_chng' class='form-control' ></p>
                                         <input type='submit' name='ch_sub' id='ch_sub' class='btn btn-info' value='CHANGE'></center>
                                         ".$blood_groups['bloodID']."
                                       </div>
                                       <div class='modal-footer'>
                                         <button type='button' name='mod_dismiss' id='mod_dismiss' class='btn btn-default' data-dismiss='modal'><b>Close</b></button>
                                       </div>
                                     </div>

                                   </div>
                                 </div>
                            </tr>";
      }?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>

                <div id="tab2" class="tab-pane">
                   <!-- <form action="#" method="post" class="form-horizontal">-->
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label">Blood Group</label>
                                <div class="controls">
                                  <select name="bloodGroup" class="span11"  id="bloodGroup" >
                                    <option value="default"> -- Blood Group --</option>
                                    <option value="O-positive">O-positive</option>
                                    <option value="O-negative">O-negative</option>
                                    <option value="A-positive">A-positive</option>
                                    <option value="A-negative">A-negative</option>
                                    <option value="B-positive">B-positive</option>
                                    <option value="B-negative">B-negative</option>
                                    <option value="AB-positive">AB-positive</option>
                                    <option value="AB-negative">AB-negative</option>
                                  </select>
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label"> Number Of Bags :</label>
                                <div class="controls">
                                  <input type="number" class="span11" placeholder="Number Of Bags" name="numberOfBags" />
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" class="btn btn-primary btn-block span10" name="save_blood">Save Blood</button>
                              </div>
                          </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
      </div>

<!--      <hr/>-->
           <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab3">Blood Donor List</a></li>
                    <li><a data-toggle="tab" href="#tab4">Add New Blood Donor</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab3" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Donor ID</th>
                              <th>Donor Name</th>
                              <th>Blood Group</th>
                              <!--<th>Number OF Times</th>-->
                             <!-- <th>Action</th>-->
                            </tr>
                          </thead>
                          <tbody>
                              <?php
                                $bank_show= select("SELECT * FROM bloodBank");
                                foreach($bank_show as $bank_shows){
                               echo "<tr>

                              <td>".$bank_shows['donorID']."</td>
                              <td>".$bank_shows['donorName']."</td>
                              <td>".$bank_shows['bloodGroup']."</td>
                              <!--<td></td>-->
                              <!--<td style='text-align: center;'><a href='#'><span class='btn btn-primary fa fa-eye'</span></a></td>-->
                            </tr>";
                          } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab4" class="tab-pane">
                    <form action="#" method="post" class="form-horizontal">
                    <div class="span6">
                          <div class="widget-content nopadding">
                              <div class="control-group">
                                <label class="control-label"> Full Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Full Name" name="fullName" required />
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label"> Date Of Birth :</label>
                                <div class="controls">
                                  <input type="date" class="span11" placeholder="Date Of Birth" name="dob" />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Blood Group</label>
                                <div class="controls">
                                  <select name="bloodGroup">
                                    <option value="default"> -- Blood Group --</option>
                                    <option value="O-positive">O-positive</option>
                                    <option value="O-negative">O-negative</option>
                                    <option value="A-positive">A-positive</option>
                                    <option value="A-negative">A-negative</option>
                                    <option value="B-positive">B-positive</option>
                                    <option value="B-negative">B-negative</option>
                                    <option value="AB-positive">AB-positive</option>
                                    <option value="AB-negative">AB-negative</option>
                                  </select>
                                </div>
                              </div>
                          </div>
                      </div>
                    <div class="span6">
                          <div class="widget-content nopadding">

                              <div class="control-group">
                                <label class="control-label">Gender</label>
                                <div class="controls">
                                  <select name="bloodGender">
                                    <option value="default"> -- Select Gender --</option>
                                    <option value="Male"> Male </option>
                                    <option value="Female"> Female </option>
                                    <option value="Other"> Other</option>
                                  </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label"> Phone Number :</label>
                                <div class="controls">
                                  <input type="tel" class="span11" placeholder="Phone Number" name="phoneNumber" required />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label"> Last Donate Date :</label>
                                <div class="controls">
                                  <input type="date" class="span11" name="lastDonate" />
                                </div>
                              </div>
                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" class="btn btn-primary btn-block span10"name="save_group">Save Blood</button>
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
