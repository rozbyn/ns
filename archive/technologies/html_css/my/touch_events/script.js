//Hello world!!!123
//папаавпвапвапвап

random = Math.floor(Math.random() * (18 - 1 + 1)) + 1;
//debug = document.getElementsByClassName('debug')[0];
// document.querySelector('html').style.backgroundImage = 'url("img/0 ('+random+').png")';

speed = 0.5;
speed2 = 1;

html = document.querySelector('html');
MoveMouse = function (event) {
	circleMove(event.clientX, event.clientY);
}


MoveTouch = function (event) {
	cx = event.targetTouches[0].clientX;
	cy = event.targetTouches[0].clientY;
	circleMove(cx, cy);
}
StartTouch = function (evt) {
	return 1;
	touches = evt.changedTouches;
	for (i = 0; i < touches.length; i++){
		debug.innerHTML = 'Start new touch: ' + touches[i].pageX + ' : ' + touches[i].pageY + '<br>' + debug.innerHTML;
	}
	
	//debug.innerHTML = '';
}
EndTouch = function (event) {
	
}
CancelTouch = function (event) {
	
}

circleMove = function (x, y) {
    centerY = window.innerHeight/2;
    centerX = window.innerWidth/2;
	
    distFromCenterY = centerY - y;
    distFromCenterX = centerX - x;
	
    document.querySelector('.circle').style.top = (centerY - distFromCenterY*-speed2 - 100) +'px';
    document.querySelector('.circle').style.left = (centerX - distFromCenterX*-speed2 - 100) +'px';
};
backgroundMove = function (x, y){
    centerY = window.innerHeight/2;
    centerX = window.innerWidth/2;
	distFromCenterY = centerY - y;
    distFromCenterX = centerX - x;
    document.querySelector('html').style.backgroundPosition = (centerX - distFromCenterX*-speed) +'px '+ (centerY - distFromCenterY*-speed) + 'px';
}

html.onmousemove = MoveMouse;
html.addEventListener('touchstart', StartTouch, false);
html.addEventListener('touchend', EndTouch, false);
html.addEventListener('touchcancel', CancelTouch, false);
html.addEventListener('touchmove', MoveTouch, false);

