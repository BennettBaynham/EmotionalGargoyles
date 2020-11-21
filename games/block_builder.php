<h1>Block Builder Game</h1>
<?php       //Block to make sure there is a user logged in
    include_once "../my_functions.php";
		my_session_start();
		if(!isset($_SESSION['u_name'])){
			header("Location:../login.php");
        }
?>