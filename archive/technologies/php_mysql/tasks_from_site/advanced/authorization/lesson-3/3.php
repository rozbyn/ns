<?php
function login_validate($str){
	if(strlen($str)<15 and !preg_match('#^[0-9]+$#',$str)){
		if(preg_match('#^[a-z0-9]{1}(?:[a-z0-9]|(?:[-](?!-))|(?:[_](?!_)))+[a-z0-9]{1}$#i', $str)===1)return true;
	}
	return false;
}


//////////////////////
//Подключение к БД++++++++++++++++++++
$dbConfigFilePath = $_SERVER['DOCUMENT_ROOT'] . '/config/dbConfig.php';
if(!is_file($dbConfigFilePath)){
	exit('no db config');
}
$dbConfig = require_once $dbConfigFilePath;

$myDbObj = new mysqli($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
$myDbObj->set_charset("utf8");
//++++++++++++++++++++++++++++++++++++
$login = '';
$password = '';
$confirmPassword = '';
if(isset($_POST['register'])){
	$emptyFields = '';
	!empty($_POST['login'])?$login = $_POST['login']:$emptyFields.='1';
	!empty($_POST['pass'])?$password = $_POST['pass']:$emptyFields.='2';
	!empty($_POST['confirm-pass'])?$confirmPassword = $_POST['confirm-pass']:$emptyFields.='3';
	echo $password . '<br>';
	echo $myDbObj->real_escape_string($password) . '<br>';
	
	
	
	
	if (strlen($emptyFields) != 0){
		echo mb_substr(str_replace([1,2,3], ['логин, ', 'пароль, ', 'подтверждение пароля, '], 'Введите '.$emptyFields),0,-2) . '!<br>';
	} elseif($password != $confirmPassword) {
		echo 'Пароли не совпадают' . '<br>';
	} elseif(!login_validate($login)) {
		echo 'Введите корректный логин!' . '<br>';
	} else {
		$res = $myDbObj->query("SELECT * FROM users2 WHERE login='$login'");
		$res = mysqli_fetch_assoc($res);
		if(!empty($res)){
			echo 'Логин занят!' . '<br>';
		} else {
			$password = $myDbObj->real_escape_string($password);
			$res = $myDbObj->query("INSERT INTO users2 SET login='$login', password='$password', lastvisit='".time()."'");
			if ($res === false){
				echo 'Ошибка записи данных в бд. ' .$myDbObj->error. '<br>';
			} else {
				echo 'Регистрация прошла успешно' . '<br>';
				$login = '';
				$password = '';
				$confirmPassword = '';
			}
		}
	}
}
//var_dump(login_validate('a3sa-do'));
//var_dump(login_validate('rozbyn'));
//var_dump(login_validate('_r-'));
//var_dump(login_validate('ddd---d'));
//var_dump(login_validate('wer-ed_r-p'));
//var_dump(login_validate('90ddak-gg_d'));
//var_dump(login_validate('5644964'));


?>
Регистрация</br>
<form action="" method="POST">
	Логин</br><input name="login" value="<?= $login ?>"></br>
	Пароль</br><input type="password" name="pass" value="<?= $password ?>"></br>
	Подтверждение пароля</br><input type="password" name="confirm-pass" value="<?= $confirmPassword ?>"></br>
	<input type="submit" name="register" value="Регистрация">
</form>



