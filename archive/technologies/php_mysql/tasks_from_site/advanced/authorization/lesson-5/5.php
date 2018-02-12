<?php
function login_validate($str){
	if(strlen($str)<15 and !preg_match('#^[0-9]+$#',$str)){
		if(preg_match('#^[a-z0-9]{1}(?:[a-z0-9]|(?:[-](?!-))|(?:[_](?!_)))+[a-z0-9]{1}$#i', $str)===1)return true;
	}
	return false;
}
function name_validate($str, $len = 20){
	if(mb_strlen($str)<=$len and !preg_match('#^[0-9]+$#',$str)){
		if(preg_match('#^[a-zа-я]{1}(?:[a-zа-я]|(?:[-](?!-)))+[a-zа-я]{1}$#iu', $str)===1)return true;
	}
}
function generatePassword ($n=10){
	$pass = '';
	for($i=1; $i<=$n; $i++){
		$s = mt_rand(1,3);
		switch ($s) {
			case 1:
				$pass .= chr(mt_rand(65,90));
				break;
			case 2:
				$pass .= chr(mt_rand(97,122));
				break;
			case 3:
				$pass .= chr(mt_rand(48,57));
				break;
		}
	}
	return $pass;
}
function addSaltToPassword($password, $salt){
	return md5(md5($salt).md5($password));
}


//////////////////////
if($_SERVER['DOCUMENT_ROOT'] === '/home/u784337761/public_html'){
	$myDbObj = new mysqli('localhost', 'u784337761_root', 'nSCtm9jplqVA', 'u784337761_test');
} else {
	$myDbObj = new mysqli('localhost', 'root', '', 'test');
}
$myDbObj->set_charset("utf8");
if(isset($_COOKIE['lastvisited'])){
	$timePassed = time() - $_COOKIE['lastvisited'];
	echo 'Ваше последнее посещение было '. $timePassed . ' секунд назад<br>';
}
session_start(); 


$loginErr = '';
$passErr = '';
$confPassErr = '';
$emailErr = '';
$errClassAdd = ['login'=>'','pass'=>'','confPass'=>'', 'email'=>''];

$authLogin = '';
$authPass = '';
$authRem = '';

$login = '';
$password = '';
$confirmPassword = '';
$email = '';
$name = '';
$surname='';
$city='';
$lang = ['r'=>'', 'e'=>'', 'u'=>'', 'b'=>'', 'o'=>''];
if(isset($_POST['register'])){
	$emptyFields = '';
	!empty($_POST['login']) ? $login = $_POST['login'] : $emptyFields.='1';
	!empty($_POST['pass']) ? $password = $_POST['pass'] : $emptyFields.='2';
	!empty($_POST['confirm-pass']) ? $confirmPassword = $_POST['confirm-pass'] : $emptyFields.='3';
	!empty($_POST['email']) ? $email = $_POST['email'] : $emptyFields.='4';
	!empty($_POST['name']) ? $name = $_POST['name'] :'';
	!empty($_POST['surname']) ? $surname = $_POST['surname'] :'';
	!empty($_POST['city']) ? $city = $_POST['city'] :'';
	if(!empty($_POST['lang'])){
		foreach($_POST['lang'] as $language){
			$lang[$language] = 'selected';
		}
	}
	if (strlen($emptyFields) != 0){
		echo mb_substr(str_replace([1,2,3,4], ['логин, ', 'пароль, ', 'подтверждение пароля, ', 'E-mail, '], 'Введите '.$emptyFields),0,-2) . '!<br>';
	} elseif(!login_validate($login)) {
		$loginErr = 'Введите корректный логин!' . '<br>';
		$errClassAdd['login'] = 'class="error"';
	} elseif($password != $confirmPassword) {
		$confPassErr = 'Пароли не совпадают!' . '<br>';
		$passErr = 'Пароли не совпадают!' . '<br>';
		$errClassAdd['confPass'] = 'class="error"';
		$errClassAdd['pass'] = 'class="error"';
	} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$emailErr = 'Введите корректный e-mail!' . '<br>';
		$errClassAdd['email'] = 'class="error"';
	} else {
		if(!empty(mysqli_fetch_assoc($myDbObj->query("SELECT * FROM users2 WHERE login='$login'")))){
			echo 'Логин занят!' . '<br>';
		} elseif(!empty(mysqli_fetch_assoc($myDbObj->query("SELECT * FROM users2 WHERE email='$email'")))){
			echo 'E-mail занят!' . '<br>';
		} else {
			$name = $myDbObj->real_escape_string(mb_substr($name,0,15));
			$surname = $myDbObj->real_escape_string(mb_substr($surname,0,30));
			$city = $myDbObj->real_escape_string(mb_substr($city,0,20));
			$langToDB = '';
			foreach($lang as $key=>$val){
				if($val=='selected'){
					$langToDB .= $key;
				}
			}
			$langToDB = $myDbObj->real_escape_string(mb_substr($langToDB,0,5));
			$password = $myDbObj->real_escape_string($password);
			
			$salt = generatePassword();
			$saltedPassword = addSaltToPassword($password, $salt);
			$res = $myDbObj->query("INSERT INTO users2 SET login='$login', password='$saltedPassword', name='$name', surname='$surname', email='$email', city='$city', lang='$langToDB', salt = '$salt', lastvisit='".time()."'");
			if ($res === false){
				echo 'Ошибка записи данных в бд. ' .$myDbObj->error. '<br>';
			} else {
				echo 'Регистрация прошла успешно' . '<br>';
				$login = '';
				$password = '';
				$confirmPassword = '';
				$email = '';
				$name = '';
				$surname='';
				$city='';
				$lang = ['r'=>'', 'e'=>'', 'u'=>'', 'b'=>'', 'o'=>''];
			}
		}
	}
}


