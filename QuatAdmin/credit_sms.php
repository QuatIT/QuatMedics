<?php
include '../assets/core/connection.php';

$reqID = $_GET['id'];
$centerID = $_GET['centerID'];
$cred = $_GET['cred'];

$sql = select("SELECT * FROM medicalcenter WHERE centerID='".$centerID."' ");
foreach($sql as $row){
    $credit = $row['credit'];
    $creditArr = $row['creditArr'];
}

$newCredit = $credit + $cred;
$newCreditArr = $creditArr + $cred;

$charge = update("UPDATE medicalcenter SET credit='$newCredit', creditArr='$newCreditArr' WHERE centerID='$centerID' ");
$charge .= update("UPDATE sms_tb SET status='".SMS_APPROVED."' WHERE requestID='$reqID' ");
if($charge){
    echo "<script>alert('SMS CREDITED SUCCESSFULLY')
                    window.location.href='sms_request';</script>";
}

?>
