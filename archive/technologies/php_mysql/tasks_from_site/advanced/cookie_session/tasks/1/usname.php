<?php
date_default_timezone_set('Europe/Moscow');

if(isset($_POST['name'])){
	session_start();
	$_SESSION['name'] = $_POST['name'];
	header('Location: hello.php');
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
				<input type="text" name="name" placeholder="Ваше имя">
				<input type="submit">
			</form>
			<a href="hello.php">hello</a>
		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/auth/rabota-s-sessiyami-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>