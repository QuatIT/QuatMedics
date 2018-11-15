<?php
include 'assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$med_status='administered';
$id=$_GET['id'];

$sqll = update("UPDATE eme_ward SET nurseID='".$_SESSION['username']."' , med_status='".$med_status."' WHERE id='$id' ");

echo "<script>window.location.href='emergency-patient-treatment?emeid={$_GET['emeid']}&&pid={$_GET['pid']}'</script>";


?>

