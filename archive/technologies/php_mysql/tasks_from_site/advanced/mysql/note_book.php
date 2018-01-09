<?php
date_default_timezone_set('Europe/Moscow');
include('mysql_function.php');
header('Content-Type: text/html; charset=utf-8');
$myDbObj = connect_DB('u784337761_test', 'u784337761_root', 'nSCtm9jplqVA', 'localhost');
$pTime = date('H:i');
$pDate = date('d.m.Y');
$showOneNote = false;
$edit_note = false;
$showAllNotes = false;
$new_note = false;
$id = '';
$pName = '';
$pMessage = '';
$countMessageOnOnePage = 10;
if (empty($_POST) && empty($_GET)){
	$showAllNotes = true;
} elseif (!empty($_GET['showNoteId'])){
	if(is_numeric($_GET['showNoteId'])){
		$id = $_GET['showNoteId'];
		$query = "SELECT note_timestamp, note_name, note_message FROM note_book WHERE note_id = ?";
		$stmt = $myDbObj->prepare($query);
		$stmt -> bind_param('i',$_GET['showNoteId']);
		$stmt -> execute();
		$stmt->bind_result($note_timestamp,$note_name,$note_message);
		$stmt->fetch();
		$stmt->close();
		if($note_timestamp && $note_name && $note_message){
			$showOneNote = true;
		} else {
			header('Location: note_book.php');
		}
	} else {
		header('Location: note_book.php');
	}
//Проверяем редактируется ли запись
} elseif (!empty($_GET['btn_edit_note']) && empty($_POST['btn_submit'])){
	if(is_numeric($_GET['btn_edit_note'])){
		$id = $_GET['btn_edit_note'];
		$query = "SELECT note_timestamp, note_name, note_message FROM note_book WHERE note_id = ?";
		$stmt = $myDbObj->prepare($query);
		$stmt -> bind_param('i',$id);
		$stmt -> execute();
		$stmt->bind_result($note_timestamp,$note_name,$note_message);
		$stmt->fetch();
		$stmt->close();
		if($note_timestamp && $note_name && $note_message){
			$pTime = date('H:i',$note_timestamp);
			$pDate = date('d.m.Y',$note_timestamp);
			$pName = $note_name;
			$pMessage = $note_message;
			$edit_note = true;
		} else {
			header('Location: note_book.php');
		}
	} else {
		header('Location: note_book.php');
	}
//Проверяем отредактировалась ли запись
} elseif(!empty($_GET['btn_edit_note']) && !empty($_POST['btn_submit'])){
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
		if (mb_strlen($pName, 'UTF-8')<=100){
			$name = htmlspecialchars(strip_tags($pName));
		} else {
			$info_message = '<div class="alert_info">Слишком длинное имя! Допустимая длинна имени 100 символов.</div>';
			$name = false;
		}
	} else {
		$info_message = '<div class="alert_info">Введите, пожалуйста, название записи!</div>';
		$name = false;
	}
	if(!empty($_POST['date']) && !empty($_POST['time'])){
		$pDate = $_POST['date'];
		$pTime = $_POST['time'];
		if (preg_match('/^\d{2}\.\d{2}\.(\d{2}|\d{4})$/', $pDate) && preg_match('/^\d{2}\:\d{2}($|\:\d{2}$)/', $pTime)){
			$date = $pDate;
			$time = $pTime;
		} else {
			$info_message = '<div class="alert_info">Введите дату и время в формате 12:30 30.12.2012</div>';
			$time = false;
			$date = false;
		}
	} else {
		$info_message = '<div class="alert_info">Введите, пожалуйста, дату и время записи!</div>';
		$time = false;
		$date = false;
	}
	if (is_numeric($_POST['btn_submit']) && is_numeric($_GET['btn_edit_note']) && $_POST['btn_submit']==$_GET['btn_edit_note']){
		$id = $_POST['btn_submit'];
	}
	//Проверка данных перед отправкой в бд и отправка
	if ($name && $message && $date && $time && $id){
		$tstmp = strtotime($time.' '.$date);
		$query = "UPDATE note_book SET note_timestamp = ?, note_name=?, note_message=? WHERE note_id=?";
		$stmt = $myDbObj -> prepare($query);
		$stmt -> bind_param('issi', $tstmp, $name, $message, $id);
		if($stmt->execute()){
			$info_message = '<div class="alert_success">Запись успешно сохранена!</div>';
			$edit_note = false;
			$showAllNotes = true;
			$_GET=[];
			$_POST=[];
		} else {
			$info_message = '<div class="alert_error">Что-то пошло не так((</div>';
		}
		$stmt->close();
	} else {
		$edit_note = true;
	}
