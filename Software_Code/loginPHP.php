<?php
  session_start();

  include "connectionPHP.php";
  $connection = openCon();

  // Check if the form is submitted
    if (isset($_POST['submit'])) {
      //retrieve the form data by using the element's name attributes value as key
      $username = $_POST['username'];
      $password = hash('ripemd160', $_POST['password']);
  }

  //Run the query in the database
  $usernameQ = "SELECT * FROM login WHERE Username = '$username'";
  $result = $connection->query($usernameQ);

  closeCon($connection);

  if ($result->num_rows == 0) {
    //Failed login due to user not existing
    $_SESSION['failedUsername'] = 1;
    header("Location: loginAndRegistration.php");
  } else {
    $resultRow = $result->fetch_array();
      if ($resultRow['UserPassword'] == $password) {
        //Successfull login
        $userInfoArray=array($resultRow['Username'], $resultRow['UserIndex'], $resultRow['Role']);
        $_SESSION["userInfoArray"] = $userInfoArray;
        header("Location: dashboard.php");
      } else {
        //Failed login due to password not correct
        $_SESSION['failedPassword'] = 1;
        header("Location: loginAndRegistration.php");
      }
  }
?>
