<?php

function send_mail($send_to,$body,$subj){
//$account="gracemintah5@gmail.com";
$account="kingicon05@gmail.com";
//$password="phreshest";
$password="zkzymfkffcrfilew";
$to = $send_to;
$from="kingicon05@gmail.com";
$from_name="QUATMEDIC";
$msg= $body; // HTML message
$subject= $subj;
/*End Config*/

include("phpmailer/class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth= true;
$mail->Port = 465; // Or 587
//    $mail->SMTPDebug  = 2;
$mail->Username= $account;
$mail->Password= $password;
$mail->SMTPSecure = 'ssl';
$mail->From = $from;
$mail->FromName= $from_name;
$mail->isHTML(true);
$mail->Subject = $subject;
//$mail->Body = $msg;
$mail->MsgHTML(file_get_contents($msg));
$mail->addAddress($to);
if(!$mail->send()){
 echo "Mailer Error: " . $mail->ErrorInfo;
}else{
 echo "E-Mail has been sent";
}

}

?>
