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
                    //header("refresh:2; url=login.php");
                }
                break; 
            case 'register':
                $out = create_account();
                if($out == 0){
                    echo "Username Taken";
                    //header("refresh:2; url=login.php");
                }else if($out == 1){
                    echo "Incorrect Teacher ID";
                    //header("refresh:2; url=login.php");
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
        $users = getData("user.json");
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

    function create_account(){
        $users = getData("user.json");
        $create_user = array(
            'username' => $_POST['u'],
            'password' => $_POST['pw'],
            'user_type' => $_POST['ut']
            
        );
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
    function redirect($user_type){
        if($user_type == 3){
            header("Location: menus/admin_menu.php");
        }
        elseif($user_type == 2){
            header("Location: menus/teacher_menu.php");
        }
        else{//default to student menu to prevent accidental teacher/admin access
            header("Location: menus/student_menu.php");
        }
        
    }

   function my_session_start(){
        if(session_status()!==PHP_SESSION_ACTIVE){
            session_start();
        }
   }
?> 
