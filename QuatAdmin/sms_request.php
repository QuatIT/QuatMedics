<?php
require_once '../assets/core/connection.php';

$success = '';
$error = '';


//generate centerID
$user = new User;
$centerIDs = $user->find_num_centerID() + 1;
//$centerIDs = User::find_num_centerID() ;
//mkdir(date('YmdHis'));

//echo mkdir(date('YmdHis').$centerIDs);

if(isset($_POST['btnSMSRequest'])){
    $smsamount = trim($_POST['smsamount']);
    $smscredit = trim($_POST['smscredit']);

    $reqsql = insert("INSERT INTO smscredits(sms_amount,sms_credit) VALUES('$smsamount','$smscredit')");

    if($reqsql){
        $success =  "CREDIT CREATED SUCCESSFULLY";
    }else{
         $error =  "CREDIT CREATION FAILED";
    }
}


if(isset($_POST['btnSave'])){

//declare and assign variables
$centerID = trim(substr($_POST['centerName'], 0, 5))."-".trim(sprintf('%06s',$centerIDs));
$centerName = $_POST['centerName'];
$centerCategory = $_POST['centerCategory'];
$centerLocation = $_POST['centerLocation'];
$numOfStaff = $_POST['numOfStaff'];
$aboutCenter = $_POST['aboutCenter'];
$numOfBranches = $_POST['numOfBranches'];
$userName = $_POST['userName'];
$password = $_POST['password'];
$email = $_POST['email'];
$accessLevel = CENTER_ADMIN;


if(count($user->find_by_centerID($centerID)) >= 1){
//    $centerID = randomString('10'); //regenerate centerID
    $centerID = substr($_POST['centerName'], 0, 5)."-".sprintf('%06s',$centerIDs);//regenerate centerID

//create center admin
$registerCenterAdmin = $user->createCenterAdmin($centerID,$centerName,$centerCategory,$centerLocation,$numOfStaff,$aboutCenter,$numOfBranches,$userName,$password,$accessLevel,$email);

if($registerCenterAdmin){

echo make_dir($centerID);


            $send_to = $email;
            $body = "Dear ".$centerName.", <br> Kindly find below your access to QUATMedic. <br><br> Username: ".$userName."<br>Password: ".$password."<br><br> Thank you.";
            $subj = "QUATMEDIC LOGIN ACCESS";
            $copy = "";

            //send mail
            echo send_mail($send_to,$copy,$body,$subj);


    $success =  "FACILITY ADMIN CREATED SUUCESSFULLY";
}else{
    $error =  "ERROR: FACILITY ADMIN COULD NOT CREATE";
}


}else{

//create center admin
$registerCenterAdmin = $user->createCenterAdmin($centerID,$centerName,$centerCategory,$centerLocation,$numOfStaff,$aboutCenter,$numOfBranches,$userName,$password,$accessLevel,$email);

if($registerCenterAdmin){
    echo make_dir($centerID);

            $send_to = $email;
            $body = "Dear ".$centerName.", <br> Kindly find below your access to QUATMedic. <br><br> Username: ".$userName."<br>Password: ".$password."<br><br> Thank you.";
            $subj = "QUATMEDIC LOGIN ACCESS";
            $copy = "";

            //send mail
            echo send_mail($send_to,$copy,$body,$subj);


    $success =  "FACILITY ADMIN CREATED SUUCESSFULLY";
}else{
    $error =  "ERROR: FACILITY ADMIN COULD NOT CREATE";
}


}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>QUAT MEDICS ADMIN</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="../css/fullcalendar.css" />
<link rel="stylesheet" href="../css/colorpicker.css" />
<link rel="stylesheet" href="../css/datepicker.css" />
<link rel="stylesheet" href="../css/uniform.css" />
<link rel="stylesheet" href="../css/select2.css" />
<link rel="stylesheet" href="../css/maruti-style.css" />
<link rel="stylesheet" href="../css/maruti-media.css" class="skin-color" />
<link rel="stylesheet" href="../assets/css/font-awesome2.css" />
        <style>
        .active{
            background-color: #209fbf;
        }
    </style>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="quatadmin-index"> QUATMEDIC</a></h1>
</div>
<!--close-Header-part-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li class=" dropdown" id="settings">
        <a href="#" data-toggle="dropdown" data-target="#settings" class="dropdown-toggle">
            <i class="icon icon-cog"></i>
            <span class="text">Settings</span>
            <b class="caret"></b>
        </a>
      <ul class="dropdown-menu">
        <li><a title="" href="#"><i class="icon icon-user"></i> Profile</a></li>
        <li><a title="Logout" href="../logout"><i class="icon icon-share-alt"></i> Logout</a></li>
      </ul>
    </li>
  </ul>
</div>
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="index"><i class="icon icon-home"></i> <span>Dashboard</span></a></li>
    <li><a href="medcenter-index"><i class="icon icon-plus-sign"></i> <span>Medical Centers</span></a></li>
    <li><a href="#"><i class="icon icon-calendar"></i> <span>Subscriptions</span></a> </li>
    <li class="active"><a href="sms_request.php"><i class="icon icon-envelope"></i> <span>SMS Request</span></a> </li>
    </ul>
</div>



<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Out Patient Department" class="tip-bottom"><i class="icon-plus-sign"></i> MEDICAL CENTERS</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">SMS REQUEST</h3>
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
                    <li class="active"><a data-toggle="tab" href="#tab1">SMS Request</a></li>
                    <li><a data-toggle="tab" href="#tab2">SMS CREDIT</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>SMS REQUESTS</h5>
                      </div>
                    <div class="widget-content nopadding">

                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Center ID</th>
                              <th>Sendr's Name</th>
                              <th>Amount</th>
                              <th>SMS Credit</th>
                              <th>Transactional ID</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="sms_center">
                              <?php
                                    $smsR = select("SELECT * FROM sms_tb WHERE status='".SMS_PENDING."' ");
                                    foreach($smsR as $req_sms){ ?>
                                <tr>
                                    <td><?php echo $req_sms['centerID']; ?></td>
                                    <td><?php echo $req_sms['senderName']; ?></td>
                                    <td><?php echo "GHC ".$req_sms['amount']; ?></td>
                                    <td><?php echo $req_sms['credit']; ?></td>
                                    <td><?php echo $req_sms['transactionID']; ?></td>
                                    <td>
<!--                                        <a class="btn-link" data-toggle="modal" data-target="#myModal<?php #echo $req_sms['id'];?>">Recharge SMS</a>-->
                                        <a class="btn-link" href="credit_sms?id=<?php echo $req_sms['requestID'].'&centerID='.$req_sms['centerID'].'&amount='.$req_sms['amount'].'&cred='.$req_sms['credit'] ; ?>">Recharge SMS</a>
                                    </td>
                              </tr>



<!-- Modal -->
<div id="myModal<?php echo $req_sms['id'];?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header<?php echo $req_sms['id'];?></h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


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
                                <label class="control-label">SMS Amount:</label>
                               <div class="controls">


                                  <input type="number" min="0" class="span11" name="smsamount" value="" required />

                                </div>
                              </div>
<!--                              <div class="control-group">-->
                                <label class="control-label">SMS CREDIT</label>
                                <div class="controls">
                                  <input type="number" min="0" class="span11" name="smscredit" placeholder="" required />
                                </div>


                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" name="btnSMSRequest" class="btn btn-primary btn-block span10">Save SMS CREDIT</button>
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
  <div id="footer" class="span12"> 2018 &copy; QUAT MEDICS ADMIN BY  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a> </div>
</div>
<script src="../js/excanvas.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery.ui.custom.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-colorpicker.js"></script>
<script src="../js/bootstrap-datepicker.js"></script>
<script src="../js/jquery.flot.min.js"></script>
<script src="../js/jquery.flot.resize.min.js"></script>
<script src="../js/jquery.peity.min.js"></script>
<script src="../js/fullcalendar.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/bootstrap-colorpicker.js"></script>
<script src="../js/bootstrap-datepicker.js"></script>
<script src="../js/jquery.uniform.js"></script>
<script src="../js/select2.min.js"></script>
<script src="../js/maruti.js"></script>
<script src="../js/maruti.tables.js"></script>
<script src="../js/maruti.dashboard.js"></script>
<script src="../js/maruti.chat.js"></script>
<script src="../js/maruti.form_common.js"></script>
<!--<script src="js/maruti.js"></script> -->


    <script>
    function dis(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","load_MedCenter.php",false);
        xmlhttp.send(null);
        document.getElementById("load_med_center").innerHTML=xmlhttp.responseText;
    }
        dis();

        setInterval(function(){
            dis();
        },10000);
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
