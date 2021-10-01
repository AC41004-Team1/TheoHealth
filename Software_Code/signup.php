<html>
<body>
<?php
session_start();

include "connection.php";
$connection = openCon();

// Check if the form is submitted
  if (isset($_POST['submit'])) {
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
      if (strlen($justNums) > 9){
        //Run query to find if there is anyone with that username already
        $SQLInput = "CALL CheckUsername(\"{$username}\")";
        $queryOutput = $connection->query($SQLInput);
        closeCon($connection);
        //If username is unique
        if(!empty($queryOutput){
          //Add the user to the database
          $connection = openCon();
          $queryOutput = $connection->query($SQLInput);
          $SQLInput = "CALL addUser(\"{$fname}\", \"{$sname}\", \"{$phoneNum}\", \"{$username}\", \"{$password}\", \"{$role}\", \"{$email}\")";
          $queryOutput = $connection->query($SQLInput);
          closeCon($connection);
          //Create and store session variables
          $_SESSION["loggedIn"] = "true";
          $_SESSION["role"] = $role;
          $_SESSION["userIndex"] = $usernameIn;
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
</body>
</html>
