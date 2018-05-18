<?php


?>

<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>form1</title>
</head>
<body>
	<?php
		$s = 0;
		if (isset($_REQUEST['login']) && isset($_REQUEST['pass'])){
			$s = 1;
			if($_REQUEST['login'] === 'root' && $_REQUEST['pass'] === '123'){
				echo 'Доступ открыт для пользователя '. $_REQUEST['login'] . '<br>';
				//system("rundll32.exe user32.dll, LockWorkStation");
			} else {
				echo "Доступ закрыт!" . '<br>';
			}
		}
		if (!$s) :
	?>
	<form action="" method="GET">
		<input type="text" name="login" value="<?= $_REQUEST['login'] ?? '' ?>">
		<input type="password" name="pass" value="<?= $_REQUEST['pass'] ?? '' ?>">
		<button type="submit" name="send" value="1">Вход</button>
	</form>
	<?php endif;?>
	Ваш IP-адрес: <?= $_SERVER['REMOTE_ADDR'] ?><br>
	Ваш браузер: <?= $_SERVER['HTTP_USER_AGENT'] ?><br>
</body>
</html>