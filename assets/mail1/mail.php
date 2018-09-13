<?php

function mail_me($to,$bdy,$department,$address){$account="quat.pay@gmail.com";
$password="Quat@solution,1234";
$send_to = $to;
$from="quat.pay@gmail.com";
$from_name="QUATPAY";
$msg= $bdy;
$subject="QUATPAY";
$address=$send_to;
/*End Config*/

include("phpmailer/class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth= true;
$mail->Port = 465; // Or 587
$mail->Username= $account;
$mail->Password= $password;
$mail->SMTPSecure = 'ssl';
$mail->From = $from;
$mail->FromName= $from_name;
$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body = $msg;
$mail->AddAddress($address, $department);
$mail->addAddress($send_to);
if(!$mail->send()){
 #echo "Mailer Error: " . $mail->ErrorInfo;
}else{
 #echo "E-Mail has been sent";
}

 }







function mail_client($to,$bdy,$department,$address,$attachment,$fname){
$account="quat.pay@gmail.com";
$password="Quat@solution,1234";
$send_to = $to;
$from="quat.pay@gmail.com";
$from_name="QUATPAY";
$msg= $bdy;
$subject="QUATPAY";
$address=$send_to;
/*End Config*/

include("phpmailer/class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth= true;
$mail->Port = 465; // Or 587
$mail->Username= $account;
$mail->Password= $password;
$mail->SMTPSecure = 'ssl';
$mail->From = $from;
$mail->FromName= $from_name;
$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body = $msg;
$mail->AddAddress($address, $department);
$mail->addAddress($send_to);
$mail->AddAttachment($attachment, $fname);
if(!$mail->send()){
 #echo "Mailer Error: " . $mail->ErrorInfo;
}else{
 #echo "E-Mail has been sent";
}

 }

?>
