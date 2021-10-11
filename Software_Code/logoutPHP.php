<?php 
session_start();
unset($_SESSION['userInfoArray']);
session_destroy();
header("location: loginAndRegistration.php")
?>