<?php
session_start();
include 'assets/core/connection.php';

$id = $_GET['id'];
$dateToday = trim(date('Y-m-d'));

//Get consultation charges details...
$consultdet = select("SELECT * FROM paymentfixed WHERE id='$id'");
foreach($consultdet as $consultRow){
    $centerID = $consultRow['centerID'];
	$conPrice = $consultRow['servicePrice'];
//	$labID = $consultRow['labID'];
	$patientID = $consultRow['patientID'];
	$dateInsert = $consultRow['dateInsert'];
}

//select Consultation credit account...
$getConacc = select("SELECT * FROM Accounts WHERE centerID='$centerID' AND accountName='CONSULTATION' AND accountType='CREDIT'");
if($getConacc){
	foreach($getConacc as $conAccRow){
		$ConCrAcc = $conAccRow['accBalance'];
		$ConCrName = $conAccRow['accountName'];
	}
}

//select center debit account..
$getCenterDBAcc = select("SELECT * FROM accounts WHERE centerID='$centerID' AND accountType='DEBIT' AND accountName='BANK ACCOUNT'");
if($getCenterDBAcc){
	foreach($getCenterDBAcc as $centerDBrow){
		$cnterDBAcc = $centerDBrow['accBalance'];
		$cnterDBName = $centerDBrow['accountName'];
	}
}

//new bedit account..
$newDebbal =  ($cnterDBAcc-$conPrice);

//new credit account..
$newCrBal = ($ConCrAcc+$conPrice);

//update CREDIT account...
$updateCredit = update("UPDATE accounts SET accBalance='$newCrBal' WHERE centerID='$centerID' AND accountName='".$ConCrName."' AND accountType='CREDIT'");

//update DEBIT account...
$updateDebit = update("UPDATE accounts SET accBalance='$newDebbal' WHERE centerID='$centerID' AND accountName='".$cnterDBName."' AND accountType='DEBIT'");

//insert transaction..
$activity = 'PAYMENT FOR CONSULTATION';
$transaction = insert("INSERT INTO accounttransaction(creditAcc,debitAcc,Amount,patientID,staffID,activity,dateInsert) VALUES('$ConCrName','$cnterDBName','$conPrice','$patientID','$staffID','$activity','$dateInsert')");

//update consult paymentfixed row..
$status = trim("Paid");
$update = update("UPDATE paymentfixed SET status='$status' WHERE id='$id'");

if($update){
    echo "<script>alert('Lab Payment Done.!');</script>";
     header("Location:". $_SESSION['current_page']);
}else{
     echo "<script>alert('Lab Payment Not Done.!');</script>";
     header("Location:". $_SESSION['current_page']);
}
?>
