<?php
//Checks to see if the user has logged in. If not then sends them to the login page
if (!isset($_SESSION['userInfoArray'])) {
    header('Location: loginAndRegistration.php');
}
?>
