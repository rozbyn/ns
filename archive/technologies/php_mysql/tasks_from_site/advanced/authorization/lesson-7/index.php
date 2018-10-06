<?php
date_default_timezone_set('Europe/Moscow');
include('classInputform.php');

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


/* session_start();
session_destroy(); */

$registration = false;
$headerText = '<a href=".">Сайт с профилями и сообщениями.</a>';

//Выход из аккаунта-----
if(isset($_GET['exit']) && $_GET['exit'] === 'true'){
	setcookie('_ruId', '', time());
	setcookie('_ruKey', '', time());
	setcookie('_ruNoRem', '', time());
	setcookie('_ruLVis', '', time());
	header('Location: ./');
}
//Выход из аккаунта-----







//Проверка кук-----
if(!empty($_COOKIE['_ruId']) && !empty($_COOKIE['_ruKey']) && !empty($_COOKIE['_ruLVis'])){
	$logged_user_id = $myDbObj->real_escape_string($_COOKIE['_ruId']);
	$logged_user_key = $myDbObj->real_escape_string($_COOKIE['_ruKey']);
	$logged_user_time = time();
	$logged_DBuserInfo = mysqli_fetch_assoc($myDbObj->query("SELECT * FROM auth6_users WHERE id='$logged_user_id' AND userkey='$logged_user_key'"));
	if(!empty($logged_DBuserInfo)){
		if($logged_DBuserInfo['banned']=='0'){
			$banned = false;
		} else {
			if(time()>$logged_DBuserInfo['banned']){
				$myDbObj->query("UPDATE auth6_users SET banned='0' WHERE id='$logged_user_id'");
				$banned = false;
			} else {
				$banned = true;
			}
		}
		if(!$banned){
			$userAuth = ($logged_DBuserInfo['verified'] == 1) ? true : 'NOT_VERIFIED';
			$myDbObj->query("UPDATE auth6_users SET last_visit='$logged_user_time' WHERE id='$logged_user_id' AND userkey='$logged_user_key'");
			if(!empty($_COOKIE['_ruNoRem']) && $_COOKIE['_ruNoRem'] === '1'){//выход из аккаунта после 10 минут бездействия
				setcookie('_ruId', $_COOKIE['_ruId'], time()+60*10);
				setcookie('_ruKey', $_COOKIE['_ruKey'], time()+60*10);
				setcookie('_ruNoRem', '1', time()+60*10);
			} else {
				if($logged_user_time - (int)$_COOKIE['_ruLVis'] > 604800){//раз в неделю обновляем куки
					setcookie('_ruId', $_COOKIE['_ruId'], time()+60*60*24*30);
					setcookie('_ruKey', $_COOKIE['_ruKey'], time()+60*60*24*30);
				}
			}
			setcookie('_ruLVis', $logged_user_time, time()+60*60*24*30);
		} else {
			$userAuth = false;
		}
	} else {
		$userAuth = false;
	}
} else {
	$userAuth = false;
}
//Проверка кук-----

$errorMessage = '';

if(isset($_GET['test'])){
	echo '!!!' . '<br>';
}

