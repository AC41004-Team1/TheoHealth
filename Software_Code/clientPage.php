<html>
  <body>
    <?php
      session_start();

      $role = $_SESSION["role"];
      //$myIndex = $_SESSION["userIndex"];
      $myIndex = 3;

      //if($role != 'PT' || $role != 'P'){
      //  header('Location: /dashboard.php');
      //}

      include "connection.php";
      $conn = openCon();

      $SQLInput = "CALL getManagersClients(\"{$myIndex}\")";
      $queryOutput = $conn->query($SQLInput);
      $conn -> close();

      if($queryOutput->num_rows > 0){
        while($row = $queryOutput->fetch_object()){
          echo "\"{$row -> UserIndex}\" | \"{$row -> FirstName}\" | \"{$row -> LastName}\" | \"{$row -> Username}\"";
        }
      }else{
        echo "<h1>You currently have no clients</h1>";
      }
   ?>
  </body>
</html>
