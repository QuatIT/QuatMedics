<?php
require_once 'assets/core/connection.php';
@session_start();
$dateToday = trim(date('Y-m-d'));
//error_reporting(0);
if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}else{
    $staff = select("SELECT * from centeruser WHERE username='".$_SESSION['username']."' AND password='".$_SESSION['password']."'");
    foreach($staff as $staffrow){
        $staffID = $staffrow['staffID'];
    }
}
$centerID = $_SESSION['centerID'];
//search and display hospital name
$centerName_sql = select("SELECT * FROM medicalcenter WHERE centerID='".$_SESSION['centerID']."' ");
foreach($centerName_sql as $centerName){}

$ID = $_GET['id'];
if(!empty($ID)){
    $confirm = 'CONFIRMED';
    $updateLab = update("UPDATE labresults SET confirm='$confirm' WHERE id='$ID'");
    if($updateLab){
            echo "<script>window.location='".$_SESSION['current_page']."'</script>";
    }else{
            $error = "<script>alert('CONFIRMATION FAILED, TRY AGAIN');</script>";
    }
}else{
    $error = "<script>alert('NO LAB SELECTED, TRY AGAIN');</script>";
}
?>
