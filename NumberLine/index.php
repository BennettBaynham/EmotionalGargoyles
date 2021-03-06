<?php     //Block to make sure there is a user logged in
    include_once "../my_functions.php";
		my_session_start();
		if(!isset($_SESSION['u_name'])){
			header("Location:../login.php");
        }
?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" href="stylesheet.css">
  <head>
    <ul id="bar"><!--Website navigation bar at the top of the page-->
         <li style="float:left"><a href="../menu_redirector.php">Home</a></li>
         <li style="float:left"><a href="../basicLessons.php">Basic Lessons</a></li>
         <li style="float:right"><a href="../login.php">Log Out</a></li>
         <li style="float:right"><a href="../userTinfo.php">Profile</a></li> 
    </ul>
  </head>

  <body onload="selectDifficulty()"> 
	  <center>
    <h2 class="titleText">NumberLine</h2>
    <div id="container">
      <canvas id="canvas" width="1400" height="600"></canvas>
		<!-- Difficulty menu at beginning of game -->
		<div class="menu" id="difMenu">
        <h2>Select Difficulty</h2>

        <ul id="ulMenu">
          <li id="liMenu">
            <button class="difMenuBtn" style="background-color: green">Easy</button>
          </li>
          <li id="liMenu">
            <button class="difMenuBtn" style="background-color: yellow">Medium</button>
          </li>
          <li id="liMenu">
            <button class="difMenuBtn" style="background-color: red">Hard</button>
          </li>
        </ul>

      </div>
      <!-- End of Game Menu -->
      <div class="menu" id="endMenu">
        <h2 id="resultText">Filler</h2>
        <h3 id="amountRight">x out of y correct</h3>
        <ul id="ulMenu">
          <li id="liMenu">
            <button class="endMenuBtn" id="replay">Play Again</button>
          </li>
          <li id="liMenu">
            <button class="endMenuBtn"><a href="../menu_redirector.php">Home</a></button>
          </li>
        </ul>
      </div>
      
      <!-- User input section at the bottom -->
      <ul>
		<li id="inputs"><button class="btn" id="resetBtn" onclick = "reset()">Reset</button></li>
		<li id="inputs"><button class="btn" id="doneBtn" onclick = "endGame()">Done</button></li>
      </ul>
    </div>
    </center>
  </body>
</html>
<script>

var username = "<?php echo $_SESSION['u_name']?>";
var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");
var difBtnArr = document.getElementsByClassName("difMenuBtn");//stores difficulty buttons

	/**
	* 
	* Variables from the User's information
	* 
	* difficulty can be 1 for easy 2 for medium and 3 for hard
	* 
	* num right is just number gotten correct
	* 
	* num wrong is, uhhhh pretty self explanitory at this point
	* 
	* All of these have getters and setters if needed, its getDifficulty(), setDifficulty() etc
	*/
	
	var difficulty = 0;
	var numRight = 0;
	var numWrong = 0;
	var difficultyLocked = false;
	var lock = "<?php echo gameDifficulty('lineD')?>";
	if(lock == 0){
  		var difficultyLocked = false;
	}else{
  		difficultyLocked = true;
	}
	
	var wavesImage = new Image();
	wavesImage.src = "images/wavesTemp.png";
	
	var mapImage = new Image();
  mapImage.src = "images/blankMap.png";
  
  var background = new Image();
	background.src = "images/background.png";

	var island = new Image();
  island.src = "images/island.PNG";
	
	var boat = new Image();
	boat.src = "images/boat.PNG";

  var rect = canvas.getBoundingClientRect();


var currentNumber = 0;
var maxNumber = 12;
var minNumber = 0;
var targetNumber = Math.round(minNumber + ((maxNumber - minNumber) * Math.random()));
var answers=[];
var treasureFound = false;
var gameStarted = false;
var problem = "";

