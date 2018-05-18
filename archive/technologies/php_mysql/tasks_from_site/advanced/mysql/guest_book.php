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
$pName = '';
$pMessage = '';
$countMessageOnOnePage = 10;
if (!empty($_POST['btn_sbmt'])){
	if(!empty($_POST['message'])){
		$pMessage = $_POST['message'];
		if (mb_strlen($pMessage, 'UTF-8')<=4500){
			$message = htmlspecialchars(strip_tags($pMessage));
		} else {
			$info_message = '<div class="alert_info">Слишком длинное сообщение! Допустимая длинна сообщения 4500 символов.</div>';
			$message = false;
		}
	} else {
		$info_message = '<div class="alert_info">Введите, пожалуйста, ваше сообщение!</div>';
		$message = false;
	}
	if(!empty($_POST['name'])){
		$pName = $_POST['name'];
		if (mb_strlen($pName, 'UTF-8')<=50){
			$name = htmlspecialchars(strip_tags($pName));
		} else {
			$info_message = '<div class="alert_info">Слишком длинное имя! Допустимая длинна имени 50 символов.</div>';
			$name = false;
		}
	} else {
		$info_message = '<div class="alert_info">Введите, пожалуйста, ваше имя!</div>';
		$name = false;
	}
	if ($name && $message){
		$ip = $_SERVER['REMOTE_ADDR'];
		$k = $myDbObj->query("SELECT date_time FROM guest_book WHERE ip_address = '$ip' ORDER BY date_time DESC LIMIT 1");
		for ($res = []; $row = $k->fetch_assoc(); $res[] = $row);
		if (!empty($res)){
			$last_message = $res[0]['date_time'];
		} else {
			$last_message = 0;
		}
		$current_time = time();
		if($current_time - $last_message >= 1){
			$query = "INSERT INTO guest_book SET date_time = ?, name=?, message=?, ip_address = ?, public = 1";
			$stmt = $myDbObj -> prepare($query);
			$stmt -> bind_param('isss', $current_time, $name, $message, $ip);
			if($stmt->execute()){
				$info_message = '<div class="alert_success">Запись успешно сохранена!</div>';
				$_GET['page'] = 1;
				$pName = '';
				$pMessage = '';
				
			} else {
				$info_message = '<div class="alert_error">Что-то пошло не так((</div>';
			}
			$stmt->close();

		} else {
			$info_message = '<div class="alert_info">Извините, не более 1 сообщения в минуту с одного IP адреса.</div>';
		}
	}

} else {
	$info_message = '';
}
if(!isset($info_message)){
	$info_message = '';
}
$k = $myDbObj->query("SELECT COUNT(1) FROM guest_book WHERE public = 1");
for ($res = []; $row = $k->fetch_assoc(); $res[] = $row);
$pages = ceil($res[0]["COUNT(1)"]/$countMessageOnOnePage);
$active_page = 1;
if (!empty($_GET['page'])){
	if ($_GET['page']=='first'){
		$active_page = 1;
	} elseif ($_GET['page']=='last'){
		$active_page = $pages;
	} elseif (is_numeric($_GET['page'])){
		if ($_GET['page']>$pages){
			$active_page = $pages;
		} elseif($_GET['page']<1) {
			$active_page = 1;
		} else {
			$active_page = $_GET['page'];
		}
	}
}
$pagination = '<ul class="pagination">';
if ($pages>5){
	if ($active_page<4){
		for ($i=1; $i<=4; $i++){
			if ($i == $active_page){
				$pagination .= '<li class="active"><a href="#">'.$i.'</a></li>';
			} else {
				$pagination .= '<li><a href="?page='.$i.'">'.$i.'</a></li>';
			}
		}
		$pagination .= '<li><a href="?page=last" title="Последняя страница">»</a></li>';
	} elseif ($active_page>$pages-3){
		$pagination .='<li><a href="?page=first" title="Первая страница">«</a></li>';
		for ($i=$pages-3; $i<=$pages; $i++){
			if ($i == $active_page){
				$pagination .= '<li class="active"><a href="#">'.$i.'</a></li>';
			} else {
				$pagination .= '<li><a href="?page='.$i.'">'.$i.'</a></li>';
			}
		}
	} else {
		$pagination .='<li><a href="?page=first" title="Первая страница">«</a></li>';
		for($i=$active_page-1; $i<=$active_page+1; $i++){
			if ($i == $active_page){
				$pagination .= '<li class="active"><a href="#">'.$i.'</a></li>';
			} else {
				$pagination .= '<li><a href="?page='.$i.'">'.$i.'</a></li>';
			}
		}
		$pagination .= '<li><a href="?page=last" title="Последняя страница">»</a></li>';
	}
} else {
	for ($i=1; $i<=$pages; $i++){
			if ($i == $active_page){
				$pagination .= '<li class="active"><a href="#">'.$i.'</a></li>';
			} else {
				$pagination .= '<li><a href="?page='.$i.'">'.$i.'</a></li>';
			}
		}
}
$pagination .= '</ul>';

