<?php
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
$showSurvey = true;
if (isset($_POST['btn_submit']) && isset($_POST['age'])&& $_POST['age'] <= 3) {
	$ans = $_POST['age'];
	
	$stmt = $myDbObj -> prepare("UPDATE survey SET count = count + 1 WHERE id=?");
	$stmt -> bind_param('i', $ans);
	$stmt->execute();
	
	$stmt = $myDbObj -> prepare("SELECT id, count FROM survey");
	$stmt->execute();
	$stmt->bind_result($id, $count);
	for($res = [];$stmt->fetch();$res[$id]=$count);
	$stmt->close();
	$all_count = $res[1] + $res[2] + $res[3];
	$a1 = round($res[1]/$all_count*100, 2);
	$a2 = round($res[2]/$all_count*100, 2);
	$a3 = round($res[3]/$all_count*100, 2);
	
	$showSurvey= false;
	
	
	
}




?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="styles.css" type="text/css"/>
   <title>Опрос</title>
   
</head>
<body >
	<div class="main">
		<div class="wrapper">
		<?php if ($showSurvey) {?>
			<h1>Опрос</h1>
			<div class="alert_info">Укажите ваш возраст: </div>
			<form action="" method="POST">
				<label class="survey_choice"><input type="radio" value="1" name="age">До 20 лет</label><br>
				<label class="survey_choice"><input type="radio" value="2" name="age">от 20 до 30</label><br>
				<label class="survey_choice"><input type="radio" value="3" name="age">более 30</label><br>
				<button class="btn_submit" name="btn_submit" type="submit" value="1">Ответить</button>
			</form>
		<?php } else { ?>
			<h1>Результаты опроса</h1>
			<div class="alert_info">
				Общее количество опрошенных: <?=$all_count ?>. <br>
				<b>1.</b> Ответили "до 20 лет": <?=$res[1] ?> человек, <?=$a1 ?>% опрошенных. <br>
				<b>2.</b> Ответили "от 20 до 30": <?=$res[2] ?> человек, <?=$a2 ?>% опрошенных. <br>
				<b>3.</b> Ответили "более 30": <?=$res[3] ?> человек, <?=$a3 ?>% опрошенных. <br>
			</div>
			<div class="survey_progress_bars">
				<p>Ответили "до 20 лет":</p>
				<div class="pbar"><div class="progr_bar" style="width: <?=$a1 ?>%;"><?=$a1 ?>%</div></div>
				<p>Ответили "от 20 до 30":</p>
				<div class="pbar"><div class="progr_bar" style="width: <?=$a2 ?>%;"><?=$a2 ?>%</div></div>
				<p>Ответили "более 30":</p>
				<div class="pbar"><div class="progr_bar" style="width: <?=$a3 ?>%;"><?=$a3 ?>%</div></div>
				
			</div>
			
			
		<?php } ?>
		</div>
	</div>
	<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/practice/miniproekty-php-dlya-novichkov.html" target="_blank">Страница учебника</a></div>
</body>
</html>