function startGame(){
	document.getElementById("difMenu").style.display = "none";
	gameStarted = true;
	reset();

}
function endGame(){
	document.getElementById("resultText").innerHTML = "Nice Job Pirate!";
        var outcome = "car" + difficulty + "W";
        var data_arr = {
          tag: username,
          message: outcome,
          method: 'gameResult'
        } 
    $ajax({
          url: '../my_functions.php',
          data: data_arr
    })
	document.getElementById("amountRight").innerHTML =  numRight+" out of "+(numRight + numWrong)+" correct";
    //show menu
    document.getElementById("endMenu").style.display = "unset";
    //if user selects "play again", reload the page
    document.getElementById("replay").addEventListener("click", function(){
        document.location.reload();
	})
}

function selectDifficulty(){
	drawBackground();
    if(difficultyLocked == true){
        difficulty = lock;
        // ***add code here to get the assigned difficulty and store it in difficulty variable***
        // i.e.   difficulty = difficulty assigned by teacher
        document.getElementById("difMenu").style.display = "none";//hides difficulty menu
        setTimeout(function(){//this timeout gives the game time to load (might replace later)
            startGame();
        }, 1000);
    }
    
    difBtnArr[0].addEventListener("click", function(){
        difficulty = 1;//set easy difficulty (numbers are 1-10)
        startGame();
    });
    difBtnArr[1].addEventListener("click", function(){
        difficulty = 2;//set medium difficulty (numbers are 1-25)
        startGame();
    });
    difBtnArr[2].addEventListener("click", function(){
        difficulty = 3;//set hard difficulty (numbers can be any two-digit number)
        startGame();
    })
}

//detecting arrow key presses
document.addEventListener('keydown', function(e) {
	switch (e.keyCode) {
		case 32:
			//alert('left');
			space();
			break;
		case 37:
			//alert('left');
			moveLeft();
			break;
		case 38:
			moveUp();
			
		   //alert('up');
			break;
		case 39:
		moveRight();
			//alert('right');
			break;
		case 40:
			moveDown();
			//alert('down');
			break;
	}
});
document.addEventListener("mousemove", () => {
	draw();
	let mousex = event.clientX - rect.left; // Gets Mouse X
	let mousey = event.clientY - rect.top; // Gets Mouse Y
	if(mousex > 1100){
		currentNumber +=0.01;
	}
	if(mousex < 300){
		currentNumber -=0.01;
	}
});

