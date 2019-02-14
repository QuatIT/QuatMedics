<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>QUATMEDIC ADMIN</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/colorpicker.css" />
<link rel="stylesheet" href="css/datepicker.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/maruti-style.css" />
<link rel="stylesheet" href="css/maruti-media.css" class="skin-color" />
<link rel="stylesheet" href="assets/css/font-awesome.css" />
<link rel="icon" href="quatmedics.png" type="image/x-icon" style="width:50px;">
<style>
.active{
/*    background-color: #209fbf;*/
}
</style>
</head>
<body>

<?php
include 'layout/head.php';

$consultation = new Consultation();
$centerID = $_SESSION['centerID'];
$success = '';
$error = '';


//saving Account..
if(isset($_POST['saveAccount'])){
	//count number of service entered..
	$nameNum = count( $_POST['accountName']);
	$typeNum = count( $_POST['accountPurpose']);
    $accountType = trim('REVENUE');
	//check number of services..
	if($nameNum > 0 && $typeNum >0){
		//saving services into database...
		for($n=0, $t=0; $n<$nameNum, $t<$typeNum; $n++,$t++){
				if(trim($_POST['accountName'][$n] != '') && trim($_POST['accountPurpose'][$t] != '')) {
					$accountName = trim( $_POST["accountName"][$n]);
					$accountPurpose = trim( $_POST["accountPurpose"][$t]);
//						$serviceType = trim("Service");
					//generate account ID
					$accIDs = $consultation->loadAccPrices($centerID) + 1;
					$accountID = "ACC-".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$accIDs);

					//check account name if already entered else save account..
					$accExist = select("SELECT * FROM accounts WHERE accountName='$accountName' AND centerID='$centerID'");
					if($accExist){
						$error = "<script>document.write('Account Already Saved..');</script>";
					}else{
						$saveService = insert("INSERT INTO accounts(accountID,centerID,accountName,accountPurpose,accountType,dateInsert) VALUES('$accountID','$centerID','$accountName','$accountPurpose','$accountType','$dateToday')");
						if($saveService){
							$success = "<script>document.write('Account Saved.');window.location='center-account';</script>";
						}else{
							$error = "<script>document.write('Account Not Saved, Try Again.');</script>";
						}
					}
				}
		}
	}else{
		$error = "<script>document.write('Empty Fields, Try Again.');</script>";
	}
}

//saving mode of payment...
if(isset($_POST['saveMode'])){
    $numMode = count($_POST['paymode']);
    $numType = count($_POST['payType']);

    if($numMode > 0 && $numType > 0){
        for($m=0, $t=0; $m<$numMode, $t<$numType; $m++, $t++){
            if(trim($_POST['paymode'][$m] != '') && trim($_POST['payType'][$t] != '')){
                $paymodefetch = select("SELECT * FROM mode_of_payment WHERE centerID='$centerID'");
                $numModfetch = count($paymodefetch)+1;
                $modeID = "PM-".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$numModfetch);
                $paymode = trim($_POST['paymode'][$m]);
                $payType = trim($_POST['payType'][$t]);

                if($paymode == 'PRIVATE' && $payType != 'CASH' || $paymode == 'INSURANCE' && $payType == 'CASH'){
                    $error = "<script>document.write('CASH PAYMODE MUST HAVE CASH PAY TYPE');</script>";
                }else{
                    $CHECKMODE = select("SELECT * FROM mode_of_payment WHERE centerID='$centerID' AND mode='$paymode' AND Type='$payType'");
                    if($CHECKMODE){
                        $error = "<script>document.write('PAYMODE ALREADY EXIST.');</script>";
                    }else{
                       $saveMode = insert("INSERT INTO mode_of_payment(id,centerID,mode,type,dateInsert) VALUES('$modeID','$centerID','$paymode','$payType','$dateToday')");

                        $accIDs = $consultation->loadAccPrices($centerID) + 1;
                        $accountID = "ACC-".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$accIDs);
                        $accountPurpose = trim('BOTH');
                        $accountType = trim('HOLDING');
                        $saveAcc = insert("INSERT INTO accounts(accountID,centerID,accountName,accountPurpose,accountType,dateInsert) VALUES('$accountID','$centerID','$payType','$accountPurpose','$accountType','$dateToday')");

                        if($saveMode && $saveAcc){
                            $success = "<script>document.write('PAYMODE CREATED SUCCESFULL.');</script>";
                        }else{
                            $error = "<script>document.write('PAYMODE CREATION FAILED, TRY AGAIN.');</script>";
                        }
                    }
                }
            }
        }
    }
}


