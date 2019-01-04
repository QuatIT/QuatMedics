
<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

//$q = "PNT-0001";
$q = $_REQUEST['id'];

$sql = select("select * from diseases where name LIKE '%$q%' ");
foreach($sql as $row){

?>


                                        <option value="<?php echo $row['code']; ?>"><?php echo $row['name']; ?></option>


<?php
}

?>
