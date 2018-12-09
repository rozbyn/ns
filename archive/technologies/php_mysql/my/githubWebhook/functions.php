<?php
////////////////////////////////////////////////////////////////

/* Файл в который функции дебага будут записывать */
if(!defined('DEBUG_FILE')) define('DEBUG_FILE', 'dbug.html');
////////////////////////////////////////////////////////////////


/**
 * Функция отправляет запрос на сервер
 * 
 * @param string $url Строка адреса, с протоколом, без порта напр.: "https://www.example.com"
 * 
 * @param array|string $dataArr Массив или строка с данными для отправки,
 * которые пропускаются через функцию http_build_query
 * 
 * @param boolean $noAnsver Если установлен в true, то функция не будет ждать ответ от сервера
 * 
 * @param boolean $isPost Отправлять POST запрос, по умолчанию true
 * 
 * @return boolean|array|string возвращает false если была ошибка,<br> 
 * true если при установленном флаге $noAnsver данные были успешно отправлены,<br>
 * массив данных если ответ от сервера был в формате json,<br>
 * строка если ответ от сервера был не в формате json,<br>
 * пустая строка если получен пустой ответ
 * 
 */
function sendBaseRequest ($url = '', $dataArr = [], $noAnsver = false, $isPost = true) {
	$urlParts = parse_url($url);
	$method = $isPost ? 'POST' : 'GET';
	$transport = ($urlParts['scheme'] == 'https') ? 'ssl' : 'tcp';
	$port = ($urlParts['scheme'] == 'https') ? 443 : 80;
	
	if (!($fp = stream_socket_client($transport."://".$urlParts['host'].":".$port))) {
		return false;
	} else {
		$data = http_build_query($dataArr);
		$headers = $method. " ".$urlParts['path']." HTTP/1.0\r\n"
		 . "Host: ".$urlParts['host']."\r\n"
//		 . "Accept: */*\r\n"
		 . "Content-Type: application/x-www-form-urlencoded\r\n"
		 . "Content-length: ".(mb_strlen($data))."\r\n"
//		 . "Connection: Close\r\n"
		 . "\r\n";
		$wrResult = fwrite($fp, $headers . $data . "\r\n\r\n");
		if($noAnsver){
			fclose($fp);
			return $wrResult !== false;
		}
		for($i = 0, $rd = ''; (!feof($fp) && $i < 10000); $i++, $rd .= fgets($fp, 8192));
		$requestBody = explode("\r\n\r\n", $rd)[1];
		$jsonArr = json_decode($requestBody, true);
		if($jsonArr === null){
			return $requestBody;
		} else {
			return $jsonArr;
		}
	}
}

/**
 * Функция отправляет api запрос bitrix24, все параметры не обязательные
 * 
 * @param string $method название метода api bitrix24, по умолчанию 'crm.contact.list'
 * @param array $params параметры метода, по умолчанию пустой массив
 * @param string $url адрес bitrix24, если не указан, подставляется из константы BASE_URL
 * @param boolean $noAns флаг игнорирования ответа, по умолчанию false
 * @return boolean|array|string возвращаемые значения аналогичны функции sendBaseRequest()
 * @see sendBaseRequest()
 */
function sendRequest ($method = '', $params = [], $url = '', $noAns = false) {
	if($method == '') $method = 'crm.contact.list';
	if($url == '') $url = BASE_URL;
	$sendUrl = $url . $method;
	return sendBaseRequest($sendUrl, $params, $noAns);
}

/**
 * Функция отправляет api запрос bitrix24 методом "batch" (пакетная обработка нескольких методов)
 * @link https://dev.1c-bitrix.ru/rest_help/general/batch.php метод api batch
 * 
 * @param array $arCMD массив команд для метода "batch", вида: <br>
 * $arCMD = ['идентификатор операции' => ['метод api' => ['массив' => 'параметров']]]; <br>
 * где: <br>
 * "идентификатор операции" - любое буквенно-числовое обозначение, напр.: "find_contacts_by_phone" <br>
 * "метод api" - название метода api bitrix24, напр,: "crm.contact.list"<br>
 * "массив параметров" - массив параметров метода, указанного в "метод api", напр.:<br>
 * $arParams = ['filter' => ['PHONE' => $orderphone]];
 * 
 * @param boolean $halt останавливать выполнение пакета команд при возникновения ошибки, по умолчанию false
 * @param array $auth массив данных для авторизации по протоколу OAuth 2.0
 * @param string $url адрес bitrix24, по умолчанию принимает значение константы BASE_URL
 * @param boolean $noAnsver флаг игнорирования ответа, по умолчанию false
 * @return boolean|array|string возвращаемые значения аналогичны функции sendBaseRequest()
 * @see sendBaseRequest()
 * 
 */
