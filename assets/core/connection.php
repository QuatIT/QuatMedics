<?php
date_default_timezone_set("Africa/Accra");
	require "constants.php";

//connection
$host = DB_SERVER;
$username = DB_USER;
$password = DB_PASSWORD;
$dbname = DB_NAME;

try{

	$db = new PDO("mysql:host=localhost;dbname=$dbname", "$username", "$password");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e){
	echo 'ERROR: ' . $e->getMessage();
}

//select
 	function select($sql, $fetchMode = PDO::FETCH_ASSOC){
        global $db;

        $stmt = $db->prepare($sql);

        $ok = $stmt->execute();

        if(!$ok){
            return $ok;
        }
        return $stmt->fetchAll($fetchMode);

     }

     function query($sql){
        return select($sql);

     }

//insert
     function insert($sql){
        global $db;

        $stmt = $db->prepare($sql);
        return $stmt->execute();

     }

//update
     function update($sql){
        global $db;

        $stmt = $db->prepare($sql);
        return $stmt->execute();

     }

//delete
     function delete($sql){
        global $db;
        $stmt = $db->prepare($sql);
        return $stmt->execute();

     }

//function to encrypt the string
        function encode5t($str){
            for($i=0;$i<5;$i++){
                $str = strrev(base64_encode($str));// apply base64 first and then reverse the string
            }
            return $str;
        }

//function to decrypt the string
        function decode5t($str){
            for($i=0;$i<5;$i++){
                $str = base64_decode(strrev($str));// apply base64 first and then reverse the string
            }
            return $str;
        }


//generation of IDs
function randomString($length)
{
    return bin2hex(openssl_random_pseudo_bytes($length));
}


//folder creation

 function uploadDir($centerID)

{

//	$sCurrDate = date("Y-m-d"); //Current Date
//     $centerID = $_SESSION['centerID'];

// 	$sDirPath = 'http://quatitsolutions.com/try/'.$sCurrDate.'/'; //Specified Pathname
	$sDirPath = './'.$centerID.'/'; //Specified Pathname

	if (!file_exists ($centerID))

   	{

	    	mkdir($centerID,0777,true);

    	}

}

function make_dir($centerID)
{
  $parent = '../uploads/';

   $the_dir = $parent.$centerID;
   $licence = $parent.$centerID.'/licence';
   $labresults = $parent.$centerID.'/labresults';
   $patient = $parent.$centerID.'/patient';
    if (!file_exists ($the_dir)){
   @mkdir($the_dir, 0777, TRUE);
   @mkdir($licence, 0777, TRUE);
   @mkdir($labresults, 0777, TRUE);
   @mkdir($patient, 0777, TRUE);
    }
}

?>

    <?php
include 'mail_old/gmail.php';
include 'classes.class.php';
?>
