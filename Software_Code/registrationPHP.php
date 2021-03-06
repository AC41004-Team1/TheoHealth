<?php include "head.php" ?>

  <title>Sign up</title>
  <link rel="stylesheet" href="./resources/styles/register.css">
</head>

<body>
  <header style="height:200px;">
    <div class="leftContainer">
      <img src="./resources/images/theoLogo.png" alt="TheoLogo" width="500" height="100">
      <h1 class="text-left">Sign up</h1>
    </div>
  </header>

  <div id="register-main">
    <div class="left-half" style="padding:0" style="margin-bottom:1px">
      <div class="card border-light mb-3" style="max-width: 30rem;" style="margin: 10px;">
        <div class="card-header">Important</div>
        <div class="card-body" style="font-size:20px">
          <h5 class="card-title">Please Read</h5>
          <p class="card-text"></p>

          <?php
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
            $GUID = "";

            //For if the user signed up using a link
            if (isset($_POST['signUpReason'])) {
                $signUpReason = $_POST['signUpReason'];
            }
            if (isset($_POST['GUID'])) {
                $GUID = $_POST['GUID'];
            }

            //Makes sure that both password are identical and not null
            if ($password == $checkerPassword && isset($password)) {
              //Got phone number checker from https://stackoverflow.com/questions/3090862/how-to-validate-phone-number-using-php
              //eliminate every char except 0-9
              $phoneNum = preg_replace("/[^0-9]/", '', $phoneNum);
              //Make sure phone number is appropriate length
              if (strlen($phoneNum) > 9) {
                //Run query to find if there is anyone with that username already
                $connection = openCon();
                $SQLInput = "CALL checkUsername(\"{$username}\")";
                $queryOutput = $connection->query($SQLInput);
                closeCon($connection);

                //If username is unique add the user to the database
                if ($queryOutput->num_rows <= 0) {
                  //If the registering with a link
                  if (isset($_POST['signUpReason']) && isset($_POST['GUID'])) {
                      //Get managers ID from GUID
                      $connection = openCon();
                      $SQLInput = "CALL getManagerIDWithGUID(\"{$GUID}\")";
                      $queryOutput2 = $connection->query($SQLInput);
                      $managerID = $queryOutput2 -> fetch_object()->managerID;
                      closeCon($connection);

                      //add the athlete to the database with a reason
                      $connection = openCon();
                      $SQLInput = "CALL addAthlete(\"{$fname}\", \"{$sname}\", \"{$phoneNum}\", \"{$username}\", \"{$password}\", \"{$role}\",\"{$email}\", \"{$signUpReason}\")";
                      $connection->query($SQLInput);
                      closeCon($connection);

                      //Get the user index of the user we just registered
                      $connection = openCon();
                      $SQLInput = "CALL getUserIndex(\"{$username}\")";
                      $queryOutput = $connection->query($SQLInput);
                      $userIndex = $queryOutput -> fetch_object()->UserIndex;
                      closeCon($connection);

                      //Adds the client to the manager
                      $connection = openCon();
                      $SQLInput = "CALL addClienttoManager(\"{$userIndex}\",\"{$managerID}\")";
                      $connection->query($SQLInput);
                      closeCon($connection);

                      //Sets the invite link to not be used again
                      $connection = openCon();
                      $SQLInput = "CALL updateInviteUsed(\"{$GUID}\")";
                      $connection->query($SQLInput);
                      closeCon($connection);
                  }
                  else {
                    //registering without a link
                    //Add the user to the database
                    $connection = openCon();
                    $SQLInput = "CALL addUser(\"{$fname}\", \"{$sname}\", \"{$phoneNum}\", \"{$username}\", \"{$password}\", \"{$role}\", \"{$email}\")";
                    $connection->query($SQLInput);
                    closeCon($connection);
                }

                  //Welcome Message
                  echo "Welcome {$fname} {$sname}. Your account has now been created. You'll be taken to your Login in 10 seconds or you can click <a href/'/loginAndRegistration.php/'>here</a> to go there now.";
                  echo "<meta http-equiv=\"refresh\" content=\"10; URL=./loginAndRegistration.php\" />";
                  //Error messages:
                } else {
                  echo "Sorry your account could not be created. The username you entered is already taken.";
                  echo "<meta http-equiv=\"refresh\" content=\"8; URL=./loginAndRegistration.php\" />";
                }
              } else {
                echo "Sorry your account could not be created. The phone number was invalid.";
                echo "<meta http-equiv=\"refresh\" content=\"8; URL=./loginAndRegistration.php\" />";
              }
            } else {
              echo "Sorry your account could not be created. The second password doesn't match the first or the password was blank.";
              echo "<meta http-equiv=\"refresh\" content=\"8; URL=./loginAndRegistration.php\" />";
            }
          } else {
            echo "<meta http-equiv=\"refresh\" content=\"0; URL=./loginAndRegistration.php\" />";
          }
          ?>
        </div>
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
