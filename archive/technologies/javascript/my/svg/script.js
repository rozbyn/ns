


var l = document.getElementById('mainLine');
var svg = document.getElementById('svg');

window.addEventListener('resize', setViewBox);
function setViewBox() {
	svg.setAttribute('viewBox', '0 0 '+ ' ' + window.innerWidth + ' ' + window.innerHeight);
}
setViewBox();

var sub1 = document.getElementById('subLine1');
var sub2 = document.getElementById('subLine2');
var sub3 = document.getElementById('subLine3');
var perpL = document.getElementById('perpendLine');
var sD = document.getElementById('startDot');
var p1D = document.getElementById('point1Dot');
var p2D = document.getElementById('point2Dot');
var eD = document.getElementById('endDot');

var testP1 = document.getElementById('testPoint');
var testP2 = document.getElementById('testPoint2');

var startX = 50;
var startY = 50;

var point1X = 400;
var point1Y = 100;

var point2X = 500;
var point2Y = 25;

var endX = 50;
var endY = 200;


function makeLine() {
	correctPoints();
	
	var d = 'M'+startX+','+startY+' '+'C'+point1X+','+point1Y+' '+point2X+','+point2Y+' '+endX+','+endY;
	l.setAttribute('d', d);
	makeSubLinines();
	sD.setAttribute('cx', startX); sD.setAttribute('cy', startY);
	p1D.setAttribute('cx', point1X); p1D.setAttribute('cy', point1Y);
	p2D.setAttribute('cx', point2X); p2D.setAttribute('cy', point2Y);
	eD.setAttribute('cx', endX); eD.setAttribute('cy', endY);
}

function makeSubLinines() {
	var d1 = 'M'+startX+','+startY+' L'+point1X+','+point1Y;
	var d2 = 'M'+point2X+','+point2Y+' L'+endX+','+endY;
	var d3 = 'M'+startX+','+startY+' L'+endX+','+endY;
	sub1.setAttribute('d', d1);
	sub2.setAttribute('d', d2);
	sub3.setAttribute('d', d3);
}

function updatePoints() {
	startX = parseInt(sD.getAttribute('cx')); startY = parseInt(sD.getAttribute('cy'));

	point1X = parseInt(p1D.getAttribute('cx')); point1Y = parseInt(p1D.getAttribute('cy'));

	point2X = parseInt(p2D.getAttribute('cx')); point2Y = parseInt(p2D.getAttribute('cy'));

	endX = parseInt(eD.getAttribute('cx')); endY = parseInt(eD.getAttribute('cy'));
	
}


function correctPoints() {
	var dot = getMiddleDotCoords();
	var perpendDot = makePerpend();
	testP1.setAttribute('cx', dot.x); testP1.setAttribute('cy', dot.y);
	point1X = perpendDot.x;
	point2X = perpendDot.x;
	point1Y = perpendDot.y;
	point2Y = perpendDot.y;
}


var lineAngle = -50;

function getMiddleDotCoords() {
	var coord = {x:0, y:0};
	coord.x = (Math.abs(startX) + Math.abs(endX)) / 2;
	coord.y = (Math.abs(startY) + Math.abs(endY)) / 2;
	
//	console.log(hipoLenght);
	// https://www.matematicus.ru/vysshaya-matematika/analiticheskaya-geometriya-na-ploskosti/uravnenie-pryamoj-prohodyashhej-cherez-tochku-perpendikulyarno-k-pryamoj
	// http://www.mathelp.spb.ru/book1/line_on_plane.htm
	
	return coord;
}

function convertDegrToRads(deg) {
	return deg * Math.PI / 180;
}


