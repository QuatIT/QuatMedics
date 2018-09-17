<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_patient = select("SELECT * FROM patient WHERE centerID='".$_SESSION['centerID']."' ORDER BY patientID ASC");

foreach($load_patient as $patient){

?>

<tr>
  <td><?php echo $patient['patientID']; ?></td>
  <td> <?php echo $patient['firstName']." ".$patient['otherName']." ".$patient['lastName']; ?></td>
  <td> <?php echo $patient['phoneNumber']; ?></td>
  <td style="text-align: center;"> <?php echo $patient['dob']; ?></td>
  <td style="text-align: center;">
       <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
  </td>
</tr>


<?php  } ?>

