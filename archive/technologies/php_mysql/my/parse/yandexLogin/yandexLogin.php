<?php
echo '<pre>';

set_time_limit(0);
ini_set('max_execution_time', 0);
//ignore_user_abort();

$startLogin = 'abb';
//file_put_contents(__DIR__ . '/logins.txt', "");
//file_put_contents(__DIR__ . '/avalable_logins.txt', "");


if(is_file(__DIR__ . '/lastCheckedLogin.txt')){
	$savedLogin = file_get_contents(__DIR__ . '/lastCheckedLogin.txt');
}
$currLogin = (!empty($savedLogin)) ? $savedLogin : $startLogin;




writeLoginToFile($currLogin);
for ($i = 0; $i < 51000; $i++) {
	$currLogin = getNextLogin($currLogin);
	$check = checkYandexLogin($currLogin);
	if($check === 'AVAILABLE'){
		writeAvalableLoginToFile($currLogin);
	}
	writeLoginToFile("$currLogin : $check");
	saveLastCheckedLogin($currLogin);
	flush();
	ob_flush();
	flush();
	ob_flush();
	echo "$currLogin : $check\r\n";
}



//$r = checkYandexLogin('jopasrucasd231hkoi');
//var_dump($r);


function writeLoginToFile($login) {
	file_put_contents(__DIR__ . '/logins.txt', "$login\r\n", FILE_APPEND);
}

function writeAvalableLoginToFile($login) {
	file_put_contents(__DIR__ . '/avalable_logins.txt', "$login\r\n", FILE_APPEND);
}

function saveLastCheckedLogin($login) {
	file_put_contents(__DIR__ . '/lastCheckedLogin.txt', $login);
}


function getNextLogin($currLogin = '') {
	$arAvLetters = [
		'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
		0,1,2,3,4,5,6,7,8,9,'-','.'
	];
	$arAvalableSymbols = $arAvLetters;
	if(!is_string($currLogin) || $currLogin === '') return (string) $arAvalableSymbols[0];
	
	$arNotFirstLetter = [0,1,2,3,4,5,6,7,8,9,'-','.'];
	$arNotLastLetter = ['-','.'];
	$arNotInRow = ['-','.'];
	
	$arNotFirstLetter = array_combine($arNotFirstLetter, $arNotFirstLetter);
	$arNotLastLetter = array_combine($arNotLastLetter, $arNotLastLetter);
	$arNotInRow = array_combine($arNotInRow, $arNotInRow);
	
	
	
	
	$arRevSymbols = array_flip($arAvalableSymbols);
//	var_dump($arNotFirstLetter, $arRevSymbols);
	$revLoginSymbols = str_split(strrev($currLogin));
	
	$resultRevArr = [];
	$nextActionsNotRequired = false;
	$lastLoginIndex = count($revLoginSymbols) - 1;
	foreach ($revLoginSymbols as $ind => $lett) {
		if(!isset($arRevSymbols[$lett])) return false;
		if($nextActionsNotRequired){
			$resultRevArr[] = $lett;
			continue;
		}
		$lettPos = $arRevSymbols[$lett];
		if(isset($arAvalableSymbols[$lettPos+1])){
			$nextSymbol = $arAvalableSymbols[$lettPos+1];
			// $ind === $lastLoginIndex || $ind === 0
			if(($ind === 0) && isset($arNotLastLetter[$nextSymbol])){
				$resultRevArr[] = $arAvalableSymbols[0];
			} else if (($ind === $lastLoginIndex) && isset($arNotFirstLetter[$nextSymbol])) {
				$resultRevArr[] = $arAvalableSymbols[0];
			} else if (isset($arNotInRow[$nextSymbol]) && isset($arNotInRow[$revLoginSymbols[$ind+1]])) {
				$resultRevArr[] = $arAvalableSymbols[0];
			} else {
				$resultRevArr[] = $nextSymbol;
				$nextActionsNotRequired = true;
			}	
		} else {
			$resultRevArr[] = $arAvalableSymbols[0];
		}
	}
	if(!$nextActionsNotRequired){
		$resultRevArr[] = $arAvalableSymbols[0];
	}
	
	return strrev(implode('', $resultRevArr));
	
}



function checkYandexLogin($login) {
	$curl = curl_init();
	$randomSuka = uniqid('ndfionh-09-', true);

	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://passport.yandex.ru/registration-validations/login",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "login=$login&track_id=$randomSuka",
		CURLOPT_HTTPHEADER => array(
			"X-Requested-With: XMLHttpRequest",
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	
	if ($err) {
		return false;
	} else {
		$ar = json_decode($response, true);
		if(!empty($ar) && !empty($ar['status']) && $ar['status'] == 'ok'){
			return 'AVAILABLE';
		} else if (!empty($ar) && !empty($ar[0]) && $ar[0] == 'login.not_available'){
			return 'NOT AVAILABLE';
		} else {
			return $response;
		}
	}
}
