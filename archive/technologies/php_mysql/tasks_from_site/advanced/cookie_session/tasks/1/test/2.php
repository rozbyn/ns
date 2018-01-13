<?php
date_default_timezone_set('Europe/Moscow');
session_start();
if(isset($_POST['ans2']) && !empty($_POST['ans2'])){
	$_SESSION['ans2'] = $_POST['ans2'];
	header('Location: 3.php');
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
			<form action="" method="POST">
				<p>Вопрос 2. Сколько будет 6+2?</p>
				<input type="text" name="ans2" placeholder="Ответ">
				<input type="submit">
			</form>
		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/auth/rabota-s-sessiyami-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>