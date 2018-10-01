
<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

//$q = "PNT-0001";
$q = $_REQUEST['id'];

if($q == 'Insurance'){

?>


 <div class="control-group">
                                <label class="control-label">Type of Insurance:</label>
                                <div class="controls">
                                   <select class="span11" name="insuranceType">
                                        <option value=""></option>
                                        <option value="NHIS">NHIS</option>
                                        <option value="Vitality">Vitality</option>
                                        <option value="Mutuality">Mutuality</option>
                                        <option value="Acacia">Acacia Health</option>
                                    </select>
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label">Insurance Number:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Insurance Number" name="insuranceNumber" required />
                                </div>
                              </div>
<?php
                     }elseif($q == 'Company'){

?>


                              <div class="control-group">
                                <label class="control-label">Company Name:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Company Name" name="company" required />
                                </div>
                              </div>

<?php
}
//elseif($q == 'Private'){
//    echo '';
//}

?>
