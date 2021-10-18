<?php
//Checks if the user has logged in and if so sends them to the dashboard page
    if (isset($_SESSION['userInfoArray'])) {
        header("Location: dashboard.php");
    }
?>
