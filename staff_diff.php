<?php
include 'assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$q = $_GET['id'];
//echo "<script>alert('{$q}')</script>";
//exit;

if($q == 'Staff'){
    $sql = select("SELECT * FROM staff WHERE centerID='".$_SESSION['centerID']."' ");
    foreach($sql as $row){
        ?>
        <option value="<?php echo $row['staffID']; ?>"><?php echo $row['firstName']." ".$row['otherName']." ".$row['lastName']; ?></option>
        <?php
    }
}elseif($q == 'Consulting'){
    $sql = select("SELECT * FROM consultingroom WHERE centerID='".$_SESSION['centerID']."' ");
    foreach($sql as $row){
        ?>
        <option value="<?php echo $row['roomID']; ?>"><?php echo $row['roomName']; ?></option>
        <?php
    }
}

//$sql = select("SELECT * FROM account_tb WHERE account_id='$q' ");
//
//if(count($sql) > 0){
//foreach($sql as $query){}

//    echo 'Account Number <input type="text" name="credit_ac_number" class="form-control" value="'.$query['account_id'].'" readonly> <input type="text" name="credit_ac_name" class="form-control" value="'.$query['account_name'].'" hidden="hidden"> ';
//  echo 'Account Balance <input type="text" name="credit_ac_balance" class="form-control" value="'.$query['acc_balance'].'" readonly>';

//}else{
//    echo '<div class="alert alert-dismissible alert-secondary">
//  <button type="button" class="close" data-dismiss="alert">&times;</button>
//  <strong>Sorry!</strong> Account number not found.
//</div>';
//}


?>
