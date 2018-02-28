<?php
include('classInputform.php');
date_default_timezone_set('Europe/Moscow');

//////////////////////
function isAccess($arr=['2','10']){
	global $userAuth, $logged_DBuserInfo;
	if($userAuth === true){
		if(is_array($arr)){
			return in_array($logged_DBuserInfo['user_status'], $arr);
		} else {
			return ($logged_DBuserInfo['user_status']==$arr);
		}
	}
}
function make_table($headTable = ['#', 'name', 'count', 'something'], $arrOfData = [[1, 'lolol', 33, 'what?'], [2, 'komomo', 99, 'nowhere']]){
	$table = '';
	$table .= '<table><thead>';
	foreach ($headTable as $val){
		$table .=  '<td>' . $val . '</td>';
	}
	$table .=  '</thead>';
	$table .=  '<tbody>';
	foreach ($arrOfData as $record){
		$table .=  '<tr>';
		foreach($record as $val){
			$table .=  '<td>' . $val . '</td>';
		}
		$table .=  '</tr>';
	}
	$table .=  '</tbody>';
	$table .=  '</table>';
	return $table;
}
function prepStrVar($str){
	global $myDbObj;
	return $myDbObj->real_escape_string(htmlspecialchars($str, ENT_QUOTES|ENT_HTML5));
}



//////////////////////

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
$headerText = '<a href="admin">Админка</a>';
$errorMessage = '';
$showList = true;
$editUser = false;





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
if(!empty($_GET['user_full_edit']) && is_numeric($_GET['user_full_edit'])){
	$editUser = (int)$_GET['user_full_edit'];
	$showList = false;
}