//LEDGER ACCOUNT POSTINGS...........
    if(isset($_POST['POSTACC'])){
        $creditAccID = trim(htmlentities($_POST['creditaccount']));
        $creditAccBalance = trim(htmlentities($_POST['creditAccBalance']));
        $debititAccID = trim(htmlentities($_POST['debitaccount']));
        $debitAccBalance = trim(htmlentities($_POST['debitAccBalance']));
        $amount = trim(htmlentities($_POST['amount']));
        $naration = trim(htmlentities($_POST['naration']));
        $activityType = trim('POST');

        if($creditAccID === $debititAccID){
            $error = "<script>document.write('CREDIT AND DEBIT CAN NOT BE THE SAME.');</script>";
        }else{
            //account calculations, crediting and debiting..
            $newCreditBalance = ($creditAccBalance + $amount);
            $newDebitBalance = ($debitAccBalance - $amount);

            //update credit account...
            $updateCredit = update("UPDATE accounts SET accBalance='$newCreditBalance' WHERE accountID='$creditAccID'");
            if($updateCredit){
                //update debit account...
                $updatedebit = update("UPDATE accounts SET accBalance='$newDebitBalance' WHERE accountID='$debititAccID'");
                if($updatedebit){
                    //insert account post into transaction table...
                    $insertTransaction = insert("INSERT INTO accounttransaction(centerID,creditAcc,creditAccBalance,debitAcc,debitAccBalance,Amount,staffID,activityType,activity,dateInsert) VALUES('$centerID','$creditAccID','$creditAccBalance','$debititAccID','$debitAccBalance','$amount','$staffID','$activityType','$naration','$dateToday')");
                    if($insertTransaction){
                        $success = "<script>document.write('ACCOUNT POSTING SUCCESS.');window.location.href='center-account';</script>";
                    }else{
                       $error = "<script>document.write('ACCOUNT POSTING FAILED, TRY AGAIN.');</script>";
                    }
                }else{
                    $error = "<script>document.write('DEBIT ACCOUNT NOT UPDATED, TRY AGAIN.');</script>";
                }
            }else{
              $error = "<script>document.write('CREDIT ACCOUNT NOT UPDATED, TRY AGAIN.');</script>";
            }
        }
    }

