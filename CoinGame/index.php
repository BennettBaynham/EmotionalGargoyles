<!DOCTYPE html>
<?php     //Block to make sure there is a user logged in
    include "../my_functions.php";
		my_session_start();
		if(!isset($_SESSION['u_name'])){
			header("Location:../login.php");
    }
?>


<html>
<link rel="stylesheet" href="CoinStyle.css">
  <head>
    <style>
      h1 {text-align: center;}
      p {text-align: center; font-size: 30px; margin:0;}  
      .disp { 
        position:absolute;
        right:50%; /* Positions 50% from right (right edge will be at center) */
        margin-right:30px; /* Positions 200px to the left of center */
      }
      #outer,#options
      {
        width:100%;
        text-align: center;
      }
      .inner
      {
        display: inline-block;
      }
      body {
        background-color: #2591bb;
      }
    </style>
    <ul id="bar"><!--Website navigation bar at the top of the page-->
         <li style="float:left"><a href="../menu_redirector.php">Home</a></li>
         <li style="float:left"><a href="../basicLessons.html">Basic Lessons</a></li>
         <li style="float:right"><a href="../login.php">Log Out</a></li>
         <li style="float:right"><a href="../userinfo.html">Profile</a></li> 
    </ul>
  </head>

  <body>
    <h1 class="titleText">Change It Up</h1>
    <div id="outer">
      <div class="inner"><button type="submit" onClick="runGame()" >Start Game</button></div>
      <div class="inner"><button type="submit" onClick="submit()">Submit Answer</button></div>
    </div>
    <div id="options"style="display: none">
      <div class="inner"><input name="difficulty" type="radio" checked value=1>Easy</input></div>
      <div class="inner"><input name="difficulty" type="radio" value=2>Normal</input></div>
      <div class="inner"><input name="difficulty" type="radio" value=3>Hard</input></div>
    </div>
    <div clear="none" style="overflow: hidden;">
      <p class="disp">Pennies: </p>
      <p id="penny">0</p>
    </div>

    <div clear="none" style="overflow: hidden;">
      <p class="disp">Nickels: </p>
      <p id="nickel">0</p>
    </div>

    <div margin="0" style="overflow: hidden;">
      <p class="disp">Dimes: </p>
      <p id="dime">0</p>
    </div>

    <div style="overflow: hidden;">
      <p class="disp">Quarters: </p>
      <p id="quarter">0</p>
    </div>

    <div style ="overflow:hidden;">
      <p class="disp">Target: </p>
      <p id="target">0</p>
    </div>

    <div id="img-container" style="text-align: center";>
      <img width="212" height="212" src="penny.png" alt="Penny" onclick="penny()"/>
      <img width="236" height="236" src="nickel.png" alt="Nickel" onclick="nickel()"/>
      <img width="200" height="200" src="dime.png" alt="Dime" onclick="dime()"/>
      <img width="270" height="270" src="quarter.png" alt="Quarter" onclick="quarter()"/>
    </div>
    <div id="correct" style="display: none;">
      <p>Congratulations, you are correct!<br>Hit "Start Game" to play again!</p>
    </div>

    <div id="answers"  style="display: none;">
      <div clear="none" style="overflow: hidden;">
        <br>
        <p>Incorrect!</p>
        <br>
        <p>Correct Answer:</p>
        <p class="disp">Pennies: </p>
        <p id="pennyAnswer">0</p>
      </div>

      <div clear="none" style="overflow: hidden;">
        <p class="disp">Nickels: </p>
        <p id="nickelAnswer">0</p>
      </div>

      <div style="overflow: hidden;">
        <p class="disp">Dimes: </p>
        <p id="dimeAnswer">0</p>
      </div>

      <div style="overflow: hidden;">
        <p class="disp">Quarters: </p>
        <p id="quarterAnswer">0</p>
      </div>

      <div style="overflow: hidden;">
        <p text-align="center">Hit "Start Game" to play again!</p>
      </div>
    </div>
	</body>
