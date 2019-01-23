<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_newpatient = select("SELECT * FROM patient WHERE centerID='".$_SESSION['centerID']."' && DATE(dateRegistered)=CURRENT_DATE ORDER BY patientID ASC");

foreach($load_newpatient as $newpatient){

?>


<tr>
  <td class="span2">
<!--      <i class="fa fa-user"></i>-->
    <a class="" href="<?php echo $newpatient['patient_image']; ?>">
        <img src="<?php echo $newpatient['patient_image']; ?>" alt="" >
    </a>
  </td>
  <td><?php echo $newpatient['patientID']; ?></td>
  <td> <?php echo $newpatient['firstName']." ".$newpatient['otherName']." ".$newpatient['lastName']; ?></td>
  <td> <?php echo $newpatient['phoneNumber']; ?></td>
  <td style="text-align: center;">
        <a href="id-card?pid=<?php echo $newpatient['patientID'];?>" title="Patient Card"> <span class="btn btn-success fa fa-image"></span></a>
  </td>
</tr>


<?php  } ?>

