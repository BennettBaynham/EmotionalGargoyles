<?php


    

    if(isset($_POST['m'])){
        switch($_POST['m']){
            case 'login':
                if(check_login()===1){
                   header("Location: gameSelection.php");
                }else{
                    echo "Cannot login";
                    header("refresh:5; url=login.php");
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