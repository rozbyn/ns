<?php
date_default_timezone_set('Europe/Moscow');
if (isset($_POST['username']) && !empty($_POST['username'])){
	setcookie("username",$_POST['username'], time() + 1800); 
	header('Location: hellouser.php');
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
				<input type="text" name="username">
				<input type="submit">
			</form>
		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/auth/rabota-s-cookie-na-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>