if (isset($_POST['generatepass'])){
	$login = $_POST['login'];
	$password = $_POST['pass'];
	$confirmPassword = $_POST['confirm-pass'];
	$email = $_POST['email'];
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$city = $_POST['city'];
	if(!empty($_POST['lang'])){
		foreach($_POST['lang'] as $language){
			$lang[$language] = 'selected';
		}
	}
	echo generatePassword(10) . '<br>';
	echo generatePassword(12) . '<br>';
	echo generatePassword(14) . '<br>';
	echo generatePassword(16) . '<br>';
}
if (!isset($_SESSION['auth']) || $_SESSION['auth'] === false){
	if (!empty($_COOKIE['login']) && !empty($_COOKIE['key'])){
		$login = $myDbObj->real_escape_string($_COOKIE['login']); 
		$key = $myDbObj->real_escape_string($_COOKIE['key']);
		$res = mysqli_fetch_assoc($myDbObj->query("SELECT*FROM users2 WHERE login='$login' AND userkey='$key'"));
		$login = '';
		if (!empty($res)){
			//$_SESSION['auth'] = true;
			//$_SESSION['id'] = $res['id']; 
			//$_SESSION['login'] = $res['login'];
			$message = 'Вы вошли по кукам!';
			setcookie('lastvisited', time(), time()+60*60*24*30);
			
		}
	} else {
		$message = 'Войдите или зарегистрируйтесь';
	}
} elseif (isset($_SESSION['auth']) && $_SESSION['auth'] === true){
	setcookie('lastvisited', time(), time()+60*60*24*30);
	$message = 'Вы вошли по сессии!';
}
if(!empty($_POST['exit'])){
	session_destroy();
	setcookie('login', '', time());
	setcookie('key', '', time());
	setcookie('birthday', '', time());
	setcookie('lastvisited', '', time());
	$message = 'Вы вышли';
}
if(!empty($_POST['exit2'])){
	session_destroy();
	$message = 'Вы вышли из сессии!';
}

if (isset($_POST['enter'])){
	$authLogin = $_POST['authLogin'];
	$authPass = $_POST['authPass'];
	if (isset($_POST['remember'])){
		$authRem = 'checked';
	} else {
		$authRem = '';
	}
	
	if (!login_validate($authLogin)){
		$message = 'Некорректный логин';
	} else {
		if(empty($DBuserInfo = mysqli_fetch_assoc($myDbObj->query("SELECT * FROM users2 WHERE login='$authLogin'")))){
			$message = 'Нет такого логина';
		} else {
			if (addSaltToPassword($authPass, $DBuserInfo['salt']) == $DBuserInfo['password']){
				$message = 'Вы успешно вошли по паролю!';
				$_SESSION['auth'] = true;
				$_SESSION['id'] = $DBuserInfo['id']; 
				$_SESSION['login'] = $authLogin;
				if(isset($_POST['remember']) && $_POST['remember'] == '1'){
					$key = generatePassword(16);
					setcookie('login', $authLogin, time()+60*60*24*30);
					setcookie('key', $key, time()+60*60*24*30);
					setcookie('lastvisited', time(), time()+60*60*24*30);
					$res=$myDbObj->query("UPDATE users2 SET userkey='$key' WHERE login='$authLogin'");
				}
				$authLogin = '';
				$authPass = '';
			} else {
				$message = 'Неверный пароль!';
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
<style>
	.error {
		border: 1px solid red;
	}
</style>
Регистрация</br>
<form action="" method="POST">
	Логин*</br><?= $loginErr ?><input <?= $errClassAdd['login'] ?> name="login" value="<?= $login ?>"></br>
	Пароль*</br><?= $passErr ?><input  <?= $errClassAdd['pass'] ?> type="password" name="pass" value="<?= $password ?>"><input type="submit" name="generatepass" value="Генерировать пароль"></br>
	Подтверждение пароля*</br><?= $confPassErr ?><input  <?= $errClassAdd['confPass'] ?> type="password" name="confirm-pass" value="<?= $confirmPassword ?>"></br>
	E-mail*</br><?= $emailErr ?><input <?= $errClassAdd['email'] ?>  name="email" value="<?= $email ?>"></br>
	Имя</br><input name="name" value="<?= $name ?>"></br>
	Фамилия</br><input name="surname" value="<?= $surname ?>"></br>
	Город</br><input name="city" value="<?= $city ?>"></br>
	Язык</br><select name="lang[]" size="3" multiple>
				<option value="r" <?= $lang['r'] ?> >Русский</option>
				<option value="e" <?= $lang['e'] ?> >Английский</option>
				<option value="u" <?= $lang['u'] ?> >Украинский</option>
				<option value="b" <?= $lang['b'] ?> >Белорусский</option>
				<option value="o" <?= $lang['o'] ?> >другой</option>
			</select>
	</br>
	
	<input type="submit" name="register" value="Регистрация">
</form></br>
<?= $message ?>
</br>
Вход<form action="" method="POST">
	Логин*</br><input name="authLogin" value="<?= $authLogin ?>"></br>
	Пароль*</br><input type="password" name="authPass" value="<?= $authPass ?>"></br>
	<label><input name='remember' type='checkbox' value='1' <?= $authRem ?> >Запомнить меня?</label></br>
	<input type="submit" name="enter" value="Войти">
</form>
</br>
</br>
<form action="" method="POST">
	<input type="submit" name="exit" value="Выйти">
</form>

<form action="" method="POST">
	<input type="submit" name="exit2" value="Выйти из сессии">
</form>
