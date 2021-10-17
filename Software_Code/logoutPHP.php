<?php
//Unsets all stored session variables and returns user to homepage
session_start();
unset($_SESSION['userInfoArray']);
session_destroy();
header("location: loginAndRegistration.php")
?>
