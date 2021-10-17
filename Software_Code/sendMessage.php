<?php
  //adds the message sent to the database
  session_start();

  include "connectionPHP.php";

  // Check if the form is submitted
    if (isset($_POST['submitMessage'])) {
      //retrieve the form data by using the element's name attributes value as key
      $sessionIndex = $_POST['submitMessage'];
      $theMessage = $_POST['messageSent'];
  }

  //Adds the comment to the database under the correct session index and user index
  $connection = openCon();
  $query = "CALL addComment('{$sessionIndex}','{$_SESSION['userInfoArray'][1]}','{$theMessage}')";
  $result = $connection->query($query);
  closeCon($connection);
  //Sends you back to the sessions page
  header("Location: vis.php");
?>
