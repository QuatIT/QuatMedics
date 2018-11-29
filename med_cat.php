<?php

include 'assets/core/connection.php';

$id = $_GET['id'];

$serve = select("SELECT * FROM pharmacy_inventory WHERE medicine_id='$id' ");
foreach($serve as $meds){}


?>
<div class="control-group">
<label class="control-label">Medicine Category :</label>
<div class="controls">
<!--                                  <select name="medicine_type" class="span11" onchange="pharm_cat(this.value);">-->
  <select name="medicine_type" class="span11">
	  <option><?php echo $meds['medicine_type']; ?></option>
   </select>
</div>
</div>


<div class="control-group">
<label class="control-label">Remaining Pieces:</label>
<div class="controls">
  <input type="text" class="span11" value="<?php echo $meds['no_of_piece']; ?>" placeholder="No. of boxes" name="no_of_boxes" readonly />
</div>
</div>
