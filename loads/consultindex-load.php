
<?php
include '../assets/core/connection.php';
$roomID = 1;
$load_consultation = select("SELECT * FROM consultation WHERE roomID='$roomID' ORDER BY doe ASC");

?>


<?php
foreach($load_consultation as $consultRow){
    $patientID = $consultRow['patientID'];
    $staffID = $consultRow['staffID'];
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
  <td><?php echo $patientID;?></td>
  <td><?php echo $name;?></td>
  <td><?php echo $staffname;?></td>
  <td style="text-align: center;">
       <a href="consult-patient.php?conid=<?php echo $consultRow['consultID'];?>"> <span class="btn btn-primary fa fa-eye"></span></a>
  </td>
</tr>

<?php }?>

