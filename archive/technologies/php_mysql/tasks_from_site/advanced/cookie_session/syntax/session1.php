<?php
date_default_timezone_set('Europe/Moscow');


//Инициализируем сессию:
session_start();

//Пишем в сессию:
$_SESSION['test'] = 'Тест!';
echo $_SESSION['test'];
	/*
		Переменная $_SESSION['counter'] будет нашим счетчиком.
		Если скрипт запускается первый раз -
		она будет пуста, присвоим ей единицу.
		Если не первый раз - тогда прибавим единицу.
	*/
if (!isset($_SESSION['counter'])) {
	$_SESSION['counter'] = 1;
} else {
	$_SESSION['counter'] = $_SESSION['counter'] + 1;
}
echo 'Вы обновили эту страницу '.$_SESSION['counter'].' раз!';
unset($_SESSION['var']);
session_destroy();//После выполнения этой команды ВСЕ переменные сессии станут null



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
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/books/php/auth/rabota-s-sessiyami-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>