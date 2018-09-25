<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_centeruser = select("SELECT * FROM staff");

foreach($load_centeruser as $cuser){

?>

<tr>
  <td><?php echo $cuser['staffID']; ?></td>
  <td> <?php echo $cuser['firstName']." ".$cuser['otherName']." ".$cuser['lastName']; ?></td>
  <td> <?php echo $cuser['departmentID']; ?></td>
  <td> </td>
  <td style="text-align: center;">
       <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
  </td>
</tr>


<?php  } ?>
