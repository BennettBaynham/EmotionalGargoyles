<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
   <!-- get and post -->
   <form action="my_functions.php" method="post">
       username: <input type="text" name="u"><br><br>
       password: <input type="password" name="pw">
       <input type="hidden" name="m" value="login">
       <button type="submit">Login</button>
   </form>
</body>
</html>