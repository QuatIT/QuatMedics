<?php
include '../assets/core/connection.php';

if(isset($_GET['cid'])){
    $centerID = $_GET['cid'];
    $status = trim('INACTIVE');
    $updatecenter = update("UPDATE medicalcenter SET activestatus='$status' WHERE centerID='$centerID'");

    if($updatecenter){
        echo "<script>alert('CENTER DEACTIVATED SUCCESSFULL.');window.location.href='medcenter-index';</script>";
    }else{
        echo "<script>alert('CENTER DEACTIVATION FAILED.');window.location.href='medcenter-index';</script>";
    }
}else{
        echo "<script>alert('NO CENTER SELECTED.');window.location.href='medcenter-index';</script>";
}
?>
