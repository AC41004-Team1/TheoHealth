<?php include "head.php" ?>
<?php include "auth.php" ?>
<link rel="stylesheet" href="./resources/styles/dashboard.css">
<title>Theo Health</title>
</head>

<body>
  <?php include "header.php" ?>
  <!-- Mainbody of the web application--->
  <div class="jumbotron ">
    <h1 class="text-left">Welcome Back John Smith
      <!--Place First name of user--->
    </h1>
    <!--Replace Theo Health text to Logo ---->
    <h1 class="text-center">Hello</h1>
  </div>

  <div class="MainContent">
    <div class="column">
      <div class="card-dash" style="width: 30rem;">
        <img src="./resources/images/bg-image.png" class="card-img-top" alt="..."> <!-- Replace image with a brief example of your visulasation page----->
        <h5 class="card-title">Breif Overview</h5>
        <p class="card-text">You have improved by 15% since the last time you have recored your exercise. Great Work</p>
        <a href="#" class="btn btn-primary">Let see more details
          <!---Link your visulations page-->
        </a>
      </div>
    </div>
    <div class="column">
      <div class="container">
        <div class="row">
          <div class='db-nav'>
            <!--- This will need to change for physicist --->
            What whould you like to do?
            <div class="card-dash">
              <div class="Recored">
                <!-- Add new data here --->
                <!--    <i class="icon-db bi-play-circle"></i>  -->
                <h4> Recored new exercise </h4>
              </div>
            </div>
            <div class="card-dash">
              <div class="Previous">
                <!-- See Previous results (visulasations) --->
                <!--    <i class="icon-db bi-play-circle"></i> -->
                <h4>See Previous results </h4>
              </div>
            </div>
            <div class="card-dash">
              <div class="Message"></div> <!-- Message your physicist --->
              <!--  <i class="icon-db bi-clock-history"></i> -->
              <h4> Message </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>

  <!-- End of the web application--->
  <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script> -->
</body>
<?php include "footer.php" ?>

</html>