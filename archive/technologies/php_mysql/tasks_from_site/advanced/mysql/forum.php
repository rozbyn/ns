<?php
date_default_timezone_set('Europe/Moscow');
include('mysql_function.php');
$myDbObj = connect_DB('test', 'root', '', 'localhost');
$showThemeList = true;
$showOneTheme = false;
$info_message = '';
$pName = '';
$pTopicName = '';
$pMessage = '';
$ansName = '';
$ansMessage = '';

//проверяем корректность $_GET['t']
if(!empty($_GET['t']) && is_numeric($_GET['t'])){
	$idTemp = $_GET['t'];
	$k = $myDbObj->query("SELECT COUNT(*) FROM forum_themes WHERE id=$idTemp ");
	$r = $k->fetch_array();
	if ($r[0] !== '0'){
		$showThemeList = false;
		$showOneTheme = true;
		$id = $_GET['t'];
		header('Content-Type: text/html; charset=utf-8');
	} else {
		header('Content-Type: text/html; charset=utf-8');
		header('Location: forum.php');
	}
}

if($showOneTheme){
	//создание ответа в теме
	if (!empty($_POST['btn_submit_answer']) && $_POST['btn_submit_answer'] === '1'){
		if(!is_empty($_POST['name'])){
			$ansName = htmlspecialchars(strip_tags($_POST['name']));
			if (mb_strlen($ansName) <= 50){
				$db_ansName = $ansName;
			} else {
				$info_message .= '<div class="alert_info">Слишком длинное имя! Допустимая длинна имени 50 символов.</div>';
			}
		} else {
			$info_message .= '<div class="alert_info">Введите ваше имя. Не более 50 символов.</div>';
		}
		if (!is_empty($_POST['message'])){
			$ansMessage = htmlspecialchars(strip_tags($_POST['message']));
			if (mb_strlen($ansMessage) <= 4500){
				$db_ansMessage = $ansMessage;
			} else {
				$info_message .= '<div class="alert_info">Слишком длинное сообщение! Допустимая длинна сообщения 4500 символов.</div>';
			}
		} else {
			$info_message .= '<div class="alert_info">Введите сообщение. Не более 4500 символов.</div>';
		}
	}
	if (isset($db_ansName) && isset($db_ansMessage)){
		$db_ansTime = time();
		$db_ansIdOfTheme = $id;
		$query = "INSERT INTO forum_answers SET id_of_theme = ?, user_name = ?, message = ?, time = ?";
		$stmt = $myDbObj -> prepare($query);
		$stmt -> bind_param('issi', $db_ansIdOfTheme, $db_ansName, $db_ansMessage, $db_ansTime);
		if($stmt->execute()){
			$info_message = '<div class="alert_success">Запись успешно сохранена!</div>';
			$ansName = '';
			$ansMessage = '';
			header('Location: forum.php?page=1&t='.$id);
		} else {
			$info_message = '<div class="alert_error">Что-то пошло не так((</div>';
		}
		$stmt->close();
	}
	//расчет пагинации для ответов в теме

	
	$countMessageOnOnePage = 3;
	$k = $myDbObj->query("SELECT COUNT(1) FROM forum_answers WHERE id_of_theme=$id");
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
	
	
	//достаем из базы заголовок темы
	$query = "
	SELECT id, user_name, theme_name, message, time, 
	(
	SELECT COUNT(1) FROM forum_answers 
	WHERE forum_answers.id_of_theme = forum_themes.id 
	)
	AS 'count'
	FROM forum_themes WHERE id=?";
	$stmt = $myDbObj->prepare($query);
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->bind_result($id, $uname, $tname, $message, $time, $count);
	$stmt->fetch();
	$stmt->close();
	
	
	//формирование ответов в теме
	$query = "	SELECT user_name, time, message
				FROM forum_answers WHERE id_of_theme=? ORDER BY time DESC LIMIT ?,?";
	$stmt = $myDbObj->prepare($query);
	$fromRecordNo = ($active_page*$countMessageOnOnePage)-$countMessageOnOnePage;
	$stmt->bind_param('iii', $id, $fromRecordNo, $countMessageOnOnePage);
	if ($stmt->execute()){
		$stmt->bind_result($aUname, $aTime, $aMessage);
		$arrk = [];
		for($i=0;$stmt->fetch();$i++){
			$arrk[$i]['aUname'] = $aUname;
			$arrk[$i]['aTime'] = $aTime;
			$arrk[$i]['aMessage'] = $aMessage;
		}
	} else {
		$info_message = '<div class="alert_error">Ошибка чтения.</div>';
	}
	//формирование HTML ответов в теме
	$listOfAnswers = '';
	foreach($arrk as $val){
		$listOfAnswers .= '<div class="topic">';
		$listOfAnswers .= '<p class="theme_info"><span>'.date('H:i:s d.m.Y',$val['aTime']).' '.$val['aUname'].'</span></p>';
		$listOfAnswers .= '<p>'.$val['aMessage'].'</p></div>';
	}
	
}
if($showThemeList){
	//Создание новой темы
	if (!empty($_POST['btn_submit_new']) && $_POST['btn_submit_new'] === '1'){
		
		if(!is_empty($_POST['name'])){
			
			$pName = htmlspecialchars(strip_tags($_POST['name']));
			if (mb_strlen($pName) <= 50){
				$db_pName = $pName;
			} else {
				$info_message .= '<div class="alert_info">Слишком длинное имя! Допустимая длинна имени 50 символов.</div>';
				
			}
		} else {
			$info_message .= '<div class="alert_info">Введите ваше имя. Не более 50 символов.</div>';
		}
		if (!is_empty($_POST['topic_name'])){
			$pTopicName = htmlspecialchars(strip_tags($_POST['topic_name']));
			if (mb_strlen($pTopicName) <= 50){
				$db_pTopicName = $pTopicName;
			} else {
				$info_message .= '<div class="alert_info">Слишком длинное название темы! Допустимая длинна названия темы 50 символов.</div>';
			}
		} else {
			$info_message .= '<div class="alert_info">Введите название темы. Не более 50 символов.</div>';
		}
		if (!is_empty($_POST['message'])){
			$pMessage = htmlspecialchars(strip_tags($_POST['message']));
			if (mb_strlen($pMessage) <= 4500){
				$db_pMessage = $pMessage;
			} else {
				$info_message .= '<div class="alert_info">Слишком длинное сообщение! Допустимая длинна сообщения 4500 символов.</div>';
			}
		} else {
			$info_message .= '<div class="alert_info">Введите сообщение темы. Не более 4500 символов.</div>';
		}
		
		// отправка новой темы в базу
		if (isset($db_pName) && isset($db_pTopicName) && isset($db_pMessage)){
			$db_pTime = time();
			$query = "INSERT INTO forum_themes SET user_name = ?, theme_name = ?, message=?, time = ?";
			$stmt = $myDbObj -> prepare($query);
			$stmt -> bind_param('sssi', $db_pName, $db_pTopicName, $db_pMessage, $db_pTime);
			if($stmt->execute()){
					$info_message = '<div class="alert_success">Запись успешно сохранена!</div>';
					$pName = '';
					$pTopicName = '';
					$pMessage = '';
					
				} else {
					$info_message = '<div class="alert_error">Что-то пошло не так((</div>';
				}
			$stmt->close();
		}
	}
	//расчет пагинации для списка всех тем
	$countMessageOnOnePage = 4;
	$k = $myDbObj->query("SELECT COUNT(1) FROM forum_themes");
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
	//формирование списка тем
	$query = "	SELECT id, user_name, theme_name, time, 
					(SELECT COUNT(1) FROM forum_answers 
						WHERE forum_answers.id_of_theme = forum_themes.id ) AS 'count'
				FROM forum_themes ORDER BY time DESC LIMIT ?,?";
	$stmt = $myDbObj->prepare($query);
	$fromRecordNo = ($active_page*$countMessageOnOnePage)-$countMessageOnOnePage;
	$stmt->bind_param('ii', $fromRecordNo, $countMessageOnOnePage);
	if ($stmt->execute()){
		$stmt->bind_result($id, $uname, $tname, $time, $count);
		$arrk = [];
		for($i=1;$stmt->fetch();$i++){
			$arrk[$i]['id'] = $id;
			$arrk[$i]['uname'] = $uname;
			$arrk[$i]['tname'] = $tname;
			$arrk[$i]['time'] = $time;
			$arrk[$i]['count'] = $count;
		}
	} else {
		$info_message = '<div class="alert_error">Ошибка чтения записи.</div>';
	}
	//формирование HTML списка тем
	$listOfThemes = '';
	foreach($arrk as $val){
		$id = $val['id'];
		$listOfThemes .= '<div class="topic">';
		$listOfThemes .= '<p class="theme_name"><a href="?t='.$val['id'].'">'.$val['tname'].'</a></p>';
		$listOfThemes .= '<p class="theme_info"><span>Создана:</span> '.date('H:i:s d.m.Y',$val['time']).'. <span>Автор:</span> '.$val['uname'].'.</br>';
		$listOfThemes .= '<span>Количество ответов: </span>'.$val['count'].'</p></div>';
		
	}
}
//формирование HTML пагинации
$pagination = '<ul class="pagination">';
if($showThemeList){
	$pristavka = '';
} else {
	$pristavka = 't='.$_GET['t'];
}

