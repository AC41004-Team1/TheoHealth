<?php
  include "head.php";
  include "authPHP.php";

 ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="./resources/styles/dashboard.css" rel="stylesheet" type="text/css"/>
    <script>
      function changedDropdown() {
        console.log("Please don't see this");
      }
    </script>
</head>
<body>

  <?php
  include "./header.php";
  ?>

<!-- Mainbody of the web application--->
<div class="jumbotron" >
  <h1 class="text-center">Welcome Back <?php echo $_SESSION['userInfoArray'][0]; ?></h1>
  <hr class="my-4">
  <p class="lead">You could place something here</p>
</div>

<div class="MainContent">
  <div class="column">
  <!-- Replace with actual graph--->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Your last results</h1>
        <?php
        //Start of section
        $role = $_SESSION['userInfoArray'][2];
        //Display invite link for PT and Ps
        if($role == "P" || $role == "PT"){
          <a href = "#"> Invite Link </a>
        }
         ?>
       </div>
      <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
      <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js">
      </script>
    </div>
  </div>
  <div class="column">
    <div class="row">
        <div class='db-nav'>
            <!--- This will need to change for physicist --->
            <?php
              //Gets a users session
              function getSessions($userIndex){
                $con = openCon();
                $query = "CALL getClientsSessions('{$userIndex}');";
                $result = $con->query($query);
                closeCon($con);
                return $result;
              }

              //function to print the time in a readable fashion rather than large number
              function printTime($timeGiven){
                $durArray = str_split($timeGiven,1);
                $counter = strlen($timeGiven);
                $wentIn = false;

                while($counter>4){
                  echo "{$durArray[strLen($timeGiven) - $counter]}";
                  $counter = $counter-1;
                  $wentIn = true;
                }
                if($wentIn == true){
                  echo "hours ";
                  $wentIn = false;
                }

                while($counter>2){
                  echo "{$durArray[strLen($timeGiven)-$counter]}";
                  $counter = $counter-1;
                  $wentIn = true;
                }
                if($wentIn == true){
                  echo "mins ";
                  $wentIn = false;
                }

                if($counter>0){
                  $valueString = $durArray[strLen($timeGiven)-$counter];
                  $valueString .= $durArray[strLen(($timeGiven)-$counter)-1];
                  $valueInt = intval($valueString);
                  if($valueInt > 59){
                    $valueInt = $valueInt - 40;
                  }
                  echo "{$valueInt}";
                  $wentIn = true;
                }
                if($wentIn == true){
                  echo "secs";
                }
              }

              //Method to print the session labels
              function printDashCard($sessionIndex, $sessionNum, $sessionDate, $sessionDuration){
                echo "<div class=\"card-dash\">";
                   echo "<div class=\"card\" style=\"width: 40rem;\">";
                        echo "<div href=\"#\" class=\"card-body\">";
                          echo "Totally a legit link to the visualisation of session {$sessionIndex}. WIP!";
                          echo "<h1> Session {$sessionNum} </h1>";
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
              if($role == "A" || $role == "IA"){
                //Call Query to get results
                $result = getSessions($_SESSION['userInfoArray'][1]);
                //If they have done a session before
                if($result->num_rows > 0){
                  echo "<h4 class=\"text-center\">What session would you like to view?</h4>";
                  while($row = $result->fetch_object()){
                      printDashCard("{$row -> SessionIndex}", "{$row -> SessionNum}", "{$row -> DateTaken}", "{$row -> Duration}");
                  }
                }else{
                  echo "<h1>Come back here once you've started your training.</h1>";
                }
                //For physio and personal trainer
              } else {
                //Get client list
                $conn = openCon();
                $index = $_SESSION['userInfoArray'][1];
                $SQLInput = "CALL getManagersClients('{$index}')";
                $result = $conn->query($SQLInput);
                $conn -> close();
                $clientsIndex = [];

                //If there are clients
                if($result->num_rows > 0){
                  echo "<select id=\"ClientSelect\" name = \"Client\" onchange='changedDropdown()'>";
                  echo "<option value=\"2\"> Tester </option>";
                  while($row = $result->fetch_object()){
                    echo "<option value=\"{$row -> UserIndex}\"> {$row -> FirstName} {$row -> LastName} </option>";
                    array_push($clientsIndex,$row -> UserIndex);
                    $i++;
                    //echo "\"{$row -> UserIndex}\" | \"{$row -> FirstName}\" | \"{$row -> LastName}\" | \"{$row -> Username}\"";
                  }
                  echo "</select>";

                  $tempI = $i;

                  for($i--; $i >= 0; $i--){
                    //Call Query to get results
                    $result = getSessions($clientsIndex[$i]);
                    //If they have done a session before
                    if($result->num_rows > 0){
                      echo "<h4 class=\"text-center\">What session would you like to view?</h4>";
                      echo "<div id=\"user{$clientsIndex[$i]}-form-container\" class=\"form-hidden\">";
                      while($row = $result->fetch_object()){
                          printDashCard("{$row -> SessionIndex}", "{$row -> SessionNum}", "{$row -> DateTaken}", "{$row -> Duration}");
                          //echo "{$row -> SessionIndex}{$row -> SessionNum}{$row -> DateTaken}{$row -> Duration}";
                      }
                      echo "</div>";
                    }else{
                      echo "<h1>This client hasn't started training yet.</h1>";
                    }
                  }
                } else {
                  echo "<h1>You currently have no clients</h1>";
                }
              }

              //Java script for the drop down menu
              echo "<script>";
                echo "console.log(\"Im in\");";
                echo "function changedDropdown() {";
                  //Get the drop down
                  echo "var ddl = document.getElementById(\"ClientSelect\");";
                  //Get the client index selected in the drop down
                  echo "var selectedValue = ddl.value;";

                  echo "let userArray = []";
                  //Loop through all form containers and set all to be invisible
                  $loopI = $tempI;
                  for($loopI--; $loopI >= 0; $loopI--){
                    echo "let user{$clientsIndex[$loopI]} = document.getElementById('user{$clientsIndex[$loopI]}-form-container');";
                    echo "user{$clientsIndex[$loopI]}.className = form-hidden;";
                    echo "userArray[{$loopI}] = user{$clientsIndex[$loopI]};";
                  }
                  //Set required
                  echo "document.getElementById(myContainer.className = form-container;";

                  // echo "for (let i = 0; i < {$tempI}; i++) {";
                  //   echo "userArray[i].className = form-hidden;";
                  // echo "}";

                  // //Concatenating a string to be the name of the container needed
                  echo "let myContainer = 'user';";
                  echo "myContainer += selectedValue;";
                  echo "myContainer += '-form-container';";
                  //Making the container visable
                  echo "document.getElementById(myContainer.className = form-container;";

                  echo "console.log(\"something, please help\");";
                  echo "console.log(selectedValue);";

                  echo "return false;";
                echo "}";
              echo "</script>";
              ?>



                 <!--<div class="card-dash">
                   <div class="card" style="width: 40rem;">
                        <div href="#" class="card-body">
                          <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
                          <h5 class="card-title">Import new data from an external file</h5>
                          <h6 class="card-subtitle mb-2 text-muted">Last time you exercise was: </h6> --><!--Please Insert data of last data---> <!--
                        </div>
                    </div>
                 </div> -->

          </div>
      </div>
    </div>
    <?php
    include "./footer.php";
    ?>
    <!-- <div class="SecndContent">-->
      <!--- Place addditonal content below --->
      <!-- <img src="https://via.placeholder.com/500x400" alt="">
    </div> -->

</body>

<script>
  // function changedDropdown() {
  //   console.log("You're allowed to see this one");
  // }
  var ddl = document.getElementById("ClientSelect");
  var selectedValue = ddl.value;
  if(selectedValue == "1"){
    console.log("far pig");
  }else{
    console.log("near pig");
  }
  console.log(selectedValue);
</script>
