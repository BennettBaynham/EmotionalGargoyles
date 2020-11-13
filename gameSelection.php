<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Selection</title>
</head>
<?php       //Block to make sure there is a user logged in
    include_once "my_functions.php";
		my_session_start();
		if(!isset($_SESSION['u_name'])){
			header("Location: login.php");
        }
?>
<body>
   <a href="game0.php">Game0</a>
   <a href="game1.php">Game1</a>
   <a href="game2.php">Game2</a>
</body>
</html>