function moveLeft(){
	currentNumber -= 0.05;
	draw();
}
function moveRight(){
	currentNumber += 0.05;
	draw();
}
function moveUp(){
	draw();
}
function moveDown(){
	draw();
}
function space(){
	if(Math.round(currentNumber) == Math.round(targetNumber)){
		treasureFound = true;
	}else{
    alert('No Treasure, sorry');
    numWrong++;
    console.log(getNumWrong())
	}
	draw();
}
function draw(){
	ctx.textAlign = 'center';
	drawBackground();

	if(gameStarted){
		drawMap();
		drawIslands();
		drawMidWaves();
		drawBoat();
		if(treasureFound){
			win();
		}
	}
}
function drawBackground() {
	ctx.drawImage(background,0,0);
}
function drawIslands(){
	var i;
	for(i = 0; i < 11; i++){
		if((Math.round((currentNumber + 5 - i)) <= maxNumber) && (Math.round((currentNumber + 5 - i)) >= (minNumber))){
			ctx.drawImage(island,(300 *  (Math.round(currentNumber) - currentNumber)) + (1770 - (300 * i)), 280);
			//ctx.fillStyle = '#FFFF00';
			//ctx.fillRect((300 *  (Math.round(currentNumber) - currentNumber)) + (1770 - (300 * i)), 300,150,110);
			ctx.fillStyle = '#000000';
			ctx.fillText(answers[Math.round(currentNumber + 5 - i)], 50 + (300 * (Math.round(currentNumber) - currentNumber)) + (1770 - (300 * i)), 335);
		}
	}
}
function drawBoat(){
	/** 
	ctx.fillStyle = '#AA9481';
	ctx.fillRect(220, 370, 250, 150);
	ctx.fillStyle = '#000000';
	ctx.font = "30px Arial";
	ctx.fillText("Boat", 372, 424);
	*/
	ctx.drawImage(boat, 120,210);
}
function drawMap(){
	ctx.drawImage(mapImage,552,0);
	ctx.fillStyle = '#000000';
  ctx.font = "30px Arial";
	ctx.fillText(problem, 700, 75);
	//ctx.fillText(currentNumber, 690, 50);
}
function win(){
	ctx.fillStyle = '#CFAF3F';
	ctx.fillRect(0, 0, 1400, 600);
	ctx.fillStyle = '#000000';
  ctx.fillText('You Found the Treasure!!!', 700, 300);
  numRight +=1;

}
function reset(){
	currentNumber = 0;
	targetNumber = Math.round(minNumber + ((maxNumber - minNumber) * Math.random()));
	switch(difficulty){
		case 1:
			problem = "" + targetNumber;
			var i;
			for(i = 0; i < maxNumber; i++){
				answers[i] = i;
			}
			break;
		case 2:
			problem = "" + targetNumber;
			var num1 = 0;
			var num2 = 0;
			var i;
			for(i = 0; i < maxNumber; i++){
				do{
				num1 = Math.round(Math.random() * maxNumber) - Math.round(Math.random() * maxNumber);
				num2 = Math.round(Math.random() * maxNumber) - Math.round(Math.random() * maxNumber);
				}while(num1 + num2 == targetNumber);
				if(num2 > 0){
					answers[i] = num1 + " + " + num2;
				}else{
					answers[i] = num1 + " - " + num2;
				}
			}
			num1 = Math.round(Math.random() * maxNumber) - Math.round(Math.random() * maxNumber);
			num2 = targetNumber - num1;
			if(num2 > 0){
					answers[targetNumber] = num1 + " + " + num2;
				}else{
					answers[targetNumber] = num1 + " - " + num2;
				}
			break;
		case 3:
			problem = "" + targetNumber;
			var num1 = 0;
			var num2 = 0;
			var i;
			for(i = 0; i < maxNumber; i++){
				do{
				num1 = Math.round(Math.random() * 10 * maxNumber) - Math.round(Math.random() * 10 * maxNumber);
				num2 = Math.round(Math.random() * 10 * maxNumber) - Math.round(Math.random() * 10 * maxNumber);
				}while(num1 + num2 == targetNumber);
				if(num2 > 0){
					answers[i] = num1 + " + " + num2;
				}else{
					answers[i] = num1 + " - " + num2;
				}
			}
			num1 = Math.round(Math.random() * 10 * maxNumber) - Math.round(Math.random() * 10 * maxNumber);
			num2 = targetNumber - num1;
			if(num2 > 0){
					answers[targetNumber] = num1 + " + " + num2;
				}else{
					answers[targetNumber] = num1 + " - " + num2;
				}
			break;
			
	}
	treasureFound = false;
	draw();
}
function drawMidWaves(){
	var i;
	for(i=0;i < 17; i++){
		ctx.drawImage(wavesImage, (142 * i - 284) + (426 * (Math.round(currentNumber) - currentNumber)),355);
	}
}
function getDifficulty(){
	 return difficulty;
 }
function getNumRight(){
	return numRight;
}
function getNumWrong(){
	return numWrong;
}
function setDifficulty(variable){
	difficulty = variable;
}
function setNumRight(variable){
   numRight = variable;
}
function setNumWrong(variable){
   numWrong = variable;
}

function $ajax({method = "get", url, data}){

/**Create an XMLHTTPRequest Object */
var xhr = new XMLHttpRequest();

if(data){
  data = querystring(data);
}

if(method == "get" & data != ""){
  url += "?" + data;
}

/**
 * Specifies the HTTP method to use (GET OR POST), the target URL,
 * and whether the request should be handled asynchronously (true or false)
 */
xhr.open(method, url, true);
// console.log(url);
xhr.send();
}

/**
Convert an object to query string
username=value1&password=pvalue query string
*/
function querystring(obj){
	var str = "";
	for(var key in obj){
  		str += key + "="+obj[key] + "&";
	}
	return str.substring(0, str.length-1);
}
	
</script>