function makePerpend() {	
	var midDot = getMiddleDotCoords();
	var k1 = (endY - startY) / (endX - startX);
			
	var dist = getDistanceBetweenTwoDots(startX, startY, endX, endY);
	var halfDist = dist / 2;
	
	var subAngle = (180 - Math.abs(lineAngle)) / 2;
	
	var cat1cat2rel = Math.tan(convertDegrToRads(subAngle));
	
	var cat2Lenght = halfDist * cat1cat2rel;
	
	var k2 = -1/(k1);
	
	
	
	
//	var perpDot2 = calcPerpendPoint(midDot.x, midDot.y, k2, cat2Lenght, -lineAngle);
	
	var temp;
	if(endX >= startX){
		var perpDot1 = calcPerpendPoint(midDot.x, midDot.y, k2, cat2Lenght, lineAngle);
	} else {
		var perpDot1 = calcPerpendPoint(midDot.x, midDot.y, k2, cat2Lenght, -lineAngle);
	}
	
//	var perp2X = 400;
//	var perp2Y = fX2(perp2X);
	
	testP2.setAttribute('cx', perpDot1.x); testP2.setAttribute('cy', perpDot1.y);
	
	var d1 = 'M'+perpDot1.x+','+perpDot1.y+' L'+midDot.x+','+midDot.y;
	perpL.setAttribute('d', d1);
	return {x:perpDot1.x, y: perpDot1.y};
}

function calcPerpendPoint(x, y, k, r, direction) {
	var coord = {x:0, y:0};
	direction = (direction > 0) ? 1 : -1; 
	coord.x = x + direction * (r*Math.sin(Math.atan(1/(k))));
	coord.y = y + direction * (r*Math.cos(Math.atan(1/(k))));
	return coord;
}



var downTarget = false;
var downOffset = {x:0,y:0};

function onDotMouseDown(e) {
//	console.log(e.type, e.target, e.pageX, e.pageY, e);
//	e.preventDefault();
	if(downTarget) {
		downTarget = false;
		return;
	}

	if(e.type === 'touchstart'){
		document.body.addEventListener('touchmove', draggin, {passive: false});
		document.body.addEventListener('touchend', endDrag, {passive: false});
		document.body.addEventListener('touchcancel', endDrag, {passive: false});
		e.pageX = e.changedTouches[0].pageX;
		e.pageY = e.changedTouches[0].pageY;
	} else {
		document.body.addEventListener('mousemove', draggin);
		document.body.addEventListener('mouseup', endDrag);
	}
	downTarget = e.target;
	downOffset.x = downTarget.getAttribute('cx') - e.pageX;
	downOffset.y = downTarget.getAttribute('cy') - e.pageY;
	


//	console.log(e, downOffset);
}


function draggin(e) {
//	e.preventDefault();
	if(!downTarget) return endDrag();
	if (e.type === 'touchmove') {
		e.pageX = e.changedTouches[0].pageX;
		e.pageY = e.changedTouches[0].pageY;
		
	}
	downTarget.setAttribute('cx', e.pageX + downOffset.x);
	downTarget.setAttribute('cy', e.pageY + downOffset.y);
	updatePoints();
	makeLine();
}


function endDrag(e) {
//	e.preventDefault();
	if(e.type === 'touchend' || e.type === 'touchcancel'){
		document.body.removeEventListener('touchend', endDrag);
		document.body.removeEventListener('touchcancel', endDrag);
		document.body.removeEventListener('touchmove', draggin);
	} else {
		document.body.removeEventListener('mouseup', endDrag);
		document.body.removeEventListener('mousemove', draggin);
	}
//	console.log(downTarget.getAttribute('cx'), downTarget.getAttribute('cy'));
	downTarget = false;

}


function getDistanceBetweenTwoDots(d1x, d1y, d2x, d2y) {
	var deltaX = Math.abs(Math.abs(d1x) - Math.abs(d2x));
	var deltaY = Math.abs(Math.abs(d1y) - Math.abs(d2y));
	
	var dist = Math.sqrt((Math.pow(deltaX, 2) + (Math.pow(deltaY, 2))));
	return dist;
}





sD.addEventListener('mousedown', onDotMouseDown);
p1D.addEventListener('mousedown', onDotMouseDown);
p2D.addEventListener('mousedown', onDotMouseDown);
eD.addEventListener('mousedown', onDotMouseDown);


sD.addEventListener('touchstart', onDotMouseDown, {passive: false});
p1D.addEventListener('touchstart', onDotMouseDown, {passive: false});
p2D.addEventListener('touchstart', onDotMouseDown, {passive: false});
eD.addEventListener('touchstart', onDotMouseDown, {passive: false});


makeLine();

function setAngle(angle) {
	lineAngle = angle;
	makeLine();
}