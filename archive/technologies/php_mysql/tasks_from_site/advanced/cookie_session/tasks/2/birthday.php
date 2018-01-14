<?php
date_default_timezone_set('Europe/Moscow');

$timestamp = '';
$showForm = true;
$showRemain = false;
if (isset($_POST['birthday']) && ($timestamp = strtotime($_POST['birthday'])) !== false){
	setcookie("birthday",$timestamp, time()+2592000);
	$showForm = false;
	$showRemain = true;
}
if (isset($_COOKIE['birthday']) || $showRemain){
	if (isset($_COOKIE['birthday'])){
		$timestamp = $_COOKIE['birthday'];
	}
	$showForm = false;
	$nextBirthday = mktime(00, 00, 00, date('m', $timestamp), date('d', $timestamp));
	$daysRemain = floor(($nextBirthday - time())/86400);
	if ($daysRemain < -1){
		$nextBirthday = mktime(00, 00, 00, date('m', $timestamp), date('d', $timestamp), date('Y')+1);
		$daysRemain = floor(($nextBirthday - time())/86400);
		echo 'До вашего дня рождения осталось '. ++$daysRemain . ' дней.<br>';
	} elseif($daysRemain == 0) {
		echo 'Завтра у Вас день рождения!!' . '<br>';
	} elseif ($daysRemain == -1){
		echo 'Поздравляем с днем рождения!!' . '<br>';
	} else {
		echo 'До вашего дня рождения осталось '. ++$daysRemain . ' дней.<br>';
	}
}



$showbanner = true;
if (isset($_COOKIE['nobanner']) && $_COOKIE['nobanner']==1){
	$showbanner = false;
}
if(isset($_GET['showbanner']) && $_GET['showbanner'] === '0'){
	setcookie("nobanner",1, time()+2592000);
	$showbanner = false;
}
if(isset($_GET['clearCookie']) && $_GET['clearCookie'] === '1'){
	setcookie("nobanner",'', time());
	setcookie("count",'', time());
	setcookie("PHPSESSID",'', time());
	setcookie("birthday",'', time());
	setcookie("lastvisit",'', time());
	
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Cookie & Sessions</title>
   
</head>
<body >
	<div class="main">
		<div class="wrapper">
		<?php if ($showForm){ ?>
			<form action="" method="POST">
				<input type="text" name="birthday">
				<input type="submit" value="Отправить">
			</form>
		<?php } ?>
			<a href="?clearCookie=1" style="float: right;">Clear cookie</a>
		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/auth/rabota-s-cookie-na-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>