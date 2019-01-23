
<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

//$q = "PNT-0001";
$q = $_GET['id'];


$load_patient_name = select("SELECT * FROM patient WHERE patientID='".$q."' ORDER BY patientID ASC");
if(count($load_patient_name) > 0){
foreach($load_patient_name as $patient_name){}

?>
 <div class="control-group">
<label class="control-label">Full Name :</label>
<div class="controls">
  <input type="text" required readonly value="<?php echo $patient_name['firstName']." ".$patient_name['otherName']." ".$patient_name['lastName']; ?>" id="FullName" class="span11" placeholder="Full name" name="FullName" />
</div>
</div>


<?php  }else{ ?>
<div class="control-group">
<label class="control-label">Full Name :</label>
<div class="controls">
  <input type="text" required readonly value="<?php echo 'No record found.'; ?>" id="FullName" class="span11" placeholder="Full name" name="FullName" />
</div>
</div>


<?php } ?>

