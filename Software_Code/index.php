<?php
    if (isset($_GET['GUIDv1'])) {
        $GUIDv1 = $_GET['GUIDv1'];
        include "connectionPHP.php";
        
        $con = openCon();

        $qGUID = "SELECT * FROM inviteLinksView WHERE GUIDv1 = '$GUIDv1'";
        $result = $con->query($qGUID);
        //var_dump($result);
        if ($result->num_rows == 0) {
            header('Location: loginAndRegistration.php');
        }   else {
            $resultRow = $result->fetch_array();
            $timeElapsed = time() - $resultRow['generatedTime'];
            if ($timeElapsed <= '86400') {
                //var_dump($resultRow);
                if ($resultRow['isUsed'] == '1') {
                    echo "USED";
                    echo "<script>alert('Sorry, your invite link is has already been used, press okay to return to login');document.location='loginAndRegistration.php'</script>";
                } else {
                    echo "NOT USED";
                    header('Location: inviteRegistration.php?ID='.$GUIDv1);
                }
            } else {
                echo "<script>alert('Sorry, your invite link is more than 24 hours old, press okay to return to login');document.location='loginAndRegistration.php'</script>";
            }
        }
    } else {
        header('Location: loginAndRegistration.php');
    }
?>