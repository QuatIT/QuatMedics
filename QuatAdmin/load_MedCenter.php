
<?php
include '../assets/core/connection.php';

$load_MedCenter = select("SELECT * FROM medicalCenter ORDER BY centerID ASC");

?>


<?php
foreach($load_MedCenter as $medCenterRow){
?>



<tr>
  <td><?php echo $medCenterRow['centerID']; ?></td>
  <td> <?php echo $medCenterRow['centerName']; ?></td>
  <td> <?php echo $medCenterRow['centerLocation']; ?></td>
  <td style="text-align: center;"> <?php echo $medCenterRow['numOfBranches']; ?></td>
  <td style="text-align: center;">
       <a href="#"> <span class="btn btn-primary fa fa-eye"></span></a>
  </td>
</tr>

<?php } ?>

