<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}
$emeid = $_GET['emeid'];
$pid = $_GET['pid'];
$load_newpatient = select("SELECT * FROM eme_ward WHERE eme_medID='$emeid' AND patientID='$pid'  ORDER BY dateRegistered ASC");

foreach($load_newpatient as $newpatient){

?>


<tr>
  <td> <?php echo $newpatient['dateRegistered']; ?></td>
<!--  <td> <?php #echo $newpatient['patientID']; ?></td>-->
  <td> <?php echo $newpatient['prescrib_med']; ?></td>
  <td> <?php echo $newpatient['dosage']; ?></td>
  <td> <?php echo $newpatient['prescribed_by']; ?></td>
  <td> <?php echo $newpatient['med_status']; ?></td>
  <td style="text-align: center;">
	  <?php if($newpatient['med_status']=="administered"){echo '';}else{ ?>
       <a href="nursecheck?emeid=<?php echo $_GET['emeid'];?>&pid=<?php echo $_GET['pid']; ?>&id=<?php echo $newpatient['id']; ?>"> Administered</a><?php } ?>
  </td>
</tr>


<?php  } ?>

