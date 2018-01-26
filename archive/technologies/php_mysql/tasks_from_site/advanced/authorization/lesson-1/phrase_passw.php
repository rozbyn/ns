<?php

function encode($str){
	$md5arr = str_split(md5($str));
	$md5arr = array_map('ord', $md5arr);
	$md4arr = [];
	foreach ($md5arr as $val){
		$md4arr[] = $val%3+$val;
	}
	$md5arr = array_map('chr', $md4arr);
	return implode('', $md5arr);
}
echo encode('Я сегодня отлично поспал и поел тоже хорошо') . '<br>';




$pass1 = '38d9g2c3dce560be637d84750gge364e';
$pass2 = '2c:ff:2:8:6345g:4f3ed3384:47bd0e';
$login = '42434f498b78b7b853:95b0g5b:02fc3';
if(isset($_POST['auth'])){
	if(
		isset($_POST['login']) && encode($_POST['login']) == $login &&
		isset($_POST['pass1']) && encode($_POST['pass1']) == $pass1 &&
		isset($_POST['pass2']) && encode($_POST['pass2']) == $pass2
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
	Пароль2<input type="text" name="pass2"></br>
	<input type="submit" name="auth" value="Войти">
</form>