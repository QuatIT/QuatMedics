<?php
include 'assets/core/connection.php';
session_start();
$id = $_GET['id'];
//$patientID = $_GET['pid'];
//$appointNumber = $_GET['aid'];
$status = trim("Paid");
//$consultation = new Consultation();
//$update = $consultation->updateAppointment($appointNumber,$staffID,$patientID,$status);

$update = update("UPDATE labresults SET paystatus='$status' WHERE id='$id'");
if($update){
    echo "<script>alert('Lab Payment Done.!');</script>";
     header("Location:". $_SESSION['current_page']);
}else{
     echo "<script>alert('Lab Payment Not Done.!');</script>";
     header("Location:". $_SESSION['current_page']);
}
?>