if ($pages>5){
	if ($active_page<4){
		for ($i=1; $i<=4; $i++){
			if ($i == $active_page){
				$pagination .= '<li class="active"><a>'.$i.'</a></li>';
			} else {
				$pagination .= '<li><a href="?page='.$i.'&'.$pristavka.'">'.$i.'</a></li>';
			}
		}
		$pagination .= '<li><a href="?page=last" title="Последняя страница">»</a></li>';
	} elseif ($active_page>$pages-3){
		$pagination .='<li><a href="?page=first" title="Первая страница">«</a></li>';
		for ($i=$pages-3; $i<=$pages; $i++){
			if ($i == $active_page){
				$pagination .= '<li class="active"><a>'.$i.'</a></li>';
			} else {
				$pagination .= '<li><a href="?page='.$i.'&'.$pristavka.'">'.$i.'</a></li>';
			}
		}
	} else {
		$pagination .='<li><a href="?page=first" title="Первая страница">«</a></li>';
		for($i=$active_page-1; $i<=$active_page+1; $i++){
			if ($i == $active_page){
				$pagination .= '<li class="active"><a>'.$i.'</a></li>';
			} else {
				$pagination .= '<li><a href="?page='.$i.'&'.$pristavka.'">'.$i.'</a></li>';
			}
		}
		$pagination .= '<li><a href="?page=last" title="Последняя страница">»</a></li>';
	}
} else {
	for ($i=1; $i<=$pages; $i++){
			if ($i == $active_page){
				$pagination .= '<li class="active"><a>'.$i.'</a></li>';
			} else {
				$pagination .= '<li><a href="?page='.$i.'&'.$pristavka.'">'.$i.'</a></li>';
			}
		}
}
$pagination .= '</ul>';

