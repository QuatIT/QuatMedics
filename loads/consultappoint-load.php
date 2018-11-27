
<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

//$roomID = $_GET['roomID'];
$staffID = $_GET['staffID'];
$load_appoint = select("SELECT * FROM doctorappointment WHERE staffID='$staffID' && centerID='".$_SESSION['centerID']."' ORDER BY doe ASC");

foreach($load_appoint as $appointrow){
    $appointNumber = $appointrow['appointNumber'];
    $staffID = $appointrow['staffID'];
    $patientID = $appointrow['patientID'];
    $appointmentDate = $appointrow['appointmentDate'];
    $appointmentTime = $appointrow['appointmentTime'];
    $status = $appointrow['status'];

    $fetchpatient = select("SELECT firstName,lastName,otherName from patient WHERE patientID='$patientID'");
    $fetchstaff = select("SELECT firstName,lastName,otherName from staff WHERE staffID='$staffID'");

    foreach($fetchpatient as $ptndetails){
        $name = $ptndetails['firstName']." ".$ptndetails['otherName']." ".$ptndetails['lastName'];
    }

    foreach($fetchstaff as $staffdetails){
        $staffname = $staffdetails['firstName']." ".$staffdetails['otherName']." ".$staffdetails['lastName'];
    }

?>

<tr>
  <td><?php echo $appointNumber;?></td>
  <td><?php echo $name;?></td>
  <td><?php echo $appointmentDate;?></td>
  <td><?php echo $appointmentTime;?></td>
  <td>
	  <?php if($status == 'PENDIND'){?>
	  	<span class="label label-warning text-center"><?php  echo $status;?></span>
	  <?php }?>
	  <?php if($status == 'DONE'){?>
	  	<span class="label label-success text-center"><?php  echo $status;?></span>
	  <?php }?>
  </td>
  <td style="text-align: center;">
	  <?php if($status == 'PENDIND'){?>
       			<a onclick="return confirm('Set As Done');" href="update-appointment?pid=<?php echo $patientID;?>&sid=<?php echo $staffID;?>&aid=<?php echo $appointNumber;?>"><span class="btn btn-success btn-md fa fa-check"></span></a>
	  <?php }?>
  </td>
</tr>

<?php }?>
<!--<tr><td colspan="5"> No Data Available in table</td></tr>-->
<?php// }?>
