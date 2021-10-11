<?php
include "head.php";
include "checkSigninPHP.php";
if (isset($_SESSION['failedUsername']) == false) {
  $_SESSION['failedUsername'] = 0;
}

if (isset($_SESSION['failedPassword']) == false) {
  $_SESSION['failedPassword'] = 0;
}
?>

<link rel="stylesheet" href="./resources/styles/general.css">
<link rel="stylesheet" href="./resources/styles/footer.css">
<link rel="stylesheet" href="./resources/styles/login.css">
<style type="text/css">
  body {
    display: grid;
    grid-template-rows: 6em 10fr 1fr;
  }
</style>

<script>
  function swapSignIn(e) {
    let signup = document.getElementById('signup-form-container')
    let signin = document.getElementById('signin-form-container')
    signin.className = signup.className == "form-hidden" ? "form-hidden" : "form-container"
    signup.className = signup.className == "form-hidden" ? "form-container" : "form-hidden"
    e.innerText = signup.className == "form-hidden" ? "Not Registered?" : "Already Registered?"

    return false;
  }
</script>
</head>

<body>
  <header >
    <div class="leftContainer">
      <img src="./resources/images/theoLogo.png" alt="" style="height:1em; width :auto;">
      <h1 class="text-left">Login</h1>
    </div>
  </header>
  <div id="loginBox" class="form-container">
    <a href="#" style="font-size: 0.75em; " class="link-primary" onclick="swapSignIn(this)">Not Registered?</a>
    <div class="left-half" style="padding:0" style="margin-bottom:1px;">
      <div id="signin-form-container" class="form-container">
        <form action="loginPHP.php" method="post">
          <div class="form-group">

            <label for="username">Username:</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" style="width: 250px">
            <span class="help-block" style="color:red">
              <?php
              if ($_SESSION['failedUsername'] == true) {
                echo "User Not Found!";
                $_SESSION['failedUsername'] = 0;
              }
              ?>
            </span>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" style="width: 250px">
            <span class="help-block" style="color:red">
              <?php
              if ($_SESSION['failedPassword'] == true) {
                echo "Incorrect Password!";
                $_SESSION['failedPassword'] = 0;
              }
              ?>
            </span>
            <br></br>
            <button class="btn btn-outline-primary" type="submit" name="submit">Sign in</button>

          </div>
        </form>
      </div>
      <div id="signup-form-container" class="form-hidden">
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
                <option value="P">Physiotherapist</option>
                <option value="PT">Personal trainer</option>
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
            <button class="btn btn-outline-primary" type="submit" name="submitsignup" style="margin-top: 10px;">Sign up</button>
          </div>
        </form>
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