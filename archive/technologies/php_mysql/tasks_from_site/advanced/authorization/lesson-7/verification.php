<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpMailer/src/PHPMailer.php';
require 'phpMailer/src/SMTP.php';
require 'phpMailer/src/Exception.php';
date_default_timezone_set('Europe/Moscow');
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
$headerText = 'Регистрация';
$info_mes = '';


if(isset($_GET['login']) && isset($_GET['afterReg']) && $_GET['afterReg']==='true'){
	$userLogin = $myDbObj->real_escape_string($_GET['login']);
	$res = mysqli_fetch_assoc($myDbObj->query("SELECT verified_key, email FROM auth6_users WHERE login='$userLogin'"));
	$verified_key = $res['verified_key'];
	$email = $res['email'];
	$link = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?fromEmail=true&login='.$userLogin.'&verified_key='.$verified_key;
	$email_text = 'Здравствуйте, '.$userLogin.'.<br>Для завершения регистрации на сайте '.$_SERVER['SERVER_NAME'].' перейдите по <a href="'.$link.'">ссылке.</a>';
	$altEmail_text = 'Здравствуйте, '.$userLogin.'. Для завершения регистрации на сайте '.$_SERVER['SERVER_NAME'].' перейдите по ссылке: '.$link;
 	$mail = new PHPMailer;

	$mail->isSMTP();

	$mail->Host = 'smtp.yandex.ru';
	$mail->SMTPAuth = true;
	$mail->Username = 'ezcs'; // логин от вашей почты
	$mail->Password = 'Q3KmE2Bckh'; // пароль от почтового ящика
	$mail->SMTPSecure = 'ssl';
	$mail->Port = '465';

	$mail->CharSet = 'UTF-8';
	$mail->From = 'ezcs@yandex.ru'; // адрес почты, с которой идет отправка
	$mail->FromName = 'rozbyn'; // имя отправителя
	$mail->addAddress($email);
	//$mail->addCC('email3@email.com');

	$mail->isHTML(true);

	$mail->Subject = 'Подтверждение регистрации на '.$_SERVER['SERVER_NAME'];
	$mail->Body = $email_text;
	$mail->AltBody = $altEmail_text;
	//$mail->addAttachment('img/Lighthouse.jpg', 'Картинка Маяк.jpg');
	// $mail->SMTPDebug = 1;
	$mailStatus = $mail->send(); 
	//$mailStatus = false;
	if( $mailStatus ){
		$info_mes = '<p class="info_mes">Письмо с подтверждением было выслано вам на почту.</p>';
		header('Refresh: 5; URL=./');
		//header("Location: verification?mailSended=true");
		//header('Refresh: 5; URL=verification?mailSended=true');
	}else{
		$info_mes = '<p class="info_mes">Письмо не может быть отправлено. Ошибка: '.$mail->ErrorInfo.'</p>';
		header('Refresh: 5; URL=./');
	}
} elseif(isset($_GET['fromEmail']) && $_GET['fromEmail']==='true' && isset($_GET['login']) && isset($_GET['verified_key'])){
	$fromEmailLogin = $myDbObj->real_escape_string($_GET['login']);
	$fromEmailVerified_key = $myDbObj->real_escape_string($_GET['verified_key']);
	if($myDbObj->query("UPDATE auth6_users SET verified=1 WHERE login='$fromEmailLogin' AND verified_key='$fromEmailVerified_key'")){
		if($myDbObj->affected_rows === 0){
			$info_mes = '<p class="info_mes">Ошибка! Аккаунт не найден!</p>';
		} elseif($myDbObj->affected_rows === 1){
			$info_mes = '<p class="info_mes">Аккаунт успешно активирован!</p>';
		}		
	} else {
		$info_mes = '<p class="info_mes">Ошибка! '.$myDbObj->error.'</p>';
	}
	header('Refresh: 5; URL=./');
} else {
	header("Location: ./");
}
/* $userLogin = 'asd';
$verified_key = 'asd';
$testLink = '<a href="';
$testLink .= 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?fromEmail=true&login='.$userLogin.'&verified_key='.$verified_key;
$testLink .= '">link</a>';
echo $testLink . '<br>'; */

//var_dump($_GET);


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
			<h1><?= $headerText ?></h1>
		</header>
		<content>
			<div class="logIn">
			<?= $info_mes ?>
			</div>
		</content>
		<footer>ROZBYN©</footer>
	</div>
</body>
</html>