function sendBatch ($arCMD, $halt = false, $auth = false, $url = '', $noAnsver = false) {
	$arParams = [];
	$cmdAr = [];
	
	$arParams['halt'] = $halt;
	if ($auth !== false && is_array($auth)) $arParams['auth'] = $auth;
	if ($url == '') $url = BASE_URL;
	
	foreach ($arCMD as $comID => $cmd) {
		$cmdAr[$comID] = key($cmd) . '?' . http_build_query(current($cmd));
	}
	
	$arParams['cmd'] = $cmdAr;
	
	return sendBaseRequest($url . 'batch', $arParams, $noAnsver);
}

class B24RestConnector
{
//	'access_token' => 'd788595b0029c11800291bc4000000010000037eebc5eda99428446ede093b34e6c7b2'
	public $app_id = '';
	public $app_secret = '';
	
	public $auth_token = '';
	public $refresh_token = '';
	public $client_endpoint = '';
	public $user_id = '';
	
	public $tokenCreated = '';
	public $tokenExpires = '';
	
	public $currentState = 0;
	
	public $stage2_code = '';
	
	public $dbg = false;
	
	public $useHook = false;
	public $webHookUrl = '';
	
	public $needLogging = false;
	public $loggingObj = false;

	/**
	 * Функция отправляет запрос на сервер
	 * 
	 * @param string $url Строка адреса, с протоколом, без порта напр.: "https://www.example.com"
	 * 
	 * @param array|string $dataArr Массив или строка с данными для отправки,
	 * которые пропускаются через функцию http_build_query
	 * 
	 * @param boolean $noAnsver Если установлен в true, то функция не будет ждать ответ от сервера
	 * 
	 * @param boolean $isPost Отправлять POST запрос, по умолчанию true
	 * 
	 * @return boolean|array|string возвращает false если была ошибка,<br> 
	 * true если при установленном флаге $noAnsver данные были успешно отправлены,<br>
	 * массив данных если ответ от сервера был в формате json,<br>
	 * строка если ответ от сервера был не в формате json,<br>
	 * пустая строка если получен пустой ответ
	 * 
	 */
	public static function sendBaseRequest ($url = '', $dataArr = [], $noAnsver = false) 
	{
		$urlParts = parse_url($url);
		$transport = ($urlParts['scheme'] == 'https') ? 'ssl' : 'tcp';
		$port = ($urlParts['scheme'] == 'https') ? 443 : 80;
		if (!($fp = stream_socket_client($transport."://".$urlParts['host'].":".$port))) {
			return false;
		} else {
			$query = $urlParts['path'] . (!empty($urlParts['query']) ? '?' . $urlParts['query'] : '');
			$data = http_build_query($dataArr);
			$headers = "POST ".$query." HTTP/1.0\r\n"
			 . "Host: ".$urlParts['host']."\r\n"
			 . "Content-Type: application/x-www-form-urlencoded\r\n"
			 . "Content-length: ".(mb_strlen($data))."\r\n"
			 . "\r\n";
			$wrResult = fwrite($fp, $headers . $data . "\r\n\r\n");
			if($noAnsver){
				fclose($fp);
				return $wrResult !== false;
			}
			for($i = 0, $rd = ''; (!feof($fp) && $i < 10000); $i++){
				$rd .= fgets($fp, 8192);
			}
			$requestBody = explode("\r\n\r\n", $rd)[1];
			$jsonArr = json_decode($requestBody, true);
			if($jsonArr === null){
				return $requestBody;
			} else {
				return $jsonArr;
			}
		}
	}
	/**
	 * Функция отправляет api запрос bitrix24 методом "batch" (пакетная обработка нескольких методов)
	 * @link https://dev.1c-bitrix.ru/rest_help/general/batch.php метод api batch
	 * 
	 * @param array $arCMD массив команд для метода "batch", вида: <br>
	 * $arCMD = ['идентификатор операции' => ['метод api' => ['массив' => 'параметров']]]; <br>
	 * где: <br>
	 * "идентификатор операции" - любое буквенно-числовое обозначение, напр.: "find_contacts_by_phone" <br>
	 * "метод api" - название метода api bitrix24, напр,: "crm.contact.list"<br>
	 * "массив параметров" - массив параметров метода, указанного в "метод api", напр.:<br>
	 * $arParams = ['filter' => ['PHONE' => $orderphone]];
	 * 
	 * @param boolean $halt останавливать выполнение пакета команд при возникновения ошибки, по умолчанию false
	 * @param boolean $noAnsver флаг игнорирования ответа, по умолчанию false
	 * @return boolean|array|string возвращаемые значения аналогичны функции sendBaseRequest()
	 * @see B24RestConnector::sendBaseRequest()
	 * 
	 */
	public function sendBatch ($arCMD, $halt = false, $noAnsver = false) 
	{
		$noAns = ($this->needLogging === false) ? $noAns : false ;
		$arParams = [];
		$cmdAr = [];

		$arParams['halt'] = $halt;
		
		if($this->useHook){
			$url = $this->webHookUrl;
		} else {
			$url = $this->client_endpoint;
			$arParams['access_token'] = $this->auth_token;
		}
		if($this->needLogging) {
			$paramsForLog = $arParams;
			$cmdForLog = [];
		}
		
		foreach ($arCMD as $comID => $cmd) {
			$cmdAr[$comID] = key($cmd) . '?' . http_build_query(current($cmd));
			if($this->needLogging) $cmdForLog[$comID] = [key($cmd) => current($cmd)];
		}

		$arParams['cmd'] = $cmdAr;
		if($this->needLogging) $paramsForLog['cmd'] = $cmdForLog;
		$requestResponce = $this->sendBaseRequest($url . 'batch', $arParams, $noAnsver);
		if($this->needLogging){
			$this->loggingObj->preparelogApiRequest($url . 'batch', $paramsForLog, $requestResponce);
		}
		return $requestResponce;
	}
	
