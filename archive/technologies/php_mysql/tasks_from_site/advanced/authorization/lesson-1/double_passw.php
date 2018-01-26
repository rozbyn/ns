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
//echo encode('awds') . '<br>';
//echo encode('zxc') . '<br>';

session_start();


$pass1 = '52e47c804g2:c707080f76ed2589cgb:';
$pass2 = '7fb8437:f0d5fd5f4c7e8eg:c9b52:56';
if(isset($_SESSION['success']) && $_SESSION['success'] === true){
	echo 'Привет' . '<br>';
}

if(isset($_SESSION['fpas']) && $_SESSION['fpas'] === true){
	if(isset($_POST['pass'])){
		if(encode($_POST['pass']) == $pass2){
			session_destroy();
			session_start();
			$_SESSION['success']= true;
			echo '1Вход разрешен!' . '<br>';
		} else {
			session_destroy();
			echo '2Неверный пароль!' . '<br>';
		}
	} else {
		echo '3Неверный пароль!' . '<br>';
	}
} elseif (isset($_POST['pass'])){
	if(encode($_POST['pass']) == $pass1){
		$_SESSION['fpas'] = true;
		echo '4Неверный пароль!' . '<br>';
	} else {
		session_destroy();
		echo '5Неверный пароль!' . '<br>';	
	}
} else {
	echo 'Введите пароль!' . '<br>';
}


var_dump($_POST);
var_dump($_SESSION);




?>
<form action="" method="POST">
	Пароль<input type="password" name="pass"></br>
	<input type="submit" name="auth" value="Войти">
</form>