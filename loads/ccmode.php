
<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

//$q = "PNT-0001";
$q = $_REQUEST['id'];
$pid = $_GET['pid'];

if($q == 'NHIS'){

  $sql = select("select * from patient where patientID='$pid' ");
  foreach($sql as $row){
    $_SESSION['exp_date'] = $row['insurance_number'];
  }

?>

                              <div class="control-group">
                                <label class="control-label">CC Number:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="CC Number" name="ccNumber" required />
                                </div>
                              </div>

                              <div class="control-group">
                                <label class="control-label">Insurance Number:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Insurance Number" value="<?php echo $_SESSION['exp_date']; ?>" name="insuranceNumber" required />
                                </div>
                              </div>
<?php
                     }else{

?>



                              <div class="control-group">
                                <label class="control-label">Insurance Number:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Insurance Number" name="insuranceNumber" value="<?php echo $_SESSION['exp_date']; ?>" required />
                                </div>
                              </div>

<?php
}
//elseif($q == 'Private'){
//    echo '';
//}

?>
