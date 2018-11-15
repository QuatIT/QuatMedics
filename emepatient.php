<?php
include 'assets/core/connection.php';
@session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$id = $_GET['id'];

$readonly='';
$disabled='';

//echo "<script>alert('{$q}')</script>";
//exit;
$sql = select("SELECT * FROM patient WHERE patientID='$id' || phoneNumber='$id'  ");
if(count($sql) == 1){

    foreach($sql as $query){}

    $disabled = 'disabled';
    $readonly='readonly';
?>

	<label class="control-label">Patient ID</label>
		<div class="controls">
		  <input name="patientid" value="<?php echo $query['patientID'];?>" class="span11" <?php echo $readonly; ?> >

	</div>

	<label class="control-label">Patient Full Name</label>
		<div class="controls">
		  <input name="patientfullname" value="<?php echo $query['firstName'].' '.$query['otherName'].' '.$query['lastName'];?>" class="span11" <?php echo $disabled." ".$readonly; ?> >

	</div>


                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" class="btn btn-primary btn-block span10" name="btnSave">Check Vitals</button>
                              </div>
<?php

}else{ $disabled = ''; $readonly=''; ?>
    	<label class="control-label">Patient Name</label>
		<div class="controls">
			<input type="text" class="span11" name="patientname" value="<?php echo count(select("SELECT * FROM emergency_patient")) + 1; ?>" readonly />
	</div>


 <div class="control-group">
                                <label class="control-label">Gender:</label>
                                <div class="controls">
                                  <label>
                                    <input type="radio" name="gender" value="Male" <?php echo $disabled." ".$readonly; ?> /> Male
                                    </label>
                                  <label>
                                    <input type="radio" name="gender" value="Female" <?php echo $disabled." ".$readonly; ?> /> Female
                                    </label>
                                </div>
                              </div>



                              <div class="control-group">
                                <label class="control-label">Guardian Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Guardian Name" name="gName" <?php echo $disabled." ".$readonly; ?> />
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Guardian Phone Number :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Guardian Phone Number" name="gMobile" <?php echo $disabled." ".$readonly; ?> />
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Guardian Address :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Guardian Address" name="gAddress" <?php echo $disabled." ".$readonly; ?> />
                                </div>
                              </div>


                              <div class="control-group">
                                <label class="control-label">Upload Image :</label>
                                <div class="controls">
                                  <input type="file" class="span11" placeholder="Upload Image" name="image" <?php echo $disabled." ".$readonly; ?> />
                                </div>
                              </div>


                              <div class="form-actions">
                                  <i class="span1"></i>
                                <button type="submit" class="btn btn-primary btn-block span10" name="btnNewSave">Check Vitals</button>
                              </div>


<?php
}
?>
