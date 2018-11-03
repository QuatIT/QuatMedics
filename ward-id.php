<?php
include 'assets/core/connection.php';

$wid = $_GET['wid'];
//echo "<script>alert('{$q}')</script>";
//exit;
$sql = select("SELECT * FROM bedlist WHERE wardId='$wid' AND status='Free'");
if(count($sql) > 0){
?>
	<label class="control-label">Bed Number</label>
		<div class="controls">
		  <select name="bedID" class="span11">
              <option></option>
			 <?php
				foreach($sql as $query){
			?>
			<option value="<?php echo $query['bedID'];?>"> <?php echo $query['bedNumber'];?> </option>
			 <?php }?>
		  </select>
	</div>
<?php
}else{ ?>
    	<label class="control-label">Bed Number</label>
		<div class="controls">
			<input type="text" class="span11" name="bedID" value="All Beds Occupied" readonly/>
	</div>
<?php
}
?>
