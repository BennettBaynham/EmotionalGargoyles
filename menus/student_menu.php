<!DOCTYPE html>
<html lang="en">

<!--This file makes the menu for students-->

<!--Links to a file with format features common to all game menus-->
<link rel="stylesheet" href="menu_overlap.css">

<head>
    <ul id="bar"><!--Website navigation bar at the top of the page-->
        <li><a href="../menu_redirector.php" class="active">Home</a></li>
         <li style="float:right"><a href="../login.php">Log Out</a></li>
         <li style="float:right"><a href="../userinfo.php">Profile</a></li> 
         <li style="float:left"><a href="../basicLessons.html">Basic Lessons</a></li>
    </ul>
</head>

<?php       //Block to make sure there is a user logged in
    include_once "../my_functions.php";
		my_session_start();
		if(!isset($_SESSION['u_name'])){
			header("Location: ../login.php");
        }
?>


<!--Menu title and text-->
<center>
<body>    
    <h1 class="titleBorder"> Welcome!</h1><br>
    <h2 class="textBorder">
        What would you like to play? <br><br>
    
        <ul id="games">
            <li><a href="../CarGame/index.php">Crazy Cars</a></li>
            <!-- <li><a href="../games/whack_a_mole.php">Whack-A-Mole</a></li> -->
            <li><a href="../games/change_it_up.php">Change It Up</a></li>
            <!-- <li><a href="../games/block_builder.php">Block Builder</a></li> -->
            <li><a href="../NumberLine/index.html">Fine Line</a></li>
        </ul>
    </h2>
</body>
</center>