$query = "SELECT date_time, Name, Message FROM guest_book WHERE public = 1 ORDER BY date_time DESC LIMIT ?,?";
$stmt = $myDbObj->prepare($query);
$fromRecordNo = ($active_page*$countMessageOnOnePage)-$countMessageOnOnePage;
$stmt->bind_param('ii', $fromRecordNo, $countMessageOnOnePage);
$stmt->execute();
$stmt->bind_result($kl1,$kl2,$kl3);
$k = [];
for ($i=1; $stmt->fetch(); $i++) {
	$k[$i]['date_time'] = $kl1;
	$k[$i]['Name'] = $kl2;
	$k[$i]['Message'] = $kl3;
}
$stmt->close();

$content = '';
foreach($k as $key => $val){
	$content .= '<div class="note">';
	$content .= '<p><span class="date">'.date('H:i:s d.m.Y',$val['date_time']).'</span> <span class="name">'.$val['Name'].'</span></p>';
	$content .= '<p>'.$val['Message'].'</p>';
	$content .= '</div>';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Гостевая книга rozbyn.esy.es</title>
   <style>
		* {
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			margin: 0;
			padding: 0;
		}
		body{
			font-size: 14px;
		}
		.main {
			padding: 0px;
			color: #333;
			
		}
		h1 {
			font-size: 36px;
			font-weight: 500;
			line-height: 1.1;
			margin-top: 10px;
			margin-bottom: 10px;
			text-align: center;
		}
		.wrapper {
			width: 50%;
			margin: 0px auto;
			padding: 0px;
			text-align: justify;
		}
		.date {
			font-weight: bold;
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
		.note{
			background: #cbe3f8;
			border: 2px solid #337ab7;
			border-radius: 18px;
			padding-right: 10px;
			padding-left: 10px;
			margin-bottom: 6px;
		}
		.wrapper>div:not(.note) {
			margin-bottom: 15px;
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
			border-radius: 4px;
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
			box-sizing: border-box;
			transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
		}
		.form_control:focus{
			box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
			border-color: #66afe9;
			outline: 0;
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
			background-color: #5bc0de;
			border: 1px solid #46b8da;
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
			background-color: #31b0d5;
			border-color: #269abc;
		}
		.btn_submit:active{
			background-color: #31b0d5;
			border-color: #269abc;
			outline: 0;
			box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
		}
		.btn_submit:focus{
			outline-offset: -2px;
			background-color: #31b0d5;
			border-color: #1b6d85;
		}
		.btn_submit:active:hover{
			background-color: #269abc;
			border-color: #1b6d85;
		}
		.pagination{
			display: inline-block;
			margin: 5px auto;
			border-radius: 4px;
		}
		.pagination>li{
			display: inline;
		}
		.pagination>li>a{
			position: relative;
			float: left;
			padding: 6px 12px;
			margin-left: -1px;
			line-height: 1.42857143;
			color: #337ab7;
			text-decoration: none;
			background-color: #fff;
			border: 1px solid #ddd;
			cursor: pointer;
		}
		.pagination > li:last-child > a{
			border-top-right-radius: 4px;
			border-bottom-right-radius: 4px;
		}
		.pagination > li:first-child > a{
			border-top-left-radius: 4px;
			border-bottom-left-radius: 4px;
		}
		.pagination > li.active > a{
			color: #fff;
			cursor: default;
			background-color: #337ab7;
			border-color: #337ab7;
		}
		.pagination > li:not(.active) > a:hover{
			color: #23527c;
			background-color: #eee;
			border-color: #ddd;
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
		
	</style>
</head>
<body>
	<div class="main">
		<div class="wrapper">
			<h1>Гостевая книга</h1>
			<div style="text-align: center;"><?=$pagination?></div>
			<?=$content?>
			<?=$info_message?>
			<div class="form">
				<form action="" method="POST">
					<input class="form_control" name="name" placeholder="Ваше имя" value="<?=$pName?>">
					<textarea class="form_control" name="message" placeholder="Ваше сообщение"><?=$pMessage?></textarea>
					<input class="btn_submit" name="btn_sbmt" type="submit" value="Сохранить">
				</form>
			</div>
			
		</div>
	</div>
	<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/practice/miniproekty-php-dlya-novichkov.html" target="_blank">Страница учебника</a></div>
</body>