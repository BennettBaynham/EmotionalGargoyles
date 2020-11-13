<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php

		if(session_status() !== PHP_SESSION_ACTIVE){
			session_start();
		}
		if(isset($_SESSION['u_name'])){
			unset($_SESSION['u_name']);
		}
	?>


   <form action="my_functions.php" method="post">
       username: <input type="text" name="u"><br><br>
       password: <input type="password" name="pw">
       <input type="hidden" name="task" value="login">
       <button type="submit">Login</button>
   </form>
</body>
</html>