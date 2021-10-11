<?php include "head.php"; 
      include "header.php";
?>
<title>Visulisation</title>
<link rel="stylesheet" href="./resources/styles/general.css">
<link rel="stylesheet" href="./resources/styles/footer.css">
<link rel="stylesheet" href="./resources/styles/Header.css">
<link rel="stylesheet" href="./resources/styles/vis.css">


</head>

<body>
  <header>
    <div class="leftContainer">
      <h1 class="text-left">Visualisation</h1>
    </div>
  </header>
  <div class="right-half" style="padding: 50px;" style="margin-bottom:1px;">
  <div class="card">
    <!-- insert body model -->
    <img src="./resources/images/silverGuy1.jpg" width= "300" height= "300" alt="">
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
  </div>
  
</body>
<?php include "footer.php" ?>

</html>