	/**
	 * Функция отправляет api запрос bitrix24, все параметры не обязательные
	 * 
	 * @param string $method название метода api bitrix24, по умолчанию 'server.time'
	 * @param array $params параметры метода, по умолчанию пустой массив
	 * @param boolean $noAns флаг игнорирования ответа, по умолчанию false
	 * @return boolean|array|string возвращаемые значения аналогичны функции sendBaseRequest()
	 * @see sendBaseRequest()
	 */
	public function sendRequest ($method = '', $params = [], $noAns = false) 
	{
		$noAns = ($this->needLogging === false) ? $noAns : false ;
		if($method == '') $method = 'server.time';
		if($this->useHook){
			$url = $this->webHookUrl;
		} else {
			$url = $this->client_endpoint;
			$params['access_token'] = $this->auth_token;
		}
		
		$sendUrl = $url . $method;
		$requestResponce = $this->sendBaseRequest($sendUrl, $params, $noAns);
		if($this->needLogging){
			$this->loggingObj->preparelogApiRequest($sendUrl, $params, $requestResponce);
		}
		return $requestResponce;
	}

	public function __construct ($app_id = '', $app_secret = '') 
	{
		$this->app_id = $app_id;
		$this->app_secret = $app_secret;
	}
	
	public function initVarablesByArr($arr) 
	{		
		if(!empty($arr['access_token'])) $this->auth_token = $arr['access_token'];
		if(!empty($arr['refresh_token'])) $this->refresh_token = $arr['refresh_token'];
		if(!empty($arr['client_endpoint'])) $this->client_endpoint = $arr['client_endpoint'];
		if(!empty($arr['user_id'])) $this->user_id = $arr['user_id'];
		$this->tokenCreated = !empty($arr['tokenCreated']) ? $arr['tokenCreated'] : time();
		if(!empty($arr['expires_in'])) $this->tokenExpires = $arr['expires_in'];
	}
	
