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
$activityType =  trim("PAYMENT");
//get admit details..
$assigndet = select("SELECT * FROM wardassigns WHERE assignID='$id'");
foreach($assigndet as $assignRow){}

//get patient details..
$pdet = select("SELECT * FROM patient where patientID='".$assignRow['patientID']."'");
foreach($pdet as $prow){}

//get ward details...
$warddet = select("SELECT * FROM wardlist WHERE wardID='".$assignRow['wardID']."'");
foreach($warddet as $wardrow){}

//select Ward credit account...
$getWdacc = select("SELECT * FROM Accounts WHERE centerID='$centerID' AND accountName='WARD' AND accountPurpose='CREDIT'");
if($getWdacc){
	foreach($getWdacc as $wdAccRow){
		$wdCrID = $wdAccRow['accountID'];
		$wdCrAcc = $wdAccRow['accBalance'];
		$wdCrName = $wdAccRow['accountName'];
	}
}

//select center debit account..
$getCenterDBAcc = select("SELECT * FROM accounts WHERE centerID='$centerID' AND accountType='DEBIT' AND accountPurpose='BANK ACCOUNT'");
if($getCenterDBAcc){
	foreach($getCenterDBAcc as $centerDBrow){
		$cnterDBID = $centerDBrow['accountID'];
		$cnterDBAcc = $centerDBrow['accBalance'];
		$cnterDBName = $centerDBrow['accountName'];
	}
}

//new bedit account..
$newDebbal =  ($cnterDBAcc-$assignRow['charge']);

//new credit account..
$newCrBal = ($wdCrAcc+$assignRow['charge']);

//update CREDIT account...
$updateCredit = update("UPDATE accounts SET accBalance='$newCrBal' WHERE centerID='$centerID' AND accountName='$wdCrName' AND accountType='CREDIT'");
if($updateCredit){
    //update DEBIT account...
    $updateDebit = update("UPDATE accounts SET accBalance='$newDebbal' WHERE centerID='$centerID' AND accountName='$cnterDBName' AND accountType='DEBIT'");

    if($updateDebit){
        //insert transaction..
        $activity = 'Payment For Ward Discharge From '.$wardrow['wardName'];
        $transaction = insert("INSERT INTO accounttransaction(centerID,creditAcc,creditAccBalance,debitAcc,debitAccBalance,Amount,patientID,staffID,activityType,activity,dateInsert) VALUES('$centerID','$wdCrID','$wdCrAcc','$cnterDBID','$cnterDBAcc','".$assignRow['charge']."','".$assignRow['patientID']."','$staffID','$activityType','$activity','$dateInsert')");

        if($transaction){
           //update wardassigns row..
            $status = trim("Paid");
            $update = update("UPDATE wardassigns SET paystatus='$status' WHERE assignID='$id'");

                if($update){
                    echo "<script>alert('Ward Discharge Payment Done.!');</script>";
                     header("Location:". $_SESSION['current_page']);
                }else{
                     echo "<script>alert('Ward Discharge Not Done.!');</script>";
                     header("Location:". $_SESSION['current_page']);
                }
        }
    }
}
?>
