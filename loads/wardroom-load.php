<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_wardroom = select("SELECT * FROM wardlist WHERE centerID='".$_SESSION['centerID']."' ORDER BY centerID ASC");

foreach($load_wardroom as $ward){

?>

<tr>
  <td><?php echo $ward['wardID']; ?></td>
  <td> <?php echo $ward['wardName']; ?></td>
  <td style="text-align: center;">
       <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
  </td>
</tr>


<?php  } ?>

