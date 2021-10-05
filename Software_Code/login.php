<?php include "head.php" ?>
<?php
if (isset($_SESSION['failedUsername']) == false) {
  $_SESSION['failedUsername'] = 0;
}

if (isset($_SESSION['failedPassword']) == false) {
  $_SESSION['failedPassword'] = 0;
} ?>
<link rel="stylesheet" href="styleTemp.css">
<style type="text/css">
  .wrapper {
    margin-left: 35%;
    margin-right: 35%;
    width: 30%;
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

<body style="background-image: url('theoHealthBackground.png');  width: 900px; height: 900px; background-repeat: no-repeat ; background-size: cover;">
  <header style="height:200px;">
    <div class="leftContainer">
      <img src="theoLogo.png" alt="" width="400" height="100">
      <h1 class="text-left">Login</h1>
    </div>
  </header>
  <a href="#" style="font-size: 0.75em;" class="link-primary" onclick="swapSignIn(this)">Not Registered?</a>
  <div class="left-half" style="padding:0" style="margin-bottom:1px;">
    <div id="signin-form-container" class="form-container">
      <form action="signinform.php" method="post">
        <div class="form-group">

          <label for="username" style="margin: 10px;">Username:</label>
          <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" style="width: 250px" style="margin: 10px;">
          <span class="help-block" style="color:red">
            <?php
            if ($_SESSION['failedUsername'] == true) {
              echo "User Not Found!";
              $_SESSION['failedUsername'] = 0;
            }
            ?>
          </span>

          <label for="password" style="margin: 10px;">Password:</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" style="width: 250px" style="margin: 10px;">
          <span class="help-block" style="color:red">
            <?php
            if ($_SESSION['failedPassword'] == true) {
              echo "Incorrect Password!";
              $_SESSION['failedPassword'] = 0;
            }
            ?>
          </span>

          <button class="btn btn-outline-primary" type="submit" name="submit" style="margin-top: 10px;">Sign in</button>
        </div>
      </form>
    </div>
    <div id="signup-form-container" class="form-hidden">
      <form action="signup.php" method="post">
        <div class="form-group" id="form-2-cols">
          <div id="form-group-left">
            <label for="fname" style="margin: 10px;">First name:</label>
            <input type="text" name="fname" id="fname" class="form-control" placeholder="Enter first name" style="width: 250px" style="margin: 10px;">
            <span class="help-block" style="color:red">
            </span>

            <label for="sname" style="margin: 10px;">Surname:</label>
            <input type="text" name="sname" id="sname" class="form-control" placeholder="Enter surname" style="width: 250px" style="margin: 10px;">
            <span class="help-block" style="color:red">
            </span>

            <label for="role" style="margin: 10px;">Role:</label>
            <select name="role" id="role" class="form-control" style="width: 250px" style="margin: 10px;">
              <option value="A">Athlete</option>
              <option value="IA">Injured athlete</option>
              <option value="P">Physiotherapist</option>
              <option value="PT">Personal trainer</option>
            </select>
            <span class="help-block" style="color:red">
            </span>

            <label for="phoneNum" style="margin: 10px;">Phone number:</label>
            <input type="text" name="phoneNum" id="phoneNum" class="form-control" placeholder="Enter phone number" style="width: 250px" style="margin: 10px;">
            <span class="help-block" style="color:red">
            </span>
          </div>
          <div id="form-group-right">
            <label for="email" style="margin: 10px;">Email:</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address" style="width: 250px" style="margin: 10px;">
            <span class="help-block" style="color:red">
            </span>

            <label for="username" style="margin: 10px;">Username:</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" style="width: 250px" style="margin: 10px;">
            <span class="help-block" style="color:red">
            </span>

            <label for="password" style="margin: 10px;">Password:</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" style="width: 250px" style="margin: 10px;">
            <span class="help-block" style="color:red">
            </span>

            <label for="checkerPassword" style="margin: 10px;">Confirm password:</label>
            <input type="password" name="checkerPassword" id="checkerPassword" class="form-control" placeholder="Enter your password again" style="width: 250px" style="margin: 10px;">
            <span class="help-block" style="color:red">
            </span>
          </div>
          <button class="btn btn-outline-primary" type="submit" name="submitsignup" style="margin-top: 10px;">Sign up</button>
        </div>
      </form>



    </div>




  </div>

  <footer>

  </footer>
</body>

</html>