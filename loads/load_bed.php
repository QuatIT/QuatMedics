
<?php
include '../assets/core/connection.php';

$wardID = $_GET['warID'];

$load_bed = select("SELECT * FROM bedlist WHERE wardID='".$wardID."' ORDER BY bedNumber ASC");

?>


<?php
foreach($load_bed as $bed){
?>
<tr>
  <td><?php echo $bed['bedNumber']; ?></td>
<!--  <td> <?php //echo $bed['bedDescription']; ?></td>-->
<!--  <td> <?php // echo $bed['BedCharge']; ?></td>-->
  <td> <?php echo $bed['status']; ?></td>
</tr>

<?php } ?>