	public function initAuthArrByVarables() 
	{
		$returnArray = [
		 'access_token' => $this->auth_token,
		 'refresh_token' => $this->refresh_token,
		 'client_endpoint' => $this->client_endpoint,
		 'user_id' => $this->user_id,
		 'tokenCreated' => $this->tokenCreated,
		 'expires_in' => $this->tokenExpires
		];
		return $returnArray;
	}
	
	
	public function checkRequiredFields()
	{
		if($this->dbg) echo 'Проверяем обязательные поля' . '<br>';
		if(empty($this->auth_token)){ 
			
			return false;
		}
		if(empty($this->client_endpoint)) return false;
		if(empty($this->tokenExpires)) return false;
		return true;
	}
	
	public function haveSavedToken ()
	{
		if($this->dbg) echo 'Проверяем есть ли сохраненный токен' . '<br>';
		$tokArr = $this->getSavedToken();
		if($tokArr === false) return false;
		$this->initVarablesByArr($tokArr);
		$res = $this->checkRequiredFields();
		return $res;
	}
	
	public function haveRequiredAuthParamsInRequest ()
	{
		if (
		 !empty($_REQUEST['auth']['access_token']) &&
		 !empty($_REQUEST['auth']['client_endpoint']) &&
		 !empty($_REQUEST['auth']['expires_in'])
		) {
			$this->initVarablesByArr($_REQUEST['auth']);
			return $this->checkRequiredFields();
		} elseif(
			!empty($_REQUEST['AUTH_ID']) &&
			!empty($_REQUEST['AUTH_EXPIRES']) &&
			!empty($_REQUEST['DOMAIN']) 
		) {
			$authArr = [
			 'access_token' => $_REQUEST['AUTH_ID'],
			 'expires_in' => $_REQUEST['AUTH_EXPIRES'],
			 'client_endpoint' => 'https://' . $_REQUEST['DOMAIN'] . '/rest/'
			];
			$this->initVarablesByArr($authArr);
			return true;
		} else {
			return false;
		}
	}
	
	public function recivedValidData()
	{
		if(
			!empty($_REQUEST['bx24Portal']) && 
			filter_var($_REQUEST['bx24Portal'], FILTER_VALIDATE_URL)
		){
			$this->client_endpoint = $_REQUEST['bx24Portal'];
			return true;
		} elseif (
			!empty($this->client_endpoint) && 
			filter_var($this->client_endpoint, FILTER_VALIDATE_URL)
		) {
			return true;
		}
		return false;
	}
	
	public function returnedFromPortalAuth() 
	{
		if(
		 !empty($_REQUEST['state']) && 
		 $_REQUEST['state'] = 'Auth_user_jas08dgha8' &&
		 !empty($_REQUEST['code'])
		){
			$this->stage2_code = $_REQUEST['code'];
			return true;
		}
		return false;
	}

	public function getSavedToken ()
	{
		if(file_exists('savedToken')){
			$tokArr = @unserialize(file_get_contents('savedToken'));
			if($tokArr === false){
				if($this->dbg) echo 'Не удалось сериализовать файл' . '<br>';
				return false;
			} elseif(is_array($tokArr) && !empty($tokArr)) {
				if($this->dbg) echo 'Удалось сериализовать файл' . '<br>';
				return $tokArr;
			} else {
				return false;
			}
		} else {
			if($this->dbg) echo 'Файл не найден' . '<br>';
			return false;
		}
	}
	
	public function saveToken ()
	{
		$data = [
		 'access_token' => $this->auth_token,
		 'refresh_token' => $this->refresh_token,
		 'client_endpoint' => $this->client_endpoint,
		 'user_id' => $this->user_id,
		 'tokenCreated' => $this->tokenCreated,
		 'expires_in' => $this->tokenExpires,
		];
		file_put_contents('savedToken', serialize($data));
	}
	
	public function tokenRemainingTime ($tokenCreated = '', $tokenExpires = '') 
	{
		if ($tokenCreated === '') $tokenCreated = $this->tokenCreated;
		if ($tokenExpires === '') $tokenExpires = $this->tokenExpires;
		return ($tokenCreated + $tokenExpires) - time();
	}
	
	public function refreshToken() {
		$url = 'https://oauth.bitrix.info/oauth/token/?grant_type=refresh_token'
		 . '&client_id=' . urlencode($this->app_id)
		 . '&client_secret=' . urlencode($this->app_secret)
		 . '&refresh_token=' . $this->refresh_token;
		 $result = $this::sendBaseRequest($url);
		 if(is_array($result)){
			 $this->initVarablesByArr($result);
			 return true;
		 } else {
			 return false;
		 }
	}
	
