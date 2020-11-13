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
                    header("refresh:3; url=login.php");
                }
                break;       
        }
    }
    function check_login(){
        $users= array(
            'hope' => array( 
                'username' => 'hope',
                'password' => 'hups123',
                'user_type' => 1, // 1: student
            ),
    
            'alan' => array( 
                'username' => 'alan',
                'password' => 'alanups',
                'user_type' => 2, // 1: student, 2: teacher
            ),
        
            'kate' => array( 
                'username' => 'kate',
                'password' => 'pw123etak',
                'user_type' => 1, // 1: student, 2: teacher
            ),
    
            'harry' => array(
                'username' => 'harry',
                'password' => 'harry2012',
                'user_type' => 1, // 1: student, 2: teacher
            ),
    
            'hermione' => array(
                'username' => 'hermione',
                'password' => 'pwis123',
                'user_type' => 1, // 1: student, 2: teacher
            )
        );
    
    
        $user_login = array(
            'username' => $_POST['u'],
            'password' => $_POST['pw']
        );
        
        if(array_key_exists($user_login['username'], $users)){
            if($user_login['password'] == $users[$user_login['username']]['password']){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
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