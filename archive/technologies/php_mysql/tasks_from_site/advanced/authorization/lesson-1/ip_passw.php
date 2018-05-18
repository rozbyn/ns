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
$pass1 = '52e47c804g2:c707080f76ed2589cgb:';
if (isset($_POST['pass']) && encode($_POST['pass']) == $pass1){
	if ($_SERVER['REMOTE_ADDR']==='::1'){
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