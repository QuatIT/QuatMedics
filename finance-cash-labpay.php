<?php
include 'assets/core/connection.php';
session_start();
$id = $_GET['id'];
$dateToday = trim(date('Y-m-d'));
$getdetails = select("SELECT * FROM labresults WHERE id='$id'");
foreach($getdetails as $detailRow){
	$centerID = $detailRow['centerID'];
	$labprice = $detailRow['labprice'];
	$labID = $detailRow['labID'];
	$patientID = $detailRow['patientID'];
	$staffID = $detailRow['staffID'];
	$status = trim("Paid");
}

//get Lab Name..
$getlabName = select("SELECT labName FROM lablist WHERE labID='$labID'");
if($getlabName){
	foreach($getlabName as $labNameRow){
		$labName = $labNameRow['labName'];
	}
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
if($getCenterDBAcc){
	foreach($getCenterDBAcc as $centerDBrow){
		$cnterDBAcc = $centerDBrow['accBalance'];
		$cnterDBName = $centerDBrow['accountName'];
	}
}

//new bedit account..
$newDebbal =  ($cnterDBAcc-$labprice);
//new credit account..
$newCrBal = ($labCrAcc+$labprice);
//update CREDIT account...
$updateCredit = update("UPDATE accounts SET accBalance='$newCrBal' WHERE centerID='$centerID' AND accountName='".$labCrName."' AND accountType='CREDIT'");
//update DEBIT account...
$updateDebit = update("UPDATE accounts SET accBalance='$newDebbal' WHERE centerID='$centerID' AND accountName='".$cnterDBName."' AND accountType='DEBIT'");
//insert transaction..
$activity = 'PAYMENT FOR '.$labName;
$transaction = insert("INSERT INTO accounttransaction(creditAcc,debitAcc,Amount,patientID,staffID,activity,dateInsert) VALUES('$labCrName','$cnterDBName','$labprice','$patientID','$staffID','$activity','$dateToday')");

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
