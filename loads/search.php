<?php
include '../assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

//$success = '';
//$error = '';

$perscriptionCode = $_GET['id'];

if(empty($perscriptionCode)){
    echo  "INVALID DATA";
}else{

$load_search = select("SELECT perscriptionCode FROM prescriptions WHERE perscriptionCode='".$perscriptionCode."' ");

if(count($load_search) >=1){
    foreach($load_search as $pharmData){
        $phamCode = $pharmData['perscriptionCode'];
    }
//    echo "gud0";
    echo "<script>window.location.href='./pharmacy-patient?code={$phamCode}'</script>";
}else{
    echo "DATA NOT FOUND";
}
}

?>
