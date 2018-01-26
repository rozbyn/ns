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
echo $_SERVER['HTTP_USER_AGENT'] . '<br>';




//echo encode('awds') . '<br>';
$pass1 = '52e47c804g2:c707080f76ed2589cgb:';
if (isset($_POST['pass']) && encode($_POST['pass']) == $pass1){
	if ($_SERVER['HTTP_USER_AGENT']==='Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0'){
		echo 'Доступ разрешен!!!' . '<br>';
	} else {
		echo 'Ограничение по IP!' . '<br>';
	}
}










?>
<form action="" method="POST">
	Пароль<input type="password" name="pass"></br>
	<input type="submit" name="auth" value="Войти">
</form>