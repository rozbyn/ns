var c = 0;
function wow(){
	asd.innerHTML = 'Текущее время: ' + new Date().toLocaleString('ru', {hour: 'numeric',minute: 'numeric',second: 'numeric'}) +'<br>Секунд на сайте: '+c;
	asd.innerHTML += '<br>a = '+a+'<br>b = '+b;
	c++;
}
wow();
setInterval(wow, 1000);