
<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

//$q = "PNT-0001";
$q = $_GET['id'];


if($q=="Capsule" || $q=="Tablet"|| $q=="Inhalers" ){

	?>



							   <div class="control-group">
                                <label class="control-label">Number of Pieces :</label>
                                <div class="controls">
                                  <input type="text" class="span11" placeholder="No. of pieces" name="no_of_piece" />
                                </div>
                              </div>

<?php
	$type = 'solid';
}elseif($q == "Syrup" || $q == "Suppositories" || $q=="Injections" || $q=="Drops" ){

	?>


                              <div class="control-group">
                                <label class="control-label">Number of Bottles</label>
                                <div class="controls">
                                  <input type="text"  class="span11" name="no_of_bottles" placeholder="No. of bottles" required />
                                </div>
                              </div>


<?php
$type='liquid';
}else{ echo '';}



?>

