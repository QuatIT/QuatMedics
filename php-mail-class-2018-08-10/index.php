<?php

require_once 'Classes/Mail.php';

//Example using php mailer
$mail = new Mail;
//Set subject and sender of the mail.
$mail->setSubject('Example mail');
$mail->setSender('mail@example.com');
//Set the plain content of the mail.
$mail->setContentPlain('Example plain-content!');
//Add a receiver of the mail (you can add more than one receiver too).
$mail->addReceiver('example@gmail.com');
//Finally send the mail.
var_dump($mail->send());

//Example using smtp
$mail = new Mail;

//Set subject and sender of the mail.
$mail->setSubject('Example mail');
$mail->setSender('example@gmail.com');
//Set the plain content of the mail.
$mail->setContentPlain('Example plain-content!');
//Add a receiver of the mail (you can add more than one receiver too).
$mail->addReceiver('lablnet01@gmail.com');

$mail->isSMTP(true,['host'=>"mx1.hostinger.ae
",'user'=>'mail@hostinger.com','pass'=>'hostinger','port'=>587]);
//Finally send the mail.
var_dump($mail->send());
