<?php
 include 'assets/core/connection.php';

$review=$_GET['rid'];
$pat = $_GET['patid'];
$ward = $_GET['wardID'];
$updater="Administered";


$update_stat = update("UPDATE review_tb SET status='$updater' WHERE reviewID ='".$review."'");



echo "<script>window.location='ward-patientDetails.php?rev={$review}&patid={$pat}&wardno={$ward}'</script>";


?>
