var canvas = document.getElementById("canvas")
var ctx = canvas.getContext("2d")

//vars for images used
var grass = new Image()
grass.src = "images/grass.jpg"

var finishLine = new Image()
finishLine.src = "images/finishLine.jpg"

//vars for common coordinates/measurements
var border = 3;
var lineWidth = 25//start/finish line width
var lineHeight = 120//start/finish line and road height
var ycenter = canvas.height/2//center y coordinate

/**
 * Master function to run the game
 */
function runGame(){
    drawBackground();
}

/**
 * Fills the game background
 */
function drawBackground() {
    //color whole canvas yellow (used as border)
    ctx.fillStyle = '#FFFF00'
    ctx.fillRect(0, 0, canvas.width, canvas.height)

    //grass background, with a 3px border on all sides 
    ctx.drawImage(grass, border, border, canvas.width-(2*border), canvas.height-(2*border))
    
    //road
    ctx.fillStyle = '#242608'
    ctx.fillRect(border, ycenter-(lineHeight/2), canvas.width-(2*border), lineHeight)

    //center lines
    var counter = 0
    ctx.fillStyle = '#BAC60E'
    for(i = 5; i <= canvas.width-(border+20); i += 30){//repeats from near the left until one before the final line
        ctx.fillRect(i, ycenter-3, 20, 6)
        counter = i + 30
    }
    if(counter < canvas.width - border){
        ctx.fillRect(counter, ycenter-3, (canvas.width-border)-counter, 6)
    }

    //start/finish lines
    ctx.drawImage(finishLine, border+70, ycenter-(lineHeight/2), lineWidth, lineHeight)//starting line
    ctx.drawImage(finishLine, canvas.width-(border+70+lineWidth), ycenter-(lineHeight/2), lineWidth, lineHeight)//finish line
}

runGame();