	public function showChoisePortalForm()
	{
		$formHtml = <<<form81939273817392asd
<form action="" method="POST">
	<input name="bx24Portal" placeholder="https://portal.bitrix24.ru/">
	<input type="submit" name="as" value="OK">
</form>
form81939273817392asd;
		echo $formHtml;
	}
	
	public function redirectUserToAuth() 
	{
		$portal = $this->client_endpoint;
		$url = $portal . 'oauth/authorize/?'
		 . 'client_id=' . urlencode($this->app_id)
		 . '&state=Auth_user_jas08dgha8';
    Header("Location: ".$url);
    exit;
	}
	
	public function useWebHook($webHookUrl) {
		if(filter_var($webHookUrl, FILTER_VALIDATE_URL)){
			$this->useHook = true;
			$this->webHookUrl = $webHookUrl;
		}
	}
	
	public function loggingOn($loggingObj) {
		$this->needLogging = true;
		$this->loggingObj = $loggingObj;
	}
	
	public function requestAccessToken() 
	{
		$url = 'https://oauth.bitrix.info/oauth/token/?'
		 . 'grant_type=authorization_code'
		 . '&client_id=' . $this->app_id
		 . '&client_secret=' . $this->app_secret
		 . '&code=' . $this->stage2_code;
		$result = $this::sendBaseRequest($url);
		if(is_array($result)){
			$this->initVarablesByArr($result);
			return true;
		} else {
			return false;
		}
	}
	
	public function refreshTokenIfNeeded($checkByRequest) 
	{
		$remLifeTime = $this->tokenRemainingTime();
		if($remLifeTime < 10){
			if($this->dbg) echo 'Необходимо обновление токена' . '<br>';
			if($this->refreshToken()){
				if($this->dbg) echo 'Токен обновлен' . '<br>';
				$this->saveToken();
			} else {
				if($this->dbg) echo 'Токен не обновлен' . '<br>';
			}
		}
	}
	
	public function checkTokenByRequest() 
	{
		
	}

	public function getCurrState ()
	{
		if ($this->haveRequiredAuthParamsInRequest()) return $this->currentState = 4;
		if ($this->haveSavedToken()) return $this->currentState = 3;
		if ($this->returnedFromPortalAuth()) return $this->currentState = 2;
		if ($this->recivedValidData()) return $this->currentState = 1;
		return $this->currentState = 0;
	}

	public function getAccessToken ($checkSavedToken = false, $checkTokenAnyway = false) 
	{
		if($this->useHook){
			return;
		}
		$returnToken = false;
		if($this->dbg) echo 'Проверяем стадию' . '<br>';
		$this->getCurrState();
		switch ($this->currentState) {
			case 0:
				if($this->dbg) echo 'Показываем форму выбора портала' . '<br>';
				$this->showChoisePortalForm();
				break;
			case 1:
				$this->redirectUserToAuth();
				break;
			case 2:
				if($this->dbg) echo 'Пользователь авторизовался, отправляем запрос на получение токена' . '<br>';
				$this->requestAccessToken();
				if($this->auth_token){
					if($this->dbg) echo 'Токен получен' . '<br>';
					$this->saveToken();
					$returnToken = $this->auth_token;
				} else {
					if($this->dbg) echo 'Токен не получен' . '<br>';
				}
				break;
			case 3:
				if($this->dbg) echo 'Доступен сохраненный токен' . '<br>';
				$this->refreshTokenIfNeeded($checkSavedToken);
				if($this->auth_token){
					if($this->dbg) echo 'Токен получен' . '<br>';
					$returnToken = $this->auth_token;
				} else {
					if($this->dbg) echo 'Токен не получен' . '<br>';
				}
				break;
			case 4:
				if($this->dbg) echo 'Токен доступен в $_REQUEST' . '<br>';
				$returnToken = $this->auth_token;
				break;
			
			default:
				break;
		}
		
		if($returnToken){
			if($checkTokenAnyway) {
				
			} else {
				return $returnToken;	
			}
		} else {
			return false;
		}
	}
}


/////////////////////////////////////////////////////


class LoggingBitrix24Api {

