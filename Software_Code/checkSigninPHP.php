<?php
    if (isset($_SESSION['userInfoArray'])) {
        header("Location: dashboard.php");
    }
?>