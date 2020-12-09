<!DOCTYPE html>
<?php       //Block to make sure there is a user logged in
    include_once "my_functions.php";
		my_session_start();
		if(!isset($_SESSION['u_name'])){
			header("Location: login.php");
        }
?>


<!-- So basically the div called "dropDown" will contain all of the students assigned to the 
    teacher.  The teacher can select one and their stats will pop up. I will have it ready 
    with sample info, and I just need you to get it to loop through the actual students and 
    access the appropriate student's data -->

<style>
    /* id for ul in menu bar */
#bar {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #b1efff;
    box-shadow: 5px 5px 4px gray;
}

#bar li {
   float: left;
}

#bar li a {
   display: block;
   color: black;
   text-align: center;
   padding: 18px 20px;
   text-decoration: none;
}

#bar li a:hover:not(.active) {
   background-color: #4899ad;
}

.active {
   background-color: #4899ad;
}

/* style for the rest of the page */
body{
    background-color: #C2FFE0;
}

/* Student selection div */
#title{
    float: left;
    margin-top: 25px;
    width: fit-content;
    height: 30px;
    padding: 10px;
    background-color:  #b1efff;
    box-shadow: 5px 5px 4px gray;
}

/* for dropdown menu */
#dropDown{
    display: none;
    position: absolute;
    left: 112px;
    top: 125px;
    width: fit-content;
    background-color: white;
    border: 2px solid black;
    cursor: pointer;
}

/* For the button to select a student */
#select{
    background-color: white;
    padding: 5px;
    border: 2px solid black;
    border-radius: 7px;
    cursor: pointer;
}

h2{
    display: inline;
}

/* id used for buttons containing student names */
.student{
    display: block;
    margin: 0px;
    padding: 3px;
    background-color: white;
    border: none;
    cursor: pointer;

}

.stats{
    background-color: #FFFFC2;
    border: 5px solid black;
    border-radius: 15px;
    box-shadow: 5px 5px 4px gray;
}

.statTitle{
    margin: 0;
    padding: 5px;
}

#cars{
    position: absolute;
    left: 10%;
    top: 40%;
}

#coin{
    position: absolute;
    left: 50%;
    top: 40%;
    transform: translate(-50%);
}

#line{
    position: absolute;
    right: 10%;
    top: 40%;
}
</style>

<head>
    <ul id="bar"><!--Website navigation bar at the top of the page-->
        <li><a href="menu_redirector.php">Home</a></li>
         <li style="float:right"><a href="login.php">Log Out</a></li>
         <li style="float:right" class="active"><a href="userTinfo.php">Profile</a></li> 
         <li style="float:left"><a href="basicLessons.html">Basic Lessons</a></li>
    </ul>
</head>

<body>
    <div id="title">
        <h2>Student: </h2> 
        <button id="select">select student</button>
    </div>

    <!-- Students will go here in a dropdown menu -->
    <div id="dropDown">
        <button class="student">Sample student</button>
        <button class="student">Sample student 2</button>
    </div>


    <!-- Stats by game and difficulty -->
    <div class="stats" id="cars">
        <h1 class="statTitle">Crazy Car Stats<h1>
        <h1 class="statText" id="carEasy">Easy:</h1>
        <h1 class="statText" id="carMed">Medium:</h1>
        <h1 class="statText" id="carHard">Hard:</h1>
    </div>

    <div class="stats" id="coin">
        <h1 class="statTitle">Change It Up Stats<h1>
        <h1 class="statText" id="coinEasy">Easy:</h1>
        <h1 class="statText" id="coinMed">Medium:</h1>
        <h1 class="statText" id="coinHard">Hard:</h1>
    </div>

    <div class="stats" id="line">
        <h1 class="statTitle">Fine Line Stats<h1>
        <h1 class="statText" id="lineEasy">Easy:</h1>
        <h1 class="statText" id="lineMed">Medium:</h1>
        <h1 class="statText" id="lineHard">Hard:</h1>
    </div>


</body>



<script type="text/javascript">
var dropDown = document.getElementById("dropDown");
var select = document.getElementById("select");
var students = document.getElementsByClassName("student");//***THIS SHOULD GET STUDENTS LINKED TO TEACHER INSTEAD***

function main(){
    setDropDownListeners();
}



/**
 * Set up initial eventListeners for drop down menu funtion
*/
function setDropDownListeners(){
    //open and close the dropdown menu on hover
    select.addEventListener("mouseover", openDropDown);
    dropDown.addEventListener("mouseover", openDropDown);
    select.addEventListener("mouseout", closeDropDown);
    dropDown.addEventListener("mouseout", closeDropDown);

    //creates eventListeners for each student name in the dropdown menu
    var name;
    for(var i=0; i < students.length; i++){
        name = students[i].textContent;
        students[i].addEventListener("click", setSelected.bind(this, name))

    }
}

/**
 * Switches the stats and selected student text to the chosen student
*/
function setSelected(name){
    select.innerHTML = name;
    // USE NAME TO GET OTHER INFO FROM JSON FILE
    // USING SAMPLE INFO HERE
}

/**
 * displays the drop down menu for student selection
*/
function openDropDown(){
    dropDown.style.display = "unset";
}

/**
 * stops displaying the drop down menu for student selection
*/
function closeDropDown(){
    dropDown.style.display = "none";
}


var studentList= <?php echo json_encode(findStudents($_SESSION['u_name'])); ?>;
console.log(studentList['Horowitz']['coin1W']);//for example

main()
</script>

