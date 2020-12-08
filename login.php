<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body style="background: url('menus/menu_image.png')">
    <?php

		if(session_status() !== PHP_SESSION_ACTIVE){
			session_start();
		}
		if(isset($_SESSION['u_name'])){
			unset($_SESSION['u_name']);
		}
	?>

    <style>
        #login{
            position: absolute;
            left: 50%;
            bottom: 50%;
            transform: translate(-50%);
            background-color: #b1efff;
            padding: 30px 20px 25px 20px;
            border: 2px solid black;
            border-radius: 5px;
        }

        /* create new user button */
        #newUser{
            background: none;
            border: none;
            color: blue;
        }

        #newUser:hover{
            /* cursor: pointer; */
            color: darkblue;
        }

        #register{
            display: none;
            position: absolute;
            left: 50%;
            bottom: 40%;
            transform: translate(-50%);
            background-color: #b1efff;
            padding: 30px 20px 25px 20px;
            border: 2px solid black;
            border-radius: 5px;
        }

        button:hover{
            cursor: pointer;
        }

        #checkbox:hover{
            cursor: pointer;
        }
    </style>

    <!-- login menu -->
    <div id="login">
   <form action="my_functions.php" method="post">
       Username: <input type="text" name="u"><br><br>
       Password: <input type="password" name="pw">
       <input type="hidden" name="task" value="login">
       <button type="submit">Login</button>
   </form>
   <br>
   <center><button id="newUser">Create new user</button></center>
    </div>

   <!-- User creation menu -->
   <div id="register">
   <form action="my_functions.php" method="post">
       Create Username: <input type="text" name="u"><br><br>
       Create Password: <input type="password" name="pw"><br><br>
       Student: <input type="radio" name='ut' id="checkbox" value="1" checked>
       Teacher:  <input type="radio" name='ut' id="checkbox" value="2"><br><br>
       Teacher Username (if student): <input type="text" name="t"><br><br>
       <input type="hidden" name="task" value="register">
       <button type="submit">Register</button>
   </form>
   <button id="back">Back to login</button>
    </div>

    <!-- Make user creation a pop-up menu -->
    <script type="text/javascript">
    function main(){
        document.getElementById("newUser").addEventListener("click", openReg);
    }

    function openReg(){//switch to the register menu
        document.getElementById("register").style.display = "unset";
        document.getElementById("login").style.display = "none";
        document.getElementById("newUser").removeEventListener("click", openReg);
        document.getElementById("back").addEventListener("click", back);
    }

    function back(){//switch back to the login menu
        document.getElementById("login").style.display = "unset";
        document.getElementById("register").style.display = "none";
        document.getElementById("back").removeEventListener("click", back);
        document.getElementById("newUser").addEventListener("click", openReg);
    }
    main();
    </script>
</body>
</html>