//удаление записи
} elseif(!empty($_GET['btn_delete_note']) && is_numeric($_GET['btn_delete_note'])){
	$query = "DELETE FROM note_book WHERE note_id=?";
	$stmt = $myDbObj -> prepare($query);
	$stmt -> bind_param('i', $_GET['btn_delete_note']);
	$stmt -> execute();
	$affRows = $stmt -> affected_rows;
	if($affRows === 1){
		$showAllNotes = true;
		$info_message = '<div class="alert_success">Запись успешно удалена.</div>';
	} else {
		$showAllNotes = true;
		$info_message = '<div class="alert_error">Запись не найдена((</div>';
	}
//Создание новой записи
} elseif(!empty($_GET['btn_new']) && $_GET['btn_new']==='1' && empty($_POST['btn_submit_new'])){
	$new_note = true;
//Проверка и отправка новой записи в бд
} elseif(!empty($_GET['btn_new']) && $_GET['btn_new']==='1' && !empty($_POST['btn_submit_new']) && $_POST['btn_submit_new'] === '1'){
	$new_note = true;
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
		if (mb_strlen($pName, 'UTF-8')<=100){
			$name = htmlspecialchars(strip_tags($pName));
		} else {
			$info_message = '<div class="alert_info">Слишком длинное имя! Допустимая длинна имени 100 символов.</div>';
			$name = false;
		}
	} else {
		$info_message = '<div class="alert_info">Введите, пожалуйста, название записи!</div>';
		$name = false;
	}
	if(!empty($_POST['date']) && !empty($_POST['time'])){
		$pDate = $_POST['date'];
		$pTime = $_POST['time'];
		if (preg_match('/^\d{2}\.\d{2}\.(\d{2}|\d{4})$/', $pDate) && preg_match('/^\d{2}\:\d{2}($|\:\d{2}$)/', $pTime)){
			$date = $pDate;
			$time = $pTime;
		} else {
			$info_message = '<div class="alert_info">Введите дату и время в формате 12:30 30.12.2012</div>';
			$time = false;
			$date = false;
		}
	} else {
		$info_message = '<div class="alert_info">Введите, пожалуйста, дату и время записи!</div>';
		$time = false;
		$date = false;
	}
	if ($name && $message && $date && $time){
		$tstmp = strtotime($time.' '.$date);
		$query = "INSERT INTO note_book SET note_timestamp = ?, note_name=?, note_message=?";
		$stmt = $myDbObj -> prepare($query);
		$stmt -> bind_param('iss', $tstmp, $name, $message);
		if($stmt->execute()){
			$info_message = '<div class="alert_success">Запись успешно сохранена!</div>';
			$new_note = false;
			$showAllNotes = true;
			$_GET=[];
			$_POST=[];
		} else {
			$info_message = '<div class="alert_error">Что-то пошло не так((</div>';
		}
		$stmt->close();
	} else {
		$edit_note = true;
	}
	
} elseif(!empty($_GET['page'])){
	$showAllNotes = true;
} else {
	header('Location: note_book.php');//если ничего не сработало	
}

