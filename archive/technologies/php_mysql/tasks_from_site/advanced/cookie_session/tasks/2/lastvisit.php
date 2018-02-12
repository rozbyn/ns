<?php
date_default_timezone_set('Europe/Moscow');

if (isset($_COOKIE['lastvisit']) ){
	$timePassed = time() - $_COOKIE['lastvisit'];
	$timePassed = time() - 677289600;
	$years = floor($timePassed/31556926);
	$a = $timePassed%31556926;
	$months = floor($a/2629743);
	$a = $timePassed%2629743;
	$days = floor($a/86400);
	$a = $timePassed%86400;
	$hours = floor($a/3600);
	$a = $timePassed%3600;
	$min = floor($a/60);
	$a = $timePassed%60;
	$seconds = $a;
	echo 'Вы не были на сайте:' . '<br>';
	echo "$years лет, $months месяцев, $days дней, $min минут, $seconds секунд." . '<br>';
}
setcookie("lastvisit",time(), time()+31104000);
if(isset($_GET['clearCookie']) && $_GET['clearCookie'] === '1'){
	setcookie("nobanner",'', time());
	setcookie("count",'', time());
	setcookie("PHPSESSID",'', time());
	setcookie("lastvisit",'', time());
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

			<a href="?clearCookie=1" style="float: right;">Clear cookie</a>
		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/auth/rabota-s-cookie-na-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>