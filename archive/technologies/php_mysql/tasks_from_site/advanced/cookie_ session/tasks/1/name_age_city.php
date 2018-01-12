<?php
date_default_timezone_set('Europe/Moscow');
session_start();
if(isset($_POST['city']) && isset($_POST['age'])){
	$_SESSION['city'] = $_POST['city'];
	$_SESSION['age'] = $_POST['age'];
	echo '<a href="name_age_city2.php">name_age_city.php</a><br>';
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
				<input type="text" name="city" placeholder="city">
				<input type="text" name="age" placeholder="age">
				<input type="submit">
			</form>
		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/auth/rabota-s-sessiyami-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>