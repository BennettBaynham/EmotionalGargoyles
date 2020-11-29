<!DOCTYPE html>
<html lang="en">

<!--This file makes the menu for users with administrator access-->

<!--Links to a file with format features common to all game menus-->
<link rel="stylesheet" href="menu_overlap.css">

<head>
    <ul id="bar"><!--Website navigation bar at the top of the page-->
         <li><a href="../menu_redirector.php" class="active">Home</a></li>
         <li style="float:left"><a href="../basicLessons.html">Basic Lessons</a></li>
         <li style="float:right"><a href="../login.php">Log Out</a></li>
         <li style="float:right"><a href="../userinfo.html">Profile</a></li> 
    </ul>
</head>

<!--Menu title and text-->
<center>
<body background="menu_image.png">  

    <?php       //Block to make sure there is a user logged in
    include_once "../my_functions.php";
		my_session_start();
		if(!isset($_SESSION['u_name'])){
			header("Location:../login.php");
        }
    ?>

    <h1 class="titleBorder"> Welcome!</h1><br>
    <h2 class="textBorder">
        What would you like to do? <br><br>
        
        Play...<br>
        <ul id="games">
            <li><a href="../CarGame/index.php">Crazy Cars</a></li>
            <li><a href="../games/whack_a_mole.php">Whack-A-Mole</a></li>
            <li><a href="../games/change_it_up.php">Change It Up</a></li>
            <li><a href="../games/block_builder.php">Block Builder</a></li>
            <li><a href="../NumberLine/index.html">Fine Line</a></li><br>
        </ul>

        Access...<br>
        <ul id="games">
            <li><a href="../student_list.html">Student List</a></li>
            <li><a href="../teacher_list.html">Teacher List</a></li><br>
        </ul>
        
        Other...<br>
        <ul id="games">
            <li><a href="../problems_page.html">Add Problems</a></li>
        </ul>
    </h2>
</body>
</center>