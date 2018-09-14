<?php
include 'assets/core/connection.php';

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] ){
    echo "<script>window.location.href='index'</script>";
}

session_unset($_SESSION['username']);
session_unset($_SESSION['password']);
session_unset($_SESSION['accessLevel']);

session_destroy();

echo "<script>window.location.href='index'</script>";

?>
