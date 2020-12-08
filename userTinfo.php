<link rel="stylesheet" href="creativeProfile.css">

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
                            <li style="float:right"><a class="active" href="userinfo.html">Profile</a></li>
                            <li style="float:left"><a href="basicLessons.html">Basic Lessons</a></li>
                          </ul>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Student Lists</p>
                                        <div>
                                            <button class='button button2'><a href="studentLists.php">Students</a></button>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Teacher List</p>
                                        <div>
                                            <button class='button button2'><a href="teacherLists.php">Teachers</a></button>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Games</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Select Game Difficulty</p>
                                        
                                        <form action="" method="POST">
                                            <button name="click" class="button button2">Easy</button>
                                        </form>
                                        <?php
                                            if(isset($_POST['click'])) {
                                                $easy_locked = 1;
                                                echo "Easy has been set";
                                            }
                                        ?>
                                        <div>
                                            <button class='button button2'><a>Medium</a></button>
                                        </div>
                                        <div>
                                            <button class='button button2'><a>Hard</a></button>
                                        </div>
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