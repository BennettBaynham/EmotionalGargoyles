var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");

//general variables
var backdrop;//stores imageData of background
var scaler1 = 0.5;//variable used to change blue car speed
var scaler2 = 0.5;//variable used to change orange car speed

//variables to store math problem componenents
var num1; 
var num2;
var realAnswer;//correct answer to math problem
// var userAnswer;//user input

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
var correctWidth = 300;//'correct' variables determine dimensions of display for a correct answer
var correctHeight = 100;
var correctBorder = 3;
var correcty = ((canvas.height + ((lineHeight/2) + ycenter))/2) - (correctHeight/2)
//eraseResults stores the imageData of the space behind the results display area
var storeResults;

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
    document.getElementById("goBtn").addEventListener("click", getUserAnswer);
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
            
            drawProblem();
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
    num1 = Math.round(Math.random()*25);
    num2 = Math.round(Math.random()*25);
    realAnswer = num1 + num2;
    ctx.fillStyle = "#FF0000";
    ctx.fillRect(xcenter-(probWidth/2), yprob, probWidth, probHeight)//border
    ctx.fillStyle = "#FFFFFF";
    ctx.fillRect(xcenter-(probWidth/2)+probBorder, yprob + probBorder, probWidth-(2*probBorder), probHeight-(2*probBorder));
    ctx.fillStyle = "#000000";
    ctx.font = "50px Comic Sans MS";
    ctx.textAlign = "center";
    ctx.fillText(num1+" + "+num2, xcenter, yprob+probBorder+(probHeight*0.7), 0.75*probWidth)
   
    //store current math problem to display
    tempProblem = ctx.getImageData(xcenter-(probWidth/2), yprob, probWidth, probHeight);
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
        if((playerIndex - oldPlayerIndex) < (playerMoveTo - oldPlayerIndex)/2){//speed up for first half, slow down for second half
            console.log("added " + scaler1 + " to playerIndex (speeding up)")
            scaler1 += 0.25;
        }
        else{
            console.log("added " + scaler1 + " to playerIndex (slowing down)")
            scaler1 -= 0.25;
        }
   
        redrawBackground(1);
        drawCars();
        window.requestAnimationFrame(movePlayer);
    }
    else{
        playerMoveTo += Math.floor(distance/5);
        scaler1 = 0.5;
        console.log("scaler1 reset")
        console.log("playerMoveTo += distance/5")
        if(playerIndex >= canvas.width-(70+lineWidth+(carWidth/2))){//Player victory
            alert("YOU WIN!")
            document.getElementById("goBtn").removeEventListener("click", getUserAnswer);
        }
    }
}

/**
 * Move the cpu's car
 */
function moveCpu(){
    if(cpuIndex < cpuMoveTo){
        if((cpuIndex - oldCpuIndex) < (cpuMoveTo - oldCpuIndex)/2){//speed up for first half, slow down for second half
            console.log("added " + scaler2 + " to cpuIndex (speeding up)")
            scaler2 += 0.25;
            cpuIndex += scaler2;
        }
        else{
            cpuIndex += scaler2;
            console.log("added " + scaler2 + " to cpuIndex (slowing down)")
            scaler2 -= 0.25;
        }
   
        redrawBackground();
        drawCars();
        window.requestAnimationFrame(moveCpu);
    }
    else{
        cpuMoveTo += Math.floor(distance/8);
        scaler2 = 0.5;
        console.log("scaler2 reset")
        console.log("cpuMoveTo += distance/8")
        drawProblem();
        if(cpuIndex >= canvas.width-(70+lineWidth+(carWidth/2))){//CPU victory
            alert("Game Over!")
            document.getElementById("goBtn").removeEventListener("click", getUserAnswer);
        }
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
        oldCpuIndex = cpuIndex;
        moveCpu();
    }
    else if(document.getElementById("ans").value == realAnswer){//correct answer
        drawCorrect();
        oldPlayerIndex = playerIndex;
        movePlayer();
        oldCpuIndex = cpuIndex;
        moveCpu();
    } 
    document.getElementById("ans").value = null;
}

main();