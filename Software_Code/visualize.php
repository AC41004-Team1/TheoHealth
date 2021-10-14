<!DOCTYPE html>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.1/papaparse.min.js"></script>

<!-- Insert PHP Database connect here -->



<?php


$userSession = $_SESSION["userSession"];

?>


<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>
</head>

<body>

<div class ="chartBox">
  <canvas id="myChart"></canvas>
</div>

  <?php
  try {
    $connection = openCon();
    // Change first para to client thing;
    $queryInput = "CALL getClientDataWithSensor(\"{$userSession}\",1)";
    $result = $connection->query($queryInput);

    if ($result->num_rows > 0) {

      $time1 = array();
      $reading1 = array();

      while ($row = $result->fetch_object()) {

        $time1[] = $row->TimeStamp;

        $reading1[] = $row->Reading;
      }

      unset($result);
    } else {
    }
  } catch (PDOException $e) {

    die($e->getMessage());
  }

  closeCon($connection);
  $connection = openCon();



  try {

    // Change first para to client thing;
    $queryInput = "CALL getClientDataWithSensor(\"{$userSession}\",2)";
    $result = $connection->query($queryInput);


    if ($result->num_rows > 0) {

      $time2 = array();
      $reading2 = array();

      while ($row = $result->fetch_object()) {

        $time2[] = $row->TimeStamp;

        $reading2[] = $row->Reading;
      }

      unset($result);
    } else {
    }
  } catch (PDOException $e) {

    die($e->getMessage());
  }

  closeCon($connection);
  $connection = openCon();



  try {

    // Change first para to client thing;
    $queryInput = "CALL getClientDataWithSensor(\"{$userSession}\",3)";
    $result = $connection->query($queryInput);


    if ($result->num_rows > 0) {

      $time3 = array();
      $reading3 = array();

      while ($row = $result->fetch_object()) {

        $time3[] = $row->TimeStamp;

        $reading3[] = $row->Reading;
      }

      unset($result);
    } else {
    }
  } catch (PDOException $e) {

    die($e->getMessage());
  }
  closeCon($connection);
  $connection = openCon();



  try {

    // Change first para to client thing;
    $queryInput = "CALL getClientDataWithSensor(\"{$userSession}\",4)";
    $result = $connection->query($queryInput);


    if ($result->num_rows > 0) {

      $time4 = array();
      $reading4 = array();

      while ($row = $result->fetch_object()) {

        $time4[] = $row->TimeStamp;

        $reading4[] = $row->Reading;
      }

      unset($result);
    } else {
    }
  } catch (PDOException $e) {

    die($e->getMessage());
  }




  ?>

  <div style="width: 20vw">
  </div>
</body>

