<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

$keyword = urldecode($_GET['kwd']);
// echo $keyword;

if(!empty($keyword)){
$selectkywrk = select("SELECT * FROM notes WHERE keyword='$keyword'");
if($selectkywrk){
    foreach($selectkywrk as $wordrow){}
}
// echo $wordrow['note'];

$_SESSION['wordrow'] = $wordrow['note'];

?>

<div class="control-group">
<label class="control-label"> NOTE DETAILS</label>
  <div class="controls">
      <textarea class="span11" id="noteDet" name="noteDetails" rows="6" ><?php echo $_SESSION['wordrow'];?></textarea>
  </div>
</div>


<?php }else{ ?>

  <div class="control-group">
  <label class="control-label"> NOTE DETAILS</label>
    <div class="controls">
        <textarea class="span11" id="noteDet" name="noteDetails" rows="6" ></textarea>
    </div>
  </div>

<?php }?>
