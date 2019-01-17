<?php
//include 'assets/core/connection.php';

$rn = $_GET['rn'];

if($rn == "Other"){
?>
    <label class="control-label">REASON DETAILS</label>
    <div class="controls">
        <textarea class="span11" name="rnDetails" rows="3"></textarea>
    </div>
<?php }else{ ?>
    <label class="control-label">REASON DETAILS</label>
    <div class="controls">
        <textarea class="span11" name="rnDetails" rows="3" readonly></textarea>
    </div>

<?php }?>
