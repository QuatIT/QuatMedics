<?php

include 'assets/core/connection.php';

$code = $_GET['code'];
$ph = $_GET['ph'];
$comment = $_GET['comment'];

$served = 'served';

$serve = update("UPDATE prescribedmeds SET prescribeStatus='$served',comment='$comment' WHERE prescribeid='$ph' ");

if($serve){
    echo "<script>window.location.href='pharmacy-patient.php?code={$code}'</script>";
}

?>
