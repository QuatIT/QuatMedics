<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$patient = select("SELECT * FROM emergency_patient WHERE centerID='".$_SESSION['centerID']."' ORDER BY patientID ASC");
if(count($patient)>0){
    ?>

 <option value="default"> -- Select Patient ID --</option>

<?php
foreach($patient as $pID){
?>

<option value="<?php echo $pID['patientID']; ?>"><?php echo $pID['patientID']; ?></option>

<?php }}else{echo "<option>no record found.</option>";}?>

