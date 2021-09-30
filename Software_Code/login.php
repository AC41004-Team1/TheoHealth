<?php
  session_start();
  
  if (isset($_SESSION['failedUsername']) == false) {
    $_SESSION['failedUsername'] = 0;
  }

  if (isset($_SESSION['failedPassword']) == false) {
    $_SESSION['failedPassword'] = 0;
  }
?>

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
    <div class="leftContainer">
      <img src="theoLogo.png" alt="" width="400" height="100">
      <h1 class="text-left">Login</h1>
    </div>
  </header>
  <div class="left-half" style="padding:0" style="margin-bottom:1px;">
    <form action="signinform.php" method="post">
      <div class="form-group">
        
        <label for="username" style="margin: 10px;">Username:</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" style="width: 250px" style="margin: 10px;">
        <span class="help-block" style="color:red">
          <?php
            if($_SESSION['failedUsername'] == true) {
              echo "User Not Found!";
              $_SESSION['failedUsername'] = 0;
            }
          ?>
        </span>
        
        <label for="password" style="margin: 10px;">Password:</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" style="width: 250px" style="margin: 10px;">
        <span class="help-block" style="color:red">
          <?php 
            if($_SESSION['failedPassword'] == true) {
              echo "Incorrect Password!";
              $_SESSION['failedPassword'] = 0;
            }
          ?>
        </span>
        
        <button class="btn btn-outline-primary" type="submit" name="submit" style="margin-top: 10px;">Sign in</button>
      
      </div>
    </form>
    <br></br>
  </div>
  <footer>

  </footer>
</body>

</html>