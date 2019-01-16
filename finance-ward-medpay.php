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

//get assignid
$id = $_GET['id'];
$dateToday = trim(date('Y-m-d'));

//get admit meds details..
$assigndet = select("SELECT * FROM wardmeds WHERE medID='$id'");
foreach($assigndet as $assignRow){}

//get patient details..
$pdet = select("SELECT * FROM patient where patientID='".$assignRow['patientID']."'");
foreach($pdet as $prow){}

//get ward details...
$warddet = select("SELECT * FROM wardlist WHERE wardID='".$assignRow['wardID']."'");
foreach($warddet as $wardrow){}

//select Pharmacy credit account...
$getPhacc = select("SELECT * FROM Accounts WHERE centerID='$centerID' AND accountName='PHARMACY' AND accountType='CREDIT'");
if($getPhacc){
	foreach($getPhacc as $phAccRow){
		$PhCrAcc = $phAccRow['accBalance'];
		$PhCrName = $phAccRow['accountName'];
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
$newDebbal =  ($cnterDBAcc-$assignRow['charge']);

//new credit account..
$newCrBal = ($PhCrAcc+$assignRow['charge']);

//update CREDIT account...
$updateCredit = update("UPDATE accounts SET accBalance='$newCrBal' WHERE centerID='$centerID' AND accountName='$PhCrName' AND accountType='CREDIT'");

//update DEBIT account...
$updateDebit = update("UPDATE accounts SET accBalance='$newDebbal' WHERE centerID='$centerID' AND accountName='$cnterDBName' AND accountType='DEBIT'");

//insert transaction..
$activity = 'Payment For '.$assignRow['medicine'];
$transaction = insert("INSERT INTO accounttransaction(centerID,creditAcc,debitAcc,Amount,patientID,staffID,activity,dateInsert) VALUES('$centerID','$PhCrName','$cnterDBName','".$assignRow['charge']."','".$assignRow['patientID']."','$staffID','$activity','$dateInsert')");

//update consult prescribedmeds row..
$status = trim("Paid");
$update = update("UPDATE wardmeds SET paystatus='$status' WHERE medID='$id'");

if($update){
    echo "<script>alert('Medication Payment Done.!');</script>";
     header("Location:". $_SESSION['current_page']);
}else{
     echo "<script>alert('Medication Payment Not Done.!');</script>";
     header("Location:". $_SESSION['current_page']);
}
?>
