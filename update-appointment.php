<?php
include 'assets/core/connection.php';
session_start();
$staffID = $_GET['sid'];
$patientID = $_GET['pid'];
$appointNumber = $_GET['aid'];
$status = trim("DONE");
$consultation = new Consultation();
$update = $consultation->updateAppointment($appointNumber,$staffID,$patientID,$status);

if($update){
    echo "<script>alert('Appointment Set As Done.!');</script>";
     header("Location:". $_SESSION['current_page']);
}else{
     echo "<script>alert('Appointment Not Set As Done.!');</script>";
     header("Location:". $_SESSION['current_page']);
}
?>
