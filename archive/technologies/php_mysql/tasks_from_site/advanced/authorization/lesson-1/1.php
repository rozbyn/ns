<?php

$pass1 = '01f00836d59def3830c532bfe74aa63f';
$pass2 = '9f191b1e986e07c36e694001bc1117b5';
$login = '7815696ecbf1c96e6894b779456d330e';
if(isset($_POST['auth'])){
	if(
		isset($_POST['login']) && md5($_POST['login']) == $login &&
		isset($_POST['pass1']) && md5($_POST['pass1']) == $pass1 &&
		isset($_POST['pass2']) && md5($_POST['pass2']) == $pass2
		)
		{
		echo 'Всё ок!' . '<br>';
		
	} else {
		echo 'Пароли не совпадают' . '<br>';
	}
}


?>
<form action="" method="POST">
	Логин<input name="login"></br>
	Пароль1<input type="password" name="pass1"></br>
	Пароль2<input type="password" name="pass2"></br>
	<input type="submit" name="auth" value="Войти">
</form>