<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_consultroom = select("SELECT * FROM consultingroom WHERE centerID='".$_SESSION['centerID']."'");

foreach($load_consultroom as $room){

?>

<tr>
  <td><?php echo $room['roomID']; ?></td>
  <td> <?php echo $room['roomName']; ?></td>
  <td style="text-align: center;">
       <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
  </td>
</tr>


<?php  } ?>
