<?php
include 'assets/core/connection.php';

$q = $_GET['id'];

$sql = select("SELECT * FROM accounts WHERE accountID='$q' ");

if(count($sql) > 0){
foreach($sql as $query){}

    echo '<input type="text" class="span12" name="creditAccID" value="'.$query['accountID'].'" readonly /><input type="text" name="credit_ac_name" class="form-control" value="'.$query['accountName'].'"  style="display:none;">';

}


?>
