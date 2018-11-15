<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_newpatient = select("SELECT * FROM emergency_patient WHERE centerID='".$_SESSION['centerID']."'  ORDER BY patientID ASC");

foreach($load_newpatient as $newpatient){

?>


<tr>
 <!-- <td class="span2">
      <i class="fa fa-user"></i>
    <a class="" href="<?php #echo $newpatient['patient_image']; ?>">
        <img src="<?php #echo $newpatient['patient_image']; ?>" alt="" >
    </a>
  </td> -->
<!--  <td><?php #echo $newpatient['patientID']; ?></td>-->
  <td> <?php echo $newpatient['patientName']; ?></td>
  <td> <?php echo $newpatient['gName']; ?></td>
  <td> <?php echo $newpatient['gMobile']; ?></td>
  <td> <?php echo $newpatient['dateAdmitted']; ?></td>
  <td style="text-align: center;">
       <a href="emergency-vitals?emeid=<?php echo $newpatient['emeID'];?>&tab=vitals&pid=<?php echo $newpatient['patientID']; ?>"> Vitals</a> |  <a href="emergency-patient-treatment?emeid=<?php echo $newpatient['emeID'];?>&pid=<?php echo $newpatient['patientID']; ?>"> Patient&nbsp;Management</a>
  </td>
</tr>


<?php  } ?>

