<?php
//include 'includes/connection.php';
include 'assets/core/connection.php';
// Get search term
// $searchTerm = $_GET['term'];



//echo $_GET['query'];

if(isset($_GET['query'])){
// Get matched data from skills table
$query = select("SELECT * FROM notes WHERE keyword LIKE '%".$_GET['query']."%' ");

echo "<ul id='ul' style='list-style:none; width:700px;' class='list-unstyled'>";
// Generate skills data array
    foreach($query as $row){
      echo "<li id='li' >".$row['keyword']."</li>";
    }

echo "</ul>";
}
?>
