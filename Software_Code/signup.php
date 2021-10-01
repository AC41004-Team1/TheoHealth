
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Index</title> <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
  <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="styleTemp.css">
  <style type="text/css">
    .wrapper {
      margin-left: 35%;
      margin-right: 35%;
      width: 30%;
    }
  </style>
</head>
<body style="background-image: url('theoHealthBackground.png');  width: 900px; height: 900px; background-repeat: no-repeat ; background-size: cover;">
  <header style="height:200px;">
  <div class="left-half" style="padding:0" style="margin-bottom:1px;">
            <div class="card">
              <div class="card-body">



<?php
session_start();

include "connection.php";
$connection = openCon();

// Check if the form is submitted
  if (isset($_POST['submitsignup'])) {
    // retrieve the form data by using the element's name attributes value as key
    $password = hash('ripemd160', $_POST['password']);
    $checkerPassword = hash('ripemd160', $_POST['checkerPassword']);
    $username = $_POST['username'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNum'];
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];

    //Makes sure that both password are identical
    if($password == $checkerPassword){
      //Got phone number checker from https://stackoverflow.com/questions/3090862/how-to-validate-phone-number-using-php
      //eliminate every char except 0-9
      $phoneNum = preg_replace("/[^0-9]/", '', $phoneNum);
      if (strlen($phoneNum) > 9){
        //Run query to find if there is anyone with that username already
        $SQLInput = "CALL CheckUsername(\"{$username}\")";
        $queryOutput = $connection->query($SQLInput);
        closeCon($connection);
        //If username is unique
        if(!empty($queryOutput)){
          //Add the user to the database
          $connection = openCon();
          $SQLInput = "CALL addUser(\"{$fname}\", \"{$sname}\", \"{$phoneNum}\", \"{$username}\", \"{$password}\", \"{$role}\", \"{$email}\")";
          $connection->query($SQLInput);
          closeCon($connection);
          
          //Create and store session variables
          $_SESSION["loggedIn"] = "true";
          $_SESSION["role"] = $role;
          //Get the user index to store as a session variable
          $connection = openCon();
          $SQLInput = "CALL getUserIndex(\"{$username}\")";
          $results = $connection->query($SQLInput);
          closeCon($connection);
          $row = $results->fetch_object();
          $_SESSION["userIndex"] = $row-> UserIndex;

          //Welcome Message
          echo "Welcome {$fname} {$sname}. Your account has now been created. You'll be taken to your dashboard in 10 seconds or you can click <a href/'/Dashboard.php/'>here</a> to go there now.";
          echo "<meta http-equiv=\"refresh\" content=\"10; URL=/Dashboard.php\" />";
        }
        else{
          echo "Sorry your account could not be created. The username you entered is already taken.";
          echo "<meta http-equiv=\"refresh\" content=\"8; URL=/login.php\" />";
        }
      }
      else{
        echo "Sorry your account could not be created. The phone number was invalid.";
        echo "<meta http-equiv=\"refresh\" content=\"8; URL=/login.php\" />";
      }
    }
    else{
      echo "Sorry your account could not be created. The second password doesn't match the first.";
      echo "<meta http-equiv=\"refresh\" content=\"8; URL=/login.php\" />";
    }
  }
  else{
    echo "<meta http-equiv=\"refresh\" content=\"0; URL=/login.php\" />";
  }
?>
    </div>
          </div>
        </div>
</body>



</html>
