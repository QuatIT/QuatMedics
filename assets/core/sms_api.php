<?php

//SMS to members
function sendsms($bdy,$subject,$phone_number){
$username = 'kingicon';
$password = 'x6G0U6K7';
$body = $subject.PHP_EOL.$bdy;
$message= $body;

$from = "CHURCH";//your senderid example "kwamena"max is 11 chars;
$baseurl = "http://isms.wigalsolutions.com/ismsweb/sendmsg/";

//All numbers must have a country code. delimit them with comma(,)

$text_to = $phone_number;

$params = "username=".$username."&password=".$password."&from=".$from."&to=".$text_to."&message=".$message ;

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
echo "<script>alert('message sent');
window.location.href('arena.php')</script>";
}else{
echo "<script>alert('message could not be sent');
window.location.href('arena.php')</script>";
}
}
?>
