<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_newpatient = select("SELECT * FROM dispensary_tb WHERE centerID='".$_SESSION['centerID']."' && expire_date= DATE_ADD(CURDATE(), INTERVAL 8 DAY) ORDER BY medicine_id ASC");

foreach($load_newpatient as $newpatient){

?>


<tr>

  <td><?php echo $newpatient['medicine_id']; ?></td>
  <td> <?php echo $newpatient['medicine_name']; ?></td>
  <td> <?php echo $newpatient['no_of_piece']; ?></td>
  <td> <?php echo $newpatient['expire_date']; ?></td>
</tr>



<?php  } ?>

