
<?php
include '../assets/core/connection.php';
$dateToday = date('Y-m-d');
$roomID = $_GET['roomID'];
$load_consultation = select("SELECT * FROM consultation WHERE roomID='$roomID' ORDER BY status asc");
//$load_consultation = select("SELECT * FROM consultation WHERE roomID='$roomID' AND dateInsert='$dateToday' ORDER BY doe ASC");
//$load_consultation = select("SELECT * FROM consultation WHERE roomID='$roomID' && doe='$dateToday' ORDER BY doe ASC");
foreach($load_consultation as $consultRow){
    $patientID = $consultRow['patientID'];
    $staffID = $consultRow['staffID'];
    $status = $consultRow['status'];

    $fetchpatient = select("SELECT firstName,lastName,otherName,dob from patient WHERE patientID='$patientID'");
    $fetchstaff = select("SELECT firstName,lastName,otherName from staff WHERE staffID='$staffID'");

    foreach($fetchpatient as $ptndetails){
        //calculate age
        $dateOfBirth = $ptndetails['dob'];
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        $name = $ptndetails['firstName']." ".$ptndetails['otherName']." ".$ptndetails['lastName'];
    }

foreach($fetchstaff as $staffdetails){
    $staffname = $staffdetails['firstName']." ".$staffdetails['otherName']." ".$staffdetails['lastName'];
}

?>

<tr>
    <td><?php echo $patientID;?></td>
    <td><?php echo $ptndetails['firstName']." ".$ptndetails['otherName']." ".$ptndetails['lastName']?></td>
    <td><?php echo $staffname;?></td>
<!--    <td><?php // echo $diff->format('%y'); ?></td>-->

  <td>
      <?php if($status == "sent_to_consulting"){?>
      <span class="label label-warning">Awaiting</span>
      <?php } if($status == "sent_to_lab"){?>
      <span class="label btn-danger">Lab Requested</span>
      <?php } if($status == "sent_to_ward"){?>
      <span class="label label-info">Inpatient</span>
      <?php } if($status == "sent_to_pharmacy"){?>
      <span class="label label-success">Moved To Dispensary</span>
      <?php } if($status == "Done"){?>
      <span class="label label-success">Discharged</span>
      <?php }?>
    </td>
  <td style="text-align: center;">
       <a href="consult-patient?conid=<?php echo $consultRow['consultID'];?>&roomID=<?php echo $roomID;?>"> <span class="btn btn-primary fa fa-eye labell "> View</span></a>
  </td>
</tr>

<?php }?>
<!--<tr><td colspan="5"> No Data Available in table</td></tr>-->
