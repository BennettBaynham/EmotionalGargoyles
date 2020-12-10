<!DOCTYPE html>
<?php       //Block to make sure there is a user logged in
    include_once "my_functions.php";
		my_session_start();
		if(!isset($_SESSION['u_name'])){
			header("Location: login.php");
        }
        $users = getData("user.json");
        if(!array_key_exists($_SESSION['u_name'], $users)){//if there is a teacher with this id
            header("Location: menus/student_menu.php");
        }

        $studentList = findStudents($_SESSION['u_name']);
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
    <!-- ***THIS SHOULD CONTAIN ELEMENTS CREATED WITH STUDENT NAMES LINKED TO THE TEACHER*** -->
    <div id="dropDown">
        <!-- Elements are created here by the createStudentElements() function -->
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

var students;
var billyData = ["Billy", //***STAND IN FOR ACTUAL DATA FROM A STUDENT***
                                    
                    //right, wrong for carEasy, carMed, and carHard
                    6, 10,
                    8, 9,
                    10, 15,

                    //right, wrong for coinEasy, coinMed, and coinHard
                    1, 4,
                    12, 16,
                    8, 8,
                            
                    //right, wrong for lineEasy, lineMed, and lineHard
                    9, 10,
                    10, 12,
                    6, 9];

var sueData = ["Sue", //***STAND IN FOR ACTUAL DATA FROM A STUDENT***
                                    
                //right, wrong for carEasy, carMed, and carHard
                5, 12,
                10, 10,
                14, 15,
                
                //right, wrong for coinEasy, coinMed, and coinHard
                4, 6,
                10, 20,
                7, 10,
                                            
                //right, wrong for lineEasy, lineMed, and lineHard
                10, 11,
                5, 6,
                2, 4];
var studentList= <?php echo json_encode($studentList);?>;
console.log(studentList['bing']['coin1W']);
	
	
studentList = [billyData, sueData]//***THIS SHOULD GET STUDENT NAMES LINKED TO TEACHER INSTEAD***
function main(){
    createStudentElements()
    setDropDownListeners();
}

function createStudentElements(){
    var element;
    var location = document.querySelector('#dropDown');
    for(i=0; i<studentList.length; i++){
        element = document.createElement("BUTTON");
        element.className = "student";
        element.innerHTML = userData[i][0];
        location.appendChild(element);
    }
    students = document.getElementsByClassName("student");
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

    //creates eventListeners in the dropdown menu for each student name (using the created html elements) 
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
    console.log(name);
    // USE NAME TO GET OTHER INFO FROM JSON FILE
    // USING SAMPLE INFO HERE
    var currentData;
    for(i=0; i < userData.length; i++){
        if(userData[i][0] == name){
            currentData = userData[i];//get the array for selected user
        }
    }

    //alter the innerHTML of the stat blocks to include user data
    document.getElementById("carEasy").innerHTML = "Easy: "+currentData[11]+"/"+(currentData[11]+currentData[12]);
    document.getElementById("carMed").innerHTML = "Medium: "+currentData[13]+"/"+(currentData[13]+currentData[14]);
    document.getElementById("carHard").innerHTML = "Hard: "+currentData[15]+"/"+(currentData[15]+currentData[16]);
    document.getElementById("coinEasy").innerHTML = "Easy: "+currentData[4]+"/"+(currentData[4]+currentData[5]);
    document.getElementById("coinMed").innerHTML = "Medium: "+currentData[6]+"/"+(currentData[6]+currentData[7]);
    document.getElementById("coinHard").innerHTML = "Hard: "+currentData[8]+"/"+(currentData[8]+currentData[9]);
    document.getElementById("lineEasy").innerHTML = "Easy: "+currentData[18]+"/"+(currentData[18]+currentData[19]);
    document.getElementById("lineMed").innerHTML = "Medium: "+currentData[20]+"/"+(currentData[20]+currentData[21]);
    document.getElementById("lineHard").innerHTML = "Hard: "+currentData[22]+"/"+(currentData[22]+currentData[23]);    
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

main()
</script>

