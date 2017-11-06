<?php

// define variables and set to empty values
$name="";
$email="";
$school="";
$reason="";

 $name= $_POST["name"];
 $email= $_POST["email"];
 $school= $_POST["school"];
 $reason= $_POST["reason"];

 $formcontent="From: $name \n School: $school \n Message: $reason";
 $recipient = "admin@sellitgh.com";
 $subject = "Login I.D Request";
 $mailheader = "From: $email \r\n";

 mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
 echo "Thank You! We would reply you via E-mail within the next 24hrs." . " -" . "<a href='login.php' style='text-decoration:none;color:#ff0099;'> Return Home</a>";



?>
