//Hello world!!!123
//папаавпвапвапвап

random = Math.floor(Math.random() * (18 - 1 + 1)) + 1;

document.querySelector('html').style.backgroundImage = 'url("img/0 ('+random+').png")';

speed = 0.5;
speed2 = 1;

html = document.querySelector('html');
html.onmousemove = function (event) {


    let centerY = window.innerHeight/2;
    let centerX = window.innerWidth/2;
    /*pageX = event.pageX;//положение курсора относительно размеров страницы
    pageY = event.pageY;//положение курсора относительно размеров страницы
    scrY = event.screenY;//положение курсора относительно экрана монитора
    scrX = event.screenX;//положение курсора относительно экрана монитора*/
    let scrY2 = event.clientY;//положение курсора относительно размеров окра браузера
    let scrX2 = event.clientX;//положение курсора относительно размеров окра браузера
    let distFromCenterY = centerY - scrY2;
    let distFromCenterX = centerX - scrX2;
    document.querySelector('html').style.backgroundPosition = (centerX - distFromCenterX*-speed) +'px '+ (centerY - distFromCenterY*-speed) + 'px';

    document.querySelector('.circle').style.top = (centerY - distFromCenterY*-speed2 - 100) +'px';
    document.querySelector('.circle').style.left = (centerX - distFromCenterX*-speed2 - 100) +'px';
};


function showDisplayParams(rewrite) {
    let el = document.getElementById('displayParamsContainer');
    let created = false;
    if (!el) {
        el = document.createElement('pre');
        el.id = 'displayParamsContainer';
        el.style.display = 'block'
        el.style.position = 'absolute'
        el.style.top = '15px';
        el.style.left = '15px';
        el.style.background = 'white';
        el.style.padding = '15px';
        el.style.fontFamily = 'monospace';
        el.onclick = function () {
            this.innerHTML = '';
        }
        created = true
    }
    let itemWrap = document.createElement('div');
    itemWrap.classList.add('displayParamsItemWrap');
    itemWrap.innerHTML += 'availHeight: ' + screen.availHeight + '<br>';
    itemWrap.innerHTML += 'availWidth: ' + screen.availWidth + '<br>';
    itemWrap.innerHTML += 'colorDepth: ' + screen.colorDepth + '<br>';
    itemWrap.innerHTML += 'width: ' + screen.width + '<br>';
    itemWrap.innerHTML += 'height: ' + screen.height + '<br>';
    itemWrap.innerHTML += 'pixelDepth: ' + screen.pixelDepth + '<br>';
    itemWrap.innerHTML += 'devicePixelRatio: ' + devicePixelRatio + '<br>';
    if (rewrite) {
        el.innerHTML = '';
    }
    el.appendChild(itemWrap);
    if (created) {
        document.body.appendChild(el);
    }
}
window.addEventListener('load', function () {
   showDisplayParams(1);
});
window.addEventListener('resize', function () {
    showDisplayParams(1);
});