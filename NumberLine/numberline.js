var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");

//var bg = new image();

//bg.src = "images/bg.jpg";
/**

//Load Imgaes
var wavesImage = new Image();
pirateImage.src = "images/pirateImage.png";

load and use sounds:

var fly = new Audio();
var scor = new Audio();

fly.src = "sounds/fly.mp3";
scor.src = "sounds/score.mp3";

*/

var wavesImage = new Image();
wavesImage.src = "images/wavesTemp.png";

var mapImage = new Image();
mapImage.src = "images/blankMap.png";

var currentNumber = 0;
var maxNumber = 25;
var minNumber = 0;
var targetNumber = Math.round(minNumber + ((maxNumber - minNumber) * Math.random()));
var treasureFound = false;
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

function moveLeft(){
	currentNumber -= 0.1;
	draw();
}
function moveRight(){
	currentNumber += 0.1;
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
	}
	draw();
}
function draw(){
	ctx.textAlign = 'center';
	drawBackground();
	drawMap();
		
	//ctx.drawImage(bg,0,0); // draws background

	//ctx.drawImage(fg,0,cvs.height - fg.height); // draws foreground
	
	//ctx.drawImage(pirate,bX,bY);
	drawIslands();
	drawMidWaves();
	drawBoat();
	//requestAnimationFrame(draw());
	if(treasureFound){
		win();
	}
	
}
function drawBackground() {
	ctx.fillStyle = '#7FAFFF';
	ctx.fillRect(0, 0, 1400, 600);
}
function drawIslands(){
	var i;
	for(i = 0; i < 11; i++){
		if((Math.round((currentNumber + 5 - i)) <= maxNumber) && (Math.round((currentNumber + 5 - i)) >= (minNumber))){
			ctx.fillStyle = '#FFFF00';
			ctx.fillRect((300 *  (Math.round(currentNumber) - currentNumber)) + (1770 - (300 * i)), 300,150,110);
			ctx.fillStyle = '#000000';
			ctx.fillText(Math.round(currentNumber + 5 - i), 75 + (300 * (Math.round(currentNumber) - currentNumber)) + (1770 - (300 * i)), 335);
		}
	}
}
function drawBoat(){
	ctx.fillStyle = '#AA9481';
	ctx.fillRect(320, 370, 115, 85);
	ctx.fillStyle = '#000000';
	ctx.font = "30px Arial";
	ctx.fillText("Boat", 372, 424);
}
function drawMap(){
	ctx.drawImage(mapImage,612,0);
	ctx.fillStyle = '#000000';
	ctx.font = "30px Arial";
	ctx.fillText(Math.round(targetNumber), 700, 75);
	//ctx.fillText(currentNumber, 690, 50);
}
function win(){
	ctx.fillStyle = '#CFAF3F';
	ctx.fillRect(0, 0, 1400, 600);
	ctx.fillStyle = '#000000';
	ctx.fillText('You Found the Treasure!!!', 700, 300);
}
function reset(){
	currentNumber = 0;
	maxNumber = 25;
	minNumber = 0;
	targetNumber = Math.round(minNumber + ((maxNumber - minNumber) * Math.random()));
	treasureFound = false;
	draw();
}
function drawMidWaves(){
	var i;
	for(i=0;i < 17; i++){
		ctx.drawImage(wavesImage, (142 * i - 284) + (426 * (Math.round(currentNumber) - currentNumber)),355);
	}
}
draw();
