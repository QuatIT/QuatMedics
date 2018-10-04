<?php




function clean($string) {
      // Replaces all spaces with hyphens.

   $string = str_replace('0','233', $string); // Replaces all spaces with hyphens.

return $string;
}


//SMS to student when approved
function sendsmsme($tel,$body,$frm){
$username = 'kingicon';
//$password = 'x6G0U6K7';
$password = 'godwin1.';
$message = $body;
$from = $frm;//your senderid example "kwamena"max is 11 chars;
$baseurl = "http://isms.wigalsolutions.com/ismsweb/sendmsg/";

//All numbers must have a country code. delimit them with comma(,)
$to = $tel;
$params = "username=".$username."&password=".$password."&from=".$from."&to=".$to."&message=".$message ;

//send the message
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$baseurl);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
$return = curl_exec($ch);
curl_close($ch);

$send = explode(" :: ",$return);
if(stristr($send[0],"SUCCESS") != FALSE){
//echo "message sent";
}else{
//echo "message could not be sent";
}
}


?>
