<?php
//-----------------------------
function skloneniye ($number, $word_0="Товаров",$word_1 = "Товар", $word_2_4 = "Товара"){
	$f10 = $number % 10;
	$f100 = $number % 100;
	if ($f10==1 && $f100!=11){
		return $word_1;
	} elseif ( ($f10 >= 2 && $f10 <=4) && ($f100>20 || $f100 <= 10) ) {
		return $word_2_4;
	} else {
		return $word_0;
	}
}
function timeWord($number, $interval = 'H'){
	$tempStr = (int)$number . ' ';
	switch ($interval) {
		case 'Y':
			$tempStr .= skloneniye ($number, "лет", "год", "года");
			break;
		case 'M':
			$tempStr .= skloneniye ($number, "месяцев", "месяц", "месяца");
			break;
		case 'D':
			$tempStr .= skloneniye ($number, "дней", "день", "дня");
			break;
		case 'H':
			$tempStr .= skloneniye ($number, "часов", "час", "часа");
			break;
		case 'I':
			$tempStr .= skloneniye ($number, "минут", "минута", "минуты");
			break;
		case 'S':
			$tempStr .= skloneniye ($number, "секунд", "секунда", "секунды");
			break;
	}
	return $tempStr;
}
function showLastVisitInterval($str='01.01.1970', $endStr=' назад'){
	$firstTmpStr = '';
	$secondTmpStr = '';
	$nowDate = new DateTime();
	$lastVisitDate = new DateTime($str);
	$interval = $nowDate->diff($lastVisitDate);
	$intervalY=(int)$interval->format('%Y');
	$intervalM=(int)$interval->format('%M');
	$intervalD=(int)$interval->format('%D');
	$intervalH=(int)$interval->format('%H');
	$intervalI=(int)$interval->format('%I');
	$intervalS=(int)$interval->format('%S');
	if(!empty($intervalY)){
		$firstTmpStr = timeWord($intervalY, 'Y');
		if(!empty($intervalM)){
			$secondTmpStr = timeWord($intervalM, 'M');
			return $firstTmpStr . ' и ' . $secondTmpStr . $endStr;
		} elseif (!empty($intervalD)){
			$secondTmpStr = timeWord($intervalD, 'D');
			return $firstTmpStr . ' и ' . $secondTmpStr . $endStr;
		} else {
			return $firstTmpStr . $endStr;
		}
	} elseif(!empty($intervalM)){
		$firstTmpStr = timeWord($intervalM, 'M');
		if(!empty($intervalD)){
			$secondTmpStr = timeWord($intervalD, 'D');
			return $firstTmpStr . ' и ' . $secondTmpStr . $endStr;
		} elseif (!empty($intervalH)){
			$secondTmpStr = timeWord($intervalH, 'H');
			return $firstTmpStr . ' и ' . $secondTmpStr . $endStr;
		} else {
			return $firstTmpStr . $endStr;
		}
	} elseif(!empty($intervalD)){
		$firstTmpStr = timeWord($intervalD, 'D');
		if(!empty($intervalH)){
			$secondTmpStr = timeWord($intervalH, 'H');
			return $firstTmpStr . ' и ' . $secondTmpStr . $endStr;
		} elseif (!empty($intervalI)){
			$secondTmpStr = timeWord($intervalI, 'I');
			return $firstTmpStr . ' и ' . $secondTmpStr . $endStr;
		} else {
			return $firstTmpStr . $endStr;
		}
	} elseif(!empty($intervalH)){
		$firstTmpStr = timeWord($intervalH, 'H');
		if(!empty($intervalI)){
			$secondTmpStr = timeWord($intervalI, 'I');
			return $firstTmpStr . ' и ' . $secondTmpStr . $endStr;
		} elseif (!empty($intervalS)){
			$secondTmpStr = timeWord($intervalS, 'S');
			return $firstTmpStr . ' и ' . $secondTmpStr . $endStr;
		} else {
			return $firstTmpStr . $endStr;
		}
	} elseif(!empty($intervalI)){
		$firstTmpStr = timeWord($intervalI, 'I');
		if(!empty($intervalS)){
			$secondTmpStr = timeWord($intervalS, 'S');
			return $firstTmpStr . ' и ' . $secondTmpStr . $endStr;
		} else {
			return $firstTmpStr . $endStr;
		}
	} else {
		return timeWord($intervalS, 'S') . $endStr;
	}
}
function addSaltToPassword($password, $salt){
	return md5(md5($salt).md5($password));
}
function generatePassword ($n=10){
	$pass = '';
	for($i=1; $i<=$n; $i++){
		$s = mt_rand(1,3);
		switch ($s) {
			case 1:
				$pass .= chr(mt_rand(65,90));
				break;
			case 2:
				$pass .= chr(mt_rand(97,122));
				break;
			case 3:
				$pass .= chr(mt_rand(48,57));
				break;
		}
	}
	return $pass;
}






