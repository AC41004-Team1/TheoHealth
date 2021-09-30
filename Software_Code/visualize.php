<!DOCTYPE html>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.1/papaparse.min.js"></script>

<!-- Insert PHP Database connect here -->

<?php

include "connection.php";
$connection = openCon();

?>


<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>
</head>

<body>
<h1> Please work *bless* </h1>

  <?php
    try{

      //  $sql = "SELECT * FROM TABLENAME";
        $queryInput = "CALL getAllClientData(1)";
        $result = $connection->query($queryInput);
        echo "Done Query";
        echo "End of result";
        if($result->num_rows > 0){
          echo "Done if";
          $time = array();
          $reading = array();
          echo "Created variables";
          while($row = $result->fetch_object()){

            $time[] = $row->TimeStamp;

            $reading[] = $row->Reading;

          }
          echo "populated arrays";
          unset($result);
          } else {
            echo"Problem";
          }
        }catch(PDOException $e){
          echo "no result";
        die($e->getMessage());
      }

      unset($conn);

    ?>


    <!--


   SQL for selecting the correct data in Database

    -->

    <!--

    Buttons to upload CSV --- Needs to delete

    <input type = "file" id="uploadfile" accept=".csv">
    <button id="uploadButton">Upload</button>

     -->

<h1> Bee doop 1 </h1>

    <div style = "width: 50%">
      <canvas id="myChart"></canvas>
    </div>
<h1> Hello there team 1 </h1>
  </body>



  <canvas id="myChart" width="400" height="400"></canvas>
  <script>



  // Parse csv files using papaparse


  //   const time=[];
  //   const sensor = [];
  //   const uploadButton = document.getElementById('uploadButton').
  // addEventListener('click',()=>{
  //   Papa.parse(document.getElementById('uploadfile').files[0],
  //   {
  //       download:true,
  //       header: true,
  //       skipEmptyLines:true,
  //       dynamicTyping: true,
  //       transformHeader:function(h) {
  //         console.log(h.trim());
  //         return h.trim();
  //
  //       },
  //       complete: function(results){
  //
  //         for(i= 0;i< results.data.length;i++){
  //           time.push(results.data[i].Date);
  //           sensor.push(results.data[i].sensor3)
  //
  //         }
  //         console.log(sensor);
  //
  //       }
  //   })
  // })


// setup
const time = <?php echo json_encode($time); ?>;
console.log(time);
const reading = <?php echo json_encode($reading); ?>;
console.log(reading);

const data = {
labels: [0,1,2,3,4,5,6,7,8,9,1,1,1,1,,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1], // Put times here but we need to edit it Manually put in time labels to fix this problem
datasets: [{
    label: 'Muscle Tension Sensor 1',
    data: reading, // Replace with Sensor
    backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
    ],
    borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ],
    borderWidth: 0.5
}]
};


//config

const config= {
type: 'line',
data,
options: {
    scales: {
        y: {
            beginAtZero: true
        }
    }
}
};
//render

const myChart = new Chart(
document.getElementById('myChart'),
config
);

<?php
  closeCon($connection);
?>
  </script>
</html>
