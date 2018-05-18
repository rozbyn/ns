<?php
date_default_timezone_set('Europe/Moscow');
header('Content-Type: text/html; charset=utf-8');
//Подключение к БД++++++++++++++++++++
if($_SERVER['DOCUMENT_ROOT'] === '/home/u784337761/public_html'){
	$myDbObj = new mysqli('localhost', 'u784337761_root', 'nSCtm9jplqVA', 'u784337761_test');
} elseif($_SERVER['DOCUMENT_ROOT'] === '/storage/ssd3/266/4204266/public_html'){
	$myDbObj = new mysqli('localhost', 'id4204266_root', 'asdaw_q32d213e', 'id4204266_test');
} else {
	$myDbObj = new mysqli('localhost', 'root', '', 'test');
}
$myDbObj->set_charset("utf8");
//++++++++++++++++++++++++++++++++++++
$dayOfWeek = [1=>'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];
$monts = [1=>'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];
$today = '<p class="date"><span>Сегодня:</span> '.date('d').' '.$monts[date('n')].' '.date('Y').' года</p>';
$pMessage = '';
if (empty($_GET)){
	$actPage = date('w');
	if($actPage === '0')$actPage=7;
} elseif(!empty($_GET['day']) && is_numeric($_GET['day'])){
	$actPage = $_GET['day'];
}
if(!empty($_POST['btn_submit_new']) && $_POST['btn_submit_new'] === '1'){
	$query = "UPDATE organizer SET message=? WHERE id=?";
	$stmt = $myDbObj->prepare($query);
	$stmt -> bind_param('si', $_POST['message'], $actPage);
	if ($stmt->execute()){
		$info_message = '<div class="alert_success">Успешно сохранено.</div>';
	} else {
		$info_message = '<div class="alert_error">Произошла ошибка.</div>';
	}
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Органайзер</title>
   <style>
		* {
			margin: 0;
			padding: 0;
		}
		body{
			font-size: 14px;
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		}
		.main {
			padding: 10px;
			color: #333;
			
		}
		h1 {
			font-size: 36px;
			font-weight: 500;
			line-height: 1.1;
			margin-top: 20px;
			margin-bottom: 10px;
			text-align: left;
		}
		.wrapper {
			width: 625px;
			margin: 0px auto;
			padding: 10px;
			text-align: justify;
		}

		.name {
			font-size: 12pt;
		}
		.wrapper p {
			margin-bottom: 5px;
			line-height: 1.42857143;
			font-size: 14px;
			box-sizing: border-box;
		}
		.alert_info{
			color: #31708f;
			background-color: #d9edf7;
			padding: 15px;
			border-radius: 4px;
			box-sizing: border-box;
			border: 1px solid #bce8f1;
		}
		.alert_error{
			color: #f00;
			background-color: #ffb999;
			padding: 15px;
			border-radius: 4px;
			box-sizing: border-box;
			border: 1px solid #f00;
		}
		.alert_success{
			color: #21a500;
			background-color: #cdffcc;
			padding: 15px;
			border-radius: 4px;
			box-sizing: border-box;
			border: 1px solid #83d281;
		}
		.form_control{
			display: block;
			font-size: 14px;
			margin-bottom: 5px;
			box-sizing: border-box;
			width: 100%;
			height: 34px;
			padding: 6px 12px;
			line-height: 1.42857143;
			color: #555;
			background-color: #fff;
			border: 1px solid #ccc;
			border-radius: 10px;
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
			box-sizing: border-box;
			transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
		}
		.form_control:focus{
			box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(255, 99, 0, 0.6);
			border-color: #ffb164;
		}
		textarea.form_control{
			padding: 5px 10px;
			min-height: 200px;
			resize: vertical;
			height: auto;
			overflow: auto;
		}
		.btn_submit{
			width: 100%;
			cursor: pointer;
			display: block;
			color: #fff;
			background-color: #fcb860;
			border: 1px solid #f90;
			padding: 6px 12px;
			margin-bottom: 0;
			font-size: 14px;
			font-weight: normal;
			line-height: 1.42857143;
			text-align: center;
			white-space: nowrap;
			vertical-align: middle;	
			border-radius: 4px;
			touch-action: manipulation;
		}
		.btn_submit:hover{
			background-color: #ffb29e;
			border-color: #ff1200;
		}
		.btn_submit:active{
			background-color: #810000;
			border-color: #000;
			outline: 0;
			box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
		}
		.btn_submit:focus{
			outline-offset: -2px;
			background-color: #993100;
			border-color: #ce613e;
		}
		.btn_submit:active:hover{
			background-color: #810000;
			border-color: #000;
		}

		@media (max-width: 800px){
		   .wrapper{
			  width: calc(90% - 20px);
		   }
		}
		@media (max-width: 226px){
		   .wrapper{
			  padding: 2px;
			  width: 96%;
		   }
		   
		}
		.d_of_week{
			
			margin-bottom: 5px;
		}
		.d_of_week > li:first-child>a {
			border-radius: 13px 0 0 13px;
		}
		.d_of_week > li:last-child>a {
			border-radius: 0 13px 13px 0;
		}
		.d_of_week li{
			display: inline-block;
			padding: 4px 0px;
		}
		.d_of_week li>a{
			border: 1px solid #1ea872;
			padding: 4px 6px;
			margin-left: -1px;
			margin-top: -1px;
			color: black;
			cursor: pointer;
			text-decoration: none;
		}
		.d_of_week li:not(.active)>a:hover{
			border: 1px solid #00472b;
			background: #cbff93;
			color: black;
		}
		.d_of_week > .active > a{
			border: 1px solid #00472b;
			background: #2d802d;
			color: white;
			cursor: default;
		}
		.date {
			text-align: left;
			padding-right: 20px;
		}
		p>span{
			font-weight: bold;
		}
		@media (max-width: 623px){
			.d_of_week > li:first-child>a {
				border-radius: 0px;
			}
			.d_of_week > li:last-child>a {
				border-radius: 0px;
			}
		   
		}
		
		
	</style>
</head>
<?php 
$weekShow = '<ul class="d_of_week">';
for ($i=1;$i<=7;$i++){
	if($i == $actPage){
		$weekShow .= '<li class="active"><a>'.$dayOfWeek[$i].'</a></li>';
	} else {
		$weekShow .= '<li><a href="?day='.$i.'">'.$dayOfWeek[$i].'</a></li>';
	}
}
$weekShow .= '</ul>';
$query = "SELECT message FROM organizer WHERE id=?";
$stmt = $myDbObj->prepare($query);
$stmt -> bind_param('i', $actPage);
if ($stmt->execute()){
	$stmt->bind_result($pMessage);
	$stmt->fetch();
	$info_message = '';
} else {
	$info_message = '<div class="alert_error">Ошибка чтения записи.</div>';
}
?>

<body>
	<div class="main">
		<div class="wrapper">
			<h1>Органайзер</h1>
			<?=$info_message?>
			<div class="organizer_form">
				<?=$today?>
				<?=$weekShow?>
				<form action="" method="POST">
					<textarea class="form_control" name="message" placeholder="Текст заметки"><?=$pMessage?></textarea>
					<button class="btn_submit" name="btn_submit_new" type="submit" value="1">Добавить запись</button>
				</form>
			</div>
		</div>
	</div>
	<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/practice/miniproekty-php-dlya-novichkov.html" target="_blank">Страница учебника</a></div>
</body>
</html>