//saving Ledger Account..
if(isset($_POST['saveLedger'])){
	//count number of service entered..
	$nameNum = count( $_POST['accountName']);
	$actype = count( $_POST['accountType']);
//	$actype = count( $_POST['acc']);
    $accountPurpose = trim('BOTH');
	//check number of services..
	if($nameNum >0  && $actype > 0){
		//saving services into database...
		for($n=0, $t=0; $n<$nameNum, $t<$actype; $n++,$t++){
				if(trim($_POST['accountName'][$n] != '') && trim($_POST['accountType'][$t] != '')) {
					$accountName = trim(strtoupper($_POST["accountName"][$n]));
					$accountType = trim( $_POST["accountType"][$t]);
					//generate account ID
					$accIDs = $consultation->loadAccPrices($centerID) + 1;
					$accountID = "ACC-".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$accIDs);

					//check account name if already entered else save account..
					$accExist = select("SELECT * FROM accounts WHERE accountName='$accountName' AND centerID='$centerID'");
					if($accExist){
						$error = "<script>document.write('Account Already Saved..');</script>";
					}else{
						$saveService = insert("INSERT INTO accounts(accountID,centerID,accountName,accountPurpose,accountType,dateInsert) VALUES('$accountID','$centerID','$accountName','$accountPurpose','$accountType','$dateToday')");
						if($saveService){
							$success = "<script>document.write('Account Saved.');window.location='center-account';</script>";
						}else{
							$error = "<script>document.write('Account Not Saved, Try Again.');</script>";
						}
					}
				}
		}
	}else{
		$error = "<script>document.write('Empty Fields, Try Again.');</script>";
	}
}



	//saving services..
    if(isset($_POST['saveServiceprices'])){
		//count number of service entered..
		$serviceNum = count($_POST['serviceName']);
        $servicePriceNum = count($_POST['servicePrice']);
        $modeOfPaymentNum = count($_POST['modeOfPayment']);
		//check number of services..
		if($serviceNum > 0 && $servicePriceNum >0 && $modeOfPaymentNum >0){
			//saving services into database...
            for($n=0, $p=0, $m=0; $n<$serviceNum, $p<$servicePriceNum, $m<$modeOfPaymentNum; $n++,$p++,$m++){
                    if(trim($_POST['serviceName'][$n] != '') && trim($_POST['servicePrice'][$p] != '') && trim($_POST['modeOfPayment'][$m] != '')) {
                        $serviceName = trim(ucwords($_POST['serviceName'][$n]));
                        $servicePrice = trim(ucwords($_POST['servicePrice'][$p]));
                        $modeOfPayment = trim(ucwords($_POST['modeOfPayment'][$m]));
						$serviceType = trim(ucwords("Service"));
						//generate service ID
						$serviceIDs = $consultation->loadServicePrices($centerID) + 1;
						$serviceID = ucwords("SV.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$serviceIDs));

						//check service name if already entered else save service..
				$serviceExist = select("SELECT * FROM prices WHERE serviceName='$serviceName' AND modePayment='$modeOfPayment' AND centerID='$centerID' ");
						if($serviceExist){
							$error = "<script>document.write('Service Already Saved..');</script>";
						}else{
							$saveService = insert("INSERT INTO prices(serviceID,centerID,serviceName,servicePrice,serviceType,modePayment,dateInsert) VALUES('$serviceID','$centerID','$serviceName','$servicePrice','$serviceType','$modeOfPayment','$dateToday')");
							if($saveService){
								$success = "<script>document.write('Services Saved.');window.location='center-account';</script>";
							}else{
								$error = "<script>document.write('Services Not Saved, Try Again.');</script>";
							}
						}
               		}
            }
		}else{
			$error = "<script>document.write('Empty Fields, Try Again.');</script>";
		}
    }

	//saving laboratory services..
    if(isset($_POST['saveLabPrices'])){
		//count number of service entered..
		$serviceNum = count($_POST['serviceName']);
        $servicePriceNum = count($_POST['servicePrice']);
        $modeOfPaymentNum = count($_POST['modeOfPayment']);
		//check number of services..
		if($serviceNum > 0 && $servicePriceNum >0 && $modeOfPaymentNum >0){
			//saving services into database...
            for($n=0, $p=0, $m=0; $n<$serviceNum, $p<$servicePriceNum, $m<$modeOfPaymentNum; $n++,$p++,$m++){
        if(trim($_POST['serviceName'][$n] != '') && trim($_POST['servicePrice'][$p] != '') && trim($_POST['modeOfPayment'][$m] != '')){
                        $serviceName = trim($_POST['serviceName'][$n]);
                        $servicePrice = trim($_POST['servicePrice'][$p]);
                        $modeOfPayment = trim($_POST['modeOfPayment'][$m]);
						$serviceType = trim("Lab");
						//generate service ID
						$serviceIDs = $consultation->loadServicePrices($centerID) + 1;
						$serviceID = "SV.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$serviceIDs);

						//check service name if already entered else save service..
$serviceExist = select("SELECT * FROM prices WHERE centerID='$centerID' AND serviceName='$serviceName' AND modePayment='$modeOfPayment'");
						if(count($serviceExist) > 0){
							$error = "<script>document.write('Service Already Saved..');</script>";
						}else{
$saveService = insert("INSERT INTO prices(serviceID,centerID,serviceName,servicePrice,serviceType,modePayment,dateInsert) VALUES('$serviceID','$centerID','$serviceName','$servicePrice','$serviceType','$modeOfPayment','$dateToday')");
							if($saveService){
								$success = "<script>document.write('Services Saved.');window.location='center-account';</script>";
							}else{
								$error = "<script>document.write('Services Not Saved, Try Again.');</script>";
							}
						}
               		}
            }
		}else{
			$error = "<script>document.write('Empty Fields, Try Again.');</script>";
		}
    }


	//saving ward services..
    if(isset($_POST['saveWardPrices'])){
		//count number of service entered..
		$serviceNum = count($_POST['serviceName']);
        $servicePriceNum = count($_POST['servicePrice']);
        $modeOfPaymentNum = count($_POST['modeOfPayment']);
		//check number of services..
		if($serviceNum > 0 && $servicePriceNum > 0 && $modeOfPaymentNum > 0){
			//saving services into database...
            for($n=0, $p=0, $m=0; $n<$serviceNum, $p<$servicePriceNum, $m<$modeOfPaymentNum; $n++,$p++,$m++){
            if(trim($_POST['serviceName'][$n] != '') && trim($_POST['servicePrice'][$p] != '') && trim($_POST['modeOfPayment'][$m] != '')){
                        $serviceName = trim($_POST['serviceName'][$n]);
                        $servicePrice = trim($_POST['servicePrice'][$p]);
                        $modeOfPayment = trim($_POST['modeOfPayment'][$m]);
						$serviceType = trim("Ward");
						//generate service ID
						$serviceIDs = $consultation->loadServicePrices($centerID) + 1;
						$serviceID = "SV.".substr($centerName['centerName'], 0, 5)."-".sprintf('%06s',$serviceIDs);

						//check service name if already entered else save service..
$serviceExist = select("SELECT * FROM prices WHERE serviceName='$serviceName' AND modePayment='$modeOfPayment' AND centerID='$centerID' ");
						if($serviceExist){
							$error = "<script>document.write('Service Already Saved..');</script>";
						}else{
$saveService = insert("INSERT INTO prices(serviceID,centerID,serviceName,servicePrice,serviceType,modePayment,dateInsert) VALUES('$serviceID','$centerID','$serviceName','$servicePrice','$serviceType','$modeOfPayment','$dateToday')");
							if($saveService){
								$success = "<script>document.write('Services Saved.');window.location='center-account';</script>";
							}else{
								$error = "<script>document.write('Services Not Saved, Try Again.');</script>";
							}
						}
               	}
            }
		}else{
			$error = "<script>document.write('Empty Fields, Try Again.');</script>";
		}
    }

?>

<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-left" title="Search"><i class="icon-search icon-white"></i></button>
</div>

<!--close-top-Header-menu-->

<div id="sidebar">
    <ul>
        <li><a href="medics-index"><i class="icon icon-home"></i> <span>DASHBOARD</span></a> </li>
        <li class=""> <a href="centerconsultation-index"><i class="icon-th-list"></i> <span>CONSULTATION</span></a> </li>
        <li class=""> <a href="centerward-index"><i class="icon-folder-close"></i> <span>WARD</span></a> </li>
        <li class=""> <a href="centerlab-index"> <i class="icon-search"></i> <span>LABORATORY</span></a> </li>
        <li class=""> <a href="centeruser-index"> <i class="icon-user"></i> <span>STAFF</span></a> </li>
        <li class=""> <a href="centerpharmacy-index"> <i class="icon-plus-sign"></i> <span>PHARMACY</span></a> </li>
        <li class="active" style="background-color:#209fbf;"> <a href="center-account"> <i class="icon-list-alt"></i> <span>ACCOUNTS</span></a> </li>
        <li class=""> <a href="smsrequest-index"> <i class="icon-envelope"></i> <span>SMS REQUEST</span></a> </li>
    </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a title="Go to Home" class="tip-bottom"><i class="icon-home"></i> HOME</a>
        <a title="ACCOUNT MANAGEMENT" class="tip-bottom"><i class="icon-file"></i> ACCOUNT MANAGEMENT</a>
    </div>
  </div>
  <div class="container-fluid">
      <h3 class="quick-actions">ACCOUNT &amp; CHARGES MANAGEMENT</h3>
      <div class="row-fluid">
		  <?php if($success || $error){?>
		 <div class="span12">
			<?php
		  if($success){
		  ?>
			<div class="alert alert-success">
			  <strong>Success!</strong> <?php echo $success; ?>
			</div>
			<?php } if($error){
					  ?>
			<div class="alert alert-danger">
			  <strong>Error!</strong> <?php echo $error; ?>
			</div>
		  <?php
		  } ?>
		</div>
		  <?php }?>

        <div class="widget-box">
            <div class="widget-title">
                <ul class="nav nav-tabs labell">
                    <li class="active"><a data-toggle="tab" href="#tab6">PAYMENT MODES</a></li>
                    <li class=""><a data-toggle="tab" href="#tab2">SERVICE CHARGES</a></li>
                    <li><a data-toggle="tab" href="#tab3">LAB TESTS CHARGES</a></li>
                    <li><a data-toggle="tab" href="#tab4">WARD CHARGES</a></li>
                    <li><a data-toggle="tab" href="#tab1">ACCOUNT MANAGEMENT</a></li>
                    <li><a data-toggle="tab" href="#tab5">LEDGER MANAGEMENT</a></li>
                </ul>
            </div>
            <div class="widget-content tab-content">
                <div id="tab1" class="tab-pane">
<!--            <div class="widget-box">-->
				<div class="span7">
                    <form action="#" method="post" class="form-horizontal">
						  <table class="table table-bordered" id="dynamic_field4">

							  <tr>
							  	<td colspan="3" style="height:10px;">
								  	<h4 class="text-center" style="height:10px;"> CREATE ACCOUNT</h4>
								  </td>
							  </tr>
                              <tr>
                                  <th> ACCOUNT NAME</th>
                                  <th> ACCOUNT PURPOE</th>
                                  <th> ACTION</th>
                              </tr>
							<tr>
								<td style="width:30%;">
									<select class="span" name="accountName[]" required>
										<option value="OPD"> OPD </option>
										<option value="CONSULTATION"> CONSULTATION </option>
										<option value="LABORATORY"> LABORATORY </option>
										<option value="WARD"> WARD </option>
										<option value="PHARMACY"> PHARMACY </option>
									</select>
								</td>
								<td>
									<select class="span" name="accountPurpose[]" required>
										<option value="CREDIT"> CREDIT ACCOUNT </option>
									</select>
								</td>
								<td style="text-align:center;"><button type="button" name="add" id="add4" class="btn btn-primary labell">Add Account</button></td>
							</tr>
						</table>
						  <div class="form-actions">
							  <i class="span5"></i>
							  <button type="submit" name="saveAccount" class="btn btn-primary btn-block labell span6"><i class="fa fa-save"></i> Save Account</button>
						  </div>
              		</form>

                    <hr/>

                    <form action="#" method="post" class="form-horizontal">
						  <table class="table table-bordered" id="dynamic_field6">
							  <tr>
							  	<td colspan="3" style="height:10px;">
								  	<h4 class="text-center" style="height:10px;"> LEDGER ACCOUNTS</h4>
								  </td>
							  </tr>
                              <tr>
                                  <th> ACCOUNT NAME</th>
                                  <th> ACCOUNT TYPE</th>
                                  <th> ACTION</th>
                              </tr>
							<tr>
								<td style="width:30%;">
									<input type="text" name="accountName[]" required />
								</td>
								<td>
									<select class="span" name="accountType[]" required>
										<option value="EXPENSE"> EXPENSE ACCOUNT </option>
										<option value="INCOME"> INCOME ACCOUNT </option>
										<option value="REVENUE"> REVENUE ACCOUNT </option>
										<option value="HOLDING"> HOLDING ACCOUNT </option>
									</select>
								</td>
								<td style="text-align:center;"><button type="button" name="add" id="add6" class="btn btn-primary labell">ADD LEDGER</button></td>
							</tr>
						</table>
						  <div class="form-actions">
							  <i class="span5"></i>
							  <button type="submit" name="saveLedger" class="btn btn-primary btn-block labell span6"><i class="fa fa-save"></i> SAVE LEDGER</button>
						  </div>
              		</form>
				</div>

                    <div class="span5">
                        <div class="widget-box" style="margin:0px;">
                          <div class="widget-title">
                             <span class="icon"><i class="icon-th"></i></span>
                          </div>
                          <div class="widget-content nopadding">
                                <table class="table table-bordered table-stripped data-table">
                                    <thead>
                                        <th> ACCOUNT ID</th>
                                        <th> ACCOUNT NAME</th>
<!--                                        <th> ACOUNT TYPE</th>-->
                                        <th> ACCOUNT BALANCE</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $allAcc = select("SELECT * FROM accounts WHERE centerID='$centerID'");
                                        if($allAcc){
                                            foreach($allAcc as $accRow){
                                        ?>
                                        <tr>
                                            <td><?php echo $accRow['accountID'];?></td>
                                            <td><?php echo $accRow['accountName'];?></td>
<!--                                            <td><?php // echo $accRow['accountType'];?></td>-->
                                            <td><?php echo $accRow['accBalance'];?></td>
                                        </tr>
                                        <?php }}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



<div id="tab5" class="tab-pane">
    <form method="post" enctype="multipart/form-data" onsubmit="return confirm('CONFIRM POST ACCOUNT');">
        <div class="row-fluid">
            <table class="table table-bordered" style="width:100%;">
                <tr>
                    <th>CREDIT ACCOUNT <span style="color:red; font-size:150%;">*</span></th>
                    <th>ACCOUNT NUMBER</th>
                    <th>ACCOUNT BALANCE</th>
                </tr>
                <tr>
                    <td style="width:33%;">
                       <select class="span12" name="creditaccount" onchange="ac_code(this.value);" required>
                           <option> </option>
                            <?php
                           $crsql = select("SELECT * FROM accounts WHERE accountPurpose='BOTH' AND centerID='$centerID'");
                           if($crsql){
                               foreach($crsql as $crrow){
                           ?>
                           <option value="<?php echo $crrow['accountID'];?>" ><?php echo $crrow['accountName'];?></option>
                           <?php }}?>
                       </select>
                    </td>

                    <td id="ca"></td>
                    <td id="ca1"></td>
                </tr>
                 <tr>
                    <th>DEBIT ACCOUNT <span style="color:red; font-size:150%;">*</span></th>
                    <th>ACCOUNT NUMBER</th>
                    <th>ACCOUNT BALANCE</th>
                </tr>
                <tr>
                    <td>
                   <select class="span12" name="debitaccount" onchange="dr_code(this.value);" required>
                       <option> </option>
                        <?php
                       $crsql = select("SELECT * FROM accounts WHERE accountPurpose='BOTH' AND centerID='$centerID'");
                       if($crsql){
                           foreach($crsql as $crrow){
                       ?>
                       <option value="<?php echo $crrow['accountID'];?>" ><?php echo $crrow['accountName'];?></option>
                       <?php }}?>
                   </select>
                    </td>
                    <td id="da"></td>
                    <td id="da1"></td>
                </tr>

                 <tr class="labell">
                    <th> AMOUNT <span style="color:red; font-size:150%;">*</span></th>
                    <th> NARATION <span style="color:red; font-size:150%;">*</span></th>
                    <th></th>
                </tr>
                <tr>
                    <td><input type="number" min="1" class="span12" name="amount" required/></td>
                    <td><textarea name="naration" class="span12" required></textarea></td>
                    <td><button type="submit" name="POSTACC" class="btn btn-primary labell btn-block span12">POST ACCOUNT</button></td>
                </tr>
            </table>
        </div>
    </form>
    <form method="post" enctype="multipart/form-data" >
        <div class="row-fluid">
            <table class="table table-bordered data-table">
                <thead>
                    <th>ID</th>
                    <th>CREDIT ACCOUNT</th>
                    <th>CREDIT ACCOUNT BALANCE</th>
                    <th>DEBIT ACCOUNT</th>
                    <th>DEBIT ACCOUNT BALANCE</th>
                    <th> AMOUNT</th>
                    <th> NARATION</th>
                </thead>
                <tbody>
                    <?php
                    $ledsql = select("SELECT * FROM accounttransaction WHERE centerID='$centerID' AND activityType='POST'");
                    if($ledsql){
                        foreach($ledsql as $ledgRow){
                            $creditAccID = $ledgRow['creditAcc'];
                            $debitAccID = $ledgRow['debitAcc'];

                            //get credit account name
                            $cresql = select("SELECT * FROM accounts WHERE accountID='$creditAccID'");
                            foreach($cresql as $creditrow){}

                            //get debit account name
                            $debsql = select("SELECT * FROM accounts WHERE accountID='$debitAccID'");
                            foreach($debsql as $debitrow){}
                    ?>
                    <tr>
                        <td><?php echo $ledgRow['id'];?></td>
                        <td><?php echo $creditrow['accountName'];?></td>
                        <td><?php echo $ledgRow['creditAccBalance'];?></td>
                        <td><?php echo $debitrow['accountName'];?></td>
                        <td><?php echo $ledgRow['debitAccBalance'];?></td>
                        <td><?php echo $ledgRow['Amount'];?></td>
                        <td><?php echo $ledgRow['activity'];?></td>
                    </tr>
                    <?php }}?>
                </tbody>
            </table>
        </div>
    </form>
</div>

<div id="tab6" class="tab-pane active">
    <div class="row-fluid">
        <div class="span6">
            <form action="#" method="post" class="form-horizontal">
                  <table class="table table-bordered" id="dynamic_field7">
                      <tr>
                        <td colspan="3" style="height:10px;">
                            <h4 class="text-center" style="height:10px;"> MODE OF PAYMENT</h4>
                          </td>
                      </tr>
                      <?php
//                      $n = 2;
//                        for($t=0;$t<$n;$t++){
                      ?>
                    <tr>
                        <td>
                            <select class="span11" name="paymode[]" onchange="pmode(this.value)">
<!--                                <option>-- Select Mode --</option>-->
<!--                                <option value="PRIVATE"> PRIVATE / CASH </option>-->
                                <option value="INSURANCE"> INSURANCE</option>
                            </select>
                        </td>
                        <td>
                            <select class="span11" name="payType[]">
<!--                                <option value="CASH"> CASH </option>-->
                                <option value="NHIS"> NHIS </option>
                                <option value="ACACIA"> ACACIA </option>
                                <option value="VITALITY"> VITALITY </option>
                            </select>
                        </td>
                        <td style="text-align:center;">
                           <button type="button" name="add" id="add7" class="btn btn-primary labell">Add More</button>
                        </td>
                    </tr>
                      <?php //}?>
                </table>
                  <div class="form-actions">
                      <i class="span5"></i>
                      <button type="submit" name="saveMode" class="btn btn-primary btn-block labell span6"><i class="fa fa-save"></i> Save Pay Mode</button>
                  </div>
            </form>
        </div>

				<div class="span6">
                     <div class="widget-box" style="margin:0px;">
                          <div class="widget-title">
                             <span class="icon"><i class="icon-th"></i></span>
                          </div>
                          <div class="widget-content nopadding">
                            <table class="table table-bordered table-stripped data-table">
                                <thead>
                                    <th> PAY MODE</th>
                                    <th> PAY TYPE</th>
                                    <th> ACTION</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $allService = select("SELECT * FROM mode_of_payment WHERE centerID='$centerID'");
                                    if($allService){
                                        foreach($allService as $serviceRow){
                                    ?>
                                    <tr>
                                        <td><?php echo $serviceRow['mode'];?></td>
                                        <td><?php echo $serviceRow['type'];?></td>
                                        <td style="text-align:center;">
                                            <a href="#?sid=<?php echo $serviceRow['id'];?>" class="btn btn-primary">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                         </div>
                    </div>
                </div>
            </div>
        </div>



<div id="tab2" class="tab-pane">
    <div class="row-fluid">
        <div class="span6">
            <form action="#" method="post" class="form-horizontal">
                  <table class="table table-bordered" id="dynamic_field2">
                      <tr>
                        <td colspan="3" style="height:10px;">
                            <h4 class="text-center" style="height:10px;"> SERVICE PRICING</h4>
                          </td>
                      </tr>
                      <?php
                      $n = 2;
                        for($t=0;$t<$n;$t++){
                      ?>
                    <tr>
                        <td>
                            <select class="span" name="serviceName[]">
                                <option>-- Select Service --</option>
                                <option value="CONSULTATION"> CONSULTATION </option>
                                <option value="ID CARD"> HOSPITAL CARD</option>
                            </select>
                        </td>
                        <td><input type="number" step="any" min="1" name="servicePrice[]" placeholder="Price" class="span11" /></td>
                        <td><select class="span" name="modeOfPayment[]" required>
                                <option>-- Payment Mode --</option>
                                <option value="CASH"> CASH </option>

                            <?php
                                $modePayment = select("select * FROM mode_of_payment ");
                                if($modePayment){
                                    foreach($modePayment as $modePay){ ?>
                            <option><?php echo $modePay['type']; ?></option>
                                <?php }} ?>
                            ?>
                            </select>
                        </td>
                    </tr>
                      <?php }?>
                </table>
                  <div class="form-actions">
                      <i class="span5"></i>
                      <button type="submit" name="saveServiceprices" class="btn btn-primary btn-block labell span6"><i class="fa fa-save"></i> Save Prices</button>
                  </div>
            </form>
        </div>

				<div class="span6">
                     <div class="widget-box" style="margin:0px;">
                          <div class="widget-title">
                             <span class="icon"><i class="icon-th"></i></span>
                          </div>
                          <div class="widget-content nopadding">
                            <table class="table table-bordered table-stripped data-table">
                                <thead>
                                    <th> SERVICE NAME</th>
                                    <th> PAYMODE</th>
                                    <th> SERVICE PRICE</th>
                                    <th> ACTION</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $allService = select("SELECT * FROM prices WHERE centerID='$centerID' AND serviceType='Service'");
                                    if($allService){
                                        foreach($allService as $serviceRow){
                                    ?>
                                    <tr>
                                        <td><?php echo $serviceRow['serviceName'];?></td>
                                        <td><?php echo $serviceRow['modePayment'];?></td>
                                        <td><?php echo $serviceRow['servicePrice'];?></td>
                                        <td style="text-align:center;">
                                            <a href="updateservice?sid=<?php echo $serviceRow['serviceID'];?>" class="btn btn-primary">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                         </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="tab3" class="tab-pane">
            <div class="row-fluid">
                <div class="span6">
                    <form action="#" method="post" class="form-horizontal">
						  <table class="table table-bordered" id="dynamic_field">
							  <tr>
							  	<td colspan="3" style="height:10px;">
								  	<h4 class="text-center" style="height:10px;"> LAB PRICING</h4>
								  </td>
							  </tr>
                              <?php
                              $n = 4;
                                for($t=0;$t<$n;$t++){
                              ?>
							<tr>
								<td>
									<select class="span" name="serviceName[]">
										<option>-- Select Lab --</option>
										<?php
											$lablist = select("SELECT * FROM lablist WHERE centerID='$centerID'");
										if($lablist){
											foreach($lablist as $labRow){
										?>
										<option value="<?php echo $labRow['labName']?>"><?php echo $labRow['labName'];?></option>
										<?php }}?>
									</select>
								</td>
								<td><input type="number" step="any" min="1" name="servicePrice[]" placeholder="Price" class="span11"/></td>
								<td><select class="span" name="modeOfPayment[]" required>
										<option>-- Payment Mode --</option>
                                            <option value="CASH"> CASH </option>

									<?php
										$modePayment = select("select * FROM mode_of_payment ");
										if($modePayment){
											foreach($modePayment as $modePay){ ?>
									<option><?php echo $modePay['type']; ?></option>
										<?php }} ?>
									?>
									</select>
								</td>
<!--								<td><button type="button" name="add" id="add" class="btn btn-primary labell">Add</button></td>-->
							</tr>
                              <?php }?>
						</table>
						  <div class="form-actions">
							  <i class="span5"></i>
							  <button type="submit" name="saveLabPrices" class="btn btn-primary btn-block labell span6"><i class="fa fa-save"></i> Save Prices</button>
						  </div>
              		</form>
				</div>
				<div class="span6">
                     <div class="widget-box" style="margin:0px;">
                          <div class="widget-title">
                             <span class="icon"><i class="icon-th"></i></span>
                          </div>
                          <div class="widget-content nopadding">
					<table class="table table-bordered table-stripped data-table">
						<thead>
							<th> LAB NAME</th>
							<th> PAYMODE</th>
							<th> LAB PRICE</th>
							<th> ACTION</th>
						</thead>
						<tbody>
							<?php
							$allService = select("SELECT * FROM prices WHERE centerID='$centerID' AND serviceType='Lab'");
							if($allService){
								foreach($allService as $serviceRow){
							?>
							<tr>
								<td><?php echo $serviceRow['serviceName'];?></td>
								<td><?php echo $serviceRow['modePayment'];?></td>
								<td><?php echo $serviceRow['servicePrice'];?></td>
								<td style="text-align:center;">
                                    <a href="updateservice?sid=<?php echo $serviceRow['serviceID'];?>" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </td>
							</tr>
							<?php }}?>
						</tbody>
					</table>
                         </div>
                    </div>
				</div>
            </div>
        </div>

        <div id="tab4" class="tab-pane">
            <div class="row-fluid">
				<div class="span6">
                    <form action="#" method="post" class="form-horizontal">
						  <table class="table table-bordered" id="dynamic_field3">
							  <tr>
							  	<td colspan="3" style="height:10px;">
								  	<h4 class="text-center" style="height:10px;"> WARD PRICING</h4>
								  </td>
							  </tr>
                              <?php
                              $n = 4;
                                for($t=0;$t<$n;$t++){
                              ?>
							<tr>
								<td>
									<select class="span" name="serviceName[]">
										<option>-- Select Ward --</option>
										<option value="Emergency"> Emergency</option>
										<?php
											$wardlist = select("SELECT * FROM wardlist WHERE centerID='$centerID'");
										if($wardlist){
											foreach($wardlist as $wardRow){
										?>
										<option value="<?php echo $wardRow['wardName']?>"><?php echo $wardRow['wardName'];?></option>
										<?php }}?>
									</select>
								</td>
								<td><input type="number" step="any" min="1" name="servicePrice[]" placeholder="Price" class="span11"/></td>
								<td><select class="span" name="modeOfPayment[]" required>
										<option>-- Payment Mode --</option>
                                        <option value="CASH"> CASH </option>
									<?php
										$modePayment = select("select * FROM mode_of_payment ");
										if($modePayment){
											foreach($modePayment as $modePay){ ?>
									<option><?php echo $modePay['type']; ?></option>
										<?php }} ?>
									?>
									</select>
								</td>
							</tr>
                              <?php }?>
						</table>
						  <div class="form-actions">
							  <i class="span5"></i>
							  <button type="submit" name="saveWardPrices" class="btn btn-primary btn-block labell span6"><i class="fa fa-save"></i> Save Prices</button>
						  </div>
              		</form>
				</div>

                        <div class="span6">
                             <div class="widget-box" style="margin:0px;">
                          <div class="widget-title">
                             <span class="icon"><i class="icon-th"></i></span>
                          </div>
                          <div class="widget-content nopadding">
                            <table class="table table-bordered table-stripped data-table">
                                <thead>
                                    <th> WARD NAME</th>
                                    <th> PAYMODE</th>
                                    <th> WARD PRICE</th>
                                    <th> ACTION</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $allService = select("SELECT * FROM prices WHERE centerID='$centerID' AND serviceType='Ward'");
                                    if($allService){
                                        foreach($allService as $serviceRow){
                                    ?>
                                    <tr>
                                        <td><?php echo $serviceRow['serviceName'];?></td>
                                        <td><?php echo $serviceRow['modePayment'];?></td>
                                        <td><?php echo $serviceRow['servicePrice'];?></td>
                                        <td style="text-align:center;">
                                            <a href="updateservice?sid=<?php echo $serviceRow['serviceID'];?>" class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                    <?php }}?>
                                </tbody>
                            </table>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	  </div>
    </div>
</div>
<div class="row-fluid">
  	<div id="footer" class="span12">
	  2018 &copy; QUAT MEDICS ADMIN BY  <a href="http://quatitsolutions.com" target="_blank"><b>QUAT IT SOLUTIONS</b></a>
	</div>
</div>
<script src="js/excanvas.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.ui.custom.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-colorpicker.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.flot.min.js"></script>
<script src="js/jquery.flot.resize.min.js"></script>
<script src="js/jquery.peity.min.js"></script>
<script src="js/fullcalendar.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/bootstrap-colorpicker.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.uniform.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/maruti.js"></script>
<script src="js/maruti.tables.js"></script>
<script src="js/maruti.dashboard.js"></script>
<script src="js/maruti.chat.js"></script>
<script src="js/maruti.form_common.js"></script>
<!--<script src="js/maruti.js"></script> -->
<script>
//    $(document).ready(function(){
        var i=1;
        $('#add4').click(function(){
            i++;
            $('#dynamic_field4').append('<tr id="row'+i+'"><td><select class="span" name="accountName[]" required><option value="OPD"> OPD </option><option value="CONSULTATION"> CONSULTATION </option><option value="LABORATORY"> LABORATORY </option><option value="WARD"> WARD </option><option value="PHARMACY"> PHARMACY </option></select></td><td><select class="span" name="accountType[]" required><option value="CREDIT"> CREDIT ACCOUNT </option></select></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
//    $(document).ready(function(){
        var i=1;
        $('#add6').click(function(){
            i++;
            $('#dynamic_field6').append('<tr id="row'+i+'"><td style="width:30%;"><input type="text" name="accountName[]" required /></td><td><select class="span" name="accountType[]" required><option value="EXPENSE"> EXPENSE ACCOUNT </option><option value="INCOME"> INCOME ACCOUNT </option><option value="REVENUE"> REVENUE ACCOUNT </option></select></td><td style="text-align:center;"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
//    });
//    $(document).ready(function(){
        var i=1;
        $('#add7').click(function(){
            i++;
            $('#dynamic_field7').append('<tr id="row'+i+'"><td><select class="span11" name="paymode[]" ><option value="INSURANCE"> INSURANCE</option></select></td><td><select class="span11" name="payType[]"><option value="NHIS"> NHIS </option><option value="ACACIA"> ACACIA </option><option value="VITALITY"> VITALITY </option></select></td><td style="text-align:center;"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
//    });
</script>

<script>
function ac_code(val){
	// load the select option data into a div
        $('#loader').html("Please Wait...");
        $('#ca').load('ca_code.php?id='+val, function(){
		$('#loader').html("");
       });

        $('#ca1').load('ca_code1.php?id='+val, function(){
		$('#loader').html("");
       });
}
</script>

<script>
function dr_code(val){
	// load the select option data into a div
        $('#loader').html("Please Wait...");
        $('#da').load('da_code.php?id='+val, function(){
		$('#loader').html("");
       });

        $('#da1').load('da_code1.php?id='+val, function(){
		$('#loader').html("");
       });
}
</script>

<script>
function pmode(val){
	// load the select option data into a div
        $('#loader').html("Please Wait...");
        $('#col').load('pmode.php?mode='+val, function(){
		$('#loader').html("");
       });

        $('#da1').load('da_code1.php?id='+val, function(){
		$('#loader').html("");
       });
}
</script>
</body>
</html>
