function test() {
	switch (now.getMonth()) {
			case 0:
				b="Январь";
				break;
			case 1:
				b="Февраль";
				break;
			case 2:
				b="Март";
				break;
			case 3:
				b="Апрель";
				break;
			case 4:
				b="Май";
				break;
			case 5:
				b="Июнь";
				break;
			case 6:
				b="Июль";
				break;
			case 7:
				b="Август";
				break;
			case 8:
				b="Сентябрь";
				break;
			case 9:
				b="Октябрь";
				break;
			case 10:
				b="Ноябрь";
				break;
			case 11:
				b="Декабрь";
				break;
			default:
				b="Жопа";
		}
		

	
}
function task1() {
	var a,b,c;
	a=parseInt(val1.value,10);
	b=parseInt(val2.value,10);
	c=b/a;
	document.getElementById('answer1').innerHTML = c*1000/60+ " м/с," + " " + c*60 + " км/ч,"
}
function task2() {
	document.getElementById('answer2').innerHTML = "Silence is golden"
}
function task3() {
	var now = new Date();
	var a,b;
	switch (now.getDay()) {
			  case 0:
				a="Воскресенье";
				break;
			  case 1:
				a="Понедельник";
				break;
			  case 2:
				a="Вторник";
				break;
			  case 3:
				a="Среда";
				break;
			  case 4:
				a="Четверг";
				break;
			  case 5:
				a="Пятница";
				break;
			  case 6:
				a="Суббота";
				break;
			  default:
				a="Жопа"
			}
	switch (now.getMonth()) {
		case 0:
			b="Январь";
			break;
		case 1:
			b="Февраль";
			break;
		case 2:
			b="Март";
			break;
		case 3:
			b="Апрель";
			break;
		case 4:
			b="Май";
			break;
		case 5:
			b="Июнь";
			break;
		case 6:
			b="Июль";
			break;
		case 7:
			b="Август";
			break;
		case 8:
			b="Сентябрь";
			break;
		case 9:
			b="Октябрь";
			break;
		case 10:
			b="Ноябрь";
			break;
		case 11:
			b="Декабрь";
			break;
		default:
			b="Жопа";
	}
	document.getElementById('answer3').innerHTML = a+'</br>'+b+'</br>'+"Авраам Сулейманов"
}
function task4() {
	var a,b,ans, ans2;

	a=parseFloat(val4_1.value);
	b=parseFloat(val4_2.value);
	ans=(a*(b/100)*5)+a;
	ans2=a*Math.pow((1+b/100/12),60);
	document.getElementById('answer4').innerHTML = "Без капитализации = " + '<b>'+ans+'</b>'+", С капитализацией раз в 1 месяц = "+ '<b>'+ans2+'</b>';
}
function task5() {

	document.getElementById('answer2').innerHTML = "Silence is golden"

}
