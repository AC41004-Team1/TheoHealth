<?php include "head.php";
include "authPHP.php";
// Check if the form is submitted
if (isset($_POST['sessionIndexIn'])) {
  //retrieve the form data by using the element's name attributes value as key
  $sessionIndex = $_POST['sessionIndexIn'];
} else {
  //return to dashboard
  // header("Location: dashboard.php");
}
?>

<title>Visulisation</title>
<link rel="stylesheet" href="./resources/styles/general.css">
<link rel="stylesheet" href="./resources/styles/vis.css">
<link rel="stylesheet" href="./resources/styles/layout.css">

<?php
// Check if the form is submitted
if (isset($_POST['submitMessage'])) {
  //retrieve the form data by using the element's name attributes value as key
  echo "Message sent";
  $sessionIndex = $_POST['submitMessage'];
  $theMessage = $_POST['messageSent'];
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
    <div class="leftContainer">
      <h1 class="text-left">Visualisation</h1>
    </div>

    <div class=form-container>
      <div class="right-half" style="padding: 50px;" style="margin-bottom:1px;">
        <div class="card">
          <!-- insert body model -->
          <img src="./resources/images/silverGuy1.jpg" width="300" height="300" alt="">
          <div class="card-body">
            <h5 class="card-title">Example body</h5>
            <p class="card-text">Wow look at your body and analyse your performance.</p>
          </div>
        </div>
      </div>

      <div class="left-half" style="padding: 50px;" style="margin-bottom:1px;">
        <div class="card">
          <!-- add graph in here -->

          <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
          <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
          <script src="./resources/scripts/tempGraph.js"></script>
          <div class="card-body">
            <h5 class="card-title">Example Graph</h5>
            <p class="card-text">Wow look at your cool graph. So exciting!!!!!!!!!!</p>
          </div>
        </div>

        <?php
        echo "<div class=\"card\">";
        //Bool to see if user can send another message
        $alreadySent = false;
        //Get gets the comments
        $conn = openCon();
        $SQLInput = "CALL getComments(\"{$sessionIndex}\")";
        $result = $conn->query($SQLInput);
        closeCon($conn);
        //If there are comments
        if ($result->num_rows > 0) {
          echo "<div class=\"card-body\">";
          echo "<h5 class=\"card-title\">Feedback:</h5>";
          //Grabs each comment and display them
          while ($row = $result->fetch_object()) {
            //If this user is ourself just use username already given and set variable
            if ($row->SenderIndex == $_SESSION['userInfoArray'][1]) {
              echo "<p id=\"userName\">{$_SESSION['userInfoArray'][0]}:</p>";
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
                echo "<p id=\"userName\">{$tester}:</p>";
              }
            }
            //Display message
            echo  "<p id=\"userMessage\">{$row->MessageSent}</p>";
            echo "<hr>";
          }
          echo "</div>";
        }
        echo "</div>";
        //For sending a message
        if ($alreadySent == false) {
          echo "<div class=\"form-group\">";
          //Create form with text area and
          echo "<form action=\"#\" method=\"post\">";
          echo "<label for=\"messageSent\">Enter Feedback:</label>";
          echo "<textarea class=\"form-control\" name = \"messageSent\" rows=\"3\"></textarea>";
          echo "<input type=text value= \"{$sessionIndex}\" name = 'sessionIndexIn' class = \"form-hidden\" ></input>";
          echo "<button class=\"btn btn-outline-primary\" type=\"submit\" name=\"submitMessage\" value = \"{$sessionIndex}\" style=\"margin-top: 10px;\">Send feedback</button>";
          echo "</form>";
          echo "</div>";
        }
        echo "</div>";
        ?>
      </div>
    </div>
  </div>
  <!-- if needed for bootstrap layout again -->
  <!--  id="exampleFormControlTextarea1" rows="3"></textarea>  -->
  <footer>
    <?php include "footer.php" ?>
  </footer>

</body>

</html>