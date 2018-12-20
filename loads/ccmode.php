
<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

//$q = "PNT-0001";
$q = $_REQUEST['id'];

if($q == 'NHIS'){

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
                                  <input type="text" class="span11" placeholder="Insurance Number" name="insuranceNumber" required />
                                </div>
                              </div>
<?php
                     }else{

?>



                              <div class="control-group">
                                <label class="control-label">Insurance Number:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Insurance Number" name="insuranceNumber" required />
                                </div>
                              </div>

<?php
}
//elseif($q == 'Private'){
//    echo '';
//}

?>
