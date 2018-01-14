<?php
date_default_timezone_set('Europe/Moscow');
if (isset($_COOKIE['country']) && !empty($_COOKIE['country'])){
	echo $_COOKIE['country'] . '<br>';

	
}
setcookie("country",'', time());
setcookie("test",'', time());
setcookie("phone",'', time());
setcookie("age",mt_rand(10,70), time()+3600*24*365*10); 
$dayend = mktime(23, 59, 59);//до конца дня
$yearend = mktime(23, 59, 59, 12, 31);//до конца года
setcookie("age1",mt_rand(10,70), $dayend); 
setcookie("age2",mt_rand(10,70), $yearend); 


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
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/auth/rabota-s-cookie-na-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>