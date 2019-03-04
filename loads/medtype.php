<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$type = $_GET['tp'];
$loadmeds = select("SELECT * FROM pharmacy_inventory WHERE centerID='".$_SESSION['centerID']."'");

if($loadmeds){

?>
<select class="span11" name="medicine_name">
    <option></option>
	<?php foreach($loadmeds as $medrow){ ?>
	<option value="<?php echo $medrow['medicine_id'];?>"> <?php echo $medrow['medicine_name'];?></option>
	<?php }?>
</select>

<?php  } ?>
