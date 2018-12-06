<?php
include 'assets/core/connection.php';
session_start();
$id = $_GET['id'];
$dateToday = trim(date('Y-m-d'));
$getdetails = select("SELECT * labresults WHERE id='$id'");
foreach($getdetails as $detailRow){
	$centerID = $detailRow['centerID'];
	$labprice = $detailRow['labprice'];
	$labID = $detailRow['labID'];
	$patientID = $detailRow['patientID'];
	$staffID = $detailRow['staffID'];
	$status = trim("Paid");
}

//select lab credit account...
$getlabacc = select("SELECT * FROM Accounts WHERE centerID='$centerID' AND accountName='LABORATORY' AND accountType='CREDIT'");
if($getlabacc){
	foreach($getlabacc as $labaccRow){
		$labCrAcc = $labaccRow['accBalance'];
		$labCrName = $labaccRow['accountName'];
	}
}

//select center debit account..
$getCenterDBAcc = select("SELECT * FROM accounts WHERE centerID='$centerID' AND accountType='DEBIT' AND accountName='BANK ACCOUNT'");
if($getlabacc){
	foreach($getlabacc as $centerDBrow){
		$cnterDBAcc = $centerDBrow['accBalance'];
		$cnterDBName = $centerDBrow['accountName'];
	}
}

//new bedit account..
$newDebbal =  ($cnterDBAcc-$labprice);
//new credit account..
$newCrBal = ($labCrAcc+$labprice);
//update CREDIT account...
$updateCredit = update("UPDATE accounts SET accBalance='$newCrBal' WHERE centerID='$centerID' AND accountName='LABORATORY' AND accountType='CREDIT'");
//update DEBIT account...
$updateDebit = update("UPDATE accounts SET accBalance='$newDebbal' WHERE centerID='$centerID' AND accountName='BANK ACCOUNT' AND accountType='DEBIT'");
//insert transaction..
$activity = trim('LAB PAYMENT FOR ');
$transaction = insert("INSERT INTO accounttransaction(creditAcc,debitAcc,Amount,patientID,staffID,activity,dateInsert) VALUES('$labCrName','$cnterDBName','$labprice','$patientID','$staffID','$activity','$dateInsert')");

//update lab results row..
$update = update("UPDATE labresults SET paystatus='$status' WHERE id='$id'");

if($update){
    echo "<script>alert('Lab Payment Done.!');</script>";
     header("Location:". $_SESSION['current_page']);
}else{
     echo "<script>alert('Lab Payment Not Done.!');</script>";
     header("Location:". $_SESSION['current_page']);
}
?>
