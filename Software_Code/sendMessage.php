<?php
  session_start();

  include "connectionPHP.php";

  // Check if the form is submitted
    if (isset($_POST['submitMessage'])) {
      //retrieve the form data by using the element's name attributes value as key
      $sessionIndex = $_POST['submitMessage'];
      $theMessage = $_POST['messageSent'];
  }

  $connection = openCon();
  $query = "CALL addComment('{$sessionIndex}','{$_SESSION['userInfoArray'][1]}','{$theMessage}')";
  $result = $connection->query($query);
  closeCon($connection);

  header("Location: vis.php");
?>
