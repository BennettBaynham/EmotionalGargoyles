<?php     //Block to make sure there is a user logged in
    include_once "../my_functions.php";
		my_session_start();
		if(!isset($_SESSION['u_name'])){
			header("Location:../login.php");
        }
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="stylesheet.css">
  <head>
    <ul id="bar"><!--Website navigation bar at the top of the page-->
         <li style="float:left"><a href="../menu_redirector.php">Home</a></li>
         <li style="float:left"><a href="../basicLessons.html">Basic Lessons</a></li>
         <li style="float:right"><a href="../login.php">Log Out</a></li>
         <li style="float:right"><a href="../userinfo.html">Profile</a></li> 
    </ul>
  </head>

  <body background="images/background.jpg"> 
	  <center>
    <h2 class="titleText">Crazy Cars</h2>
    <div id="container">
      <canvas id="canvas" width="1000" height="400"></canvas>
      
      <!-- Difficulty menu at beginning of game -->
      <div class="menu" id="difMenu">
        <h2>Select Difficulty</h2>

        <ul id="ulMenu">
          <li id="liMenu">
            <button class="difMenuBtn" style="background-color: green">Easy</button>
          </li>
          <li id="liMenu">
            <button class="difMenuBtn" style="background-color: yellow">Medium</button>
          </li>
          <li id="liMenu">
            <button class="difMenuBtn" style="background-color: red">Hard</button>
          </li>
        </ul>

      </div>

      <!-- End of Game Menu -->
      <div class="menu" id="endMenu">
        <h2 id="resultText">Filler</h2>
        <h3 id="amountRight">x out of y correct</h3>

        <ul id="ulMenu">
          <li id="liMenu">
            <button class="endMenuBtn" id="replay">Play Again</button>
          </li>
          <li id="liMenu">
            <button class="endMenuBtn"><a href="../menu_redirector.php">Home</a></button>
          </li>
        </ul>
      
      </div>
      <!-- User input section at the bottom -->
      <ul>
        <li class="titleText" id="inputs">Answer: <input type="text" style="width: 50px" id="ans"></li>
        <li id="inputs"><button class="btn" id="goBtn">GO!</button></li>
      </ul>
      <script src="cars.js"></script>
    </div>
    </center>
  </body>
</html>