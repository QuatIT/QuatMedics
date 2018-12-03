<?php
include('../assets/core/connection.php');
  $term=$_GET["term"];

 $query=mysqli_query($con,"SELECT * FROM pharmacy_inventory where medicine_name like '%".$term."%' ");
 $json=array();

   foreach($query as $proj){
         $json[]=array(
                    'value'=> $proj["medicine_name"] ,
//                    'value'=> $proj["supervisor_name"]

                        );
    }

 echo json_encode($json);

?>
