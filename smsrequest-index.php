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

    $success = '';
    $error = '';

//    //generate centerID
//    $staffIDs = User::find_num_staffID() + 1;
//
//    if(isset($_POST['btnSave'])){
//
//        $staffID = substr(filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_STRING), 0, 5)."-".sprintf('%06s',$staffIDs);
//        $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
//        $lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_STRING);
//        $otherName = filter_input(INPUT_POST, "otherName", FILTER_SANITIZE_STRING);
//        $gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_STRING);
//        $dob = filter_input(INPUT_POST, "dob", FILTER_SANITIZE_STRING);
//        $specialty = filter_input(INPUT_POST, "specialty", FILTER_SANITIZE_STRING);
//        $staffCategory = filter_input(INPUT_POST, "staffCategory", FILTER_SANITIZE_STRING);
//        $staffDepartment = filter_input(INPUT_POST, "staffDepartment", FILTER_SANITIZE_STRING);
//        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRING);
//
//        $username = filter_input(INPUT_POST, "userName", FILTER_SANITIZE_STRING);
//        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
//        $userID = $staffID;
//
//        $centerID = $_SESSION['centerID'];
//
//        $centerUser = User::saveUserData($staffID,$firstName,$lastName,$otherName,$gender,$dob,$specialty,$staffCategory,$staffDepartment,$email,$centerID);
//
//        if($centerUser){
//
//            $accessLevel = $staffDepartment;
//
//
////            $userCredential = User::centerUserLogin($staffID,$username,$password,$accessLevel,$centerID);
//            $userCredential = User::saveUserCredential($staffID,$username,$password,$accessLevel,$centerID,$userID);
//
//            $send_to = $email;
//            $body = "Dear ".$firstName.", <br> Kindly find below your access to QUATMedic. <br><br> Username: ".$username."<br>Password: ".$password."<br><br> Thank you.";
//            $subj = "QUATMEDIC LOGIN ACCESS";
//            $copy = '';
//
//            //send mail
//            echo send_mail($send_to,$copy,$body,$subj);
//
//            $success = "USER DATA CREATED SUCCESSFULLY";
//        }else{
//            $error = "FAILED TO CREATE USER DATA";
//        }
//    }

?>


<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
    <li><a href="medics-index.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    <li class="active"><a href="smsrequest-index.php"><i class="icon-envelope"></i> <span>SMS Request</span></a> </li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="Staff Management" class="tip-bottom"><i class="icon-envelope"></i> SMS REQUEST</a>
    </div>
  </div>
  <div class="container">
      <h3 class="quick-actions">SMS REQUEST</h3>

      <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">SMS CREDITS</a></li>
                    <li><a data-toggle="tab" href="#tab2">REQUESTED SMS</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane active">
                    <div class="widget-box">
                      <div class="widget-title">
                         <span class="icon"><i class="icon-th"></i></span>
                        <h5>SMS CREDITS</h5>
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
                      </div>
                      <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Amount</th>
                              <th>Credit</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="credits">
                              <?php
                                    $credit=select("SELECT * FROM smsCredits");
                                    foreach($credit as $cred){ ?>
                                <tr>
                                    <td><?php echo $cred['sms_amount']; ?></td>
                                    <td><?php echo $cred['sms_credit']; ?></td>
                                    <td><a class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal<?php echo $cred['id']; ?>">Request SMS</a></td>

                <?php
                        $reqq = select("SELECT count(*) as counta FROM sms_tb");
                                foreach($reqq as $req){
                                    $reqID = $req['counta'] + 1;
                                }

                    if(isset($_POST['btnRequest'.$cred['id']])){
                        $centerID = $_SESSION['centerID'];
//                        $center_staffID = $staffID;
                        $amount = $cred['sms_amount'];
                        $credit = $cred['sms_credit'];
                        $transactionID = filter_input(INPUT_POST, "transactionID", FILTER_SANITIZE_STRING);
                        $senderName = filter_input(INPUT_POST, "senderName", FILTER_SANITIZE_STRING);
                        $requestID = "REQ-SMS-".$centerID."-".sprintf('%06s',$reqID);
                        $status = SMS_PENDING;

                        $req_sql = insert("INSERT INTO sms_tb(centerID,staffID,amount,credit,transactionID,senderName,requestID,status,dateRegistered) VALUES('$centerID','$centerID','$amount','$credit','$transactionID','$senderName','$requestID','$status',CURDATE()) ");

                        if($req_sql){
                            $success = "<script>document.write('SMS REQUESTED. YOUR SMS WILL BE CREDITED SOON.')
                                                window.location.href='smsrequest-index';</script>";
                        }

                    }

                                    ?>


<!-- Modal -->
<div id="myModal<?php echo $cred['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">REQUEST SMS CREDIT</h4>
      </div>
      <div class="modal-body">
<!--        <p>Some text in the modal.</p>-->
          <form action="" method="post">
              <div class="span6">
            Request ID <input type="text" class="span12" value="<?php echo $reqID; ?>" readonly name="requestID">
              </div>
                  <div class="span6">
            Sender Name <input type="text" class="span12" name="senderName">
              </div>
              <div class="span6">
            Transaction Number <input type="number" class="span12" name="transactionID">
              </div>
              <div class="span6">
                                <input type="submit" class="btn btn-xs btn-primary" name="btnRequest<?php echo $cred['id']; ?>">
                  </div>
          </form>
      </div>
      <div class="modal-footer">
<!--        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
      </div>
    </div>

  </div>
</div>


                              </tr>
                              <?php } ?>
                            </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                          <thead>
                            <tr>
                              <th>Transaction ID</th>
                              <th>Sender Name</th>
                              <th>Amount</th>
                              <th>Credit</th>
                              <th>Status</th>
                              <th>Date</th>
                            </tr>
                          </thead>
                        <tbody>
                            <?php
                                $sms_sql = select("SELECT * FROM sms_tb WHERE centerID='".$_SESSION['centerID']."' ");
                                foreach($sms_sql as $sm){
                            ?>
                            <tr style="background-color:transparent;">
                                <td><?php echo $sm['transactionID']; ?></td>
                                <td><?php echo $sm['senderName']; ?></td>
                                <td><?php echo "GHC ".$sm['amount']; ?></td>
                                <td><?php echo $sm['credit']; ?></td>
                                <td><?php if($sm['status']=='sms_pending'){echo "<span class='badge badge-danger'>pending</span>";}elseif($sm['status']=='sms_approved'){echo "<span class='badge badge-success'>approved</span>";} ?></td>
                                <td><?php echo $sm['dateRegistered']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
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
  function newpatient(){
        xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","loads/centeruser-load.php",false);
        xmlhttp.send(null);
        document.getElementById("centeruser").innerHTML=xmlhttp.responseText;
    }
        newpatient();

        setInterval(function(){
            newpatient();
        },3000);
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
