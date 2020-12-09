var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");

//VARIABLES FOR FORCING DIFFICULTY
/**
 * difficultyLocked should be true if the teacher has locked student difficulty.  I wasn't
 * sure how to get this, but the code can be written here instead of false. The variable 
 * called difficulty stores an int 1-3 (1=easy, 2=medium, 3=hard) to manage difficulty.
 * the selectDifficulty() function has a conditional at the beginning, where I thought it 
 * would make sense to put the code for retrieving the difficulty if it was assigned.
*/
var difficultyLocked = false;

//variables for game menus
var difBtnArr = document.getElementsByClassName("difMenuBtn");//stores difficulty buttons
var difficulty;//used to store/signal selected difficulty (1, 2, or 3)

//general variables
var backdrop;//stores imageData of background
var scaler1 = 0.5;//variable used to change blue car speed
var scaler2 = 0.5;//variable used to change orange car speed
var playerWon = false;//true when the user crosses the finish line
var cpuWon = false;//true when the cpu crosses the finish line

//variables to store math problem componenents
var num1; 
var num2;
var maxNum;//maximum number, determined by difficulty selection
var minNum;//minimum number, determined by difficulty selection
var realAnswer;//correct answer to math problem
var numCorrect = 0;//tracks the number of problems answered correctly
var numWrong = 0;//tracks the number of problems answered incorrectly
var numTotal = 0;//how many problems were answered total in a game

//vars for images used
var grass = new Image();
grass.src = "images/grass.jpg";

var finishLine = new Image();
finishLine.src = "images/finishLine.jpg";

var blueCar = new Image();
blueCar.src = "images/blueCar.png";
var orangeCar = new Image();
orangeCar.src = "images/orangeCar.png";

var tempProblem;//stores imageData of current problem to display

//vars for common coordinates/measurements
var lineWidth = 25;//start/finish line width
var lineHeight = 120;//start/finish line and road height
var ycenter = canvas.height/2;//center y coordinate
var xcenter = canvas.width/2;//center x coordinate
//math problem dimensions 
var probWidth = 250;//width of box for math problem
var probHeight = 100;//height of the box for math problem
var probBorder = 3;//border width for math problem box
var yprob = ((ycenter - (lineHeight/2))/2) - (probHeight/2)
//results dimensions
var correctWidth = 300;//called correct, but also ended up being used for incorrect results
var correctHeight = 100;//^^
var correctBorder = 3;//^^
var correcty = ((canvas.height + ((lineHeight/2) + ycenter))/2) - (correctHeight/2)//^^
var storeResults;//stores imageData for results 

//car data
var playerIndex = 2;//position of player's car
var cpuIndex = 2;//position of the "computer's" car
var oldPlayerIndex;//used in movePlayer() to store previous playerIndex
var oldCpuIndex;//used in moveCpu() to store previous cpuIndex
var carHeight = Math.floor((lineHeight/2) - 10);//vertical car dimension
var carWidth = Math.floor(carHeight*2);//horizontal car dimension
var finishCoord = canvas.width - carWidth//the position of the car that wins
var distance = finishCoord - 2;//total distance between starting position and finish position
var playerMoveTo = Math.floor(playerIndex + (distance/5));//the next target destination for the player to move to
var cpuMoveTo = Math.floor(cpuIndex + (distance/8));//the next target destination for the cpu to move to 

/**
 * Master function to run the game
 */
function main(){
    drawBackgroundInit();
    selectDifficulty();
}

/**
 * Creates eventListeners for each difficulty button
 */