if(isset($_GET['reg']) && $_GET['reg'] === 'true'){
	$registration = true;
}
if($registration){
	$headerText = '<a href=".">Регистрация</a>';
	$regForm = new Inputform('','POST',[],'registration');
	$regForm->addHtml('<p class="info_mes">Пожалуйста, заполните все поля отмеченые <span class="spanRequired">*</span></p>');
	$regForm->labelOpen('<span class="fieldInfo">Логин<span class="spanRequired">*</span></span>');
	$regLogin = $regForm->addTextInput('regLogin', true, ['placeholder'=>'Логин', 'maxlength'=>30], 'Введите логин!', 'Login', 'Некорректный логин!<br>Не менее 3 символов и не более 30,<br>только латинские символы, "-", "_".');
	$regForm->labelClose('');
	$regForm->labelOpen('<span class="fieldInfo">Пароль<span class="spanRequired">*</span></span>');
	$regPass = $regForm->addPasswordInput('regPass', true, ['placeholder'=>'Пароль', 'maxlength'=>30], 'Введите пароль!', 'Password', 'Некорректный пароль!<br>Русские символы недопустимы,<br>от 6 до 30 символов.');
	$regPassID = $regForm->id;
	$regForm->labelClose('');
	$regForm->labelOpen('<span class="fieldInfo">Подтверждение пароля<span class="spanRequired">*</span></span>');
	$regPassConf = $regForm->addPasswordInput('regPassConf', true, ['placeholder'=>'Подтверждение пароля', 'maxlength'=>30], 'Введите подтверждение пароля!', 'Password', 'Некорректный пароль!<br>Русские символы недопустимы,<br>от 6 до 30 символов.', $regPassID, 'Пароли должны совпадать');
	$regForm->labelClose('');
	$regForm->labelOpen('<span class="fieldInfo">E-mail<span class="spanRequired">*</span></span>');
	$regEmail = $regForm->addEmailInput('regEmail', true, ['placeholder'=>'E-mail', 'maxlength'=>30], 'Введите E-mail!', 'Email', 'Не корректный E-mail!');
	$regForm->labelClose('');
	$regForm->addButton('submit', 'Регистрация', ['class'=>'punch']);
	$regFormHtml = $regForm->returnFullHtml();
	
	if($regForm->formSended && $regForm->noErrors){
		$regLogin = $myDbObj->real_escape_string($regLogin);
		$regPass = $myDbObj->real_escape_string($regPass);
		$regPassConf = $myDbObj->real_escape_string($regPassConf);
		$regEmail = $myDbObj->real_escape_string($regEmail);
		$regDate = time();
		if(!empty(mysqli_fetch_assoc($myDbObj->query("SELECT id FROM auth6_users WHERE login='$regLogin'")))){
			$errorMessage = "<div class=\"errorMessage\">Логин \"$regLogin\" занят!</div>";
		} elseif(!empty(mysqli_fetch_assoc($myDbObj->query("SELECT id FROM auth6_users WHERE email='$regEmail'")))){
			$errorMessage = "<div class=\"errorMessage\">E-mail \"$regEmail\" занят!</div>";
		} else {
			$verifed_key = generatePassword();
			$salt = generatePassword();
			$saltedPassword = addSaltToPassword($regPass, $salt);
			$res = $myDbObj->query("INSERT INTO auth6_users SET login='$regLogin', password='$saltedPassword', email='$regEmail', salt = '$salt', registerDate=$regDate, verified_key='$verifed_key'");
			if($res === false){
				$errorMessage = '<div class="errorMessage">Ошибка записи данных в бд. ' .$myDbObj->error. '</div>';
			} else {
				header("Location: verification?login=$regLogin&afterReg=true");
				//header("Location: .");
			}
		}
	}
}elseif($userAuth===false){
	$authForm = new Inputform('','POST',[],'authentication');
	$authForm->addHtml('<p class="info_mes">Пожалуйста войдите.</p>');
	$authForm->labelOpen('<span class="fieldInfo">Логин<span class="spanRequired">*</span></span>');
	$login = $authForm->addTextInput('authLogin', true, ['placeholder'=>'Логин', 'maxlength'=>30], 'Введите логин!', false, 'Некорректный логин!<br>Не менее 3 символов и не более 30,<br>только латинские символы, "-", "_".');
	$authForm->labelClose('');
	$authForm->labelOpen('<span class="fieldInfo">Пароль<span class="spanRequired">*</span></span>');
	$pass = $authForm->addPasswordInput('authPass', true, ['placeholder'=>'Пароль', 'maxlength'=>30], 'Введите пароль!', false, 'Некорректный пароль!<br>Русские символы недопустимы,<br>от 6 до 30 символов.');
	$authForm->labelClose('');
	$remember = $authForm->addCheckBox('rememberChkBox', ['checked'=>''], true, false, '<label id="remChkBx">', 'Запомнить меня?</label>');
	$authForm->addButton('submit', 'Войти');
	$authFormHtml = $authForm->returnFullHtml();
	
	if($authForm->formSended && $authForm->noErrors){
		$login = $myDbObj->real_escape_string($login);
		$pass = $myDbObj->real_escape_string($pass);
		$DBuserInfo = mysqli_fetch_assoc($myDbObj->query("SELECT id, password, salt, verified FROM auth6_users WHERE login='$login'"));
		if($myDbObj->affected_rows === 1){
			$auth_saltedPassword = addSaltToPassword($pass, $DBuserInfo['salt']);
			if($auth_saltedPassword == $DBuserInfo['password']){
				$userId = $DBuserInfo['id'];
				$key = generatePassword(16);
				$lastVisit = time();
				$myDbObj->query("UPDATE auth6_users SET userkey='$key', last_visit='$lastVisit' WHERE id='$userId'");
				
				if($remember){
					setcookie('_ruId', $userId, time()+60*60*24*30);
					setcookie('_ruKey', $key, time()+60*60*24*30);
					setcookie('_ruLVis', $lastVisit, time()+60*60*24*30);
				} else {
					setcookie('_ruId', $userId, time()+60*10);
					setcookie('_ruKey', $key, time()+60*10);
					setcookie('_ruLVis', $lastVisit, time()+60*60*24*30);
					setcookie('_ruNoRem', '1', time()+60*10);
				}
				if($DBuserInfo['verified'] == 1){
					$userAuth = true;
					$logged_DBuserInfo['login'] = $login;
					$logged_DBuserInfo['id'] = $userId;
				} else {
					$userAuth = 'NOT_VERIFIED';
					$logged_DBuserInfo['login'] = $login;
				}
			} else {
				$errorMessage = '<div class="errorMessage">Неправильная пара логин-пароль!</div>';
			}
		} else {
			$errorMessage = '<div class="errorMessage">Неправильная пара логин-пароль!</div>';
		}
	}
}
if($userAuth===true){
	$logged_user_id = $logged_DBuserInfo['id'];
	$row = $myDbObj->query("SELECT id, name, surname, avatar, short_addr FROM auth6_users WHERE name<>'' AND surname<>'' AND verified=1 AND id<>'$logged_user_id'");
	for ($user_list=[]; $temp = $row->fetch_array(MYSQLI_ASSOC); $user_list[]=$temp);
	if(!empty($user_list)){
		$user_list_html = '<div class="users_list">';
		foreach($user_list as $key=>$user){
			if(!empty($user['short_addr'])){
				$user_list_html .= '<a href="profile/'.$user['short_addr'].'" class="user_info" title="Посмотреть профиль">';
			} else {
				$user_list_html .= '<a href="profile/'.$user['id'].'" class="user_info" title="Посмотреть профиль">';
			}
			$user_list_html .= '<div class="user_name">'.$user['name'].' '.$user['surname'].'</div>';
			$user_list_html .= '<div class="avatar" style="background-image: url(\''.$user['avatar'].'\')"></div>';
			$user_list_html .= '</a>';
		}
		$user_list_html .= '</div>';
	} else {
		$user_list_html = '<div class="users_list">Тут пока никого нет =\'(</div>';
	}
}

