<?php include "head.php" ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <meta charset="utf-8">
  <title>Sign up</title>
  <link rel="stylesheet" href="./resources/styles/general.css">
  <link rel="stylesheet" href="./resources/styles/footer.css">
  <link rel="stylesheet" href="./resources/styles/register.css">
</head>

<body>
  <header style="height:200px;">
    <div class="leftContainer">
      <img src="./resources/images/theoLogo.png" alt="" width="500" height="100">
      <h1 class="text-left">Sign up</h1>
    </div>
    <div class="left-half" style="padding:0" style="margin-bottom:1px">
      <div class="card border-light mb-3" style="max-width: 30rem;" style="margin: 10px;">
        <div class="card-header">Important</div>
        <div class="card-body" style="font-size:20px">
          <h5 class="card-title">Please Read</h5>
          <p class="card-text"></p>

          <?php
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
            $signUpReason = "";
            $GUID = $_POST['GUID'];

            if (isset($_POST['signUpReason'])) {
                $signUpReason = $_POST['signUpReason'];
            }

            if (isset($_POST['GUID'])) {
                $signUpReason = $_POST['signUpReason'];
            }
            //Makes sure that both password are identical
            if ($password == $checkerPassword) {
              //Got phone number checker from https://stackoverflow.com/questions/3090862/how-to-validate-phone-number-using-php
              //eliminate every char except 0-9
              $phoneNum = preg_replace("/[^0-9]/", '', $phoneNum);
              if (strlen($phoneNum) > 9) {

                //Run query to find if there is anyone with that username already
                $SQLInput = "CALL checkUsername(\"{$username}\")";
                $queryOutput = $connection->query($SQLInput);
                closeCon($connection);

                $connection = openCon();
                $SQLInput = "CALL getManagerIDWithGUID(\"{$GUID}\")";
                $queryOutput2 = $connection->query($SQLInput);
                $managerID = $queryOutput2 -> fetch_object()->managerID;
                closeCon($connection);

                //If username is unique
                if ($queryOutput->num_rows <= 0) {
                  //Add the user to the database
                  $connection = openCon();
                  if (isset($_POST['signUpReason'])) {
                      $SQLInput = "CALL addAthlete(\"{$fname}\", \"{$sname}\", \"{$phoneNum}\", \"{$username}\", \"{$password}\", \"{$role}\",\"{$email}\", \"{$signUpReason}\")";
                      $connection->query($SQLInput);
                      closeCon($connection);

                      $connection = openCon();
                      $SQLInput = "CALL getUserIndex(\"{$username}\")";
                      $queryOutput = $connection->query($SQLInput);
                      $userIndex = $queryOutput -> fetch_object()->UserIndex;
                      closeCon($connection);

                      $connection = openCon();
                      $SQLInput = "CALL addClienttoManager(\"{$userIndex}\",\"{$managerID}\")";
                      $connection->query($SQLInput);
                      var_dump($connection);
                      closeCon($connection);
                  }
                  else{
                  $SQLInput = "CALL addUser(\"{$fname}\", \"{$sname}\", \"{$phoneNum}\", \"{$username}\", \"{$password}\", \"{$role}\", \"{$email}\")";
                  $connection->query($SQLInput);
                  closeCon($connection);
                }

                  //Welcome Message
                  echo "Welcome {$fname} {$sname}. Your account has now been created. You'll be taken to your Login in 10 seconds or you can click <a href/'/loginAndRegistration.php/'>here</a> to go there now.";
                  echo "<meta http-equiv=\"refresh\" content=\"10; URL=./loginAndRegistration.php\" />";
                } else {
                  echo "Sorry your account could not be created. The username you entered is already taken.";
              //    echo "<meta http-equiv=\"refresh\" content=\"8; URL=./loginAndRegistration.php\" />";
                }
              } else {
                echo "Sorry your account could not be created. The phone number was invalid.";
                echo "<meta http-equiv=\"refresh\" content=\"8; URL=./loginAndRegistration.php\" />";
              }
            } else {
              echo "Sorry your account could not be created. The second password doesn't match the first.";
              echo "<meta http-equiv=\"refresh\" content=\"8; URL=./loginAndRegistration.php\" />";
            }
          } else {
            echo "<meta http-equiv=\"refresh\" content=\"0; URL=./loginAndRegistration.php\" />";
          }
          ?>
        </div>
      </div>
    </div>
    <footer>
             <?php
               include "footer.php";
             ?>
  </footer>
</body>

</html>
