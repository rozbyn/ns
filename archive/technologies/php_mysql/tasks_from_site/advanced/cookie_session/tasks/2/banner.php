<?php
date_default_timezone_set('Europe/Moscow');
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
	$showbanner = true;
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
		<?php if ($showbanner){ ?>
			<div style="width: 226px;position: fixed;background: red;color: wheat;">
				<a href="?showbanner=0" style="position: absolute;right: 3%;top: 3%;">[x]</a>
				<h1>Купи быстрей!</h1>
				Купи наше барахло очень быстро дешево!
			</div>
		<?php } ?>
			<a href="?clearCookie=1" style="float: right;">Clear cookie</a>
		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/auth/rabota-s-cookie-na-php.html" target="_blank">Страница учебника</a></div>
</body>
</html>