function selectDifficulty(){
    if(difficultyLocked == true){
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

/**
 * Functionality between clicking difficulty button and game starting
 */
function startGame(){
    document.getElementById("difMenu").style.display = "none";
    switch(difficulty){
        case 1://easy (1-10 only)
            maxNum = 10;
            minNum = 1;
            break;
        
        case 2://medium (1-25)
            maxNum = 25;
            minNum = 1;
            break;

        case 3://hard (any two-digit numbers)
            maxNum = 99;
            minNum = 10;
            break;
    }
    drawReady();
}

/**
 * Prepares and opens the end of game menu
 */
function endGame(){
    //stop go button function
    document.getElementById("goBtn").removeEventListener("click", getUserAnswer);
    //fix text to reflect number of problems correct/completed
    document.getElementById("amountRight").innerHTML =  numCorrect+" out of "+numTotal+" correct";
    //show menu
    document.getElementById("endMenu").style.display = "unset";
    //if user selects "play again", reload the page
    document.getElementById("replay").addEventListener("click", function(){
        document.location.reload();
    })
}

/**
 * Draws the game background, cars, and math problem and stores background (not cars or
 *  problem) in backdrop.  Use this when first loading the page.
 */
function drawBackgroundInit() {
    //grass background
    grass.onload = function() {
        ctx.drawImage(grass, 0, 0, canvas.width, canvas.height);

        //road
        ctx.fillStyle = '#242608';
        ctx.fillRect(0, ycenter-(lineHeight/2), canvas.width, lineHeight);

        //center lines
        var counter = 0;//helps keep track of where the last line was drawn
        ctx.fillStyle = '#BAC60E';
        //repeats from near the left until one before the final line
        for(i = 5; i <= canvas.width - 20; i += 30){
            ctx.fillRect(i, ycenter-3, 20, 6);
            counter = i + 30;
        }
        //if necessary, draws the final partial dividing line
        if(counter < canvas.width){
            ctx.fillRect(counter, ycenter-3, canvas.width-counter, 6);
        }

        //start/finish lines
        finishLine.onload = function(){
            ctx.drawImage(finishLine, 70, ycenter-(lineHeight/2), lineWidth, lineHeight);//starting line
            ctx.drawImage(finishLine, canvas.width-(70+lineWidth), ycenter-(lineHeight/2), lineWidth, lineHeight);//finish line
            
            //store background in 'backdrop' before drawing cars
            backdrop = ctx.getImageData(0, 0, canvas.width, canvas.height)
            drawCars();
        }
    }
}

/**
 * Redraws the background during car movement to prevent trails on cars
 */
function redrawBackground(){
    ctx.putImageData(backdrop, 0, 0);
    ctx.putImageData(tempProblem, xcenter-(probWidth/2), yprob);
    ctx.putImageData(storeResults, xcenter-(correctWidth/2), correcty)
}

//currently not used, cars are drawn in drawBackground()
function drawCars(){
        ctx.drawImage(blueCar, playerIndex, ycenter + 5, carWidth, carHeight);
        ctx.drawImage(orangeCar, cpuIndex, ycenter - (5 + carHeight), carWidth, carHeight);
}

/**
 * draws the math problem onto the canvas
 */
function drawProblem(){
    //create pseudorandom integers between minNum and maxNum
    num1 = Math.round(Math.random()*(maxNum-minNum) + minNum);
    num2 = Math.round(Math.random()*(maxNum-minNum) + minNum);

    //determine addition or subtration
    var tempNum = Math.floor(Math.random()*9)//random int 0 <= int <= 9
    var operator;//keep track of current operation
    if(tempNum < 5){//choose addition 1/2 the time
        realAnswer = num1 + num2;
        operator = " + ";
    }
    else{//subtraction
        if(num2 > num1){//check number order
            tempNum = num1;
            num1 = num2;
            num2 = tempNum;
        }
        realAnswer = num1 - num2;
        operator = " - "
    }
    ctx.fillStyle = "#FF0000";
    ctx.fillRect(xcenter-(probWidth/2), yprob, probWidth, probHeight)//border
    ctx.fillStyle = "#FFFFFF";
    ctx.fillRect(xcenter-(probWidth/2)+probBorder, yprob + probBorder, probWidth-(2*probBorder), probHeight-(2*probBorder));
    ctx.fillStyle = "#000000";
    ctx.font = "50px Comic Sans MS";
    ctx.textAlign = "center";
    ctx.fillText(num1+operator+num2, xcenter, yprob+probBorder+(probHeight*0.7), 0.75*probWidth)
   
    //store current math problem to display
    tempProblem = ctx.getImageData(xcenter-(probWidth/2), yprob, probWidth, probHeight);
}

/**
 * Display "Ready? Set... GO!" at beginning of game and draw first problem
 */
function drawReady(){
    //draw background for text
    ctx.fillStyle = "#FF0000";
    ctx.fillRect(xcenter-(probWidth/2), yprob, probWidth, probHeight)//border
    ctx.fillStyle = "#FFFFFF";
    ctx.fillRect(xcenter-(probWidth/2)+probBorder, yprob + probBorder, probWidth-(2*probBorder), probHeight-(2*probBorder));
    //store blank background
    var temp = ctx.getImageData(xcenter-(probWidth/2), yprob, probWidth, probHeight);
    
    //display ready for 1 second
    ctx.fillStyle = "#FF0000";
    ctx.font = "50px Comic Sans MS";
    ctx.textAlign = "center";
    ctx.fillText("Ready?", xcenter, yprob+probBorder+(probHeight*0.7), 0.75*probWidth)

    setTimeout(function(){//display set... for 1 second
        ctx.putImageData(temp, xcenter-(probWidth/2), yprob);
        ctx.fillStyle = "#CDC82D"
        ctx.fillText("Set...", xcenter, yprob+probBorder+(probHeight*0.7), 0.75*probWidth);
        // startCars.play();
    }, 1000);

    setTimeout(function(){//display GO! for 1 second
        ctx.putImageData(temp, xcenter-(probWidth/2), yprob);
        ctx.fillStyle = "#00FF00"
        ctx.fillText("GO!", xcenter, yprob+probBorder+(probHeight*0.7), 0.75*probWidth);
    }, 2000);

    setTimeout(function(){//draw first problem
        drawProblem();
        document.getElementById("goBtn").addEventListener("click", getUserAnswer);
    }, 3000);
}

/**
 * Draws the display for a correct answer and stores the imageData in storeResults
 */
function drawCorrect(){
    ctx.fillStyle = "#FFFF00";
    ctx.fillRect(xcenter-(correctWidth/2), correcty, correctWidth, correctHeight);
    ctx.fillStyle = "#50D242"
    ctx.fillRect(xcenter-(correctWidth/2)+correctBorder, correcty+correctBorder,
                 correctWidth-(2*correctBorder), correctHeight-(2*correctBorder));
    ctx.fillStyle = "#000000";
    ctx.font = "50px Comic Sans MS";
    ctx.textAlign = "center";
    ctx.fillText("Correct!", xcenter, correcty+correctBorder+(correctHeight*0.7), 
                 0.75*correctWidth);
    storeResults = ctx.getImageData(xcenter-(correctWidth/2), correcty, correctWidth, correctHeight);
}

/**
 * Draws the display for an incorrect answer and stores the imageData in storeResults
 */
function drawIncorrect(){
    ctx.fillStyle = "#FFFF00";
    ctx.fillRect(xcenter-(correctWidth/2), correcty, correctWidth, correctHeight);
    ctx.fillStyle = "#FF0000"
    ctx.fillRect(xcenter-(correctWidth/2)+correctBorder, correcty+correctBorder,
                 correctWidth-(2*correctBorder), correctHeight-(2*correctBorder));
    ctx.fillStyle = "#000000";
    ctx.font = "50px Comic Sans MS";
    ctx.textAlign = "center";
    ctx.fillText(num1+" + "+num2+" = "+realAnswer, xcenter, correcty+correctBorder+(correctHeight*0.7), 
                 0.75*correctWidth);
    storeResults = ctx.getImageData(xcenter-(correctWidth/2), correcty, correctWidth, correctHeight);
}

/**
 * Move the player's car
 */
function movePlayer(){
    if(playerIndex < playerMoveTo){
        playerIndex += scaler1;
        if((playerIndex - oldPlayerIndex) < (playerMoveTo - oldPlayerIndex)/2){//speed up for first half 
            console.log("added " + scaler1 + " to playerIndex (speeding up)")
            scaler1 += 0.25;
        }
        else{//slow down for second half
            console.log("added " + scaler1 + " to playerIndex (slowing down)")
            scaler1 -= 0.25;
        }
   
        redrawBackground(1);
        drawCars();
        window.requestAnimationFrame(movePlayer);
    }
    else{//after animation is complete
        playerMoveTo += Math.floor(distance/5);
        scaler1 = 0.5;
        console.log("scaler1 reset")
        console.log("playerMoveTo += distance/5")
        console.log(numCorrect);
        if(playerIndex >= canvas.width-(70+lineWidth+(carWidth/2))){//Player crosses finishline
            playerWon = true;
        }
    }
}

/**
 * Move the cpu's car
 */
function moveCpu(){
    if(cpuIndex < cpuMoveTo){
        if((cpuIndex - oldCpuIndex) < (cpuMoveTo - oldCpuIndex)/2){//speed up for first half
            console.log("added " + scaler2 + " to cpuIndex (speeding up)")
            scaler2 += 0.25;
            cpuIndex += scaler2;
        }
        else{//slow down for second half
            cpuIndex += scaler2;
            console.log("added " + scaler2 + " to cpuIndex (slowing down)")
            scaler2 -= 0.25;
        }
        redrawBackground();
        drawCars();
        window.requestAnimationFrame(moveCpu);
    }
    else{//after animation is complete
        cpuMoveTo += Math.floor(distance/8);
        scaler2 = 0.5;
        console.log("scaler2 reset")
        console.log("cpuMoveTo += distance/8")
        drawProblem();
        if(cpuIndex >= canvas.width-(70+lineWidth+(carWidth/2))){//cpu crosses finishline
            cpuWon = true;
        }
    }
}

/**
 * Checks for win conditions, and declares player victory, cpu victory, or tie
 */
function winAlert(){
    if(playerWon == true && cpuWon == true){//tie
        document.getElementById("resultText").innerHTML = "Tie!";
        endGame();
    }
    else if(playerWon == true){//player won
        document.getElementById("resultText").innerHTML = "You Win!";
        endGame();
    }
    else if(cpuWon == true){//cpu won
        document.getElementById("resultText").innerHTML = "Game Over!";
        endGame();
    }
}

/**
 * Listens for a click of the "goBtn" button, then checks the user's answers and one or both
 * cars move forward
 */
function getUserAnswer(){
    if(document.getElementById("ans").value.length != 0 && 
    document.getElementById("ans").value != realAnswer){//answer present but incorrect
        drawIncorrect();
        numWrong++;
        oldCpuIndex = cpuIndex;
        moveCpu();
    }
    else if(document.getElementById("ans").value == realAnswer){//correct answer
        drawCorrect();
        numCorrect++;
        oldPlayerIndex = playerIndex;
        movePlayer();
        oldCpuIndex = cpuIndex;
        moveCpu();
    } 
    setTimeout(winAlert, 950);//waits for cars to be done moving then checks win conditions
    document.getElementById("ans").value = null;
    numTotal++;
}

main();//runs the master code in main()