<!DOCTYPE html>

<link rel="stylesheet" href="creativeProfile.css">

<center>
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-xl-6 col-md-12">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25"> <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image"> </div>
                                <?php 
			                        include_once "my_functions.php";
			                        my_session_start();
			                        if(isset($_SESSION['u_name'])){
				                        echo $_SESSION['u_name'];	
			                        }else{
				                        header("Location: login.php");
                                    }
                                    $users = getData("./user.json");
                                    if(array_key_exists($_SESSION['u_name'], $users)){//if there is a teacher with this id
                                        header("Location: games/teacher_menu.php");
                                    }
                                    $teacher;
                                    foreach($users as $key => $value){//if there is a student with this id
                                        if(array_key_exists($_SESSION['u_name'], $value)){
                                            $teacher = $key;
                                        }
                                    }
                                    $carRight = $users[$teacher][$_SESSION['u_name']]['car3W'] + $users[$teacher][$_SESSION['u_name']]['car2W'] +$users[$teacher][$_SESSION['u_name']]['car1W'];
                                    $lineRight = $users[$teacher][$_SESSION['u_name']]['line3W'] + $users[$teacher][$_SESSION['u_name']]['line2W'] +$users[$teacher][$_SESSION['u_name']]['line1W'];
                                    $coinRight = $users[$teacher][$_SESSION['u_name']]['coin3W'] + $users[$teacher][$_SESSION['u_name']]['coin2W'] +$users[$teacher][$_SESSION['u_name']]['coin1W'];

                                    $carWrong = $users[$teacher][$_SESSION['u_name']]['car3L'] + $users[$teacher][$_SESSION['u_name']]['car2L'] +$users[$teacher][$_SESSION['u_name']]['car1L'];
                                    $lineWrong = $users[$teacher][$_SESSION['u_name']]['line3L'] + $users[$teacher][$_SESSION['u_name']]['line2L'] +$users[$teacher][$_SESSION['u_name']]['line1L'];
                                    $coinWrong = $users[$teacher][$_SESSION['u_name']]['coin3L'] + $users[$teacher][$_SESSION['u_name']]['coin2L'] +$users[$teacher][$_SESSION['u_name']]['coin1L'];
                                    
		                        ?>
                                <p>Student</p> <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                            </div>
                        </div>
                        <div class="footer">
                            <p>HollyPotter, BenGamble, BennettBaynham, LucasGover, HenryNorton © 2020</p>
                          </div>
                          <ul>
                            <li><a href="menu_redirector.php">Home</a></li>
                            <li style="float:right"><a href="login.php">Log Out</a></li>
                            <li style="float:right"><a class="active" href="userinfo.php">Profile</a></li>
                            <li style="float:left"><a href="basicLessons.php">Basic Lessons</a></li>
                          </ul>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Games</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Crazy Cars</p>
                                        <h6 class="text-muted f-w-400">Number of Correct Questions</h6>
                                        <div class="box">
                                            <p><?php echo $carRight?></p>
                                        </div>
                                        <h6 class="text-muted f-w-400">Number of Incorrect Questions</h6>
                                        <div class="box">
                                            <p><?php echo $carWrong?></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Change it Up</p>
                                        <h6 class="text-muted f-w-400">Number of Correct Questions</h6>
                                        <div class="box">
                                            <p><?php echo $coinRight?></p>
                                        </div>
                                        <h6 class="text-muted f-w-400">Number of Incorrect Questions</h6>
                                        <div class="box">
                                            <p><?php echo $coinWrong?></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Fine Line</p>
                                        <h6 class="text-muted f-w-400">Number of Correct Questions</h6>
                                        <div class="box">
                                            <p><?php echo $lineRight?></p>
                                        </div>
                                        <h6 class="text-muted f-w-400">Number of Incorrect Questions</h6>
                                        <div class="box">
                                            <p><?php echo $lineWrong?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</center>
