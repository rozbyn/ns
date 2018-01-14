<?php
date_default_timezone_set('Europe/Moscow');
session_start();
$count = 1;
if (isset($_SESSION['count'])){
	$count = ++$_SESSION['count'];
} else {
	$_SESSION['count'] = 1;
}
if (isset($_COOKIE['count'])){
	$_COOKIE['count']++;
	setcookie("count",$_COOKIE['count'], time()+80000);
	echo $_COOKIE['count'] . '<br>';
} else {
	setcookie("count",'1', time()+80000);
}


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
			Вы посетили наш сайт <?= $count ?> раз!
		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/auth/rabota-s-cookie-na-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>