	public $needLogRequest = true;
	public $logStr = '';
	public $portal = '';
	public $handler = '';
	public $logFolder = '.';
	public $startRequestSeparator = '↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓';
	public $endRequestSeparator = '↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑';
	
	function __construct($portal = '', $handler = __FILE__, $logFolder = '.') {
		$this->portal = $portal;
		$this->handler = $handler;
		$this->logFolder = $logFolder;
	}
	
	function logRequestOn () {
		$this->needLogRequest = true;
	}
	function logRequestOff () {
		$this->needLogRequest = false;
	}
	
	function saveToLogFile ($logStr) {
		$currDate = date('d.m.Y');
		$logDir = $this->logFolder.'/'.$currDate;
		$logFile = $logDir.'/'.$this->portal.'.txt';
		if(!is_dir($logDir)){
			mkdir($logDir, 0777, true);
		}
		file_put_contents($logFile, $logStr, FILE_APPEND);
	}
	
	function prepareLogString($str) {
		$this->logStr .= "$str\r\n";
	}
	
	function preparelogApiRequest($url, $requestArray, $responseArray){
		$currTime = date('H:i:s');
		$apiRequestSeparator = '||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
		$eol = PHP_EOL;
		
		$logStr = $apiRequestSeparator.$eol
			. $currTime.$eol
			. ' - Handler: "'.$this->handler.'"'. $eol
			. ' - Url: "'.$url.'"'. $eol
			. 'Request parameters:'.$eol
			. var_export($requestArray, true).$eol.$eol
			. 'Responce:'.$eol
			. var_export($responseArray, true) . $eol
			. $apiRequestSeparator.$eol.$eol.$eol;
		
		$this->logStr .= $logStr;
		return $logStr;
	}
	
	function makeRequestStr () {
		$currTime = date('H:i:s');
		$eol = PHP_EOL;
		$IP = $_SERVER['REMOTE_ADDR'];
		$startSep = $this->startRequestSeparator;
		$reqDataStr  = $startSep . $startSep. $startSep . $eol;
		$reqDataStr .= "Request at $currTime; Portal: {$this->portal}; IP: $IP;$eol";
		$reqDataStr .= 'Handler: '.$this->handler.$eol;
		$reqDataStr .= '$_REQUEST = '.$eol . var_export($_REQUEST, true).$eol;
		$reqDataStr .= $startSep . $startSep. $startSep . $eol;
		return $reqDataStr;
	}
	
	function logRequest($url, $requestArray, $responseArray){
		$logStr = $this->preparelogApiRequest($url, $requestArray, $responseArray);
		if($this->needLogRequest){
			$logStr = $this->makeRequestStr().$logStr.str_repeat($this->endRequestSeparator, 3).PHP_EOL;
		}
		$this->saveToLogFile($logStr);
	}
	
	function saveLog(){
		$logStr = $this->logStr;
		if($this->needLogRequest){
			$logStr = $this->makeRequestStr().$logStr.str_repeat($this->endRequestSeparator, 3).PHP_EOL;
		}
		$this->saveToLogFile($logStr);
	}
	
	function clearLog() {
		$this->logStr = '';
	}
	

}


