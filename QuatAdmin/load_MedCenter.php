
<?php
include '../assets/core/connection.php';

$load_MedCenter = select("SELECT * FROM medicalcenter ORDER BY centerID ASC");

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
      <?php if($medCenterRow['activestatus'] == 'ACTIVE'){ ?>
        <span class="label btn-success btn-sm">ACTIVE</span>
      <?php }
      if($medCenterRow['activestatus'] == 'INACTIVE'){
      ?>
        <span class="label btn-danger btn-sm">INACTIVE</span>
      <?php }?>
    </td>
  <td>
   <a href="#?cid=<?php echo $medCenterRow['centerID'];?>"> <span class="btn btn-success fa fa-edit"></span></a> ||
      <?php if($medCenterRow['activestatus'] == 'ACTIVE'){?>
   <a onclick="return confirm('DEACTIVATE CENTER.');" href="#?cid=<?php echo $medCenterRow['centerID'];?>"> <span class="btn btn-danger fa fa-times-circle"></span></a>
      <?php }?>

      <?php if($medCenterRow['activestatus'] == 'INACTIVE'){?>
   <a onclick="return confirm('ACTIVATE CENTER.');" href="#?cid=<?php echo $medCenterRow['centerID'];?>"> <span class="btn btn-success fa fa-check-circle"></span></a>
      <?php }?>

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

