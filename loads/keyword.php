<?php
include '../assets/core/connection.php';
$keyword = $_GET['kwd'];
echo $keyword;
$selectkywrk = select("SELECT * FROM notes WHERE keyword='$keyword'");
if($selectkywrk){
    foreach($selectkywrk as $wordrow){}
}
echo $wordrow['note'];

?>