if(!isset($info_message)){
	$info_message = '';
}
if ($showAllNotes){
	$k = $myDbObj->query("SELECT COUNT(1) FROM note_book WHERE 1");
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

	$query = "SELECT note_id, note_timestamp, note_name, note_message FROM note_book WHERE 1 ORDER BY note_timestamp DESC LIMIT ?,?";
	$stmt = $myDbObj->prepare($query);
	$fromRecordNo = ($active_page*$countMessageOnOnePage)-$countMessageOnOnePage;
	$stmt->bind_param('ii', $fromRecordNo, $countMessageOnOnePage);
	$stmt->execute();
	$stmt->bind_result($kl0,$kl1,$kl2,$kl3);
	$k = [];
	for ($i=1; $stmt->fetch(); $i++) {
		$k[$i]['note_id'] = $kl0;
		$k[$i]['note_time'] = date('H:i', $kl1);
		$k[$i]['note_date'] = date('d.m.Y', $kl1);
		$k[$i]['note_name'] = $kl2;
		$k[$i]['note_message'] = $kl3;
	}
	$stmt->close();

	$content = '';
	foreach($k as $key => $val){
		$content .= '<div class="note">';
		$content .= '<p><span class="date">'.$val['note_time'].' '.$val['note_date'].'</span> <a href="note_book.php?showNoteId='.$val['note_id'].'"><span class="name">'.$val['note_name'].'</span></a></p>';
		$content .= '<p>'.$val['note_message'].'</p>';
		$content .= '</div>';
	}
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
			padding: 10px;
			color: #333;
			
		}
		h1 {
			font-size: 36px;
			font-weight: 500;
			line-height: 1.1;
			margin-top: 20px;
			margin-bottom: 10px;
			text-align: center;
		}
		.wrapper {
			width: 50%;
			margin: 0px auto;
			padding: 10px;
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
			background: #ffd9a9;
			border: 2px solid #c00404;
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
			box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(255, 99, 0, 0.6);
			border-color: #ffb164;
			outline: 0;
		}
		.e25{
			width: 21%;
			float: left;
			margin-right: 1%;
		}
		.e75{
			width: 63%;
		}
		.e14{
			width: 14%;
			float: left;
			margin-right: 1%;
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
		.del{
			width: 49%;
		}
		.edi{
			width: 50%;
			float: left;
			margin-right: 1%;
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
			color: #f88606;
			text-decoration: none;
			background-color: #fff;
			border: 1px solid #edb582;
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
			background-color: #b74f33;
			border-color: #b90a03;
		}
		.pagination > li:not(.active) > a:hover{
			color: #904101;
			background-color: #efb1b1;
			border-color: #ef9292;
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
		<?php if($showAllNotes){ ?>
			<h1>Записная книжка</h1>
			<?=$info_message?>
			<div style="text-align: center;"><?=$pagination?></div>
			<?=$content?>
			<div class="form">
				<form action="" method="GET">
					<button class="btn_submit" name="btn_new" type="submit" value="1">Добавить запись</button>
				</form>
			</div>
		<?php } elseif($new_note) { ?>
		<a href="note_book.php">На главную</a>
		<h1>Новая заметка</h1>
		<?=$info_message?>
			<div class="form">
				<form action="" method="POST">
					<input class="form_control e14" name="time" placeholder="Время 12:30" value="<?=$pTime?>">
					<input class="form_control e25" name="date" placeholder="10.10.2012" value="<?=$pDate?>">
					<input class="form_control e75" name="name" placeholder="Имя заметки" value="<?=$pName?>">
					<textarea class="form_control" name="message" placeholder="Текст заметки"><?=$pMessage?></textarea>
					<button class="btn_submit" name="btn_submit_new" type="submit" value="1">Добавить запись</button>
				</form>
			</div>
		<?php }  elseif ($edit_note){ ?>
		<a href="note_book.php">На главную</a>
		<h1>Редактирование заметки</h1>
		<?=$info_message?>
			<div class="form">
				<form action="" method="POST">
					<input class="form_control e14" name="time" placeholder="Время 12:30" value="<?=$pTime?>">
					<input class="form_control e25" name="date" placeholder="10.10.2012" value="<?=$pDate?>">
					<input class="form_control e75" name="name" placeholder="Имя заметки" value="<?=$pName?>">
					<textarea class="form_control" name="message" placeholder="Текст заметки"><?=$pMessage?></textarea>
					<button class="btn_submit" name="btn_submit" type="submit" value="<?=$id?>">Редактировать запись</button>
				</form>
			</div>
		<?php } elseif($showOneNote){ ?>
			<a href="note_book.php">На главную</a>
			<h1><?=$note_name?></h1>
			<?=$info_message?>
			<div>
				<p><span class="date"><?=date('H:i d.m.Y',$note_timestamp)?></span></p>
				<p><?=$note_message?></p>
			</div>
			<form action="" method="GET">
				<button class="btn_submit edi" name="btn_edit_note" type="submit" value="<?=$id?>">Редактировать запись</button>
				<button class="btn_submit del" name="btn_delete_note" type="submit" value="<?=$id?>">Удалить запись</button>
			</form>
		<?php }?>
		
		</div>
	</div>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/practice/miniproekty-php-dlya-novichkov.html" target="_blank">Страница учебника</a></div>
</body>
</html>