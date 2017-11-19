<?php
include('includes/core.inc.php');
if(loggedIn){
	
  // destroy session and redirect user to login page
  session_destroy();
  header('Location:index.php');
}
else{
  header('Location:index.php');
}

 ?>
