<?php
//Login I.D Request Page

//Checking if the page has been submitted
if(isset($_POST['submit'])){

  //Using the preg_replace function to prevent sql injection
  preg_replace('/[^0-9a-z._-]/i',"" ,$_POST['name']);

  //Using the preg_replace function to prevent sql injection
  preg_replace('/[^0-9a-z._-]/i',"" ,$_POST['school']);

  //Using the preg_replace function to prevent sql injection
  preg_replace('/[^0-9a-z._-]/i',"" ,$_POST['reason']);

  //Assigning fields to Variables
  $name= $_POST["name"];
  $email= $_POST["email"];
  $school= $_POST["school"];
  $reason= $_POST["reason"];

  //Mail Message
  $formcontent="From: $name \n School: $school \n Message: $reason";
  $recipient = "admin@sellitgh.com";
  $subject = "Login I.D Request";
  $mailheader = "From: $email \r\n";

  //Sending the Mail
  mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
  echo "Thank You! We would reply you via E-mail within the next 24hrs." . " -" . "<a href='login.php' style='text-decoration:none;color:#ff0099;'> Return Home</a>";
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <!--Meta, Javascript Head Tags & Title-->
      <title>Login I.D Request Form - Dzella</title>
      <meta charset="utf-8" />
      <link rel="stylesheet" href="requeststyle.css" type="text/css" media="all" />
    <!--End of Meta, Javascript Head Tags & Title-->
</head>

<body>
  <!--Form Header-->
  <h2>Login I.D Request Form</h2>
  <!--End Of Form Header -->

  <!--Form-->
  <form class ="form" action="" method="POST">

    <p class= "name">
        <input type="text" name ="name"  placeholder="Name" >
    </p>

    <p class ="school">
    <input type="text" name ="school"  placeholder="School / Instituion" >
    </p>

    <p class ="email">
    <input type="email" name ="email"  placeholder="E-mail" >
    </p>

    <p class ="text">
    <textarea name="reason" placeholder="Reason for Login I.D request"></textarea>
    </p>

    <p class ="submit">
    <input type="submit" name="submit" value="Request">
    </p>
  </form>
  <!--End Of Form-->


</body>
</html>
<!--End of Login Request Page-->
