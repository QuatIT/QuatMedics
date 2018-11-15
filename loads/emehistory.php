<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$load_newpatient = select("SELECT * FROM eme_ward WHERE centerID='".$_SESSION['centerID']."' && patientID='".$_GET['pid']."'  GROUP BY dateRegistered ORDER BY dateRegistered ASC");

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
  <td> <?php if(empty($newpatient['doc_comment']) || $newpatient['doc_comment'] == 'NULL'){
		  echo "<form action='' method='post'><input type='text' name='comment".$newpatient['eme_medID']."' ><input type='submit' name='btncomment".$newpatient['eme_medID']."' class='btn btn-primary'></form> "; ?>

	  <?php

		  if(isset($_POST['btncomment'.$newpatient['eme_medID']])){
			  $cm = $_POST['comment'.$newpatient['eme_medID']];

			  $sqq = update("UPDATE eme_ward SET doc_comment='$cm' WHERE eme_medID='".$newpatient['eme_medID']."' ");

		  }

	  ?>


	  <?php }else{ echo $newpatient['doc_comment']; } ?></td>
</tr>


<!--
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

     Modal content
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
-->


<?php  } ?>

