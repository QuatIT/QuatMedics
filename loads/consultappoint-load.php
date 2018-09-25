
<?php
include '../assets/core/connection.php';

//$roomID = $_GET['roomID'];
$staffID = $_GET['staffID'];
$load_appoint = select("SELECT * FROM doctorappointment WHERE staffID='$staffID' ORDER BY doe ASC");

foreach($load_appoint as $appointrow){
    $appointNumber = $appointrow['appointNumber'];
    $staffID = $appointrow['staffID'];
    $patientID = $appointrow['patientID'];
    $appointmentDate = $appointrow['appointmentDate'];
    $appointmentTime = $appointrow['appointmentTime'];

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
  <td style="text-align: center;">
       <a href=""><span class="btn btn-primary fa fa-eye"></span></a>
  </td>
</tr>

<?php }?>
<!--<tr><td colspan="5"> No Data Available in table</td></tr>-->
<?php// }?>
