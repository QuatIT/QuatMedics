
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
<!--       <a href="#" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#myModal<?php #echo $medCenterRow['centerID']; ?>"><i class="fa fa-envelope"></i> Recharge SMS</a>-->
  </td>
</tr>


<!-- Modal -->
<div id="myModal<?php echo $medCenterRow['centerID']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<?php } ?>

