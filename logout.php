<?php
//Logout Script


// logout.php

// you must start session before destroying it
session_start();
session_unset();
session_destroy();
//}

//echo "You have been successfully logged out.
//to unet the cookie set it to a pas t time
setcookie ("ID_my_site", "", time() - 3600);
	header('Location: login.php');
?>
<!--End of logout Page-->
