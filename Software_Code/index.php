<?php
  //If the user has a GUID (registering with a P/PT)
    if (isset($_GET['GUIDv1'])) {
        //Get the GUID
        $GUIDv1 = $_GET['GUIDv1'];
        include "connectionPHP.php";

        //Run a query checking if the GUID exists
        $con = openCon();
        $qGUID = "SELECT * FROM inviteLinksView WHERE GUIDv1 = '$GUIDv1'";
        $result = $con->query($qGUID);
        closeCon($con);
        //If the GUID doesn't exist send them to login and registration
        if ($result->num_rows == 0) {
            header('Location: loginAndRegistration.php');
        }   else {
            //If the GUID does exist then make sure that it hasn't expired from the time limit and hasn't been used before
            $resultRow = $result->fetch_array();
            $timeElapsed = time() - $resultRow['generatedTime'];
            if ($timeElapsed <= '86400') {
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
        //if the user isn't accessing with a GUID then send them to login and registration
        header('Location: loginAndRegistration.php');
    }
?>
