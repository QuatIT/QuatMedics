<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_newpatient = select("SELECT * FROM eme_ward WHERE centerID='".$_SESSION['centerID']."'  GROUP BY dateRegistered ORDER BY dateRegistered ASC");

foreach($load_newpatient as $newpatient){

?>


<tr>
  <td> <?php echo $newpatient['dateRegistered']; ?></td>
  <td>
	  <?php
		  $sql = select("SELECT * FROM eme_ward WHERE eme_medID='".$newpatient['eme_medID']."' ORDER BY dateRegistered ASC");

	  ?>
	  <ol>
		  <?php  foreach($sql as $srow){ ?>
		  <li><?php echo $srow['prescrib_med']; ?></li>
		  <?php } ?>
	  </ol>


	</td>
  <td>

	  <?php
		  $sqls = select("SELECT * FROM eme_ward WHERE eme_medID='".$newpatient['eme_medID']."' ORDER BY dateRegistered ASC");

	  ?>
	  <ol>
		  <?php  foreach($sqls as $srows){ ?>
		  <li><?php echo $srows['dosage']; ?></li>
		  <?php } ?>
	  </ol>



	</td>
  <td> <?php echo $newpatient['prescribed_by']; ?></td>
  <td> <?php echo $newpatient['med_status']; ?></td>
</tr>


<?php  } ?>

