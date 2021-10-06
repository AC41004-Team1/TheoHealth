<?php
if (!isset($_SESSION['userInfoArray'])) {
    header('Location: loginAndRegistration.php');
} else {
    print_r($_SESSION['userInfoArray']);
    //TODO: remove this : purely testing
}
?>