?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="styles.css" type="text/css"/>
   <title>Форум</title>
   
</head>
<body >
	<div class="main">
		<div class="wrapper">
			<?php if($showThemeList){ ?>
			<h1>Наш форум</h1>
			<p>Наш супер крутой форум посвящен phasellus gravida fermentum pellentesque. Aenean non neque mollis nisl dapibus eleifend. Sed interdum dui nec dictum elementum. Proin eget semper dolor, ut commodo nibh. Quisque vitae pharetra ligula. Sed dictum, sem sed pellentesque aliquam, tellus sapien dapibus magna, eu suscipit lacus augue sed velit. Ut vehicula sagittis nulla, et aliquet elit. Quisque tincidunt sem nibh, finibus dictum nisl vulputate quis. In vitae nisl et lacus pulvinar ornare id ac libero. Morbi pharetra fringilla erat ut lacinia. </p>
			<h2>Темы форума</h2>
			<?=$listOfThemes?>
			<?=$pagination?>
			<h2>Создать тему</h2>
			<?=$info_message?>
			<form action="" method="POST">
				<input class="form_control" name="name" placeholder="Ваше имя" value="<?=$pName?>">
				<input class="form_control" name="topic_name" placeholder="Название темы" value="<?=$pTopicName?>">
				<textarea class="form_control" name="message" placeholder="Текст темы"><?=$pMessage?></textarea>
				<button class="btn_submit" name="btn_submit_new" type="submit" value="1">Создать тему</button>
			</form>
			<?php } elseif ($showOneTheme){ ?>
			<h1>Тема №<?=$id ?></h1>
			<p class="theme_info"><span>Создана: </span><?=date('H:i:s d.m.Y',$time) ?>. <span>Автор: </span><?=$uname ?></br>
			<span>Количество ответов: </span><?=$count ?> <a href="forum.php">Перейти на список тем.</a></p>
			<h2><?=$tname ?></h2>
			<p><?=$message ?></p>
			<h2>Ответы</h2>
			<?=$listOfAnswers?>
			<?=$pagination?>
			<h2>Ответить</h2>
			<?=$info_message?>
			<form action="" method="POST">
				<input class="form_control" name="name" placeholder="Ваше имя" value="<?=$ansName?>">
				<textarea class="form_control" name="message" placeholder="Текст сообщения"><?=$ansMessage?></textarea>
				<button class="btn_submit" name="btn_submit_answer" type="submit" value="1">Отправить сообщение</button>
			</form>
			
			<?php } ?>
			</div>
		</div>
	</div>
	<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/practice/miniproekty-php-dlya-novichkov.html" target="_blank">Страница учебника</a></div>
</body>
</html>