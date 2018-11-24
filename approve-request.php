<?php

include 'assets/core/connection.php';

$sid = $_GET['sid']; //medicine id
$id = $_GET['id'];
$piece = $_GET['piece'];

$sql = select("SELECT * FROM pharmacy_inventory WHERE medicine_id='$sid' ");
foreach($sql as $row){}

$tpiece = $row['no_of_piece'] - $piece;

$dsql = select("SELECT * FROM dispensary_tb WHERE medicine_id='$sid' ");
foreach($dsql as $drow){}

$dpiece = $drow['no_of_piece'] + $piece;

$serve .= update("UPDATE pharmacy_inventory SET no_of_piece='".$tpiece."' WHERE medicine_id='$sid' ");
$serve .= update("UPDATE dispensary_tb SET no_of_piece='$dpiece', request_status='approved', approved_by='".$_SESSION['username']."', date_approved=CURDATE() WHERE medicine_id='$sid' ");
$serve = update("UPDATE dispensary_tb_history SET no_of_piece='$dpiece', request_status='approved', approved_by='".$_SESSION['username']."', date_approved=CURDATE() WHERE medicine_id='$sid' && id='$id' ");

if($serve){
    echo "<script>window.location.href='pharmacy-inventory?tab=srequests'</script>";
}

?>
