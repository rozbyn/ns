<?php
date_default_timezone_set('Europe/Moscow');

//Запишем в куки с именем test значение 'Тест!':
setcookie('test', 'Тест!');

//Запишем куку на час (в часе 3600 секунд!):
setcookie("test","Тест!", time() + 3600); 

//Запишем куку на день (в сутках 3600*24 секунд!):
setcookie("test","Тест!", time() + 3600*24); 

//Запишем куку на месяц (в месяце 3600*24*30 секунд!):
setcookie("test","Тест!", time() + 3600*24*30); 

//Запишем куку на год (в году 3600*24*30*365 секунд!):
setcookie("test1","test3", time() + 3600*24*365); 



//Удалим куку, установив третий параметр в текущий момент времени:
setcookie('test', '', time());
echo $_COOKIE['test1'];

?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Cookie & Sessions</title>
   
</head>
<body >
	<div class="main">
		<div class="wrapper">

		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/books/php/auth/rabota-s-cookie-na-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>