<?php

    if(isset($_POST['task'])){
        switch($_POST['task']){
            case 'login':
                if(check_login()===1){
                    if(session_status() !==PHP_SESSION_ACTIVE){
                        session_start();
                    }
                    $_SESSION['u_name'] = $_POST['u'];
                    header("Location: menu_redirector.php");
                }else{
                    echo "Cannot login";
                    header("refresh:2; url=login.php");
                }
                break; 
            case 'register':
                $out = create_account();
                if($out == 0){
                    echo "Username Taken";
                    header("refresh:2; url=login.php");
                }else if($out == 1){
                    echo "Incorrect Teacher ID";
                    header("refresh:2; url=login.php");
                }else if($out == 2){
                    if(session_status() !==PHP_SESSION_ACTIVE){
                        session_start();
                    }
                    $_SESSION['u_name'] = $_POST['u'];
                    header("Location: menu_redirector.php");
                }
            break;

        }
    }

    function writeData($file, $data){
        //convert data to a json format
        $data_json = json_encode($data);
    
        if(file_put_contents($file, $data_json)){
            return true;
        }else{
            return false;
        }
    }
        
    function getData($file){
        $res  = file_get_contents($file);
    
        //convert it to an array
        $res_arr = json_decode($res, true);
        return $res_arr;
    }
    

    function check_login(){
        $users = getData("./user.json");
        if(array_key_exists($_POST['u'], $users)){//checking if the logging in user could be a teacher
            if($users[$_POST['u']]['password'] == $_POST['pw']){
                return 1;
            }
        }
        foreach($users as $key => $value){//checking if the logging in user could be a student
            if(array_key_exists($_POST['u'], $value)){
                if($users[$key][$_POST['u']]['password'] == $_POST['pw']){
                    return 1;
                }
            }
        }
        return 0;
    }

    function gameDifficulty($game){
        $users = getData("../user.json");
        if(array_key_exists($_SESSION['u_name'], $users)){//if there is a teacher with this id
            return 0;//whatever difficulty
        }
        foreach($users as $key => $value){//if there is a student with this id
            if(array_key_exists($_SESSION['u_name'], $value)){
                return $users[$key][$_SESSION['u_name']][$game]; //returning the possibly set difficulty for the game
            }
        }
    }

    if(isset($_GET["method"])){
        $users = getData("./user.json");

        extract($_GET);
        foreach($users as $key => $value){//if there is a student with this id
            if(array_key_exists($tag, $value)){
                $users[$key][$tag][$message]=$users[$key][$tag][$message]+1;
                writeData("./user.json", $users);
                break;
            }
        }
        
	}

    function create_account(){
        $users = getData("user.json");
        if($_POST['ut'] == 1){
            $create_user = array(
                'username' => $_POST['u'],
                'password' => $_POST['pw'],
                'user_type' => $_POST['ut'],
                
                'coinD' => 0,
                'coin1W' => 0,
                'coin1L' => 0,
                'coin2W' => 0,
                'coin2L' => 0,//extra values to keep track of student progress for teachers
                'coin3W' => 0,
                'coin3L' => 0,
    
                'carD' => 0,
                'car1W' => 0,
                'car1L' => 0,
                'car2W' => 0,
                'car2L' => 0,
                'car3W' => 0,
                'car4L' => 0,
    
                'lineD' => 0,
                'line1W' => 0,
                'line1L' => 0,
                'line2W' => 0,
                'line2L' => 0,
                'line3W' => 0,
                'line3L' => 0
                
            );
        }else{
            $create_user = array(
                'username' => $_POST['u'],
                'password' => $_POST['pw'],
                'user_type' => $_POST['ut']
            );
        }
        foreach($users as $key => $value){//if there is a student with this id
            if(array_key_exists($_POST['u'], $value)){
                return 0;
            }
        }
        if(array_key_exists($_POST['u'], $users)){//if there is a teacher with this id
            return 0;
        }
        if($_POST['ut'] == 1){//if a student is registering
            if(!array_key_exists($_POST['t'], $users)){//if the teacher doesn't exist
                return 1;
            }
            $users[$_POST['t']][$_POST['u']] = $create_user;//if the teacher exists
            writeData("user.json", $users);
            return 2;
        }else{
            $users[$_POST['u']] = $create_user;
            writeData("user.json", $users);
            return 2;
        }
    }

    /**Between login and game menu: function checks user type and sends user to
     * appropriate menu.**/
    function redirect($type){
        // $users = getData("user.json");
        // $type = $users[$_POST['u']['user_type']];
        if($type == 2){
            header("Location: menus/teacher_menu.php");
        }
        else{//default to student menu to prevent accidental teacher/admin access
            header("Location: menus/student_menu.php");
        }
        
    }

    function setDifficulty($teacher, $val){
        $users = getData("user.json");
        foreach($users[$teacher] as $key => $value){
            if($key != 'username' && $key != 'password' && $key != 'user_type'){
                $users[$teacher][$key]['coinD'] = $val;
                $users[$teacher][$key]['carD'] = $val;
                $users[$teacher][$key]['lineD'] = $val;
            }
        }
        writeData("user.json", $users);
        
    }

   function my_session_start(){
        if(session_status()!==PHP_SESSION_ACTIVE){
            session_start();
        }
   }


    function findStudents($name){
        $users = getData("user.json");
        $users = $users[$name];
        $studentsList = array();
        foreach($users as $key => $value){//running through students under the teacher
            if($key != 'username' && $key != 'password' && $key != 'user_type'){
                $studentsList[$key] =$value;
            }
        }
        return $studentsList;
    }
?> 
