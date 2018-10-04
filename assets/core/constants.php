<?php
//error_reporting(0);
define("DB_SERVER" , "localhost");
define("DB_USER" , "root");
//define("DB_PASSWORD" , "#edicon,123456789.");
define("DB_PASSWORD" , "");
define("DB_NAME" , "quatMedics");


define("SENT_TO_CONSULTING" , "sent_to_consulting");
define("SENT_TO_LAB" , "sent_to_lab");
define("SENT_TO_WARD" , "sent_to_ward");
define("SENT_TO_PHARMACY" , "sent_to_pharmacy");
define("CENTER_ADMIN" , "center_admin");


define("LIVING" , "living");
define("DEAD" , "dead");

define("OCCUPIED","occupied");
define("FREE","free");

define("SMS_PENDING","sms_pending");
define("SMS_APPROVED","sms_approved");

define("PARENT_DIR" , "uploads/");
define("LICENCE_DIR" , "../uploads/".PARENT_DIR."licence/");
define("LAB_RESULT_DIR" , "../uploads/labresults/");
define("PATIENT_DIR" , "../uploads/patient/");


define("PATIENT_BUSY" , "patient_busy");

$encryption_key = "encryption_key-243423";


$count = 0;
$counter = 1;

//include '../mail/gmail.php';

?>
