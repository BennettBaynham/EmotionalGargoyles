<link rel="stylesheet" href="profileCreative.css">

<style>
.button {
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.button2 {background-color: #4899ad;} /* Blue */
</style>

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
			                        //echo $_GET['user'];
			                        my_session_start();
			                        if(isset($_SESSION['u_name'])){
				                        echo $_SESSION['u_name'];	
			                        }else{
				                        header("Location: login.php");
                                    }
                                    $users = getData("user.json");
                                    if(!array_key_exists($_SESSION['u_name'], $users)){//if there is a teacher with this id
                                        header("Location: menus/student_menu.php");
                                    }
		                        ?>
                                <p>Teacher</p> <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                            </div>
                        </div>
                        <div class="footer">
                            <p>HollyPotter, BenGamble, BennettBaynham, LucasGover, HenryNorton © 2020</p>
                          </div>
                          <ul id="bar">
                            <li><a href="menu_redirector.php">Home</a></li>
                            <li style="float:right"><a href="login.php">Log Out</a></li>
                            <li style="float:right"><a class="active" href="userTinfo.php">Profile</a></li>
                            <li style="float:left"><a href="basicLessons.html">Basic Lessons</a></li>
                          </ul>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Student Lists</p>
                                        <div>
                                            <button class='button button2'><a href="student_list.php">Students</a></button>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Teacher List</p>
                                        <div>
                                            <button class='button button2'><a href="teacherLists.php">Teachers</a></button>
                                        </div>
                                    </div> -->
                                </div>
                                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Games</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Select Game Difficulty</p>
                                        
                                        <form action="" method="POST">
                                            <button name="click1" class="button button2">Easy</button>
                                        </form>
                                        <?php
                                            if(isset($_POST['click1'])) {
                                                setDifficulty($_SESSION['u_name'], 1);
                                                echo "Easy difficulty has been set";
                                            } else {
                                                echo "";
                                            }
                                        ?>
                                        <form action="" method="POST">
                                            <button name="click2" class="button button2">Medium</button>
                                        </form>
                                        <?php
                                            if(isset($_POST['click2'])) {
                                                setDifficulty($_SESSION['u_name'], 2);
                                                echo "Medium difficulty has been set";
                                            } else {
                                                echo "";
                                            }
                                        ?>
                                        <form action="" method="POST">
                                            <button name="click3" class="button button2">Hard</button>
                                        </form>
                                        <?php
                                            if(isset($_POST['click3'])) {
                                                setDifficulty($_SESSION['u_name'], 3);
                                                echo "Hard difficulty has been set";
                                            } else {
                                                echo "";
                                            }
                                        ?>
                                        <form action="" method="POST">
                                            <button name="click4" class="button button2">Free</button>
                                        </form>
                                        <?php
                                            if(isset($_POST['click4'])) {
                                                setDifficulty($_SESSION['u_name'], 0);
                                                echo "The choice has been made available";
                                            } else {
                                                echo "";
                                            }
                                        ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Most Viewed Page</p>
                                        <h6 class="text-muted f-w-400">Dinoter husainm</h6>
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
