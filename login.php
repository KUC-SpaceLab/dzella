<?php
//Submission Portal

//Authentication Script

//Session Begins
session_start();

//Check If Submit has been Clicked
if(isset($_POST['submit'])){

//Handles the echo before the header output
ob_start();

//Using the preg_replace function to prevent sql injection
preg_replace('/[^0-9a-z._-]/i',"" ,$_POST['username']);

//assigning field to a variable
$username = $_POST['username'];
$password = $_POST['password'];

echo $username ." : ".$password;

//Connection to the database
$pdo = new PDO ("mysql:host=localhost;dbname=sellit12_searchengine", "sellit12_root","Ba0548797248");
$q = 'SELECT * FROM loginuser WHERE username=:username AND password=:password';

//Prepare Statement Queries to Handle Sql injection
$query = $pdo->prepare($q);

$query->execute(array(':username' => $username, ':password' => $password));

//Checking If Username & Password is available
if($query->rowCount() == 0){
	//If not available output error on the login Page
	header('Location: login.php?err=1');
}else{

	//fetch the row of the Username and password
	$row = $query->fetch(PDO::FETCH_ASSOC);

	session_regenerate_id();
	$_SESSION['sess_user_id'] = $row['id'];
	$_SESSION['sess_username'] = $row['username'];
	$_SESSION['sess_userrole'] = $row['role'];

	echo $_SESSION['sess_userrole'];
	session_write_close();

//Redirectng Based on role
	if( $_SESSION['sess_userrole'] == "admin"){
		//Admin's Homepage
		header('Location: admin.php');
	}else{
		//User Submit Page
		header('Location: submit.php');
	}

   }

   //disconnect form database
             $pdo = null;
}

//End of authentication Script
?>


<!--Main Page-->
<!DOCTYPE html>
<html lang="en">

<head>

				<!--Meta, Javascript Head Tags & Title-->
				<meta charset="utf-8">
				<title>Login - Dzella</title>
				<link rel="stylesheet" type="text/css" href="style.css" />
				<link rel="stylesheet" href="loginstyle.css" />
				<!--End of Meta, Javascript Head Tags & Title-->
</head>

<body>

							<!--Main Content-->
							<div class="container">
								<section id="content">

									<!--Form-->
									<form action="" enctype="multipart/form-data"  method="post">
										<h1>Submission Portal</h1>
										<div>

										<!--Error Script-->
							        <?php
							          $errors = array(
							              1=>"Invalid username or password, Please Try again <br />",
							              2=>"Please login to access this area <br />"
							            );

							          $error_id = isset($_GET['err']) ? (int)$_GET['err'] : 0;

							          if ($error_id == 1) {
							                  echo '<p style="color:red;">'.$errors[$error_id].'</p>';
							              }elseif ($error_id == 2) {
							                  echo '<p style="color:red;">'.$errors[$error_id].'</p>';
							              }
							         ?>
											 <!--End Of Error Script-->

											<input type="text" placeholder="Username" id="username" name="username" required/>
										</div>

										<div>
											<input type="password" placeholder="Password" id="password" name="password" required/>
										</div>

										<div>
											<!--Login Button-->
											<input type="submit" value="Log in" name="submit"/>
											<!--End of Login Button-->

											<a href="#">Lost your password?</a>
											<a href="index.php">Click here to return to Main Page</a>
										</div>

									</form>
									<!-- End of form -->

									<!--Request I.D Section-->
									<div class="button">
										<a href="request.php">Request for Login I.D</a>
									</div>
									<!--End of Request I.D Section-->

								</section>
							</div>

							<!--Main Content-->
</body>
</html>
<!--Submission Portal Page-->
