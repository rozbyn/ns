<?php
date_default_timezone_set('Europe/Moscow');
session_start();
if(isset($_SESSION['country'])){
	echo $_SESSION['country'] . '<br>';
}
if (isset($_SESSION['timestamp'])){
	$t = time() - $_SESSION['timestamp'];
	echo "Вы заходили $t секунд назад" . '<br>';
}
$_SESSION['timestamp'] = time();

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
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/auth/rabota-s-sessiyami-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>