//-----------------------------

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
$headerText = '';
$showSelf = true;
$changePass = false;
$deleteAccount = false;
//Проверка кук-----
if(!empty($_COOKIE['_ruId']) && !empty($_COOKIE['_ruKey']) && !empty($_COOKIE['_ruLVis'])){
	$logged_user_id = $myDbObj->real_escape_string($_COOKIE['_ruId']);
	$logged_user_key = $myDbObj->real_escape_string($_COOKIE['_ruKey']);
	$logged_user_time = time();
	$logged_DBuserInfo = mysqli_fetch_assoc($myDbObj->query("SELECT * FROM auth6_users WHERE id='$logged_user_id' AND userkey='$logged_user_key'"));
	if(!empty($logged_DBuserInfo)){
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
//Проверка кук-----
if(isset($_GET['name'])){
	$showUserName = $myDbObj->real_escape_string($_GET['name']);
	$mysqlRequestCondition = "short_addr='$showUserName'";
	$showSelf=false;
	$baseDir='../';
} elseif(isset($_GET['id'])) {
	$showUserId = $myDbObj->real_escape_string($_GET['id']);
	$mysqlRequestCondition = "id='$showUserId'";
	$showSelf=false;
	$baseDir='../';
}else{
	$baseDir='./';
	if(isset($_GET['changePassword']) && $_GET['changePassword'] ==='true'){
		$changePass = true;
	} elseif(isset($_GET['deleteAccount']) && $_GET['deleteAccount'] ==='true'){
		$deleteAccount = true;
	}
}


if($userAuth==='NOT_VERIFIED' || $userAuth === false){
	header("Location: $baseDir");
}elseif($userAuth===true){
	$errorMessage = '';
	if($showSelf){
		if($changePass){
			//создаем форму изменения пароля
			$form_passChange_HTML = '';
			$form_passChange = new Inputform('','POST',[],'form_passChange');
			$form_passChange->addHtml('<p class="info_mes">Для изменения пароля введите старый пароль, новый пароль и подтверждение пароля</p>');
			$form_passChange->labelOpen('<span class="fieldInfo">Старый пароль<span class="spanRequired">*</span></span>');
			$oldPass = $form_passChange->addPasswordInput('oldPass', true, ['placeholder'=>'Старый пароль', 'maxlength'=>30], 'Введите старый пароль!');
			$newPassID = $form_passChange->id;
			$form_passChange->labelClose('');
			$form_passChange->labelOpen('<span class="fieldInfo">Новый пароль<span class="spanRequired">*</span></span>');
			$newPass = $form_passChange->addPasswordInput('newPass', true, ['placeholder'=>'Новый пароль', 'maxlength'=>30], 'Введите новый пароль!', 'Password', 'Некорректный пароль!<br>Русские символы недопустимы,<br>от 6 до 30 символов.');
			$newPassID = $form_passChange->id;
			$form_passChange->labelClose('');
			$form_passChange->labelOpen('<span class="fieldInfo">Подтверждение пароля<span class="spanRequired">*</span></span>');
			$newPassConfirm = $form_passChange->addPasswordInput('newPassConfirm', true, ['placeholder'=>'Подтверждение пароля', 'maxlength'=>30], 'Введите подтверждение пароля!', 'Password', 'Некорректный пароль!<br>Русские символы недопустимы,<br>от 6 до 30 символов.', $newPassID, 'Пароли должны совпадать');
			$form_passChange->labelClose('');
			$form_passChange->addButton('submit', 'Сменить пароль');
			$form_passChange_HTML = $form_passChange->returnFullHtml();
			//создаем форму изменения пароля
			//проверяем данные и вносим изменения в БД
			if($form_passChange->formSended && $form_passChange->noErrors){
				$oldPass = $myDbObj->real_escape_string($oldPass);
				$newPass = $myDbObj->real_escape_string($newPass);
				$old_saltedPassword = addSaltToPassword($oldPass, $logged_DBuserInfo['salt']);
				if($old_saltedPassword == $logged_DBuserInfo['password']){
					$user_id = $logged_DBuserInfo['id'];
					$newSalt = generatePassword();
					$new_saltedPassword = addSaltToPassword($newPass, $newSalt);
					$res = $myDbObj->query("UPDATE auth6_users SET password='$new_saltedPassword', salt = '$newSalt' WHERE id='$user_id'");
					if($res === false){
						$errorMessage = '<div class="errorMessage">Ошибка записи данных в бд. ' .$myDbObj->error. '</div>';
					} else {
						$errorMessage = '<p class="info_mes">Пароль успешно изменен.</p>';
						$form_passChange_HTML = '';
					}
				} else {
					$errorMessage = '<div class="errorMessage">Неправильный пароль!</div>';
				}
			}
			//проверяем данные и вносим изменения в БД
		} elseif($deleteAccount){
			//создаём форму удаления аккаунта
			$form_accDelete_HTML = '';
			$form_accDelete = new Inputform('','POST',[],'form_accDelete');
			$form_accDelete->addHtml('<div class="info_mes">Для удаления аккаунта введите пароль.</div>');
			$form_accDelete->labelOpen('<span class="fieldInfo">Пароль<span class="spanRequired">*</span></span>');
			$AccDeletePass = $form_accDelete->addPasswordInput('AccDeletePass', true, ['placeholder'=>'Пароль', 'maxlength'=>30], 'Введите пароль!');
			$form_accDelete->labelClose('');
			$form_accDelete->addButton('submit', 'Удалить аккаунт?');
			$form_accDelete_HTML = $form_accDelete->returnFullHtml();
			//создаём форму удаления аккаунта
			
			//удаляем аккаунт если пароль верный
			if($form_accDelete->formSended && $form_accDelete->noErrors){
				$deleteAcc_saltedPassword = addSaltToPassword($AccDeletePass, $logged_DBuserInfo['salt']);
				if($deleteAcc_saltedPassword == $logged_DBuserInfo['password']){
					$res = $myDbObj->query('DELETE FROM auth6_users WHERE id="'.$logged_DBuserInfo['id'].'"');
					if($res === false){
						$errorMessage = '<div class="errorMessage">Ошибка записи данных в бд. ' .$myDbObj->error. '</div>';
					} else {
						header("Location: $baseDir");
					}
				} else {
					$errorMessage = '<div class="errorMessage">Неправильный пароль!</div>';
				}
			}
			//удаляем аккаунт если пароль верный
		} else {
			//создаём форму изменения личной информации
			$html_inputs = [];
			$form_info_edit = new Inputform('','POST',[],'user_info_edit');
			$form_info_edit->showFormIdOnEveryElement(true);
			$form_info_edit->functionAddToUserValues = function($str){
				$returnStr = htmlspecialchars($str, ENT_QUOTES|ENT_HTML5);
				return $returnStr;
			};
			
			
			$info_name = $form_info_edit->addTextInput('info_name', true, ['placeholder'=>'Имя', 'maxlength'=>30, 'value'=>$logged_DBuserInfo['name']]);
			$html_inputs['info_name'] = $form_info_edit->id;
			
			
			$info_surname = $form_info_edit->addTextInput('info_surname', true, ['placeholder'=>'Фамилия', 'maxlength'=>30, 'value'=>$logged_DBuserInfo['surname']]);
			$html_inputs['info_surname'] = $form_info_edit->id;
			
			
			$info_gender = $form_info_edit->addRadioButtonGroup('info_gender', true, false);
			$html_inputs['info_gender'] = $form_info_edit->id;
			$mSelected = [];
			$fSelected = [];
			if(!empty($logged_DBuserInfo['gender'])){
				if($logged_DBuserInfo['gender'] == 'm'){
					$mSelected = ['checked'=>''];
				} elseif ($logged_DBuserInfo['gender'] == 'f'){
					$fSelected = ['checked'=>''];
				}
			}
			$form_info_edit->addRadioToGroup($html_inputs['info_gender'], 'm', '<label>', 'Мужской</label>', $mSelected);
			$form_info_edit->addRadioToGroup($html_inputs['info_gender'], 'f', '<label>', 'Женский</label>', $fSelected);
			
			
			$info_birthday = '';
			if($form_info_edit->formSended){
				if(!empty($_POST['info_birthday'])){
					$info_birthday = $myDbObj->real_escape_string($_POST['info_birthday']);
				}
			} elseif(!empty($logged_DBuserInfo['birthday'])){
				$info_birthday = date('Y-m-d', (int)$logged_DBuserInfo['birthday']);
			}
			$form_info_edit->addHTML('<input name="info_birthday" type="date" value="'.$info_birthday.'" form="user_info_edit">');
			$html_inputs['info_birthday'] = $form_info_edit->id;
			
			
			$info_city = $form_info_edit->addTextInput('info_city', true, ['placeholder'=>'Город', 'maxlength'=>30, 'value'=>$logged_DBuserInfo['city']]);
			$html_inputs['info_city'] = $form_info_edit->id;
			
			
			$info_country = $form_info_edit->addTextInput('info_country', true, ['placeholder'=>'Страна', 'maxlength'=>30, 'value'=>$logged_DBuserInfo['country']]);
			$html_inputs['info_country'] = $form_info_edit->id;
			
			
			$info_lang = $form_info_edit->addSelect ('info_lang', false, true);
			$html_inputs['info_lang'] = $form_info_edit->id;
			$avalableLangs = ['', 'Русский', 'Английский', "Украинский", "Белорусский", "Казахский", "Узбекский"];
			foreach($avalableLangs as $val){
				if($logged_DBuserInfo['lang'] == $val){
					$tags = ['selected'=>''];
				} else {
					$tags = [];
				}
				$form_info_edit->addOptionToSelect($html_inputs['info_lang'], $val, $val, $tags);
			}
			
			$info_about = $form_info_edit->addTextArea('info_about', ['placeholder'=>'О себе', 'maxlength'=>500, 'rows'=>'4'], $logged_DBuserInfo['about'], true);
			$html_inputs['info_about'] = $form_info_edit->id;
			
			
			$current_short_addr = $logged_DBuserInfo['short_addr'];
			$RegEx = $form_info_edit->validateLoginRegEx;
			$form_info_edit->validateCustomFunction = function($str) use($myDbObj, $RegEx, $current_short_addr) {
				if($current_short_addr == $str){
					return true;
				}
				if(preg_match($RegEx,$str)===1){
					if(empty(mysqli_fetch_assoc($myDbObj->query("SELECT id FROM auth6_users WHERE short_addr='$str'")))){
						return true;
					} else {
						return false;
					}
				}
			};
			$info_short_addr = $form_info_edit->addTextInput('info_short_addr', true, ['placeholder'=>'Короткий адрес', 'maxlength'=>30, 'value'=>$logged_DBuserInfo['short_addr']], false, 'CustomFunction', 'Адрес занят либо некорректный адрес!<br>Не менее 3 символов и не более 30,<br>только латинские символы, "-", "_".');
			$html_inputs['info_short_addr'] = $form_info_edit->id;
			
			
			
			$info_avatar = $form_info_edit->addFileInput('info_avatar', ['accept'=>'image/*'], 31457280, false, false, './img/'.$logged_DBuserInfo['id'].'/');
			$html_inputs['info_avatar'] = $form_info_edit->id;
			
			
			$form_info_edit->addButton('submit', 'Сохранить');
			$html_inputs['info_submit'] = $form_info_edit->id;
			
			
			$tempArr = $html_inputs;
			foreach($tempArr as $key=>$id){
				$html_inputs[$key] = $form_info_edit->returnHtmlbyId($id);
			}
			$html_inputs['form_info_edit'] = $form_info_edit->formOpenHtml() . $form_info_edit->formCloseHtml();
			unset($tempArr);
			
			
			$htmlFormChangePass = '<form action="" method="GET"><button type="submit" name="changePassword" value="true">Сменить пароль</button></form>';
			$htmlFormDeleteAcc = '<form action="" method="GET"><button type="submit" name="deleteAccount" value="true">Удалить аккаунт</button></form>';
			//создаём форму изменения личной информации
			
			//проверяем новые сообщения
			$res = mysqli_fetch_assoc($myDbObj->query("SELECT COUNT(*) FROM `auth6_messages` WHERE recipient_id=".$logged_DBuserInfo['id']." AND readed=0"));
			if(empty($res)){
				$haveNewMess = '';
			} else {
				if($res['COUNT(*)'] == '0'){
					$haveNewMess = '';
				} else {
					$haveNewMess = '('.$res['COUNT(*)'].')';
				}
			}
			//проверяем новые сообщения
			
			//вносим изменения в БД
			if($form_info_edit->formSended && $form_info_edit->noErrors){
				//проверяем и приводим к формату данные
				$info_user_id = $logged_DBuserInfo['id'];
				
				$info_name = $myDbObj->real_escape_string($info_name);
				
				$info_surname = $myDbObj->real_escape_string($info_surname);
				
				if($info_gender != 'm' && $info_gender != 'f'){
					$info_gender = '';
				}
				
				if(preg_match('#^\d{4}-\d{2}-\d{2}$#', $info_birthday)){
					$info_birthday = strtotime($info_birthday);
				} else {
					$info_birthday = 0;
				}
				
				$info_city = $myDbObj->real_escape_string($info_city);
				
				$info_country = $myDbObj->real_escape_string($info_country);
				
				if($info_lang == false || !in_array($info_lang, $avalableLangs)){
					$info_lang = '';
				}
				$info_about = $myDbObj->real_escape_string($info_about);
				
				$info_short_addr = $myDbObj->real_escape_string($info_short_addr);
				
				if($info_avatar === false){
					$info_avatar = $logged_DBuserInfo['avatar'];
				} else {
					$info_avatar = 'img/'.$logged_DBuserInfo['id'].'/'.$info_avatar;
				}
				//проверяем и приводим к формату данные
				$res = $myDbObj->query("UPDATE auth6_users SET
				name='$info_name',
				surname='$info_surname',
				birthday='$info_birthday',
				gender='$info_gender',
				country='$info_country',
				city='$info_city',
				lang='$info_lang',
				about='$info_about',
				avatar='$info_avatar',
				short_addr='$info_short_addr'
				WHERE id='$info_user_id'");
				if($res === false){
					$errorMessage = '<div class="errorMessage">Ошибка записи данных в БД! '.$myDbObj->error.'</div>';
				}
			}
			//вносим изменения в БД
		}
	} else {
		$showing_DBuserInfo = mysqli_fetch_assoc($myDbObj->query("SELECT * FROM auth6_users WHERE $mysqlRequestCondition"));
		//пол
		if(!empty($showing_DBuserInfo['gender'])){
			if($showing_DBuserInfo['gender'] == 'm'){
				$sUserGender = 'Мужской';
			} elseif($showing_DBuserInfo['gender'] == 'f'){
				$sUserGender = 'Женский';
			} else {
				$sUserGender = '';
			}
		} else {
			$sUserGender = '';
		}//пол
		
		//возраст и др
		if($showing_DBuserInfo['birthday'] != 0){
			$nowDate = new DateTime();
			$sUserBirthday = date('d.m.Y', $showing_DBuserInfo['birthday']);
			$sdbuiBirth = new DateTime($sUserBirthday);
                        $difference = $nowDate->diff($sdbuiBirth);
			$sUserAge = timeWord(($difference->format('%Y')), 'Y');
		} else {
			$sUserBirthday = '';
			$sUserAge = '';
		}//возраст и др
		
		//возраст акка и поледний визит
		$sUserAccountAge =  showLastVisitInterval(date('H:i:s d.m.Y', $showing_DBuserInfo['registerDate']), '');
		$sUserLastVisit =  showLastVisitInterval(date('H:i:s d.m.Y', $showing_DBuserInfo['last_visit']), ' назад');
		//возраст акка и поледний визит
		
	}
}


?>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="<?= $baseDir ?>styles.css" type="text/css"/>
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
		
		
		
		<?php if($showSelf){ ?>
			<?php if($changePass===true){ ?>
				<h1>Смена пароля</h1>
				<div class="logIn">
					<?= $errorMessage ?>
					<?= $form_passChange_HTML ?>
					
				</div>
				
				
			<?php } elseif($deleteAccount===true){ ?>
				<h1>Удаление аккаунта</h1>
				<div class="logIn">
					<?= $errorMessage ?>
					<?= $form_accDelete_HTML ?>
				</div>
				
				
			<?php } else { ?>
				<h1>Мой профиль</h1>
				<div class="editing_userInfo">
					<?= $errorMessage ?>
					<div class="suAvatar" style="background-image: url('<?= $baseDir.$logged_DBuserInfo['avatar'] ?>')">
						<label class="changeAvatar">
							<?= $html_inputs['info_avatar'] ?>
							Изменить аватар
						</label>
					</div>
					<div class="link-messages"><a href="<?= $baseDir ?>messages">Мои сообщения<?= $haveNewMess ?></a></div>
					<div class="suInfo">
						<?= $html_inputs['form_info_edit'] ?>
						<div><span class="info_title">Имя:</span> <span class="info_text"><?= $html_inputs['info_name'] ?></span></div>
						<div><span class="info_title">Фамилия:</span> <span class="info_text"><?= $html_inputs['info_surname'] ?></span></div>
						<div><span class="info_title">Пол:</span> <span class="info_text"><?= $html_inputs['info_gender'] ?></span></div>
						<div><span class="info_title">День рождения:</span> <span class="info_text"><?= $html_inputs['info_birthday'] ?></span></div>
						<div><span class="info_title">Город:</span> <span class="info_text"><?= $html_inputs['info_city'] ?></span></div>
						<div><span class="info_title">Страна:</span> <span class="info_text"><?= $html_inputs['info_country'] ?></span></div>
						<div><span class="info_title">Родной язык:</span> <span class="info_text"><?= $html_inputs['info_lang'] ?></span></div>
						<div><span class="info_title">О себе:</span> <span class="info_text"><?= $html_inputs['info_about'] ?></span></div>
						<div><span class="info_title">Короткий адрес:</span> <span class="info_text"><?= $html_inputs['info_short_addr'] ?></span></div>
						<div><span class="info_title">Сохранить:</span> <span class="info_text"><?= $html_inputs['info_submit'] ?></span></div>
						<div><span class="info_title">Сменить пароль:</span> <span class="info_text"><?= $htmlFormChangePass ?></span></div>
						<div><span class="info_title">Удалить аккаунт:</span> <span class="info_text"><?= $htmlFormDeleteAcc ?></span></div>
					</div>
			</div>
			<?php }?>
		<?php }else{ ?>
		<h1>Просмотр профиля<br><?= $showing_DBuserInfo['name'] . ' ' . $showing_DBuserInfo['surname'] ?></h1>
			<div class="showing_userInfo">
				<div class="suAvatar" style="background-image: url('<?= $baseDir.$showing_DBuserInfo['avatar'] ?>')">
					<div class="send_message">
						<a href="<?= $baseDir ?>messages?to=<?= $showing_DBuserInfo['id'] ?>">Отправить сообщение</a>
					</div>
				</div>
				<div class="suInfo">
					<p><span class="info_title">Имя:</span> <span class="info_text"><?= $showing_DBuserInfo['name'] ?></span></p>
					<p><span class="info_title">Фамилия:</span> <span class="info_text"><?= $showing_DBuserInfo['surname'] ?></span></p>
					<p><span class="info_title">Пол:</span> <span class="info_text"><?= $sUserGender ?></span></p>
					<p><span class="info_title">Возраст:</span> <span class="info_text"><?= $sUserAge ?></span></p>
					<p><span class="info_title">День рождения:</span> <span class="info_text"><?= $sUserBirthday ?></span></p>
					<p><span class="info_title">Город:</span> <span class="info_text"><?= $showing_DBuserInfo['city'] ?></span></p>
					<p><span class="info_title">Страна:</span> <span class="info_text"><?= $showing_DBuserInfo['country'] ?></span></p>
					<p><span class="info_title">Родной язык:</span> <span class="info_text"><?= $showing_DBuserInfo['lang'] ?></span></p>
					<p><span class="info_title">О себе:</span> <span class="info_text"><?= $showing_DBuserInfo['about'] ?></span></p>
					<p><span class="info_title">На сайте:</span> <span class="info_text"><?= $sUserAccountAge ?></span></p>
					<p><span class="info_title">Последний вход:</span> <span class="info_text"><?= $sUserLastVisit ?></span></p>
				</div>
			</div>
		<?php } ?>
		</content>
		<!--
		<form action="" method="POST">
		<input name="date" type="date" value="<?= $date1 ?>">
		<input name="date2" type="date" value="<?= $date2 ?>">
		<input type="submit">
		</form>
		-->
		<footer>ROZBYN©</footer>
	</div>
</body>
</html>