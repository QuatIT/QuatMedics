
<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

@$_SESSION['exp_date'];
//$q = "PNT-0001";
$q = $_REQUEST['id'];
$pid = $_REQUEST['pid'];

if($q == 'Insurance'){

$sql = select("select * from patient where patientID='$pid' ");
foreach($sql as $row){}

?>


 <div class="control-group">
                                <label class="control-label">Type of Insurance:</label>
                                <div class="controls">
                                   <select class="span11" name="insuranceType" onchange="ccInsure(this.value)">
                                        <option value=""></option>
                                        <option value="NHIS">NHIS</option>
                                        <option value="Vitality">Vitality</option>
                                        <option value="Mutuality">Mutuality</option>
                                        <option value="Acacia">Acacia Health</option>
                                    </select>
                                </div>
                              </div>


        <div class="control-group">
          <label class="control-label">Expire Date:</label>
          <div class="controls">
            <input type="date" class="span11" placeholder="Expire Date" value="<?php echo $row['insurance_exp']; ?>" name="exp_date" required />
          </div>
        </div>


<span id="ccmodeload"></span>

<!--
                              <div class="control-group">
                                <label class="control-label">Insurance Number:</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="Insurance Number" name="insuranceNumber" required />
                                </div>
                              </div>
-->
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
