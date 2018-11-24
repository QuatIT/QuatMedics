 <?php
include 'assets/core/connection.php';
session_start();

if(!$_SESSION['username'] && !$_SESSION['password'] && !$_SESSION['accessLevel'] && !$_SESSION['centerID'] ){
    echo "<script>window.location.href='index'</script>";
}

  $term=$_GET["term"];

 $query=select("SELECT * FROM pharmacy_inventory where medicine_name like '%".$term."%'  ");
 $json=array();

   foreach($query as $proj){
         $json[]=array(
                    'value'=> $proj["medicine_name"],

                        );
    }

 echo json_encode($json);

?>
