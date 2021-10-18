<?php
//Include all things that are needed in each head and redirect people who aren't logged in
include "head.php";
include "authPHP.php";

?>
<title>Dashboard</title>

<!-- CSS used -->
<link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"> </script>
<link href="./resources/styles/dashboard.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="./resources/styles/layout.css">

<?php
//Way to delete a user
if (isset($_POST['userToDelete'])) {
  $deletedUser = $_POST['userToDelete'];

  $connection = openCon();
  $query = "CALL deleteUser(\"{$deletedUser}\")";
  $result = $connection->query($query);
  closeCon($connection);
}
?>
</head>

<body>
  <?php
  //Make the page header appear
  include "header.php";
  ?>

  <!-- Make the title card with users name --->
  <div id="dashboard-content">
    <div class="jumbotron">
      <h1 class="text-center">Welcome Back <?php echo $_SESSION['userInfoArray'][0]; ?></h1>
    </div>

    <div class="MainContent">
      <div class="column">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <!-- Title of the graph --->
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <?php
            //changes the graph title depending on who logs in
            if ($_SESSION["userInfoArray"][2] == "P" || $_SESSION["userInfoArray"][2] == "PT") {
              echo "<h1 class=\"h2\">Client Last Results</h1>";
            } else {
              echo "<h1 class=\"h2\">Your Last Results</h1>";
            }
            ?>
          </div>
          <!-- displays the graph from the graph file--->
          <div class="chartBox">
            <canvas id="myChart" width="900" height="500"><?php include "dashboardGraph.php"; ?></canvas>
          </div>

          <?php
          //If the user is a physio or personal trainer display the generate invite link button
          if ($_SESSION["userInfoArray"][2] == "P" || $_SESSION["userInfoArray"][2] == "PT") {
            echo "<hr>";
            echo "<div id=\"inviteLink\">";
            echo "<form  action=\"dashboardPHP.php\" method=\"post\">";
            echo "<input id=\"generatorButton\" class=\"btn btn-outline-primary\" type=\"submit\" name=\"generateInvite\" value=\"Generate Invite\" />";
            echo "</form>";
            echo "</div>";
          }
          ?>
      </div>

      <div class="rightColumn">
        <div class="row">
          <div class='db-nav'>
            <!--- This will need to change for physicist --->
            <?php
            //Gets all of a users session
            function getSessions($userIndex)
            {
              $con = openCon();
              $query = "CALL getClientsSessions('{$userIndex}');";
              $result = $con->query($query);
              closeCon($con);
              return $result;
            }

            //function to print the time in a readable fashion rather than large number
            function printTime($timeGiven)
            {
              //Split the integer into an array of chars
              $durArray = str_split($timeGiven, 1);
              $counter = strlen($timeGiven);
              $wentIn = false;

              //Display the number of hours
              while ($counter > 4) {
                echo "{$durArray[strLen($timeGiven) -$counter]}";
                $counter = $counter - 1;
                $wentIn = true;
              }
              if ($wentIn == true) {
                echo "hours ";
                $wentIn = false;
              }

              //Display number of mins
              while ($counter > 2) {
                echo "{$durArray[strLen($timeGiven) -$counter]}";
                $counter = $counter - 1;
                $wentIn = true;
              }
              if ($wentIn == true) {
                echo "mins ";
                $wentIn = false;
              }

              //Display number of seconds
              if ($counter > 0) {
                $valueString = $durArray[strLen($timeGiven) - $counter];
                $valueString .= $durArray[strLen(($timeGiven) - $counter) - 1];
                //If the number of seconds is over 59 then minus 40 because the number is works as if it adds to a next column at 100 rather than at 60.
                $valueInt = intval($valueString);
                if ($valueInt > 59) {
                  $valueInt = $valueInt - 40;
                }
                echo "{$valueInt}";
                $wentIn = true;
              }
              if ($wentIn == true) {
                echo "secs";
              }
            }

            //Method to print the session labels
            function printDashCard($sessionIndex, $sessionNum, $sessionDate, $sessionDuration)
            {
              echo "<div class=\"card-dash\">";
              echo "<div class=\"card\" style=\"width: 96%;\">";
              echo "<div class=\"card-body\">";
              //Using a form for the session buttons so that we can post the session index into the session page
              echo "<form action=\"./vis.php\" method=\"post\">";
              echo "<button name=\"sessionIndexIn\" class=\"btn btn-outline-primary\" type=\"submit\" value=\"{$sessionIndex}\"><h1> Session {$sessionNum} </h1></button>";
              echo "</form>";
              echo "<h5 class=\"card-title\">{$sessionDate}</h5>";
              echo "<h6 class=\"card-subtitle mb-2 text-muted\">This session lasted: ";
              printTime($sessionDuration);
              echo "</h6>";
              echo "</div>";
              echo "</div>";
              echo "</div>";
            }

            //Start of right column
            $role = $_SESSION['userInfoArray'][2];
            //For athletes and injured athletes
            if ($role == "A" || $role == "IA") {
              //Call Query to get results
              $result = getSessions($_SESSION['userInfoArray'][1]);
              //If they have done a session before
              $row = $result->fetch_object();
              if (isset($row->DateTaken)) {
                //Print all of the users sessions
                echo "<h1 style = \"float:left;\">What session would you like to view?</h1>";
                printDashCard("{$row->SessionIndex}", "{$row->SessionNum}", "{$row->DateTaken}", "{$row->Duration}");
                while ($row = $result->fetch_object()) {
                  printDashCard("{$row->SessionIndex}", "{$row->SessionNum}", "{$row->DateTaken}", "{$row->Duration}");
                }
              } else {
                //If they haven't done a session yet print message
                echo "<h1>Come back here once you've started your training.</h1>";
              }
              //For physio and personal trainer
            } else {
              //Get client list
              $conn = openCon();
              $index = $_SESSION['userInfoArray'][1];
              $SQLInput = "CALL getManagersClients('{$index}')";
              $result = $conn->query($SQLInput);
              closeCon($conn);
              $clientsIndex = [];

              //If there have clients
              if ($result->num_rows > 0) {
                //Create a drop down menu where the PT/P can select any of their clients
                echo "<div id=\"DropDownBox\">Select a Client:  <select id=\"ClientSelect\" name = \"Client\"></div>";
                echo "<option id=\"dropDownOption\" value=\"blank\"> pick here </option>";
                //Create a drop down option for all the clients with the value being their user index
                while ($row = $result->fetch_object()) {
                  echo "<option id=\"dropDownOption\" value=\"{$row->UserIndex}\"> {$row->FirstName} {$row->LastName} </option>";
                  //Add all the clients indexes to an array
                  array_push($clientsIndex, $row->UserIndex);
                  //Use i to keep track of the amount of clients
                  $i++;
                }
                echo "</select><hr>";

                $tempI = $i;

                //For every client
                for ($i--; $i >= 0; $i--) {
                  //Call Query to get all of that clients sessions
                  $result = getSessions($clientsIndex[$i]);
                  //If they have done a session before create a container around all of their session cards being named after their user index
                  echo "<div id=\"user{$clientsIndex[$i]}-form-container\" class=\"form-hidden\">";
                  $nothingThere = false;
                  //For all of the users sessions create session cards (like done for the client)
                  $row = $result->fetch_object();
                  if (isset($row->DateTaken)) {
                    echo "<h4 class=\"text-center\">What session would you like to view?</h4>";
                    printDashCard("{$row->SessionIndex}", "{$row->SessionNum}", "{$row->DateTaken}", "{$row->Duration}");
                    while ($row = $result->fetch_object()) {
                      if (isset($row->DateTaken)) {
                        printDashCard("{$row->SessionIndex}", "{$row->SessionNum}", "{$row->DateTaken}", "{$row->Duration}");
                      } else {
                        $nothingThere = true;
                      }
                    }
                    if ($nothingThere == true) {
                      echo "<h1>This client hasn't started training yet.</h1>";
                    }
                  } else {
                    echo "<h1>This client hasn't started training yet.</h1>";
                  }
                  //At the end of the session list add a delete user button that runs the PHP at the top of this page
                  echo "<form action=\"#\" method=\"post\">";
                  echo "<button name=\"userToDelete\" class=\" btn btn-outline-primary deleteBtn\" id=\"deleteBtn\" type=\"submit\" value=\"{$clientsIndex[$i]}\">Delete User</button>";
                  echo "</form>";

                  echo "</div> </div>";
                }
              } else {
                echo "<h1>You currently have no clients</h1>";
              }


              //Java script for the drop down menu
              echo "<script>";

              //get drop down list
              echo "var ddl = document.getElementById(\"ClientSelect\");";
              //Upon the drop down list changing run this function
              echo "ddl.onchange = function(){";
              //Get the client index selected in the drop down
              echo "var selectedValue = ddl.value;";
              //Loop through all form containers containing users sessions and set all to be invisible
              $loopI = $tempI - 1;
              while ($loopI >= 0) {
                echo "let user{$clientsIndex[$loopI]} = document.getElementById('user{$clientsIndex[$loopI]}-form-container');";
                echo "user{$clientsIndex[$loopI]}.className = 'form-hidden';";
                $loopI--;
              }

              //If the user selected no user then stop here
              echo "if(selectedValue == \"blank\"){";
              echo "return false;";
              echo "}";

              // //Concatenating a string to be the name of the container needed
              echo "let myContainer = 'user';";
              echo "myContainer += selectedValue;";
              echo "myContainer += '-form-container';";
              //Making the container visable
              echo "document.getElementById(myContainer).className = 'form-container';";
              echo "return false;";
              echo "}";
              echo "</script>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  //Add the footer to the page
  include "footer.php";
  ?>

</body>