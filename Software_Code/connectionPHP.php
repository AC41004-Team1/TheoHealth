<?php
//Function to open a connection to the server and return that to the variable the method is set to.
  function openCon()
  {
    //Credentials
    $servername = "ls-1f9fbdc4cb3ac2e7c45e19fad57c73926ef8a497.cyneooocbzlz.eu-west-2.rds.amazonaws.com:3306";
    $username = "dbmasteruser";
    $password = "mAgHsPDX3Z+DBtMaGs}Lo,wGpXV`%zwz";
    $database = "dbmaster";
    //Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    //Check connection
    if ($conn->connect_error) {
      echo "FAIL";
      die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
  }
//Closes a connection that is passed into this method
  function closeCon($conn)
  {
    $conn->close();
  }
?>