/////////////////////////////////////////////////////
//
//file_put_contents($_SERVER['DOCUMENT_ROOT'].'/dbug.dbug', 'NO_DEBUG');
function putToDbug($str){
	file_put_contents(DEBUG_FILE, (string)$str);
}
function clrdump(){
	file_put_contents(DEBUG_FILE, 'clrdump');
}
function ddump ($var, $flAppend = 0) {
	$varet = gettype($var);
	$vare = var_dump($var);
	$srt = '<pre>'.$vare.'<br>'.$varet.'</pre>';
	if($flAppend){
		file_put_contents(DEBUG_FILE,$srt,FILE_APPEND);
	} else {
		file_put_contents(DEBUG_FILE,$srt);
	}
}
function dump(...$vars){
	echo '<pre>';
	foreach($vars as $var){
		var_dump($var);
	}
	echo '</pre>';
}
function dump2(...$vars){
	static $numberCalling = 0;
	$numberCalling++;
	$dbug_bt = debug_backtrace(false, 1);
	$debug_bt_file = $dbug_bt[0]['file'];
	$debug_bt_line = $dbug_bt[0]['line'];
	ob_start();
	echo PHP_EOL .date('H:i:s d.m.Y'). ' Called from: ' . $debug_bt_file . ' line: ' . $debug_bt_line .PHP_EOL .PHP_EOL;
	foreach($vars as $var){
		var_dump($var);
		$methods = get_class_methods($var);
		if (!empty($methods)) {
			var_dump($methods);
		}
	}
	$dumps = ob_get_clean();
	$fileModifySecAgo = time() - filemtime(DEBUG_FILE);
	if($numberCalling > 1 || $fileModifySecAgo < 5){
		if(file_exists(DEBUG_FILE)){
			$cont = file_get_contents(DEBUG_FILE);
		} else {
			$cont = '<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>DEBUG</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style>
			pre{
				margin: 0;
				padding: 0;
			}
		</style>
	</head>
	<body>
		<pre>
			
			<!-- end_of_file -->
		</pre>
	</body>
</html>';
		}
		$firstPart = substr($cont, 0, strlen($cont) - 50);
		$contToFile = $firstPart . $dumps . PHP_EOL . substr($cont, -49);
		file_put_contents(DEBUG_FILE, $contToFile);
	} else {
		$htmlTempl = '<!DOCTYPE html>
<html lang="ru">
	<head>
		<title>DEBUG</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style>
			pre{
				margin: 0;
				padding: 0;
			}
		</style>
	</head>
	<body>
		<pre>
			'.$dumps.'
			<!-- end_of_file -->
		</pre>
	</body>
</html>';
		file_put_contents(DEBUG_FILE, $htmlTempl);
	}
}
function dump3(...$vars){
	static $numberCalling = 0;
	$numberCalling++;
	$dbug_bt = debug_backtrace(false, 1);
	$debug_bt_file = $dbug_bt[0]['file'];
	$debug_bt_line = $dbug_bt[0]['line'];
	
	$calledFrom = PHP_EOL . 'Called from: ' . $debug_bt_file . ' line: ' . $debug_bt_line .PHP_EOL;
	$dumps = '';
	foreach($vars as $var){
		$dumps .= var_export($var, true);
	}
	$head = '<html lang="ru">
	<head>
		<title>DEBUG</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>';
	$dumps = $head . '<pre>' . $calledFrom . htmlspecialchars($dumps, ENT_QUOTES) . '</pre>';
	if($numberCalling > 1){
			file_put_contents(DEBUG_FILE, $dumps, FILE_APPEND);
	} else {
			file_put_contents(DEBUG_FILE, $dumps);
	}
}

function dump4(...$vars){
	$dbug_bt = debug_backtrace(false, 1);
	$debug_bt_file = $dbug_bt[0]['file'];
	$debug_bt_line = $dbug_bt[0]['line'];
	
	if(class_exists('dBug')){
		static $numberCalling = 0;
		$numberCalling++;
		ob_start();
		echo PHP_EOL . date('H:i:s d.m.Y') ;
		echo PHP_EOL . 'Called from: ' . $debug_bt_file . ' line: ' . $debug_bt_line .PHP_EOL;
		foreach($vars as $var){
			new dBug($var);
		}
		$dumps = ob_get_clean();
		if($numberCalling > 1){
			if(file_exists(DEBUG_FILE)){
				$cont = file_get_contents(DEBUG_FILE);
			} else {
			$cont = '<!DOCTYPE html>
	<html lang="ru">
		<head>
			<title>DEBUG</title>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<style>
				pre{
					margin: 0;
					padding: 0;
				}
			</style>
		</head>
		<body>
			<pre>
				
				<!-- end_of_file -->
			</pre>
		</body>
	</html>';
				}
			$firstPart = substr($cont, 0, strlen($cont) - 50);
			$contToFile = $firstPart . $dumps . PHP_EOL . substr($cont, -49);
			file_put_contents(DEBUG_FILE, $contToFile);
		} else {
			$htmlTempl = '<!DOCTYPE html>
	<html lang="ru">
		<head>
			<title>DEBUG</title>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<style>
				pre{
					margin: 0;
					padding: 0;
				}
			</style>
		</head>
		<body>
			<pre>
				'.$dumps.'
				<!-- end_of_file -->
			</pre>
		</body>
	</html>';
			file_put_contents(DEBUG_FILE, $htmlTempl);
		}
	}
}