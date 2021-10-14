<?php
include "head.php";
include "authPHP.php";

?>
<title>Dashboard</title>

<link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"> </script>
<link href="./resources/styles/dashboard.css" rel="stylesheet" type="text/css" />

<link href="./resources/styles/dashboard.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="./resources/styles/layout.css">
</head>

<body>

  <?php
  include "header.php";
  ?>

  <!-- Mainbody of the web application--->
  <div id="dashboard-content">
    <div class="jumbotron">
      <h1 class="text-center">Welcome Back <?php echo $_SESSION['userInfoArray'][0]; ?></h1>
      <!--<hr class="my-4">-->
      <!--<p class="lead">You could place something here</p>-->
    </div>

    <div class="MainContent">
      <div class="column">
        <div class="leftColumn">
        <!-- Replace with actual graph--->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Your last results</h1>
          </div>
          <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
          <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.2/js/bootstrap.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.js"></script> <!-- Remove once implmenting the visualisation-->
          <hr>
          <div id="inviteLink">
            <form  action="dashboardPHP.php" method="post">
                <input id="generatorButton" class="btn btn-outline-primary" type="submit" name="generateInvite" value="Generate Invite" />
            </form>
            
          </div>
        </div>
      </div>
      <div class="rightColumn">
        <div class="row">
          <div class='db-nav'>
            <!--- This will need to change for physicist --->
            <?php
            //Gets a users session
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
              $durArray = str_split($timeGiven, 1);
              $counter = strlen($timeGiven);
              $wentIn = false;

              while ($counter > 4) {
                echo "{$durArray[strLen($timeGiven) -$counter]}";
                $counter = $counter - 1;
                $wentIn = true;
              }
              if ($wentIn == true) {
                echo "hours ";
                $wentIn = false;
              }

              while ($counter > 2) {
                echo "{$durArray[strLen($timeGiven) -$counter]}";
                $counter = $counter - 1;
                $wentIn = true;
              }
              if ($wentIn == true) {
                echo "mins ";
                $wentIn = false;
              }

              if ($counter > 0) {
                $valueString = $durArray[strLen($timeGiven) - $counter];
                $valueString .= $durArray[strLen(($timeGiven) - $counter) - 1];
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

            //Start of section
            $role = $_SESSION['userInfoArray'][2];
            //For athletes and injured athletes
            if ($role == "A" || $role == "IA") {
              //Call Query to get results
              $result = getSessions($_SESSION['userInfoArray'][1]);
              //If they have done a session before
              $row = $result->fetch_object();
              if (isset($row->DateTaken)) {
                echo "<h1 style = \"float:left;\">What session would you like to view?</h1>";
                printDashCard("{$row->SessionIndex}", "{$row->SessionNum}", "{$row->DateTaken}", "{$row->Duration}");
                while ($row = $result->fetch_object()) {
                  printDashCard("{$row->SessionIndex}", "{$row->SessionNum}", "{$row->DateTaken}", "{$row->Duration}");
                }
              } else {
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

              //If there are clients
              if ($result->num_rows > 0) {
                echo "<div id=\"DropDownBox\">Select a Client:  <select id=\"ClientSelect\" name = \"Client\"></div>";
                echo "<option id=\"dropDownOption\" value=\"blank\"> pick here </option>";
                while ($row = $result->fetch_object()) {
                  echo "<option id=\"dropDownOption\" value=\"{$row->UserIndex}\"> {$row->FirstName} {$row->LastName} </option>";
                  array_push($clientsIndex, $row->UserIndex);
                  $i++;
                  //echo "\"{$row -> UserIndex}\" | \"{$row -> FirstName}\" | \"{$row -> LastName}\" | \"{$row -> Username}\"";
                }
                echo "</select><hr>";

                $tempI = $i;

                for ($i--; $i >= 0; $i--) {
                  //Call Query to get results
                  $result = getSessions($clientsIndex[$i]);
                  //If they have done a session before
                  echo "<div id=\"user{$clientsIndex[$i]}-form-container\" class=\"form-hidden\">";
                  $nothingThere = false;
                  $row = $result->fetch_object();
                  if (isset($row->DateTaken)) {
                    echo "<h4 class=\"text-center\">What session would you like to view?</h4>";
                    printDashCard("{$row->SessionIndex}", "{$row->SessionNum}", "{$row->DateTaken}", "{$row->Duration}");
                    while ($row = $result->fetch_object()) {
                      if(isset($row->DateTaken)){
                        printDashCard("{$row->SessionIndex}", "{$row->SessionNum}", "{$row->DateTaken}", "{$row->Duration}");
                      } else{
                        $nothingThere = true;
                      }
                      //echo "{$row -> SessionIndex}{$row -> SessionNum}{$row -> DateTaken}{$row -> Duration}";
                    }
                    if($nothingThere == true){
                      echo "<h1>This client hasn't started training yet.</h1>";
                    }
                  } else {
                    echo "<h1>This client hasn't started training yet.</h1>";
                  }
                  echo "</div>";
                }
              } else {
                echo "<h1>You currently have no clients</h1>";
              }
            }

            //Java script for the drop down menu
            echo "<script>";
            echo "console.log(\"Im in\");";
            echo "var ddl = document.getElementById(\"ClientSelect\");";
            echo "ddl.onchange = function(){";
            //Get the drop down

            //Get the client index selected in the drop down
            echo "var selectedValue = ddl.value;";

            //echo "console.log(selectedValue);";
            echo "let userArray = [];";
            //Loop through all form containers and set all to be invisible
            $loopI = $tempI - 1;
            while ($loopI >= 0) {
              echo "let user{$clientsIndex[$loopI]} = document.getElementById('user{$clientsIndex[$loopI]}-form-container');";
              echo "user{$clientsIndex[$loopI]}.className = 'form-hidden';";
              echo "userArray[{$loopI}] = user{$clientsIndex[$loopI]};";
              $loopI--;
            }

            echo "if(selectedValue == \"blank\"){";
            echo "return false;";
            echo "}";
            //Set required
            //echo "document.getElementById(myContainer.className) = form-container;";

            // echo "for (let i = 0; i < {$tempI}; i++) {";
            //   echo "userArray[i].className = form-hidden;";
            // echo "}";

            // //Concatenating a string to be the name of the container needed
            echo "let myContainer = 'user';";
            echo "myContainer += selectedValue;";
            echo "myContainer += '-form-container';";
            //Making the container visable
            echo "document.getElementById(myContainer).className = 'form-container';";

            //echo "console.log(\"something, please help\");";
            //echo "console.log(selectedValue);";

            echo "return false;";
            echo "}";
            echo "</script>";
            ?>



            <!--<div class="card-dash">
                   <div class="card" style="width: 40rem;">
                        <div href="#" class="card-body">
                          <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
                          <h5 class="card-title">Import new data from an external file</h5>
                          <h6 class="card-subtitle mb-2 text-muted">Last time you exercise was: </h6> -->
            <!--Please Insert data of last data--->
            <!--
                        </div>
                    </div>
                 </div> -->

          </div>
        </div>
      </div>
    </div>
    <script>
      var xValues = [50, 60, 70, 80, 90, 100, 110];
      var yValues = [7, 8, 8, 9, 9, 9, 10, 11, 14, 14, 15];

      var options = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            stacked: true,
            grid: {
              display: true,
              color: "rgba(255,99,132,0.2)"
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      };

      new Chart("myChart", {
        type: "line",
        data: {
          labels: xValues,
          datasets: [{
            fill: false,
            lineTension: 0,
            backgroundColor: "rgba(0,0,255,1.0)",
            borderColor: "rgba(0,0,255,0.1)",
            data: yValues
          }]
        },
        options: {
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              ticks: {
                min: 6,
                max: 16
              }
            }],
          }
        }
      });
    </script>
  </div>
</div>

<footer>
  <?php
  include "footer.php";
  ?>
</footer>
  <!-- <div class="SecndContent">-->
  <!--- Place addditonal content below --->
  <!-- <img src="https://via.placeholder.com/500x400" alt="">
    </div> -->

</body>
