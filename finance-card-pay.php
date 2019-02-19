<?php
session_start();
include 'assets/core/connection.php';
if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}else{
    $staff = select("SELECT * from centeruser WHERE username='".$_SESSION['username']."' AND password='".$_SESSION['password']."'");
    foreach($staff as $staffrow){
        $staffID = $staffrow['staffID'];
        $centerID = $staffrow['centerID'];
    }
}


$id = $_GET['id'];
$dateToday = trim(date('Y-m-d'));
$activityType = trim('PAYMENT');

//Get consultation charges details...
$consultdet = select("SELECT * FROM paymentfixed WHERE id='$id'");
foreach($consultdet as $consultRow){
    $centerID = $consultRow['centerID'];
	$conPrice = $consultRow['servicePrice'];
	$patientID = $consultRow['patientID'];
	$dateInsert = $consultRow['dateinsert'];
}

//select Consultation credit account...
$getConacc = select("SELECT * FROM accounts WHERE centerID='$centerID' AND accountName='OPD' AND accountPurpose='CREDIT'");
if($getConacc){
	foreach($getConacc as $conAccRow){
		$ConCrID = $conAccRow['accountID'];
		$ConCrAcc = $conAccRow['accBalance'];
		$ConCrName = $conAccRow['accountName'];
	}
}

//select center debit account..
$getCenterDBAcc = select("SELECT * FROM accounts WHERE centerID='$centerID' AND accountPurpose='DEBIT' AND accountName='BANK ACCOUNT'");
if($getCenterDBAcc){
	foreach($getCenterDBAcc as $centerDBrow){
		$cnterDBID = $centerDBrow['accountID'];
		$cnterDBAcc = $centerDBrow['accBalance'];
		$cnterDBName = $centerDBrow['accountName'];
	}
}

//new bedit account..
$newDebbal =  ($cnterDBAcc-$conPrice);

//new credit account..
$newCrBal = ($ConCrAcc+$conPrice);

//update CREDIT account...
$updateCredit = update("UPDATE accounts SET accBalance='$newCrBal' WHERE centerID='$centerID' AND accountID='".$ConCrID."' AND accountPurpose='CREDIT'");

//update DEBIT account...
$updateDebit = update("UPDATE accounts SET accBalance='$newDebbal' WHERE centerID='$centerID' AND accountID='".$cnterDBID."' AND accountPurpose='DEBIT'");

//insert transaction..
$activity = 'PAYMENT FOR ID CARD';
$transaction = insert("INSERT INTO accounttransaction(centerID,creditAcc,creditAccBalance,debitAcc,debitAccBalance,Amount,patientID,staffID,activityType,activity,dateInsert) VALUES('$centerID','$ConCrID','$ConCrAcc','$cnterDBID','$cnterDBAcc','$conPrice','$patientID','$staffID','$activityType','$activity','$dateInsert')");

//update id card paymentfixed row..
$status = trim("Paid");
$update = update("UPDATE paymentfixed SET status='$status' WHERE id='$id'");

if($update){
    echo "<script>alert('ID CARD PAYMENT DONE.!');window.location.href='finance-cash';</script>";
}else{
     echo "<script>alert('ID CARD PAYMENT FAILED, TRY AGAIN.!');</script>";
     header("Location:". $_SESSION['current_page']);
}
?>
