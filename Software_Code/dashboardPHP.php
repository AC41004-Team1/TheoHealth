<?php
//PHP for adding an invite link to the database
    session_start();
    //Make sure that it's a P or PT trying to get an invite link
    if($_SESSION['userInfoArray'][2] == "P" || $_SESSION['userInfoArray'][2] == "PT"){
      //Make sure that they pressed the button to access this page
      if (isset($_POST['generateInvite'])) {
          include "guidPHP.php";
          include "connectionPHP.php";

          //Get variables needed for SQL query
          $managerID = $_SESSION['userInfoArray'][1];
          $GUIDv1 = getGUID();
          $isUsed = '0';
          $generatedTime = time();

          //Add the link to the database
          $con = openCon();
          $inviteCreationQ = "INSERT INTO inviteLinksView (managerID, GUIDv1, isUsed, generatedTime) VALUES ('$managerID', '$GUIDv1', '$isUsed', '$generatedTime')";
          if ($con->query($inviteCreationQ) === TRUE) {
          } else {
              echo "Error: " . $sql . "<br>" . $con->error;
          }
          closeCon($con);
          //Save the link to the database
          $_SESSION['inviteLink'] = 'http://' . $_SERVER['HTTP_HOST'] . '/index.php?GUIDv1='.$GUIDv1;
          //Send user to invite
          header('Location: ./invite.php');
      }
    }else{
      //send user back to dashboard
      header('Location: dashboard.php');
    }
?>
