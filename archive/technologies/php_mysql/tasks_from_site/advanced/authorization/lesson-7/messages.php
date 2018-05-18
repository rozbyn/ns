<?php
include('classInputform.php');
date_default_timezone_set('Europe/Moscow');
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
$baseDir='./';
$headerText = 'Сообщения';
$errorMessage = '';
$sendTo = false;
$showMySended = false;
$showMyReceived = false;
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


if(isset($_GET['to']) && is_numeric($_GET['to'])){
	$sendTo = (int)$_GET['to'];
} elseif(isset($_GET['show']) && $_GET['show']==='sended'){
	$showMySended = true;
} else {
	$showMyReceived = true;
}
if($userAuth==='NOT_VERIFIED' || $userAuth === false){
	header("Location: $baseDir");
} elseif ($userAuth === true){
	if($sendTo){
		$headerText = 'Сообщение для ID-'.$sendTo;
		//создаем форму отправки сообщения
		$form_sendMessage = new Inputform('','POST',[],'form_sendMessage');
		$form_sendMessage->functionAddToUserValues = function($str){
				$returnStr = htmlspecialchars($str, ENT_QUOTES|ENT_HTML5);
				return $returnStr;
			};
		$mess_text = $form_sendMessage->addTextArea('mess_text', ['placeholder'=>'Ваше сообщение', 'maxlength'=>500, 'rows'=>'4'], '', true, 'Введите сообщение!');
		$form_sendMessage->addButton('submit', 'Отправить');
		$form_sendMessage_HTML = $form_sendMessage->returnFullHtml();
		//создаем форму отправки сообщения
		
		//вносим изменения в БД
		if($form_sendMessage->formSended && $form_sendMessage->noErrors){
			$sendedDate = date('Y-m-d H:i:s');
			$mess_text = $myDbObj->real_escape_string($mess_text);
			$res = $myDbObj->query("INSERT INTO auth6_messages SET sender_id='".$logged_DBuserInfo['id']."', recipient_id='$sendTo', message_text='$mess_text', time='$sendedDate'");
			if($res === false){
				$errorMessage = '<div class="errorMessage">Ошибка записи данных в БД! '.$myDbObj->error.'</div>';
			} else {
				$errorMessage = '<div class="info_mes">Ваше сообщение отправлено'.$myDbObj->error.'</div>';
				$form_sendMessage_HTML = '';
				header('Refresh: 5; URL=messages');
			}
		}
		//вносим изменения в БД
		
		
		
	} elseif($showMySended){
		if(
		!empty($_POST['chkSetReaded']) && 
		is_array($_POST['chkSetReaded']) &&
		isset($_POST['DeleteMess']) &&
		$_POST['DeleteMess'] == 'true'
		){
			foreach($_POST['chkSetReaded'] as $mess_id){
				if(is_numeric($mess_id)){
					$myDbObj->query('UPDATE auth6_messages SET sender_id=0 WHERE id='.$mess_id);
				}
			}
		}
		$headerText = 'Мои отправленные сообщения';
		$row = $myDbObj->query("SELECT auth6_messages.*, auth6_users.name, auth6_users.surname  FROM auth6_messages, auth6_users WHERE auth6_messages.recipient_id=auth6_users.id AND auth6_messages.sender_id=".$logged_DBuserInfo['id']." ORDER BY auth6_messages.time DESC");
		for ($messages_list=[]; $temp = $row->fetch_array(MYSQLI_ASSOC); $messages_list[]=$temp);
		if(!empty($messages_list)){
			$messages_list_HTML = '';
			foreach($messages_list as $messArr){
				$messages_list_HTML .= '<label class="message">';
				$messages_list_HTML .= '<div class="message_info">';
				$messages_list_HTML .= '<input type="checkbox" form="form_chk_readed" name="chkSetReaded[]" value="'.$messArr['id'].'">';
				$toWho = (!empty($messArr['name']) && !empty($messArr['surname']))?'КОМУ: '.$messArr['name'].' '.$messArr['surname'].'. ':'КОМУ: ID'.$messArr['sender_id'].'. ';
				$messages_list_HTML .= $toWho.'Время отправки: '.$messArr['time'].'</div>';
				$messages_list_HTML .= '<div class="message_text">'.$messArr['message_text'].'</div>';
				$messages_list_HTML .= '</label>';
			}
		} else {
			$messages_list_HTML = '<label class="message" style="text-align:center">Тут пока пусто</label>';
		}
	} elseif($showMyReceived){
		if(
		!empty($_POST['chkSetReaded']) && 
		is_array($_POST['chkSetReaded']) &&
		isset($_POST['setReaded']) &&
		$_POST['setReaded'] == 'true'
		){
			foreach($_POST['chkSetReaded'] as $mess_id){
				if(is_numeric($mess_id)){
					$myDbObj->query('UPDATE auth6_messages SET readed=1 WHERE id='.$mess_id);
				}
			}
		}elseif(
		!empty($_POST['chkSetReaded']) && 
		is_array($_POST['chkSetReaded']) &&
		isset($_POST['DeleteMess']) &&
		$_POST['DeleteMess'] == 'true'
		){
			foreach($_POST['chkSetReaded'] as $mess_id){
				if(is_numeric($mess_id)){
					$myDbObj->query('UPDATE auth6_messages SET recipient_id=0 WHERE id='.$mess_id);
				}
			}
		}
		$headerText = 'Мои полученные сообщения';
		$row = $myDbObj->query("SELECT auth6_messages.*, auth6_users.name, auth6_users.surname  FROM auth6_messages, auth6_users WHERE auth6_messages.sender_id=auth6_users.id AND auth6_messages.recipient_id=".$logged_DBuserInfo['id']." ORDER BY auth6_messages.time DESC");
		for ($messages_list=[]; $temp = $row->fetch_array(MYSQLI_ASSOC); $messages_list[]=$temp);
		if(!empty($messages_list)){
			$messages_list_HTML = '';
			foreach($messages_list as $messArr){
				$unread = ($messArr['readed'] == 0)?'unread':'';
				$messages_list_HTML .= '<label class="message '.$unread.'">';
				$messages_list_HTML .= '<div class="message_info">';
				$messages_list_HTML .= '<input type="checkbox" form="form_chk_readed" name="chkSetReaded[]" value="'.$messArr['id'].'">';
				$fromWho = (!empty($messArr['name']) && !empty($messArr['surname']))?'ОТ: '.$messArr['name'].' '.$messArr['surname'].'. ':'ОТ: ID'.$messArr['sender_id'].'. ';
				$messages_list_HTML .= $fromWho.'Время отправки: '.$messArr['time'].'</div>';
				$messages_list_HTML .= '<div class="message_text">'.$messArr['message_text'].'</div>';
				$messages_list_HTML .= '</label>';
			}
		} else {
			$messages_list_HTML = '<label class="message" style="text-align:center">Тут пока пусто</label>';
		}
		
		
	}
}
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
			<div id="user_menu">
				<div class="dropdown_menu">
					<div class="dropdown_menu_first_elem">
						<a href="#">Вы вошли как: <?= $logged_DBuserInfo['login'] ?></a>
					</div>
					<div class="dropdown_menu_elem">
						<a href="<?= $baseDir ?>.">Обзор профилей</a>
					</div>
					<div class="dropdown_menu_elem">
						<a href="<?= $baseDir ?>profile">Мой профиль</a>
					</div>
					<div class="dropdown_menu_elem">
						<a href="<?= $baseDir ?>exit">Выход</a>
					</div>
				</div>
			</div>
		</header>
		<content>
		<h1><?= $headerText ?></h1>
		<div class="messages">
		
			<?= $errorMessage ?>
			
			<?php if($sendTo){ ?>
			<div class="mess_div">
				<?= $form_sendMessage_HTML ?>
			</div>
			<?php }elseif($showMySended){ ?>
			<div class="link-messages"><a href="messages">Входящие</a></div>
			<div class="link-messages"><a href="messages?show=sended">Исходящие</a></div>
			<div class="mess_div">
				<div class="control-messages"><form action="" method="POST" id="form_chk_readed"><button type="submit" name="DeleteMess" value="true">Удалить отмеченные</button></form></div>
				<div class="messages-list">
					<?= $messages_list_HTML ?>
				</div>
			</div>
			<?php }elseif($showMyReceived){ ?>
			<div class="link-messages"><a href="messages">Входящие</a></div>
			<div class="link-messages"><a href="messages?show=sended">Исходящие</a></div>
			<div class="mess_div">
				<div class="control-messages"><form action="" method="POST" id="form_chk_readed"><button type="submit" name="setReaded" value="true">Отметить прочитанным</button><button type="submit" name="DeleteMess" value="true">Удалить отмеченные</button></form></div>
				<div class="messages-list">
					<?= $messages_list_HTML ?>
				</div>
			</div>
			<?php } ?>
			
		</div>
		</content>
		<footer>ROZBYN©</footer>
	</div>
</body>
</html>