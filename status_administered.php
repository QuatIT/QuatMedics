<?php
session_start();
 include 'assets/core/connection.php';
if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}else{
    $staff = select("SELECT * from centeruser WHERE username='".$_SESSION['username']."' AND password='".$_SESSION['password']."'");
    foreach($staff as $staffrow){
        $staffID = $staffrow['staffID'];
    }
}

$review=$_GET['rid'];
$pat = $_GET['patid'];
$ward = $_GET['wardID'];
$updater="Administered";


$update_stat = update("UPDATE wardmeds SET status='$updater' WHERE medID ='".$review."'");



//echo "<script>window.location='ward-patientDetails.php?rev={$review}&patid={$pat}&wardno={$ward}'</script>";
header("Location:". $_SESSION['current_page']);

?>
