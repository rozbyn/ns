<?php
date_default_timezone_set('Europe/Moscow');
session_start();
if(isset($_SESSION['ans1'])){
	echo 'Вопрос 1. Сколько будет 3+3?' . ' Вы ответили: '.$_SESSION['ans1'].'<br>';
}
if(isset($_SESSION['ans2'])){
	echo 'Вопрос 2. Сколько будет 6+2?' . ' Вы ответили: '.$_SESSION['ans2'].'<br>';
}
if(isset($_SESSION['ans3'])){
	echo 'Вопрос 3. Сколько будет 1+2?' . ' Вы ответили: '.$_SESSION['ans3'].'<br>';
}
session_destroy();
echo '<a href="1.php">1.php</a><br>';

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