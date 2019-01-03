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

//get id
$id = $_GET['id'];
$dateToday = trim(date('Y-m-d'));

//Get prescribed medicine charges details...
$presmeds = select("SELECT * FROM prescribedmeds WHERE prescribeid='$id'");
foreach($presmeds as $medRow){
    $prescribeCode = $medRow['prescribeCode'];
	$medicine = $medRow['medicine'];
	$medprice = $medRow['medprice'];
	$dateInsert = $medRow['dateInsert'];
}


//Get prescription details
$prescription = select("SELECT * FROM prescriptions WHERE prescribeCode='$prescribeCode'");
foreach($prescription as $prescibeRow){
    $patientID = $prescibeRow['patientID'];
}

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
$newDebbal =  ($cnterDBAcc-$medprice);

//new credit account..
$newCrBal = ($PhCrAcc+$medprice);

//update CREDIT account...
$updateCredit = update("UPDATE accounts SET accBalance='$newCrBal' WHERE centerID='$centerID' AND accountName='$PhCrName' AND accountType='CREDIT'");

//update DEBIT account...
$updateDebit = update("UPDATE accounts SET accBalance='$newDebbal' WHERE centerID='$centerID' AND accountName='$cnterDBName' AND accountType='DEBIT'");

//insert transaction..
$activity = 'Payment For '.$medicine;
$transaction = insert("INSERT INTO accounttransaction(centerID,creditAcc,debitAcc,Amount,patientID,staffID,activity,dateInsert) VALUES('$centerID','$PhCrName','$cnterDBName','$medprice','$patientID','$staffID','$activity','$dateInsert')");

//update consult prescribedmeds row..
$status = trim("Paid");
$update = update("UPDATE prescribedmeds SET paystatus='$status' WHERE prescribeid='$id'");

if($update){
    echo "<script>alert('Medication Payment Done.!');</script>";
     header("Location:". $_SESSION['current_page']);
}else{
     echo "<script>alert('Medication Payment Not Done.!');</script>";
     header("Location:". $_SESSION['current_page']);
}
?>
