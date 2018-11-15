<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_newpatient = select("SELECT * FROM prescriptions ORDER BY patientID ASC");
//$load_newpatient = select("SELECT * FROM prescriptions WHERE DATE(datePrescribe)=CURRENT_DATE ORDER BY patientID ASC");

foreach($load_newpatient as $newpatient){
$sqlll = select("SELECT * FROM patient WHERE patientID='".$newpatient['patientID']."' ");
										 foreach($sqlll as $srowss){}
?>


<tr>

  <td><?php echo $newpatient['patientID']; ?></td>
  <td> <?php echo $srowss['firstName']." ".$srowss['otherName']." ".$srowss['lastName']; ?></td>
  <td> <?php echo $newpatient['prescribeStatus']; ?></td>
  <td> <a href="pharmacy-main2?patid=<?php echo $newpatient['patientID']; ?>&code=<?php echo $newpatient['perscriptionCode']; ?>" class="btn btn-primary">Process Payment</a>&nbsp;<a href="" class="btn btn-primary">Serve Medicine</a> </td>

</tr>


<?php  } ?>

