<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_newpatient = select("SELECT * FROM pharmacy_inventory WHERE centerID='".$_SESSION['centerID']."' ORDER BY medicine_id ASC");

foreach($load_newpatient as $newpatient){

?>


<tr>

  <td><?php echo $newpatient['medicine_id']; ?></td>
  <td> <?php echo $newpatient['medicine_name']; ?></td>
  <td> <?php echo $newpatient['no_of_boxes']; ?></td>
  <td> <?php echo $newpatient['no_of_piece']; ?></td>
  <td> <a href="update-stock?sid=<?php echo $newpatient['medicine_id']; ?>&tab=admed" class="btn btn-sm btn-primary">Update Stock</a></td>
</tr>



<?php  } ?>

