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
       Username: <input type="text" name="u"><br><br>
       Password: <input type="password" name="pw">
       <input type="hidden" name="task" value="login">
       <button type="submit">Login</button>
   </form><br><br><br><br><br><br>

   <form action="my_functions.php" method="post">
       Create Username: <input type="text" name="u"><br><br>
       Create Password: <input type="password" name="pw"><br><br>
       Student: <input type="radio" name='ut' value="1" checked>
       Teacher:  <input type="radio" name='ut' value="2"><br><br>
       Teacher Username (if student): <input type="text" name="t"><br><br>
       <input type="hidden" name="task" value="register">
       <button type="submit">Register</button>
   </form>
</body>
</html>
