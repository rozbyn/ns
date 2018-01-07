//Hello world!!!123
//папаавпвапвапвап

random = Math.floor(Math.random() * (18 - 1 + 1)) + 1;

document.querySelector('html').style.backgroundImage = 'url("img/0 ('+random+').png")';

speed = 0.5;
speed2 = 1;

html = document.querySelector('html');
html.onmousemove = function (event) {
    /*client_w = document.body.clientWidth;
    client_h = document.body.clientHeight;

    height=screen.height;
    width=screen.width;

    wwidth = window.innerWidth;
    wheight = window.innerHeight;*/




    centerY = window.innerHeight/2;
    centerX = window.innerWidth/2;
    /*pageX = event.pageX;//положение курсора относительно размеров страницы
    pageY = event.pageY;//положение курсора относительно размеров страницы
    scrY = event.screenY;//положение курсора относительно экрана монитора
    scrX = event.screenX;//положение курсора относительно экрана монитора*/
    scrY2 = event.clientY;//положение курсора относительно размеров окра браузера
    scrX2 = event.clientX;//положение курсора относительно размеров окра браузера
    distFromCenterY = centerY - scrY2;
    distFromCenterX = centerX - scrX2;
    document.querySelector('html').style.backgroundPosition = (centerX - distFromCenterX*-speed) +'px '+ (centerY - distFromCenterY*-speed) + 'px';

    document.querySelector('.circle').style.top = (centerY - distFromCenterY*-speed2 - 100) +'px';
    document.querySelector('.circle').style.left = (centerX - distFromCenterX*-speed2 - 100) +'px';


    /*document.querySelector('html').style.backgroundPosition = -1*(event.pageX*speed) +'px '+ -1*(event.pageY*speed) + 'px';



    document.querySelector('h5').innerHTML = centerX +':'+ centerY;
    document.querySelector('h6').innerHTML = window.innerWidth +':'+ window.innerHeight;
    document.querySelector('h7').innerHTML = distFromCenterX +':'+ distFromCenterY;
    document.querySelector('h8').innerHTML = event.screenX +':'+ event.screenY;
    document.querySelector('h9').innerHTML = event.clientX +':'+ event.clientY;*/
};