if($userAuth==='NOT_VERIFIED' || $userAuth === false){
	header("Location: $baseDir");
} elseif ($userAuth === true && isAccess() && $showList){
	if(!empty($_POST['edit_list']) && is_numeric($_POST['edit_list'])){
		$editing_user_id = (int)$_POST['edit_list'];
		$changing_id = (int)$_POST['user_id'];
		$changing_login = prepStrVar($_POST['user_login']);
		$changing_name = prepStrVar($_POST['user_name']);
		$changing_surname = prepStrVar($_POST['user_surname']);
		$changing_status = (int)$_POST['user_status'];
		$res = $myDbObj->query("UPDATE auth6_users SET
				id='$changing_id',
				login='$changing_login',
				name='$changing_name',
				surname='$changing_surname',
				user_status='$changing_status'
				WHERE id='$editing_user_id'");
		if($res === false){
			$errorMessage = '<div class="errorMessage">Ошибка записи данных в БД! '.$myDbObj->error.'</div>';
		}
	} elseif(!empty($_POST['ban_user']) && is_numeric($_POST['ban_user'])){
		$ban_id = (int)$_POST['ban_user'];
		var_dump($_POST);
		$aval_ban_periods = ['minute', 'hour', 'day', 'week', 'month', 'year'];
		if(!empty($_POST['ban_number']) && in_array($_POST['ban_period'], $aval_ban_periods)){
			$banTimestamp = strtotime('+'.$_POST['ban_number'].' '.$_POST['ban_period']);
			$res = $myDbObj->query("UPDATE auth6_users SET banned='$banTimestamp' WHERE id = '$ban_id'");
			if($res === false){
				$errorMessage = '<div class="errorMessage">Ошибка записи данных в БД! '.$myDbObj->error.'</div>';
			}
		}
	} elseif(!empty($_POST['unban_user']) && is_numeric($_POST['unban_user'])){
		$unban_id=(int)$_POST['unban_user'];
		$res = $myDbObj->query("UPDATE auth6_users SET banned='0' WHERE id = '$unban_id'");
	} elseif(!empty($_POST['delete_user']) && is_numeric($_POST['delete_user'])){
		$delete_id = (int)$_POST['delete_user'];
		$res = $myDbObj->query("DELETE FROM auth6_users WHERE id = '$delete_id'");
	}
	//показываем строку с статистикой пользователей
	$users_status = ($myDbObj->query("
							SELECT 
							(SELECT COUNT(1) FROM auth6_users WHERE user_status = 10) AS 'admins',
							(SELECT COUNT(1) FROM auth6_users WHERE user_status = 2) AS 'moder',
							(SELECT COUNT(1) FROM auth6_users WHERE banned > ".time().") AS 'banned',
							(SELECT COUNT(1) FROM auth6_users WHERE user_status = 1 AND banned <= ".time().") AS 'users'
							"))->fetch_array(MYSQLI_ASSOC);
	$users_status_text = 'Администраторов: '.$users_status['admins'].', модераторов: '.$users_status['moder'].', забаненных пользователей: '.$users_status['banned'].', остальных пользователей: '.$users_status['users'];
	//показываем строку с статистикой пользователей
	$row = $myDbObj->query("SELECT id, login, name, surname, user_status, banned FROM auth6_users");
	for ($user_list=[]; $temp = $row->fetch_array(MYSQLI_ASSOC); $user_list[]=$temp);
	//var_dump($user_list);
} elseif($editUser){
	if(isset($_POST['edit_user_complete']) && $_POST['edit_user_complete']==='true'){
		unset($_POST['edit_user_complete']);
		$prop_str_to_DB = '';
		foreach($_POST as $key=>$val){
			$val = prepStrVar($val);
			$prop_str_to_DB .= "$key = '$val', ";
		}
		$prop_str_to_DB = substr($prop_str_to_DB, 0, -2);
		$res = $myDbObj->query("UPDATE auth6_users SET $prop_str_to_DB WHERE id='$editUser'");
		if($res === false){
			$errorMessage = '<div class="errorMessage">Ошибка записи данных в БД! '.$myDbObj->error.'</div>';
		}
	}
	$edit_user_arr = ($myDbObj->query("SELECT * FROM auth6_users WHERE id='$editUser'"))->fetch_array(MYSQLI_ASSOC);
	//var_dump($_POST);
} else {
	header("Location: $baseDir");
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
		
		<?= $errorMessage ?>
		<?php if($showList){ ?>
		<div class="admin_all_users_list">
			<h3><?= $users_status_text ?></h3>
			<?php foreach($user_list as $user){ ?>
			<div class="usr_edit">
				<form action="" method="POST" id="edit_userID-<?= $user['id'] ?>">
					<button type="submit" name="edit_list" value="<?= $user['id'] ?>" style="display:none"></button>
				</form>
				<div class="prop_div">
					<label class="usr_edit_property_name">ID<br>
					<input class="prop_id" type="text" name="user_id" form="edit_userID-<?= $user['id'] ?>" value="<?= $user['id'] ?>"></label>
				</div>
				<div class="prop_div">
					<label class="usr_edit_property_name">Login<br>
					<input class="prop_text" type="text" name="user_login" form="edit_userID-<?= $user['id'] ?>"  value="<?= $user['login'] ?>"></label>
				</div>
				<div class="prop_div">
					<label class="usr_edit_property_name">Name<br>
					<input class="prop_text" type="text" name="user_name" form="edit_userID-<?= $user['id'] ?>"  value="<?= $user['name'] ?>"></label>
				</div>
				<div class="prop_div">
					<label class="usr_edit_property_name">Surname<br>
					<input class="prop_text" type="text" name="user_surname" form="edit_userID-<?= $user['id'] ?>"  value="<?= $user['surname'] ?>"></label>
				</div>
				<div class="prop_div">
					<label class="usr_edit_property_name">Status<br>
					<input class="prop_stat" min="1" max="10" type="number" name="user_status" form="edit_userID-<?= $user['id'] ?>"  value="<?= $user['user_status'] ?>"></label>
				</div>
				<div class="prop_div">
					<span class="usr_edit_property_name">Edit<br>
						<form action="" method="GET">
							<button name="user_full_edit" class="prop_butt" type="submit" value="<?= $user['id'] ?>">Edit</button>
						</form>
					</span>
				</div>
				<div class="prop_div">
					<form action="" method="POST">
						<?php if($user['banned']<time()){ ?>
						<label class="usr_edit_property_name">BAN<br>
						<input min="0" type="number" class="ban_number" name="ban_number">
						<select class="ban_select" name="ban_period">
							<option value="none" selected=""></option>
							<option value="minute" >minutes</option>
							<option value="hour" >hours</option>
							<option value="day" >days</option>
							<option value="week" >weeks</option>
							<option value="month" >months</option>
							<option value="year" >years</option>
							
						</select>
						<button class="prop_butt" type="submit" name="ban_user" value="<?= $user['id'] ?>">ban</button></label>
						<?php }else{ ?>
							<span class="usr_edit_property_name">Banned(<?= date('H:i:s d.m.Y',$user['banned']) ?>)<br>
							<button class="prop_butt" type="submit" name="unban_user" value="<?= $user['id'] ?>">UNban</button></span>
						<?php } ?>
						
					</form>
				</div>
				<div class="prop_div">
					<form action="" method="POST">
						<span class="usr_edit_property_name">Del<br>
						<button class="prop_butt" type="submit" name="delete_user" value="<?= $user['id'] ?>">Del</button></span>
					</form>
				</div>
				
				
			</div>
			<?php } ?>
		</div>
		<?php } elseif($editUser) { ?>
			<h3>Редактировать пользователя с ID=<?= $editUser ?></h3>
			<div class="admin_edit_user">
				<form action="" method="POST">
					<?php foreach($edit_user_arr as $key=>$val){?>
						<div class="AEU_prop">
							<label>
								<span class="AEU_prop_name"><?= $key ?>:</span>
								<input class="AEU_prop_input" name="<?= $key ?>" value="<?= $val ?>">
							</label>
						</div>
					<?php } ?>
					<button type="submit" name="edit_user_complete" value="true">Сохранить</button></span>
				</form>
			</div>
		<?php }  ?>
		</content>
		<footer>ROZBYN©</footer>
	</div>
</body>
</html>