<?php
    session_start();
    if (isset($_POST['generateInvite'])) {
        include "guidPHP.php";
        include "connectionPHP.php";

        //$managerID = $_SESSION['userInfoArray'][1];
        $managerID = '18';
        $GUIDv1 = getGUID();
        $isUsed = '0';
        $generatedTime = time();

        $con = openCon();

        $inviteCreationQ = "INSERT INTO inviteLinksView (managerID, GUIDv1, isUsed, generatedTime) VALUES ('$managerID', '$GUIDv1', '$isUsed', '$generatedTime')";

        if ($con->query($inviteCreationQ) === TRUE) {
            
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }

        closeCon($con);
        $_SESSION['inviteLink'] = 'http://localhost/Software_Code/index.php?GUIDv1='.$GUIDv1;
        header('Location: testPHP.php');
    }
?>