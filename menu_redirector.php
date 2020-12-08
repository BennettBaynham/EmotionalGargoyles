<!DOCTYPE html>
<html lang="en">

<!--This file will check the user type and send them to the appropriate menu.
    Anything that would direct a user to the menu should link to this file instead.-->
<?php      //Block to make sure there is a user logged in
include_once "my_functions.php";
    my_session_start();
    if(!isset($_SESSION['u_name'])){
        header("Location:login.php");
    }

//FOR NOW THIS JUST SENDS USER TO TEACHER MENU
$user_type = 2;
redirect($user_type);
?>