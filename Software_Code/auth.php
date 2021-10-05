<?php
if (!isset($_SESSION['UserInfo'])) {
    header('Location: login.php');
}else{
    print_r($_SESSION['UserInfo']);
    //TODO: remove this : purely testing 
}
