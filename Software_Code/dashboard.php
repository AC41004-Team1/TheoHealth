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
        <h1 class="h2">Your last results</h1> </div>
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
              function getSessions($userIndex){
                $con = openCon();
                $query = "CALL getClientsSessions('{$userIndex}');";
                $result = $con->query($query);
                closeCon($con);
                return $result;
              }

              function printDashCard($sessionIndex, $sessionNum, $sessionDate, $sessionDuration){
                echo "<div class=\"card-dash\">";
                   echo "<div class=\"card\" style=\"width: 40rem;\">";
                        echo "<div href=\"#\" class=\"card-body\">";
                          echo "Totally a legit link to the visualisation of session {$sessionIndex}. WIP!";
                          echo "<h1> Session {$sessionNum} </h1>";
                          echo "<h5 class=\"card-title\">{$sessionDate}</h5>";
                          echo "<h6 class=\"card-subtitle mb-2 text-muted\">This session lasted: ";

                          $durArray = str_split($sessionDuration,1);
                          $counter = strlen($sessionDuration);
                          $wentIn = false;
                          echo "Counter = {$counter}";
                          while($counter>4){
                            echo "{$durArray[strLeng($sessionDuration) - $counter]}h";
                            $counter = $counter-1;
                            $wentIn = true;
                          }
                          if($wentIn == true){
                            echo "hours ";
                            $wentIn = false;
                          }
                          echo "Counter = {$counter}";
                          while($counter>2){
                            echo "{$durArray[strLeng($sessionDuration)-$counter]}m";
                            $counter = $counter-1;
                            $wentIn = true;
                          }
                          if($wentIn == true){
                            echo "mins ";
                            $wentIn = false;
                          }
                          echo "Counter = {$counter}";
                          while($counter>0){
                            echo "{$durArray[strLeng($sessionDuration)-$counter]}s";
                            $counter = $counter-1;
                            $wentIn = true;
                          }
                          if($wentIn == true){
                            echo "secs";
                          }
                          echo "WIP</h6>";
                        echo "</div>";
                    echo "</div>";
                 echo "</div>";
              }

              $role = $_SESSION['userInfoArray'][2];
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

              } else {
                echo "<h4 class=\"text-center\">Please select a client</h4>";
              }
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
