<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

//$success = '';
//$error = '';

$transferID = $_GET['id'];

if(empty($transferID) || $transferID='null'){
    echo  "INVALID DATA";
}else{

$load_search = select("SELECT * FROM medicalcenter WHERE centerID='".$transferID."' ");

if(count($load_search) >=1){
    foreach($load_search as $pharmData){
        $centerName = $pharmData['centerName'];
    }
//    echo "gud0";
   ?>


 <div class="control-group">
                                <label class="control-label">Center Name :</label>
                                <div class="controls">
                                  <input type="text" class="span11" name="centerName" value="<?php echo $pharmData['centerName']; ?>" readonly required/>
                                </div>
                              </div>



<?php

    $centerUser = select("SELECT * FROM staff WHERE centerID='$transferID' ");
    ?>
    <div class="control-group">
                                <label class="control-label">Staff Name :</label>
                                <div class="controls">
                                    <select class="span11" name="staffName">
    <?php
    foreach($centerUser as $centauser){

        ?>

    <option  value="<?php echo $centeruser['staffID']; ?>" ><?php echo $centeruser['firstName']." ".$centeruser['otherName']." ".$centeruser['lastName']; ?></option>

<?php

    }
    ?>
                                        </select>
       </div>
                              </div>

<?php
}else{
    echo "DATA NOT FOUND";
}
}

?>



