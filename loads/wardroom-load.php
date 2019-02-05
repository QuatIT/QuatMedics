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
  <td> <?php echo $ward['wardName']; ?></td>
  <td> <?php echo $ward['numOfBeds']; ?></td>
  <td style="text-align: center;">
       <a href="updateward?wid=<?php echo $ward['wardID'];?>"> <span class="btn btn-info labell fa fa-edit"> Edit</span></a>
  </td>
</tr>


<?php  } ?>


