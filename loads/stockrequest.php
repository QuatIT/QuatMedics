<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_newpatient = select("SELECT * FROM dispensary_tb WHERE centerID='".$_SESSION['centerID']."' && request_status='pending' ORDER BY medicine_id ASC");

foreach($load_newpatient as $newpatient){

?>


<tr>

  <td><?php echo $newpatient['medicine_id']; ?></td>
  <td> <?php echo $newpatient['medicine_name']; ?></td>
  <td> <?php echo $newpatient['no_of_piece']; ?></td>
  <td> <?php if($newpatient['request_status']=="pending"){ ?><a href="approve-request?sid=<?php echo $newpatient['medicine_id']; ?>&tab=srequests&id=<?php echo $newpatient['id'];?>&piece=<?php echo $newpatient['no_of_piece']; ?>" class="btn btn-sm btn-primary">Approve</a><?php }elseif($newpatient['request_status']=="approved"){echo '';} ?></td>
</tr>



<?php  } ?>

