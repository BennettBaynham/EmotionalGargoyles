<!DOCTYPE html>
<html lang="en">

<!--This file will check the user type and send them to the appropriate menu.
    Anything that would direct a user to the menu should link to this file instead.-->
<?php
include_once 'my_functions.php';

//FOR NOW THIS JUST SENDS USER TO ADMIN MENU
$user_type = 3;
redirect($user_type);
?>