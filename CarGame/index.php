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
	  <center><h2 class="titleText">Crazy Cars</h2></center>
	 
	  <canvas id="canvas" width="1000" height="450"></canvas>
	  <script src="cars.js"></script>
	</body>
</html>