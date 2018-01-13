<?php
date_default_timezone_set('Europe/Moscow');
session_start();
if(isset($_SESSION['refresh_times'])){
	$_SESSION['refresh_times'] = $_SESSION['refresh_times'] + 1;
	echo 'Вы обновляли страницу '. $_SESSION['refresh_times'] . ' раз<br>';
} else {
	$_SESSION['refresh_times'] = 0;
	echo 'Вы еще не обновляли страницу.<br>';
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

		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/auth/rabota-s-sessiyami-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>