$baseDir='';
?>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="styles.css" type="text/css"/>
   <title>Авторизация, регистрация</title>
</head>
<body>
	<div id="main">
		<header>
		<?php if($userAuth === true || $userAuth === 'NOT_VERIFIED'){ ?>
			<div id="user_menu">
				<div class="dropdown_menu">
					<div class="dropdown_menu_first_elem">
						<a href="#">Вы вошли как: <?= $logged_DBuserInfo['login'] ?></a>
					</div>
					<div class="dropdown_menu_elem">
						<a href="./">Обзор профилей</a>
					</div>
					<div class="dropdown_menu_elem">
						<a href="profile">Мой профиль</a>
					</div>
					<div class="dropdown_menu_elem">
						<a href="exit">Выход</a>
					</div>
				</div>
			</div>
		<?php }else{ ?>
			<h1><?= $headerText ?></h1>
		<?php } ?>
		</header>
		<content>
		<?php if($userAuth !== true){ ?>
			<div class="logIn">
			<?= $errorMessage ?>
			<?php if($registration){ ?>
				<?= $regFormHtml ?>
			<?php }elseif($userAuth===false){ ?>
				<?= $authFormHtml ?>
				<p id="register_link">Нет аккаунта?<br><a href="registration">Зарегистрируйтесь!</a></p>
			<?php }elseif($userAuth === 'NOT_VERIFIED'){ ?>
				<p class="info_mes">На указанную вами почту было отправлено письмо с ссылкой на активацию аккаунта. Пожалуйста, для полноценного использования сайта перейдите по ссылке в письме.</p>
			<?php } ?>
			</div>
		<?php } else { ?>
			<?= $user_list_html ?>
		<?php } ?>
		</content>
		<footer>ROZBYN©</footer>
	</div>
</body>
</html>