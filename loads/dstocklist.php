<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_newpatient = select("SELECT * FROM dispensary_tb WHERE centerID='".$_SESSION['centerID']."'  GROUP BY medicine_id ORDER BY medicine_id ASC");

foreach($load_newpatient as $newpatient){

?>


<tr>

  <td><?php echo $newpatient['medicine_id']; ?></td>
  <td> <?php echo $newpatient['medicine_name']; ?></td>
<!--  <td> <?php #echo $newpatient['no_of_boxes']; ?></td>-->
  <td> <?php echo $newpatient['no_of_piece']; ?></td>
</tr>



<?php  } ?>

