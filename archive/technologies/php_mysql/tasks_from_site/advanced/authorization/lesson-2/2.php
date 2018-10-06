<?php

//Подключение к БД++++++++++++++++++++
$mysqlHost = 'localhost';
$mysqlUserName = 'root';
$mysqlPass = '';
$mysqlDB = 'test';
if($_SERVER['DOCUMENT_ROOT'] === '/home/u784337761/public_html'){
	$mysqlUserName = 'u784337761_root'; $mysqlPass = 'nSCtm9jplqVA'; $mysqlDB = 'u784337761_test';
} elseif($_SERVER['DOCUMENT_ROOT'] === '/storage/ssd3/266/4204266/public_html'){
	$mysqlUserName = 'id4204266_root'; $mysqlPass = 'asdaw_q32d213e'; $mysqlDB = 'id4204266_test';
} elseif($_SERVER['DOCUMENT_ROOT'] === '/storage/ssd5/250/7376250/public_html'){
	$mysqlUserName = 'id7376250_root'; $mysqlPass = 'jasd07ag'; $mysqlDB = 'id7376250_test';
}

$myDbObj = new mysqli($mysqlHost, $mysqlUserName, $mysqlPass, $mysqlDB);
$myDbObj->set_charset("utf8");
//++++++++++++++++++++++++++++++++++++
$tsmp = time();
/* $query = "UPDATE users2 SET name='Рома', lastvisit=$tsmp WHERE id=1";
if($myDbObj->query($query)){
	echo '!!!' . '<br>';
} else{
	echo $myDbObj->error . '<br>';
} */
function user($str){
	switch ($str) {
		case 'auth':
			return isset($_SESSION['auth']) ? $_SESSION['auth']:false;
		case 'id':
			return isset($_SESSION['id']) ? $_SESSION['id']:false;
		case 'login':
			return isset($_SESSION['login']) ? $_SESSION['login']:false;
		case 'password':
			return isset($_SESSION['password']) ? $_SESSION['password']:false;
		case 'name':
			return isset($_SESSION['name']) ? $_SESSION['name']:false;
		case 'surname':
			return isset($_SESSION['surname']) ? $_SESSION['surname']:false;
		case 'lastvisit':
			return isset($_SESSION['lastvisit']) ? $_SESSION['lastvisit']:false;
		case 'e-mail':
			return isset($_SESSION['e-mail']) ? $_SESSION['e-mail']:false;
		
	}
}
function getUser($id='current'){
	if ($id=='current'):
		if(user('auth')){
			$resultArr = [];
			$resultArr['id'] = user('id');
			$resultArr['login'] = user('login');
			$resultArr['password'] = user('password');
			$resultArr['name'] = user('name');
			$resultArr['surname'] = user('surname');
			$resultArr['e-mail'] = user('e-mail');
			$resultArr['lastvisit'] = user('lastvisit');
			return $resultArr;
		} else {
			return false;
		}
	elseif(is_numeric($id)):
		global $myDbObj;
		if($myDbObj){
			$res = $myDbObj->query("SELECT*FROM users2 WHERE id=$id");
		} else {
			return false;
		}
		$user = mysqli_fetch_assoc($res);
		if(!empty($user)){
			return $user;
		} else {
			return false;
		}
	else:
		return false;
	endif;
}

session_start();
if(isset($_POST['exit'])){
	session_destroy();
	header('Location: ');
	exit();
}

if(isset($_POST['login']) and isset($_POST['pass'])){
	$login = $_POST['login'];
	$password = $_POST['pass'];
	$query = 'SELECT*FROM users2 WHERE login="'.$login.'" AND password="'.$password.'"';
	$res = $myDbObj->query($query);
	$user = mysqli_fetch_assoc($res);
	if(!empty($user)){
		$_SESSION['auth'] = true;
		$_SESSION['id'] = $user['id'];
		$_SESSION['login'] = $user['login'];
		$_SESSION['password'] = $user['password'];
		$_SESSION['name'] = $user['name'];
		$_SESSION['surname'] = $user['surname'];
		$_SESSION['e-mail'] = $user['e-mail'];
		$_SESSION['lastvisit'] = $user['lastvisit'];
		$myDbObj->query('UPDATE users2 SET lastvisit='.time().' WHERE id='.$user['id']);
	} else {
		echo 'Неправильная пара логин-пароль!' . '<br>';
	}
}

echo var_dump(user('auth')) . '<br>';
echo var_dump(user('login')) . '<br>';
echo var_dump(user('id')) . '<br>';
echo var_dump(user('e-mail')) . '<br>';
echo var_dump(user('surname')) . '<br>';

print_r(getUser(3)) . '<br>';





?>

<form action="" method="POST">
	Логин<input name="login"></br>
	Пароль<input type="password" name="pass"></br>
	<input type="submit" name="auth" value="Войти">
</form>
<form action="" method="POST">
	<input type="submit" name="exit" value="Выйти">
</form>



