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
$getdetails = select("SELECT * FROM labresults WHERE id='$id'");
foreach($getdetails as $detailRow){
	$centerID = $detailRow['centerID'];
	$labprice = $detailRow['labprice'];
	$labID = $detailRow['labID'];
	$patientID = $detailRow['patientID'];
//	$staffID = $detailRow['staffID'];
}
$activityType = trim('PAYMENT');
$status = trim("Paid");

//get Lab Name for transaction table..
$getlabName = select("SELECT labName FROM lablist WHERE labID='$labID'");
if($getlabName){
	foreach($getlabName as $labNameRow){
		$labName = $labNameRow['labName'];
	}
}

//select lab credit account...
$getlabacc = select("SELECT * FROM Accounts WHERE centerID='$centerID' AND accountName='LABORATORY' AND accountPurpose='CREDIT'");
if($getlabacc){
	foreach($getlabacc as $labaccRow){
		$labCrID = $labaccRow['accountID'];
		$labCrAcc = $labaccRow['accBalance'];
		$labCrName = $labaccRow['accountName'];
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
$newDebbal =  ($cnterDBAcc-$labprice);

//new credit account..
$newCrBal = ($labCrAcc+$labprice);

//update CREDIT account...
$updateCredit = update("UPDATE accounts SET accBalance='$newCrBal' WHERE centerID='$centerID' AND accountName='".$labCrName."' AND accountPurpose='CREDIT'");

//update DEBIT account...
$updateDebit = update("UPDATE accounts SET accBalance='$newDebbal' WHERE centerID='$centerID' AND accountName='".$cnterDBName."' AND accountPurpose='DEBIT'");

//insert transaction..
$activity = 'PAYMENT FOR '.$labName;
$transaction = insert("INSERT INTO accounttransaction(centerID,creditAcc,creditAccBalance,debitAcc,debitAccBalance,Amount,patientID,staffID,activityType,activity,dateInsert) VALUES('$centerID','$labCrID','$labCrAcc','$cnterDBID','$cnterDBAcc','$labprice','$patientID','$staffID','$activityType','$activity','$dateToday')");

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