<script>
  var time1 = <?php echo json_encode($time1); ?>;
  time1.map((e) => {
    return new Date(e)
  });




  console.log(time1);

  const reading1 = <?php echo json_encode($reading1); ?>;
  const reading2 = <?php echo json_encode($reading2); ?>;
  const reading3 = <?php echo json_encode($reading3); ?>;
  const reading4 = <?php echo json_encode($reading4); ?>;

  console.log(reading1);
  console.log(reading2);
  console.log(reading3);
  console.log(reading4);

  const data = {
    labels: time1, // Put times here but we need to edit it Manually put in time labels to fix this problem
    datasets: [{
        label: 'Left Hamstring (Semitendinosus)',
        data: reading1, // Replace with Sensor
        backgroundColor: [
          '#75E6DA',
        ],
        borderColor: [
          '#05445E',
        ],
        borderWidth: 0.35,
      },
      {
        label: 'Right Hamstring (Semitendinosus)',
        data: reading2, // Replace with Sensor
        backgroundColor: [
          '#FF8300'
        ],
        borderColor: [
          '#DF362D'
        ],
        borderWidth: 0.35,
      },
      {
        label: 'Left Quadricep (Rectus Femoris)',
        data: reading3, // Replace with Sensor
        backgroundColor: [
          '#868B8E'

        ],
        borderColor: [
          '#EEEDE7'
        ],
        borderWidth: 0.35
      },
      {
        label: 'Right Quadricep (Rectus Femoris)',
        data: reading3, // Replace with Sensor
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
<!--
<script type="module">
  import * as THREE from 'https://cdn.skypack.dev/three@0.132.2';
  import {
    OrbitControls
  } from 'https://cdn.skypack.dev/three/examples/jsm/controls/OrbitControls.js';
  import {
    GLTFLoader
  } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js';



  let scene, camera, renderer, hlight, human;
  let Right_A, Left_A, Right_B, Left_B;
  let raycaster, mouse;


  async function init() {

    scene = new THREE.Scene();
    scene.background = new THREE.Color(0x0297a2);
    camera = new THREE.PerspectiveCamera(45, 1, 0.1, 1000);
    // camera.rotation.x = 0
    // camera.rotation.y = 0
    // camera.rotation.z = 0

    // camera.position.x = -0.45;
    // camera.position.y = 2;
    // camera.position.z = 2;

    camera.rotation.y = 45 / 180 * Math.PI;
    camera.rotation.x = -5
    camera.position.x = 1;
    camera.position.y = 2.5
    camera.position.z = 1

    // camera.rotation.x = 0
    // camera.rotation.y = -0
    // camera.rotation.z = -0

    // camera.position.x = 0
    // camera.position.y = 0
    // camera.position.z = 0

    var ambient = new THREE.AmbientLight(0x101030);
    scene.add(ambient);

    var directionalLight = new THREE.DirectionalLight(0xffeedd);
    directionalLight.position.set(3, 3, 3);

    var directionalLight2 = new THREE.DirectionalLight(0xffeedd);
    directionalLight2.position.set(1, 1, 1);

    var directionalLight3 = new THREE.DirectionalLight(0xffeedd);
    directionalLight3.position.set(-1, -1, -1);

    var directionalLight4 = new THREE.DirectionalLight(0xffeedd);
    directionalLight4.position.set(-3, -3, -3);


    scene.add(directionalLight, directionalLight2, directionalLight3, directionalLight4);

    renderer = new THREE.WebGLRenderer({
      antialias: true
    });
    renderer.setSize(window.innerWidth * 0.3, window.innerWidth * 0.3);

    mouse = new THREE.Vector2();
    raycaster = new THREE.Raycaster();

    document.body.appendChild(renderer.domElement);


    let controls = new OrbitControls(camera, renderer.domElement);
    controls.addEventListener('change', animate);


    document.body.appendChild(renderer.domElement);

    let loader = new GLTFLoader();
    loader.load('person2.gltf', function(gltf) {
        var material = new THREE.MeshStandardMaterial({
          color: 0x00FF00
        });


        const geometry = new THREE.BoxGeometry(1, 1, 1);

        const cube = new THREE.Mesh(geometry, material);
        // scene.add( cube );
        human = gltf.scene;
        human.material = material
        human.material.color.setHex(0x00FF00);
        human.scale.set[1, 1, 1];
        gltf.parser.getDependencies('material').then((materials) => {


          Right_A = scene.getObjectByName("Right_A");
          Left_A = scene.getObjectByName("Left_A");
          Right_B = scene.getObjectByName("Right_B");
          Left_B = scene.getObjectByName("Left_B");
          changeColour(Right_A, "green");
        });

        human.traverse(function(child) {

          child.material = material;
          child.material.side = THREE.DoubleSide;
        });

        scene.add(gltf.scene);
        scene.background = new THREE.Color('grey');
        animate();
      },
      function(xhr) {
        console.log((xhr.loaded / xhr.total * 100) + "% loaded")
      },
      function(err) {
        console.error("Error loading obj")
      }
    );

    function animate() {
      requestAnimationFrame(animate);
      renderer.render(scene, camera);
      hoverBody();
    }



  }


  function onMouseMove(event) {

    // calculate mouse position in normalized device coordinates
    // MAY NEED TO DO SOME MATHS IF WE CHANGE DIMENSIONS
    // (-1 to +1) for both components

    mouse.x = ((event.clientX - renderer.domElement.offsetLeft) / renderer.domElement.width) * 2 - 1;
    mouse.y = -((event.clientY - renderer.domElement.offsetTop) / renderer.domElement.height) * 2 + 1;


  }

  function hoverBody() {
    raycaster.setFromCamera(mouse, camera);
    const intersects = raycaster.intersectObjects(scene.children, true);


    for (let i = 0; i < intersects.length; i++) {
      intersects[i].object.material.transparent = true;
      intersects[i].object.material = new THREE.MeshStandardMaterial({
        color: 0xff0000,
        roughness: 0.2,
        metalness: 0.8
      });;
      intersects[i].object.opacity = 0.5;

    }
  }

  function onClick(event) {
    console.log("clicked");
    console.log(camera.rotation);
    console.log(camera.position);
    raycaster.setFromCamera(mouse, camera);
    let intersects = raycaster.intersectObjects(scene.children, true);
    if (intersects.length > 0) {
      switch (intersects[0].object.name) {
        case "Right_A":
          console.log("RAGA53A4");
          break;
        case "Right_B":
          console.log("GWGSGS");
          break;
        case "Left_A":
          console.log("GWGWTBWVQ%");
          break;
        case "Left_B":
          console.log("3616216%");
          break;
        default:
          // code block
      }
      console.log(intersects[0].object.name);
    }
  }



  init();
  window.addEventListener('mousemove', onMouseMove, false);
  window.addEventListener('click', onClick)
  // document.appendChild(Object.assign(document.createElement('button'), {
  //   "innerText": "button"
  // }))
</script> -->

</html>