</html>
<script >
var username = "<?php echo $_SESSION['u_name']?>";
var difficulty = "<?php echo gameDifficulty('coinD')?>";
var setting = difficulty;
var pennyClicks = 0;
var nickelClicks = 0;
var dimeClicks = 0;
var quarterClicks = 0;
var quarterNum = 0;
var dimeNum = 0;
var nickelNum =0;
var pennyNum = 0;
var game = 0;
var num;
if(difficulty == 0){
    var x = document.getElementById("options");
    x.style.display = "block";
}


function runGame(){
  if(game == 0){
    var x = document.getElementById("img-container");
    x.style.display = "block";
    x = document.getElementById("correct");
    x.style.display = "none";
    x = document.getElementById("answers");
    x.style.display = "none";
    quarterClicks = 0;
    dimeClicks=0;
    nickelClicks=0;
    pennyClicks=0;
    quarterNum = 0;
    dimeNum = 0;
    nickelNum = 0;
    pennyNum=0;
    game = 1;//1 if game is running.
    document.getElementById("penny").innerHTML = pennyClicks;
    document.getElementById("nickel").innerHTML = pennyClicks;
    document.getElementById("dime").innerHTML = pennyClicks;
    document.getElementById("quarter").innerHTML = pennyClicks;
    if(setting == 0){
      difficulty = document.querySelector('input[name = "difficulty"]:checked').value;
    }
    num = generateNum(difficulty);//edit with difficulty setting
    document.getElementById("target").innerHTML = num + "¢";

    while(25 <= num){
      quarterNum++;
      num=num-25;
    }
    while(10 <= num){
      dimeNum++;
      num=num-10;
    }
    while(5 <= num){
      nickelNum++;
      num=num-5;
    }
    while(1 <= num){
      pennyNum++;
      num=num-1;
    }
  }
}

function  win(){
    game = 0;
    var x = document.getElementById("img-container");
    x.style.display = "none";
    x = document.getElementById("correct");
    x.style.display = "block";
    var outcome = "coin" + difficulty + "W";
    var data_arr = {
      tag: username,
      message: outcome,
      method: 'gameResult'
    } 
    $ajax({
      url: '../my_functions.php',
      data: data_arr
    })
    
}

function lose() {
    game = 0;
    var x = document.getElementById("img-container");
    x.style.display = "none";
    x = document.getElementById("answers");
    document.getElementById("pennyAnswer").innerHTML = pennyNum;
    document.getElementById("nickelAnswer").innerHTML = nickelNum;
    document.getElementById("dimeAnswer").innerHTML = dimeNum;
    document.getElementById("quarterAnswer").innerHTML = quarterNum;
    x.style.display = "block";
    var outcome = "coin" + difficulty + "L";
    var data_arr = {
      tag: username,
      message: outcome,
      method: 'gameResult'
    }
    $ajax({
      url: '../my_functions.php',
      data: data_arr
    })
} 


function submit(){
  if(game == 1){
    if(pennyClicks==pennyNum && nickelClicks == nickelNum && dimeClicks == dimeNum && quarterClicks == quarterNum){
      win();
    }else{
      lose();
    }
  }
}

function penny(){
  if(game ==  1){
      pennyClicks++;
      document.getElementById("penny").innerHTML = pennyClicks;
  }
}

function nickel(){
    if(game ==  1){
        nickelClicks++;
        document.getElementById("nickel").innerHTML = nickelClicks;
    }
}
function dime(){
    if(game ==  1){
        dimeClicks++;
        document.getElementById("dime").innerHTML = dimeClicks;
    }
}
function quarter(){
    if(game ==  1){
        quarterClicks++;
        document.getElementById("quarter").innerHTML = quarterClicks;
    }
}




function generateNum(difficulty){//3 = hard, 2 = normal, 1 = easy.
        if(difficulty == 1){
            return Math.floor(Math.random() * (50 - 10 + 1)) + 10;
        }else if(difficulty == 2){
            return Math.floor(Math.random() * (100 - 10 + 1)) + 10;
        }else if(difficulty == 3){
          return Math.floor(Math.random() * (200 - 10 + 1)) + 10;
      }
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