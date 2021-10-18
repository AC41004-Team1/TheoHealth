<!DOCTYPE html>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.1/papaparse.min.js"></script>

<?php
//Store the user index
$userIndex = $_SESSION["userInfoArray"][1];
?>


<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>
</head>

<body>

  <div class="chartBox">
    <canvas id="myChart"></canvas>
  </div>

  <?php
  try {
    //If it is a P or PT accessing this page then select an appropriate user
    if ($_SESSION["userInfoArray"][2] == "P" || $_SESSION["userInfoArray"][2] == "PT") {
      $userIndex = 1;
    }
    $connection = openCon();
    // Get the info needed from the database
    $queryInput = "CALL getClientMax(\"{$userIndex}\")";
    $result = $connection->query($queryInput);

    //If the user has results then save them to arrays
    if ($result->num_rows > 0) {
      $reading = array();
      $session = array();
      $sensornumber = array();
      while ($row = $result->fetch_object()) {

        $reading[] = $row->Reading;
        $session[] = $row->SessionIndex;
        $sensornumber[] = $row->SensorNum;
      }

      unset($result);
    } else {
    }
  } catch (PDOException $e) {

    die($e->getMessage());
  }

  closeCon($connection);
  ?>

  <div style="width: 20vw">
  </div>
</body>


<script>
  //Read in the arrays from the PHP to the Javascript
  const reading = <?php echo json_encode($reading); ?>;
  const session = <?php echo json_encode($session); ?>;
  const sensornumber = <?php echo json_encode($sensornumber); ?>;

  //Log the arrays in the console
  console.log(reading[0]);
  console.log(session);
  console.log(sensornumber);


  const data = {
    //Label and create all 4 lines, corresponding to the 4 muscles
    labels: [1], // Put times here but we need to edit it Manually put in time labels to fix this problem
    datasets: [{
        maxBarThickness: 250,
        minBarLength: 10,
        label: 'Left Hamstring (Semitendinosus)',
        data: [reading[0]], // Replace with Sensor
        backgroundColor: [
          '#75E6DA',
        ],
        borderColor: [
          '#05445E',
        ],
        borderWidth: 0.35,
      },
      {
        maxBarThickness: 250,
        minBarLength: 2,
        label: 'Right Hamstring (Semitendinosus)',
        data: [reading[1]], // Replace with Sensor
        backgroundColor: [
          '#FF8300'
        ],
        borderColor: [
          '#DF362D'
        ],
        borderWidth: 0.35,
      },
      {
        maxBarThickness: 250,
        minBarLength: 2,
        label: 'Left Quadricep (Rectus Femoris)',
        data: [reading[2]], // Replace with Sensor
        backgroundColor: [
          '#868B8E'

        ],
        borderColor: [
          '#EEEDE7'
        ],
        borderWidth: 0.35
      },
      {
        maxBarThickness: 250,
        minBarLength: 2,
        label: 'Right Quadricep (Rectus Femoris)',
        data: [reading[3]], // Replace with Sensor
        backgroundColor: [
          '#A82810'

        ],
        borderColor: [
          '#A82810'
        ],
        borderWidth: 0.35
      }
    ]

  };


  //config
  const config = {
    type: 'bar',
    data: data,
    options: {
      plugins: {
        title: {
          display: false,
          text: ''
        },
      },
      responsive: true,
      scales: {
        x: {
          stacked: true,
        },
        y: {
          stacked: true
        }
      }
    }
  };
  //render
  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>

</html>