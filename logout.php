<?php
include 'assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

if(!empty($_GET['c'])){
    $update_consulting = update("UPDATE consultingroom SET status='free' WHERE roomID='".$_GET['c']."' ");
}else{

session_unset($_SESSION['username']);
session_unset($_SESSION['password']);
session_unset($_SESSION['accessLevel']);
session_unset($_SESSION['centerID']);

session_destroy();

echo "<script>window.location.href='index'</script>";
}



session_unset($_SESSION['username']);
session_unset($_SESSION['password']);
session_unset($_SESSION['accessLevel']);
session_unset($_SESSION['centerID']);

session_destroy();

echo "<script>window.location.href='index'</script>";


?>

