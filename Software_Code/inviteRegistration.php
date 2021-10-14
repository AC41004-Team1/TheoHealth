<?php include "head.php"; ?>
<link rel="stylesheet" href="./resources/styles/general.css">
<link rel="stylesheet" href="./resources/styles/footer.css">
<link rel="stylesheet" href="./resources/styles/login.css">
<style type="text/css"></style>
<style>
  body{
    display: grid;
    grid-template-rows: 10em auto 2em;
  }
</style>
</head>

<body>
  <header style="height:200px;">
    <div class="leftContainer">
      <img src="./resources/images/theoLogo.png" alt="" width="500" height="100">
      <h1 class="text-left">Registration</h1>
    </div>
  </header>
  <div id="loginBox" class="form-container">
    <div class="left-half" style="padding:0" style="margin-bottom:1px;">

      <div id="signin-form-container" class="form-container">
        <form action="registrationPHP.php" method="post">
          <div class="form-group" id="form-2-cols">

            <div id="form-group-left">
              <label for="fname">First name:</label>
              <input type="text" name="fname" id="fname" class="form-control" placeholder="Enter first name" style="width: 250px">
              <span class="help-block" style="color:red">
              </span>

              <label for="sname">Surname:</label>
              <input type="text" name="sname" id="sname" class="form-control" placeholder="Enter surname" style="width: 250px">
              <span class="help-block" style="color:red">
              </span>

              <label for="role">Role:</label>
              <select name="role" id="role" class="form-control" style="width: 250px">
                <option value="A">Athlete</option>
                <option value="IA">Injured athlete</option>
              </select>
              <span class="help-block" style="color:red">
              </span>

              <label for="phoneNum">Phone number:</label>
              <input type="text" name="phoneNum" id="phoneNum" class="form-control" placeholder="Enter phone number" style="width: 250px">
              <span class="help-block" style="color:red">
              </span>

            </div>
            <div id="form-group-right">
              <label for="email">Email:</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address" style="width: 250px">
              <span class="help-block" style="color:red">
              </span>

              <label for="username">Username:</label>
              <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" style="width: 250px">
              <span class="help-block" style="color:red">
              </span>

              <label for="password">Password:</label>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" style="width: 250px">
              <span class="help-block" style="color:red">
              </span>

              <label for="checkerPassword">Confirm password:</label>
              <input type="password" name="checkerPassword" id="checkerPassword" class="form-control" placeholder="Enter your password again" style="width: 250px">
              <span class="help-block" style="color:red">
              </span>
            </div>
          </div>

          <div class="form-container form-submit">
            <label for="signUpReason">Reason for sign up:</label>
            <input type="text" name="signUpReason" id="signUpReason" class="form-control" placeholder="Enter reason for sign up" style="width:100%">
            <input type="hidden" name="GUID" id="GUID" class="form-control" value="<?php echo ($_GET['ID']); ?>" style="width: 250px">
            <button class="btn btn-outline-primary" type="submit" name="submitsignup" style="margin-top: 10px;">Sign up</button>
          </div>


      </div>
      </form>
    </div>
  </div>

  <footer>
    <?php
    include "footer.php";
    ?>
  </footer>
</body>

</html>
