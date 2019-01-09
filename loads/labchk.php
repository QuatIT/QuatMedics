
<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

//$q = "PNT-0001";
$q = $_REQUEST['id'];

if($q == 'sent_to_lab'){

$sql = select("select * from lablist where centerID='".$_SESSION['centerID']."'");
if(count($sql) >0){foreach($sql as $row){

?>

          <option value="<?php echo $row['labID']; ?>"><?php echo $row['labName']; ?></option>

<?php
}}else{
  echo "No data found";
}
}elseif($q == "no"){ echo "<option></option> "; }

?>
