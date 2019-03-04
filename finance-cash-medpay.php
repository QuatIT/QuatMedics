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
$activityType = trim('PAYMENT');
$confirm = 'CONFIRMED';

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
$getPhacc = select("SELECT * FROM accounts WHERE centerID='$centerID' AND accountName='PHARMACY' AND accountPurpose='CREDIT'");
if($getPhacc){
	foreach($getPhacc as $phAccRow){
		$PhCrID = $phAccRow['accountID'];
		$PhCrAcc = $phAccRow['accBalance'];
		$PhCrName = $phAccRow['accountName'];
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
$newDebbal =  ($cnterDBAcc-$medprice);

//new credit account..
$newCrBal = ($PhCrAcc+$medprice);

//UPDATE MEDS TO CONFIRMED..
$confirmmeds = update("UPDATE prescribedmeds SET confirm='$confirm' WHERE prescribeid='$id'");

//update CREDIT account...
$updateCredit = update("UPDATE accounts SET accBalance='$newCrBal' WHERE centerID='$centerID' AND accountID='$PhCrID' AND accountPurpose='CREDIT'");

//update DEBIT account...
$updateDebit = update("UPDATE accounts SET accBalance='$newDebbal' WHERE centerID='$centerID' AND accountID='$cnterDBID' AND accountPurpose='DEBIT'");

//insert transaction..
$activity = 'Payment For '.$medicine;
$transaction = insert("INSERT INTO accounttransaction(centerID,creditAcc,creditAccBalance,debitAcc,debitAccBalance,Amount,patientID,staffID,activityType,activity,dateInsert) VALUES('$centerID','$PhCrID','$PhCrAcc','$cnterDBID','$cnterDBAcc','$medprice','$patientID','$staffID','$activityType','$activity','$dateInsert')");

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
