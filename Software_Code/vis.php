<?php include "head.php";
include "authPHP.php";

// Check if the form is submitted
if (isset($_POST['sessionIndexIn'])) {
  //retrieve the form data by using the element's name attributes value as key
  $sessionIndex = $_POST['sessionIndexIn'];
  $_SESSION["userSession"] = $sessionIndex;
}
?>

<title>Visulisation</title>
<link rel="stylesheet" href="./resources/styles/general.css">
<link rel="stylesheet" href="./resources/styles/layout.css">
<link rel="stylesheet" href="./resources/styles/vis.css">


<?php
// Check if the form is submitted
if (isset($_POST['submitMessage'])) {
  //retrieve the form data by using the element's name attributes value as key
  $sessionIndex = $_POST['submitMessage'];
  $theMessage = $_POST['messageSent'];
  //Add the comment to the database
  $connection = openCon();
  $query = "CALL addComment('{$sessionIndex}','{$_SESSION['userInfoArray'][1]}','{$theMessage}')";
  $result = $connection->query($query);
  closeCon($connection);
}
?>

</head>

<body>
  <?php include "header.php"; ?>

  <div id="vis-content">
    <!-- the title -->
    <div class="leftContainer">
      <h1 class="text-left">Visualisation</h1>
    </div>

    <!-- the 3D model link and image -->
    <div class=form-container>
      <div class="right-half" style="margin-bottom:1px;">
        <div class="card" id="cardID">
          <div class="left-half" id="leftHalfID">
            <img src="./resources/images/silverGuy1.jpg" alt="">
          </div>
          <div class="right-half" id="rightHalfID">
            <div class="card-body">
              <h5 class="card-title">View Model</h5>
              <p class="card-text">Click below to see your results in 3D.</p>
              <form action="session.php" method="post">
                <?php
                //A form with a hidden element to send in the session index to the 3D model page
                echo "<input type=text value= \"{$sessionIndex}\" name = 'sessionIndexIn' class = \"form-hidden\" ></input>";
                echo "<button class=\"btn btn-outline-primary\" type=\"submit\" name=\"submitMessage\" >View</button>";
                ?>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- the graph -->
      <div class="left-half" style="margin-bottom:1px;">
        <div class="card">
          <div class="chartBox" style="padding: 20px;">
            <!-- import graph from other php page -->
            <canvas id="myChart"><?php include "visualize.php"; ?></canvas>
          </div>
          <div class="card-body">
            <h5 class="card-title">Muscle Tension Graph </h5>
            <p class="card-text">Have a look at your muscle tension during this excercise</p>
          </div>
        </div>
      </div>
    </div>

    <hr>

    <!-- the comment section -->
    <div class=form-container>
      <?php
      echo "<div class=\"left-half\" style=\"padding: 50px;\" style=\"margin-bottom:1px;\">";
      echo "<div class=\"card\">";
      //Bool to see if user can send another message
      $alreadySent = false;
      //Gets the comments
      $conn = openCon();
      $SQLInput = "CALL getComments(\"{$sessionIndex}\")";
      $result = $conn->query($SQLInput);
      closeCon($conn);
      //If there are comments
      if ($result->num_rows > 0) {
        echo "<div class=\"card-body\">";
        echo "<h5 class=\"card-title\">Feedback:</h5>";
        $previousMessage;
        //Grabs each comment and display them
        while ($row = $result->fetch_object()) {
          if (isset($previousMessage)) {
            echo "<hr>";
          }
          //If this user is ourself just use username already given and set variable
          if ($row->SenderIndex == $_SESSION['userInfoArray'][1]) {
            echo "<span id=\"userName\">{$_SESSION['userInfoArray'][0]}: </span>";
            $alreadySent = true;
          }
          //if not ourself get and display username
          else {
            //query database for username
            $conn = openCon();
            $SQLInput = "CALL getUsername(\"{$row->SenderIndex}\")";
            $result1 = $conn->query($SQLInput);
            closeCon($conn);
            if ($result1->num_rows > 0) {
              $row1 = $result1->fetch_object();
              $tester = $row1->Username;
              echo "<span id=\"userName\">{$tester}: </span>";
            }
          }
          //Display message
          echo  "<span id=\"userMessage\">{$row->MessageSent}</span>";
          $previousMessage = "Yup";
        }
        echo "</div>";
      }
      echo "</div></div>";

      //For sending a message
      echo "<div class=\"right-half\" style=\"padding: 50px;\" style=\"margin-bottom:1px;\">";
      if ($alreadySent == false) {
        echo "<div class=\"form-group\">";
        //Create form with text area and
        echo "<form action=\"#\" method=\"post\">";
        echo "<label class=\"card-title\" for=\"messageSent\">Enter Feedback:</label>";
        //Text area for collecting the message
        echo "<textarea class=\"form-control\" name = \"messageSent\" rows=\"3\"></textarea>";
        //Hidden text input for sending session index
        echo "<input type=text value= \"{$sessionIndex}\" name = 'sessionIndexIn' class = \"form-hidden\" ></input>";
        echo "<button class=\"btn btn-outline-primary\" type=\"submit\" name=\"submitMessage\" value = \"{$sessionIndex}\" style=\"margin-top: 10px;\">Send feedback</button>";
        echo "</form>";
        echo "</div>";
      }
      echo "</div></div>";
      ?>
    </div>
  </div>

  <?php include "footer.php" ?>

</body>

</html>