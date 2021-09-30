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

      // Change first para to client thing;
        $queryInput = "CALL getClientDataWithSensor(1,1)";
        $result = $connection->query($queryInput);
        echo "Done Query";
        echo "End of result";
        if($result->num_rows > 0){
          echo "Done if";
          $time1 = array();
          $reading1 = array();
          echo "Created variables";
          while($row = $result->fetch_object()){

            $time1[] = $row->TimeStamp;

            $reading1[] = $row->Reading;

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

        closeCon($connection);
        $connection = openCon();



      try{

        // Change first para to client thing;
          $queryInput = "CALL getClientDataWithSensor(1,2)";
          $result = $connection->query($queryInput);
          echo "Done Query";
          echo "End of result";
          if($result->num_rows > 0){
            echo "Done if";
            $time2 = array();
            $reading2 = array();
            echo "Created variables";
            while($row = $result->fetch_object()){

              $time2[] = $row->TimeStamp;

              $reading2[] = $row->Reading;

            }
            echo "populated arrays";
            unset($result);
            } else {
              echo"Problem2";
            }
          }catch(PDOException $e){
            echo "no result";
          die($e->getMessage());
        }

        closeCon($connection);
        $connection = openCon();



      try{

        // Change first para to client thing;
          $queryInput = "CALL getClientDataWithSensor(1,3)";
          $result = $connection->query($queryInput);
          echo "Done Query";
          echo "End of result";
          if($result->num_rows > 0){
            echo "Done if";
            $time3 = array();
            $reading3 = array();
            echo "Created variables";
            while($row = $result->fetch_object()){

              $time3[] = $row->TimeStamp;

              $reading3[] = $row->Reading;

            }
            echo "populated arrays";
            unset($result);
            } else {
              echo"Problem2";
            }
          }catch(PDOException $e){
            echo "no result";
          die($e->getMessage());
        }
        closeCon($connection);
        $connection = openCon();



      try{

        // Change first para to client thing;
          $queryInput = "CALL getClientDataWithSensor(1,4)";
          $result = $connection->query($queryInput);
          echo "Done Query";
          echo "End of result";
          if($result->num_rows > 0){
            echo "Done if";
            $time4 = array();
            $reading4 = array();
            echo "Created variables";
            while($row = $result->fetch_object()){

              $time4[] = $row->TimeStamp;

              $reading4[] = $row->Reading;

            }
            echo "populated arrays";
            unset($result);
            } else {
              echo"Problem2";
            }
          }catch(PDOException $e){
            echo "no result";
          die($e->getMessage());
        }




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

    <div style = "width: 100%">
       <canvas id="myChart"></canvas>
    </div>
<h1> Hello there team 1 </h1>
  </body>



  <!-- <canvas id="myChart" width="400" height="400"></canvas> -->
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
var time1 = <?php echo json_encode($time1); ?>;
time1.map((e)=>{return new Date(e)});




console.log(time1);

const reading1 = <?php echo json_encode($reading1); ?>;
const reading2 = <?php echo json_encode($reading2); ?>;
const reading3 = <?php echo json_encode($reading3); ?>;
const reading4 = <?php echo json_encode($reading4); ?>;

console.log(reading1);

const data = {
labels: time1, // Put times here but we need to edit it Manually put in time labels to fix this problem
datasets: [{
    label: 'Muscle Tension Left Hamstring (Semitendinosus)',
    data: reading1, // Replace with Sensor
    backgroundColor: [
        'rgba(255, 199, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 186, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 164, 0.2)'
    ],
    borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ],
    borderWidth: 0.1,
},
{
    label: 'Right Hamstring (Semitendinosus)',
    data: reading2, // Replace with Sensor
    backgroundColor: [
        'rgba(25, 99, 132, 0.2)',
        'rgba(54, 62, 235, 0.2)',
        'rgba(25, 206, 86, 0.2)',
        'rgba(75, 12, 192, 0.2)',
        'rgba(13, 102, 5, 0.2)',
        'rgba(25, 59, 64, 0.2)'
    ],
    borderColor: [
        'rgba(55, 99, 132, 1)',
        'rgba(54, 162, 35, 1)',
        'rgba(255, 26, 86, 1)',
        'rgba(75, 12, 192, 1)',
        'rgba(153, 12, 25, 1)',
        'rgba(25, 19, 64, 1)'
    ],
    borderWidth: 0.1
  },
  {
      label: 'Left Quadricep (Rectus Femoris)',
      data: reading3, // Replace with Sensor
      backgroundColor: [
          'rgba(25, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(5, 206, 86, 0.2)',
          'rgba(75, 92, 192, 0.2)',
          'rgba(13, 102, 25, 0.2)',
          'rgba(5, 159, 6, 0.2)'
      ],
      borderColor: [
          'rgba(55, 99, 132, 1)',
          'rgba(54, 12, 35, 1)',
          'rgba(255, 26, 86, 1)',
          'rgba(75, 12, 12, 1)',
          'rgba(153, 12, 255, 1)',
          'rgba(25, 159, 64, 1)'
      ],
      borderWidth: 0.1
    },
    {
        label: 'Right Quadricep (Rectus Femoris)',
        data: reading3, // Replace with Sensor
        backgroundColor: [
            'rgba(25, 99, 132, 0.2)',
            'rgba(54, 162, 35, 0.2)',
            'rgba(25, 206, 86, 0.2)',
            'rgba(75, 12, 192, 0.2)',
            'rgba(132, 102, 25, 0.2)',
            'rgba(215, 159, 64, 0.2)'
        ],
        borderColor: [
            'rgba(155, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 26, 86, 1)',
            'rgba(175, 12, 192, 1)',
            'rgba(153, 12, 255, 1)',
            'rgba(252, 19, 64, 1)'
        ],
        borderWidth: 0.1
}]

};


//config

const config= {
type: 'line',
data,
options: {
    scales: {
      xAxes: [{
        type: 'time'
      }],
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

  <script type="module">

  // Find the latest version by visiting https://cdn.skypack.dev/three.

  import * as THREE from 'https://cdn.skypack.dev/three@0.132.2';

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(
    75,
    window.innerWidth/window.innerHeight,
    0.1,
    1000
  );
  const renderer = new THREE.WebGLRenderer({antialias: true});

  renderer.setSize(window.innerWidth, window.innerHeight);

  document.body.appendChild(renderer.domElement);

const geometry = new THREE.BoxGeometry( 2, 2, 2 );
const material = new THREE.MeshBasicMaterial( {color: 0x0000ff} );
const cube = new THREE.Mesh( geometry, material );
scene.add(cube);

  camera.position.z = 5;

  function animate(){

    cube.rotation.x += 0.01;
    cube.rotation.y += 0.01;
    requestAnimationFrame(animate);
    renderer.render(scene,camera);
  }
  animate();
</script>
</html>
