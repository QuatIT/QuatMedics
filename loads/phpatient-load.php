<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_newpatient = select("SELECT * FROM prescriptions WHERE prescribeStatus='Prescribed' ORDER BY patientID ASC");
//$load_newpatient = select("SELECT * FROM prescriptions WHERE DATE(datePrescribe)=CURRENT_DATE ORDER BY patientID ASC");

foreach($load_newpatient as $newpatient){

$sqlll = select("SELECT * FROM patient WHERE patientID='".$newpatient['patientID']."' ");
 foreach($sqlll as $srowss){}

	$selz = select("SELECT * FROM prescribedmeds WHERE prescribeCode='".$newpatient['prescribeCode']."'  && paystatus='Not Paid' ");
		foreach($selz as $slz){}

	if($slz['paystatus']=='Not Paid'){
?>
<tr>

  <td><?php echo $newpatient['patientID']; ?></td>
  <td> <?php echo $srowss['firstName']." ".$srowss['otherName']." ".$srowss['lastName']; ?></td>
  <td> <?php echo $slz['paystatus']; ?></td>
  <td> <?php echo $slz['prescribeStatus']; ?></td>
  <td style="text-align:center;">
	  <?php

		  #if($slz['paystatus']=="Not Paid" ){
	  ?>
<!--	  <a href="pharmacy-main2?patid=<?php #echo $newpatient['patientID']; ?>&code=<?php #echo $newpatient['perscriptionCode']; ?>" class="btn btn-primary">Process Payment</a>-->
	  <?php #}else{ ?>
	  <a href="pharmacy-patient?code=<?php echo $newpatient['perscriptionCode']; ?>" class="btn btn-warning">Serve Medicine</a>
	  <?php #} ?>
    </td>

</tr>


<?php  }} ?>

