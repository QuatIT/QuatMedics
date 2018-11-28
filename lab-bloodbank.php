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


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
    <style>
        .active{
            background-color: #209fbf;
        }
        .modal-header {
	padding-bottom: 5px;
}

.modal-footer {
    	padding: 0;
	}

.modal-footer .btn-group button {
	height:40px;
	border-top-left-radius : 0;
	border-top-right-radius : 0;
	border: none;
	border-right: 1px solid #ddd;
}

.modal-footer .btn-group:last-child > button {
	border-right: 0;
}
    </style>
</head>
<body>

<?php
    include 'layout/head.php';

    if($_SESSION['accessLevel']=='LABORATORY' || $_SESSION['username']=='rik'){

        $success='';
        $error='';

      //generate donor id
        $donor = new Donor;
 $donorID = $donor->get_donor_id()+1;
 $donor_ID = "DNR-".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$donorID);

//generate blood id
        $blood = new blood;
$bloodID = $blood->get_bld_amt() + 1;
$blood_ID = "BLD-".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$bloodID);

 //save into bloodbank
 if(isset($_POST['save_group'])){

  $cent_id=select("SELECT * FROM centeruser");
  foreach($cent_id as $cent_ids){}

  $fullname = filter_input(INPUT_POST, 'fullName',FILTER_SANITIZE_STRING);
  $dob = filter_input(INPUT_POST, 'dob',FILTER_SANITIZE_STRING);
  $bloodGroup = filter_input(INPUT_POST, 'bloodGroup',FILTER_SANITIZE_STRING);
  $bloodGender = filter_input(INPUT_POST, 'bloodGender',FILTER_SANITIZE_STRING);
  $phoneNumber = filter_input(INPUT_POST, 'phoneNumber',FILTER_SANITIZE_STRING);
  $lastDonate = filter_input(INPUT_POST, 'lastDonate',FILTER_SANITIZE_STRING);
  $num_of_bags =  filter_input(INPUT_POST, 'num_of_bags',FILTER_SANITIZE_STRING);

  $find_id=select("SELECT * FROM bloodgroup_tb");

  if($bloodGroup=$_POST['bloodGroup']){
  foreach($find_id as $find_ids){}
  }

  $bank_insert=insert("INSERT INTO bloodbank(bloodID,donorID,centerID,amtAvail,donorName,gender,bloodGroup,phoneNumber,homeAddress,dob,lastDonate)
VALUES('".$find_ids['bloodID']."','".$donor_ID."','".$cent_ids['centerID']."','".$num_of_bags."','".$fullname."','".$bloodGender."','".$bloodGroup."','".$phoneNumber."','','".$dob."','".$lastDonate."')");


   if($bank_insert){
    $success= "<script>document.write('Entry Was Successful');
                        window.location.href='lab-bloodbank';</script>";


  }

//update bloodgroup_tb bloodbag cell
$bag_update = select("SELECT * FROM bloodgroup_tb");
foreach($bag_update as $bag_updates){$bag_updates['bloodBags']=$blood_update;}

$blood_tally = update("UPDATE bloodgroup_tb SET bloodBags = bloodBags + $num_of_bags WHERE bloodGroup ='".$_POST['bloodGroup']."' ");

}



//save into bloodGroup_tb
if(isset($_POST['save_blood'])){

  $bloodGroup = filter_input(INPUT_POST, 'bloodGroup',FILTER_SANITIZE_STRING);
  $numberOfBags = filter_input(INPUT_POST, 'numberOfBags',FILTER_SANITIZE_STRING);


  $group_insert=insert("INSERT INTO bloodgroup_tb(bloodID,bloodGroup,bloodBags)VALUES('$blood_ID ','".$bloodGroup."','".$numberOfBags."')");
  if($group_insert){
    $success= "<script>document.write('Entry Was Successful');
                    window.location.href='lab-bloodbank.php'</script>";
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
 <?php
                      if($success){
                      ?>
                      <div class="alert alert-success">
                  <strong>Success!</strong> <?php echo $success; ?>
                </div>
                      <?php } if($error){
                          ?>
                      <div class="alert alert-danger">
                  <strong>Error!</strong> <?php echo $error; ?>
                </div>
                      <?php
                      } ?>
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
                              <th>Blood Group</th>
                              <th>Charge</th>
                              <th>Amount Available</th>
                              <th>Action</th>
<!--                              <th>Action</th>-->
                            </tr>
                          </thead>
                          <tbody>

                            <?php
                              $blood_grp=select("SELECT * FROM bloodgroup_tb");
                              foreach($blood_grp as $blood_grpx){
                                ?>


                            <tr>
                              <td><?php echo $blood_grpx['bloodID']; ?></td>
                              <td><?php echo $blood_grpx['bloodGroup']; ?></td>
                              <td><?php echo $blood_grpx['charge']; ?></td>
                              <td><?php echo $blood_grpx['bloodBags']; ?></td>
                            <td style='text-align: center;'>
                                <a data-toggle="modal" data-target="#myModal<?php echo $blood_grpx['id']; ?>"><i class="btn btn-primary fa fa-usd"></i></a>
                               <!--  <a href='lab-bloodbank.php'><span class='btn btn-primary fa fa-eye' data-toggle='modal' data-target=''></span></a> -->
                            </td>

                                    <?php
 //modal codes

if(isset($_POST['ch_sub'.$blood_grpx['id']])){

    $eff_chng = filter_input(INPUT_POST,'eff_chng',FILTER_SANITIZE_STRING);
//    $eff_chng = $_POST['eff_chng'];

    $all_chng = select("SELECT * FROM bloodgroup_tb");
    foreach($all_chng as $all_chngs){}

     $eff_chngx= update("UPDATE bloodgroup_tb SET charge ='$eff_chng' WHERE bloodID ='".$blood_grpx['bloodID']."'");

      if($eff_chngx){

         echo "<script>alert('Update Is Effected {$blood_grpx['bloodID']}');
                window.location.href='lab-bloodbank.php';</script>";
//        exit();


     }

    }
        ?>

<!-- Modal -->
<div id="myModal<?php echo $blood_grpx['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header <?php echo $blood_grpx['bloodID']; ?></h4>
      </div>
      <div class="modal-body">
<!--        <p>Some text in the modal.</p>-->
          <form action="" method="post">

                                         <center><p><b>RESET CHARGE</b>&nbsp;&nbsp;&nbsp;&nbsp;<input type='number' name='eff_chng' id='eff_chng' class='form-control'></p>
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' name='ch_sub<?php echo $blood_grpx['id']; ?>' id='ch_sub' class='btn btn-info' value='CHANGE'></center>

<!--                                       </div>-->
<!--
                                       <div class='modal-footer'>
                                         <button type='button' name='mod_dismiss' id='mod_dismiss' class='btn btn-default' data-dismiss='modal'><b>Close</b></button>
                                       </div>
-->
          </form>
                                     </div>

<!--      </div>-->
<!--
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
-->
    </div>

  </div>
</div>

                                </tr>
                           <?php   }?>
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
                               <label class="control-label"> BloodID :</label>
                                <div class="controls">
                                  <input type="text" class="span11"  value="<?php echo $bloodID; ?>" name="blood_ID" readonly />
                                </div>
                              </div>
                          </div>
                      </div>
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
                                $bank_show= select("SELECT * FROM bloodbank");
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
                                <label class="control-label"> Donor ID :</label>
                                <div class="controls">
                                  <input type="text" class="span11" value="<?php echo $donorID ?>" name="donor" readonly />
                                </div>
                              </div>

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

                                 <div class="control-group">
                                <label class="control-label"> Number Of Bags :</label>
                                <div class="controls">
                                  <input type="tel" class="span11" placeholder="Number of Bags" name="num_of_bags" required/>
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
<div class="row-fluid ">
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
<?php }else{echo "<script>window.location='404'</script>";}?>
