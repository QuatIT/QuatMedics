<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_consultroom = select("SELECT * FROM pharmacy WHERE centerID='".$_SESSION['centerID']."' ORDER BY centerID ASC");

foreach($load_consultroom as $room){

?>

<tr>
  <td><?php echo $room['pharmacyID']; ?></td>
  <td> <?php echo $room['pharmacyName']; ?></td>
  <td style="text-align: center;">
       <a href="updatepharmacy?pid=<?php echo $room['pharmacyID']; ?>"> <span class="btn btn-info fa fa-edit"> Edit</span></a>
  </td>
</tr>


<?php  } ?>
