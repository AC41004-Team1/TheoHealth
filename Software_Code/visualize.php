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
       <!-- <canvas id="myChart"></canvas> -->
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

   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.5/dat.gui.min.js"></script> -->

  <script type="module">

import * as THREE from 'https://cdn.skypack.dev/three@0.132.2';
import { OrbitControls } from 'https://cdn.skypack.dev/three/examples/jsm/controls/OrbitControls.js';
import { GLTFLoader } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js';



  let scene,camera, renderer,hlight,human;
  let Right_A,Left_A,Right_B,Left_B;
  let raycaster,mouse;


async function init(){

  scene = new THREE.Scene();
  scene.background = new THREE.Color(0x404040);
  camera = new THREE.PerspectiveCamera(75,window.innerWidth/window.innerHeight,0.1, 1000);
  camera.rotation.y = 45/180*Math.PI;
  camera.position.x = 1;
  camera.position.y = 2.5;
  camera.position.z = 1;

  var ambient = new THREE.AmbientLight( 0x101030 );
       scene.add(ambient);

       var directionalLight = new THREE.DirectionalLight( 0xffeedd );
       directionalLight.position.set( 3, 3, 3 );

       var directionalLight2 = new THREE.DirectionalLight( 0xffeedd );
       directionalLight2.position.set( 1, 1, 1 );

       var directionalLight3 = new THREE.DirectionalLight( 0xffeedd );
       directionalLight3.position.set( -1, -1, -1 );

       var directionalLight4 = new THREE.DirectionalLight( 0xffeedd );
       directionalLight4.position.set( -3, -3, -3 );


       scene.add( directionalLight,directionalLight2,directionalLight3 ,directionalLight4  );

  renderer = new THREE.WebGLRenderer({antialias: true});
  renderer.setSize(window.innerWidth, window.innerHeight);

  mouse = new THREE.Vector2();
  raycaster = new THREE.Raycaster();

  document.body.appendChild(renderer.domElement);


  let controls = new OrbitControls(camera, renderer.domElement);
  controls.addEventListener('change', animate);


  document.body.appendChild(renderer.domElement);

  let loader = new GLTFLoader();
  loader.load('person2.gltf',function ( gltf ) {
     var material = new THREE.MeshStandardMaterial({ color: 0xff0000, roughness: 0.2, metalness: 0.8 });



    human = gltf.scene;
    human.material = material
    human.material.color.setHex( 0xffffff );
    human.scale.set[1,1,1];
    gltf.parser.getDependencies( 'material' ).then( ( materials ) => {


 Right_A = scene.getObjectByName( "Right_A" );
 Left_A = scene.getObjectByName( "Left_A" );
 Right_B = scene.getObjectByName( "Right_B" );
 Left_B = scene.getObjectByName( "Left_B" );
changeColour(Right_A,"green");

//Left_B.material =  new THREE.MeshStandardMaterial({ color: 0xff99e6, roughness: 0.2, metalness: 0.8 });
} );

    human.traverse( function( child ) {

                child.material = material;
                child.material.side = THREE.DoubleSide;
            //   material = new THREE.MeshStandardMaterial({ color: parseInt(Math.floor(Math.random()*16777215).toString(16),16), roughness: 0.2, metalness: 0.8 });


        } );

		scene.add( gltf.scene);
    scene.background = new THREE.Color('grey');
    animate();
  },
    function( xhr ){
        console.log( (xhr.loaded / xhr.total * 100) + "% loaded")
    },
    function( err ){
        console.error( "Error loading obj")
    }
);
  function animate(){
    requestAnimationFrame(animate);
    renderer.render(scene,camera);
    hoverBody();
  }



}


function onMouseMove( event ) {

	// calculate mouse position in normalized device coordinates
  // MAY NEED TO DO SOME MATHS IF WE CHANGE DIMENSIONS
	// (-1 to +1) for both components

	mouse.x = ( event.clientX / window.innerWidth ) * 2 - 1;
	mouse.y = - ( event.clientY / window.innerHeight ) * 2 + 1;



}

function hoverBody(){
  raycaster.setFromCamera(mouse,camera);
  const intersects = raycaster.intersectObjects(scene.getObjectByName( "Right_B"));

  console.log(intersects);
  for(let i = 0; i<intersects.length; i++){
    intersects[i].object.material.transparent = true;
    intersect.object.opacity = 0.5;
  }
}

function changeColour(bodyPart,value){

let green,orange,red;

green =  new THREE.MeshStandardMaterial({ color: 0x008000 });
orange = new THREE.MeshStandardMaterial({ color: 0xffa500 });
red = new THREE.MeshStandardMaterial({ color: 0xff0000 });

console.log(bodyPart);
if(value == "green"){
  bodyPart.material = green;
}
else if (value == "orange"){
  bodyPart.material = orange;
}
else{
  bodyPart.material = red;
}

}

  init();
window.addEventListener( 'mousemove', onMouseMove, false );

</script>
</html>
