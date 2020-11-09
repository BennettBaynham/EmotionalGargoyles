var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");

//var bg = new image();

//bg.src = "images/bg.jpg";
/**

//Load Imgaes
var pirateImage = new Image();
pirateImage.src = "images/pirateImage.png";

load and use sounds:

var fly = new Audio();
var scor = new Audio();

fly.src = "sounds/fly.mp3";
scor.src = "sounds/score.mp3";

*/

var targetNumber = 0;
var currentNumber = 0;
var maxNumber = 20;

var pirateX = 300; 
var pirateY = 100;

var CircleX = 100;
var CircleY = 100;

//detecting arrow key presses
document.addEventListener('keydown', function(e) {
	switch (e.keyCode) {
		case 37:
			//alert('left');
			moveLeft();
			console.log("LEFT");
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
			alert('down');
			break;
	}
});

function moveLeft(){
	CircleX -= 3;
	draw();
}
function moveRight(){
	CircleX += 3;
	draw();
}
function moveUp(){
	CircleY -= 3;
	draw();
}
function moveDown(){
	CircleY += 3;
	draw();
}

function draw(){
	

		
	ctx.fillStyle = "red";
	ctx.fillRect(0, 0, 800, 400);
	ctx.beginPath();
	ctx.arc(CircleX, CircleY, 95, 0, 2 * Math.PI, false);
	ctx.lineWidth = 10;
	ctx.strokeStyle = '#000000';
	ctx.stroke();
	
	//ctx.drawImage(bg,0,0); // draws background

	//ctx.drawImage(fg,0,cvs.height - fg.height); // draws foreground
	
	//ctx.drawImage(pirate,bX,bY);
	
	ctx.fillStyle = "#000";
	ctx.font = "20px Verdana";
	ctx.fillText("Score : "+score,10,cvs.height-20);
	
	console.log('AHHHH');
	
	
	requestAnimationFrame(draw);
}

draw();