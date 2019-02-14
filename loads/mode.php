
<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

@$_SESSION['exp_date'];
$q = $_REQUEST['id'];
$pid = $_REQUEST['pid'];

if($q == 'INSURANCE'){

$sql = select("select * from patient where patientID='$pid' ");
foreach($sql as $row){}

?>


 <div class="control-group">
<label class="control-label">Type of Insurance <span style="color:red; font-size:130%;">*</span></label>
<div class="controls">
   <select class="span11" name="insuranceType" onchange="ccInsure(this.value)">
        <option value=""></option>
       <?php
       $selmode = select("SELECT * FROM mode_of_payment WHERE centerID='".$_SESSION['centerID']."' AND mode='INSURANCE'");
        foreach($selmode as $moderow){
       ?>
        <option value="<?php echo $moderow['type'];?>"><?php echo $moderow['type'];?></option>
       <?php }?>
    </select>
</div>
</div>

<div class="control-group">
  <label class="control-label">Expire Date  <span style="color:red; font-size:130%;">*</span></label>
  <div class="controls">
    <input type="date" class="span11" placeholder="Expire Date" value="<?php echo $row['insurance_exp']; ?>" name="exp_date" required />
  </div>
</div>


<span id="ccmodeload"></span>

<?php
}elseif($q == 'COMPANY'){

?>
<div class="control-group">
    <label class="control-label">Company Name <span style="color:red; font-size:130%;">*</span></label>
    <div class="controls">
      <input type="text" class="span11" placeholder="Company Name" name="company" required />
    </div>
</div>

<?php
}

?>
