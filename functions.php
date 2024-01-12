<?php

////////////////////////////////////////////////////////////////1

/* Файл в который функции дебага будут записывать */
if (!defined('DEBUG_FILE'))
	define('DEBUG_FILE', $_SERVER['DOCUMENT_ROOT'] . '/dbug.html');
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
if (!function_exists('sendBaseRequest')) {

	function sendBaseRequest($url = '', $dataArr = [], $noAnsver = false, $isPost = true) {
		$urlParts = parse_url($url);
		$method = $isPost ? 'POST' : 'GET';
		$transport = ($urlParts['scheme'] == 'https') ? 'ssl' : 'tcp';
		$port = ($urlParts['scheme'] == 'https') ? 443 : 80;

		$context = stream_context_create(['ssl' => ['verify_peer_name' => false, "verify_peer" => false]]);
		if (
				!($fp = stream_socket_client(
				$transport . "://" . $urlParts['host'] . ":" . $port, $errno, $errstr, 20, STREAM_CLIENT_CONNECT, $context
				))
		) {
			return false;
		} else {
			$data = http_build_query($dataArr);
			$headers = $method . " " . $urlParts['path'] . " HTTP/1.0\r\n"
					. "Host: " . $urlParts['host'] . "\r\n"
					//		 . "Accept: */*\r\n"
					. "Content-Type: application/x-www-form-urlencoded\r\n"
					. "Content-length: " . (mb_strlen($data)) . "\r\n"
					//		 . "Connection: Close\r\n"
					. "\r\n";
			$wrResult = fwrite($fp, $headers . $data . "\r\n\r\n");
			if ($noAnsver) {
				usleep(1);
				fclose($fp);
				return $wrResult !== false;
			}
			for ($i = 0, $rd = ''; (!feof($fp) && $i < 10000); $i++, $rd .= fgets($fp, 8192));
			$requestBody = explode("\r\n\r\n", $rd)[1];
			$jsonArr = @json_decode($requestBody, true);
			if ($jsonArr === null) {
				return $requestBody;
			} else {
				return $jsonArr;
			}
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
if (!function_exists('sendRequest')) {

	function sendRequest($method = '', $params = [], $url = '', $noAns = false) {
		if ($method == '')
			$method = 'crm.contact.list';
		if ($url == '')
			$url = BASE_URL;
		$sendUrl = $url . $method;
		return sendBaseRequest($sendUrl, $params, $noAns);
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
 * @param array $auth массив данных для авторизации по протоколу OAuth 2.0
 * @param string $url адрес bitrix24, по умолчанию принимает значение константы BASE_URL
 * @param boolean $noAnsver флаг игнорирования ответа, по умолчанию false
 * @return boolean|array|string возвращаемые значения аналогичны функции sendBaseRequest()
 * @see sendBaseRequest()
 *
 */
if (!function_exists('sendBatch')) {

	function sendBatch($arCMD, $halt = false, $auth = false, $url = '', $noAnsver = false) {
		$arParams = [];
		$cmdAr = [];

		$arParams['halt'] = $halt;
		if ($auth !== false && is_array($auth))
			$arParams['auth'] = $auth;
		if ($url == '')
			$url = BASE_URL;

		foreach ($arCMD as $comID => $cmd) {
			$cmdAr[$comID] = key($cmd) . '?' . http_build_query(current($cmd));
		}

		$arParams['cmd'] = $cmdAr;

		return sendBaseRequest($url . 'batch', $arParams, $noAnsver);
	}

}
if (!class_exists('B24RestConnector')) {

	class B24RestConnector {

//	'access_token' => 'd788595b0029c11800291bc4000000010000037eebc5eda99428446ede093b34e6c7b2'
		public $app_id = '';
		public $app_secret = '';
		public $auth_token = '';
		public $refresh_token = '';
		public $client_endpoint = '';
		public $user_id = '';
		public $tokenSaved = false;
		public $tokenCreated = '';
		public $tokenExpires = '';
		public $currentState = 0;
		public $stage2_code = '';
		public $dbg = false;
		public $useHook = false;
		public $webHookUrl = '';
		public $needLogging = false;
		
		/** @var VentraLogger */
		public $loggingObj = false;
		public $lastError = '';

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
		public static function sendBaseRequest($url = '', $dataArr = [], $noAnsver = false) {
			$urlParts = parse_url($url);
			$transport = ($urlParts['scheme'] == 'https') ? 'ssl' : 'tcp';
			$port = ($urlParts['scheme'] == 'https') ? 443 : 80;
			$context = stream_context_create(['ssl' => ['verify_peer_name' => false, "verify_peer" => false]]);
			if (!($fp = stream_socket_client(
					$transport . "://" . $urlParts['host'] . ":" . $port, $errno, $errstr, 20, STREAM_CLIENT_CONNECT, $context
					))
			) {
				return false;
			} else {
				$query = $urlParts['path'] . (!empty($urlParts['query']) ? '?' . $urlParts['query'] : '');
				$data = http_build_query($dataArr);
				$headers = "POST " . $query . " HTTP/1.0\r\n"
						. "Host: " . $urlParts['host'] . "\r\n"
						. "Content-Type: application/x-www-form-urlencoded\r\n"
						. "Content-length: " . (mb_strlen($data)) . "\r\n"
						. "\r\n";
				$wrResult = fwrite($fp, $headers . $data . "\r\n\r\n");
				if ($noAnsver) {
					usleep(1);
					fclose($fp);
					return $wrResult !== false;
				}
				for ($i = 0, $rd = ''; (!feof($fp) && $i < 10000); $i++) {
					$rd .= fgets($fp, 8192);
				}
				$requestBody = explode("\r\n\r\n", $rd)[1];
				$jsonArr = json_decode($requestBody, true);
				if ($jsonArr === null) {
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
		public function sendBatch($arCMD, $halt = false, $noAnsver = false) {
			$noAns = ($this->needLogging === false) ? $noAns : false;
			$arParams = [];
			$cmdAr = [];

			$arParams['halt'] = $halt;

			if ($this->useHook) {
				$url = $this->webHookUrl;
			} else {
				$url = $this->client_endpoint;
				$arParams['access_token'] = $this->auth_token;
			}
			if ($this->needLogging) {
				$paramsForLog = $arParams;
				$cmdForLog = [];
			}

			foreach ($arCMD as $comID => $cmd) {
				$cmdAr[$comID] = key($cmd) . '?' . http_build_query(current($cmd));
				if ($this->needLogging)
					$cmdForLog[$comID] = [key($cmd) => current($cmd)];
			}

			$arParams['cmd'] = $cmdAr;
			if ($this->needLogging)
				$paramsForLog['cmd'] = $cmdForLog;
			$requestResponce = $this->sendBaseRequest($url . 'batch', $arParams, $noAnsver);
			if ($this->needLogging) {
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
		public function sendRequest($method = '', $params = [], $noAns = false) {
			$noAns = ($this->needLogging === false) ? $noAns : false;
			if ($method == '')
				$method = 'server.time';
			if ($this->useHook) {
				$url = $this->webHookUrl;
			} else {
				$url = $this->client_endpoint;
				$params['access_token'] = $this->auth_token;
			}

			$sendUrl = $url . $method;
			$requestResponce = $this->sendBaseRequest($sendUrl, $params, $noAns);
			if ($this->needLogging) {
				$this->loggingObj->preparelogApiRequest($sendUrl, $params, $requestResponce);
			}
			return $requestResponce;
		}

		public function __construct($app_id = '', $app_secret = '') {
			$this->app_id = $app_id;
			$this->app_secret = $app_secret;
		}

		public function initVarablesByArr($arr) {
			if (!empty($arr['access_token']))
				$this->auth_token = $arr['access_token'];
			if (!empty($arr['refresh_token']))
				$this->refresh_token = $arr['refresh_token'];
			if (!empty($arr['client_endpoint']))
				$this->client_endpoint = $arr['client_endpoint'];
			if (!empty($arr['user_id']))
				$this->user_id = $arr['user_id'];
			$this->tokenCreated = !empty($arr['tokenCreated']) ? $arr['tokenCreated'] : time();
			if (!empty($arr['expires_in']))
				$this->tokenExpires = $arr['expires_in'];
		}

		public function initAuthArrByVarables() {
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

		public function checkRequiredFields() {
			if ($this->dbg)
				echo 'Проверяем обязательные поля' . '<br>';
			if (empty($this->auth_token)) {

				return false;
			}
			if (empty($this->client_endpoint))
				return false;
			if (empty($this->tokenExpires))
				return false;
			return true;
		}

		public function haveSavedToken() {
			if ($this->dbg)
				echo 'Проверяем есть ли сохраненный токен' . '<br>';
			$tokArr = $this->getSavedToken();
			if ($tokArr === false)
				return false;
			$this->initVarablesByArr($tokArr);
			$res = $this->checkRequiredFields();
			return $res;
		}

		public function haveRequiredAuthParamsInRequest() {
			if (
					!empty($_REQUEST['auth']['access_token']) &&
					!empty($_REQUEST['auth']['client_endpoint']) &&
					!empty($_REQUEST['auth']['expires_in'])
			) {
				$this->initVarablesByArr($_REQUEST['auth']);
				return $this->checkRequiredFields();
			} elseif (
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

		public function recivedValidData() {
			if (
					!empty($_REQUEST['bx24Portal']) &&
					filter_var($_REQUEST['bx24Portal'], FILTER_VALIDATE_URL)
			) {
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

		public function returnedFromPortalAuth() {
			if (
					!empty($_REQUEST['state']) &&
					$_REQUEST['state'] = 'Auth_user_jas08dgha8' &&
					!empty($_REQUEST['code'])
			) {
				$this->stage2_code = $_REQUEST['code'];
				return true;
			}
			return false;
		}

		public function getSavedToken() {
			if(empty($this->client_endpoint) || empty($this->user_id)) return;
			$tokenFolder = __DIR__.'/tokens/'.parse_url($this->client_endpoint, PHP_URL_HOST).'/';
			$filePath = $tokenFolder . $this->user_id . '.tok';
			if (file_exists($filePath)) {
				$tokArr = @unserialize(file_get_contents($filePath));
				if ($tokArr === false) {
					if ($this->dbg)
						echo 'Не удалось сериализовать файл' . '<br>';
					return false;
				} elseif (is_array($tokArr) && !empty($tokArr)) {
					if ($this->dbg)
						echo 'Удалось сериализовать файл' . '<br>';
					return $tokArr;
				} else {
					return false;
				}
			} else {
				if ($this->dbg)
					echo 'Файл не найден' . '<br>';
				return false;
			}
		}

		public function saveToken() {
			// you need to save it

			$data = [
				'access_token' => $this->auth_token,
				'refresh_token' => $this->refresh_token,
				'client_endpoint' => $this->client_endpoint,
				'user_id' => $this->user_id,
				'tokenCreated' => $this->tokenCreated,
				'expires_in' => $this->tokenExpires,
			];

			$tokenFolder = __DIR__.'/tokens/'.parse_url($this->client_endpoint, PHP_URL_HOST).'/';
			$filePath = $tokenFolder . $this->user_id . '.tok';

			if(!is_dir($tokenFolder))
				mkdir($tokenFolder, 0777, true);

			return (bool)file_put_contents($filePath, serialize($data));
		}

		public function tokenRemainingTime($tokenCreated = '', $tokenExpires = '') {
			if ($tokenCreated === '')
				$tokenCreated = $this->tokenCreated;
			if ($tokenExpires === '')
				$tokenExpires = $this->tokenExpires;
			return ($tokenCreated + $tokenExpires) - time();
		}

		public function refreshToken() {
			$url = 'https://oauth.bitrix.info/oauth/token/?grant_type=refresh_token'
					. '&client_id=' . urlencode($this->app_id)
					. '&client_secret=' . urlencode($this->app_secret)
					. '&refresh_token=' . $this->refresh_token;
			$result = $this::sendBaseRequest($url);
			if (is_array($result)) {
				$this->initVarablesByArr($result);
				return true;
			} else {
				return false;
			}
		}

		public function showChoisePortalForm() {
			$formHtml = <<<form81939273817392asd
<form action="" method="POST">
	<input name="bx24Portal" placeholder="https://portal.bitrix24.ru/">
	<input type="submit" name="as" value="OK">
</form>
form81939273817392asd;
			echo $formHtml;
		}

		public function redirectUserToAuth($stage2String = '') {
			if(!is_string($stage2String) || empty($stage2String)){
				$stage2String = 'Auth_user_jas08dgha8';
			}
			$portal = $this->client_endpoint;
			$url = $portal . 'oauth/authorize/?'
					. 'client_id=' . urlencode($this->app_id)
					. '&state='.$stage2String;
			Header("Location: " . $url);
			exit;
		}

		public function useWebHook($webHookUrl) {
			if (filter_var($webHookUrl, FILTER_VALIDATE_URL)) {
				$this->useHook = true;
				$this->webHookUrl = $webHookUrl;
			}
		}

		public function loggingOn($loggingObj) {
			$this->needLogging = true;
			$this->loggingObj = $loggingObj;
		}

		public function requestAccessToken() {
			$url = 'https://oauth.bitrix.info/oauth/token/?'
					. 'grant_type=authorization_code'
					. '&client_id=' . $this->app_id
					. '&client_secret=' . $this->app_secret
					. '&code=' . $this->stage2_code;
			$result = $this::sendBaseRequest($url);

			if (is_array($result) && !isset($result['error'])) {
				$this->initVarablesByArr($result);
				return true;
			} else {
				$this->lastError = $result['error'];
				return false;
			}
		}

		public function refreshTokenIfNeeded() {
			$remLifeTime = $this->tokenRemainingTime();
			if ($remLifeTime < 10) {
				if ($this->dbg)
					echo 'Необходимо обновление токена' . '<br>';
				if ($this->refreshToken()) {
					if ($this->dbg)
						echo 'Токен обновлен' . '<br>';
					$this->saveToken();
				} else {
					if ($this->dbg)
						echo 'Токен не обновлен' . '<br>';
				}
			}
		}

		public function checkTokenByRequest() {

		}

		public function getCurrState() {
			if ($this->haveRequiredAuthParamsInRequest())
				return $this->currentState = 4;
			if ($this->haveSavedToken())
				return $this->currentState = 3;
			if ($this->returnedFromPortalAuth())
				return $this->currentState = 2;
			if ($this->recivedValidData())
				return $this->currentState = 1;
			return $this->currentState = 0;
		}

		public function getAccessToken($stage2String = '') {

			if ($this->useHook) {
				return;
			}
			$returnToken = false;
			if ($this->dbg){
				ob_start();
				echo 'Проверяем стадию' . '<br>';

			}
			$this->getCurrState();
			switch ($this->currentState) {
				case 0:
					if ($this->dbg)
						echo 'Показываем форму выбора портала' . '<br>';
					$this->showChoisePortalForm();
					break;
				case 1:
					ob_end_clean();
					$this->redirectUserToAuth($stage2String);
					break;
				case 2:
					if ($this->dbg)
						echo 'Пользователь авторизовался, отправляем запрос на получение токена' . '<br>';
					$this->requestAccessToken();
					if ($this->auth_token) {
						if ($this->dbg)
							echo 'Токен получен' . '<br>';
						$this->tokenSaved = $this->saveToken();
						$returnToken = $this->auth_token;
					} else {
						if ($this->dbg)
							echo 'Токен не получен' . '<br>';
					}
					break;
				case 3:
					if ($this->dbg)
						echo 'Доступен сохраненный токен' . '<br>';
					$this->refreshTokenIfNeeded();
					if ($this->auth_token) {
						if ($this->dbg)
							echo 'Токен получен' . '<br>';
						$this->tokenSaved = true;
						$returnToken = $this->auth_token;
					} else {
						if ($this->dbg)
							echo 'Токен не получен' . '<br>';
					}
					break;
				case 4:
					if ($this->dbg)
						echo 'Токен доступен в $_REQUEST' . '<br>';
					$returnToken = $this->auth_token;
					break;

				default:
					break;
			}
			ob_end_flush();

			if ($returnToken) {
				return $returnToken;
			} else {
				return false;
			}
		}

	}

}


/////////////////////////////////////////////////////

if (!class_exists('LoggingBitrix24Api')) {

	class LoggingBitrix24Api {

		public $needLogRequest = true;
		public $logStr = '';
		public $portal = '';
		public $handler = '';
		public $logFolder = '.';
		public $startRequestSeparator = '//↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↑↑↑';
		public $endRequestSeparator = '//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑';
		public $clearLogsDays = 10;
		public $clearLogs = true;

		function __construct($portal = '', $handler = __FILE__, $logFolder = __DIR__.'/logs') {
			$this->portal = $portal;
			$this->handler = $handler;
			$this->logFolder = $logFolder;
		}

		function logRequestOn() {
			$this->needLogRequest = true;
		}

		function logRequestOff() {
			$this->needLogRequest = false;
		}


		public static function deleteDir($path) {
			if(!is_dir($path)) return;
			$dirFiles = array_diff(scandir($path), array('..', '.'));
			foreach ($dirFiles as $file) {
				$currPath = $path . "/$file";
				if(is_file($currPath)){
					unlink($currPath);
//					var_dump("delete file: $currPath");
				} else if (is_dir($currPath)){
					self::deleteDir($currPath);
				}
			}
//			var_dump("delete dir: $path");
			rmdir($path);
		}


		function clearOldLogs() {
			if(!$this->clearLogs) return;
			$dateRegex = '#^\d{2}.\d{2}.\d{4}$#';
			$datesTS = [];
			$datesFolders = array_diff(scandir($this->logFolder), array('..', '.'));
			foreach ($datesFolders as $date) {
				if(!preg_match($dateRegex, $date)) continue;
				list($day, $month, $year) = explode('.', $date);
				$ts = mktime(0, 0, 0, $month, $day, $year);
				$datesTS[$ts] = $date;
			}
			krsort($datesTS, SORT_NUMERIC);
			$datesToDel = array_slice($datesTS, $this->clearLogsDays);
			foreach ($datesToDel as $delDate) {
				$deletePath = $this->logFolder . "/$delDate";
				self::deleteDir($deletePath);
			}
			$this->clearLogs = false;
		}


		function saveToLogFile($logStr) {
			$eol = PHP_EOL;
			$currDate = date('d.m.Y');
			$logDir = $this->logFolder . '/' . $currDate;
			$logFile = $logDir . '/' . $this->portal . '.php';
			if (!is_dir($logDir)) {
				mkdir($logDir, 0777, true);
			}
			if (!is_file($logFile)) {
				$logStr = "<?php$eol" . $logStr;
			}
			$r = file_put_contents($logFile, $logStr, FILE_APPEND);
			$this->clearOldLogs();
			if ($r)
				return $logStr;
			return false;
		}

		function prepareLogString($str) {
			$this->logStr .= "<<<string______________________________________\r\n";
			$this->logStr .= "$str\r\n";
			$this->logStr .= "string______________________________________;\r\n";
		}

		function preparelogApiRequest($url, $requestArray, $responseArray) {
			$currTime = date('H:i:s');
			$apiRequestSeparator = '//||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||';
			$eol = PHP_EOL;

			$logStr = $apiRequestSeparator . $eol
					. "\$currTime = '$currTime';$eol"
					. '$Handler = "' . $this->handler . '";' . $eol
					. '$Url = "' . $url . '";' . $eol
					. '$Request_parameters = ' . $eol
					. var_export($requestArray, true) . ';' . $eol . $eol
					. '$Responce = ' . $eol
					. var_export($responseArray, true) . ';' . $eol
					. $apiRequestSeparator . $eol . $eol . $eol;

			$this->logStr .= $logStr;
			$this->saveLog();
			$this->clearLog();
			return $logStr;
		}

		function makeRequestStr() {
			$eol = PHP_EOL;
			$startSep = $this->startRequestSeparator;
			$reqDataStr = $startSep . $startSep . $startSep . $eol;
			$reqDataStr .= $this->makeRequestTimeStr();
			$reqDataStr .= '$Handler = "' . $this->handler . '";' . $eol;
			$reqDataStr .= '$_REQUEST = ' . $eol . var_export($_REQUEST, true) . ';' . $eol;
			$reqDataStr .= $startSep . $startSep . $startSep . $eol;
			return $reqDataStr;
		}
		
		
		function makeRequestTimeStr() {
			$currTime = date('H:i:s');
			$IP = $_SERVER['REMOTE_ADDR'];
			return "//Request at $currTime; Portal: {$this->portal}; IP: $IP;".PHP_EOL;
		}
		

		function logRequest($url, $requestArray, $responseArray) {
			$logStr = $this->preparelogApiRequest($url, $requestArray, $responseArray);
			if ($this->needLogRequest) {
				$logStr = $this->makeRequestStr() . $logStr . str_repeat($this->endRequestSeparator, 3) . PHP_EOL;
			}
			return $this->saveToLogFile($logStr);
		}

		function saveLog() {
			$logStr = $this->logStr;
			if ($this->needLogRequest) {
				$logStr = $this->makeRequestStr() . $logStr . str_repeat($this->endRequestSeparator, 3) . PHP_EOL;
				$this->needLogRequest= false;
			}
			return $this->saveToLogFile($logStr);
		}

		function clearLog() {
			$this->logStr = '';
		}

		function saveRequestData() {
			$this->needLogRequest = true;
			$this->clearLog();
			$r = $this->saveLog();
			$this->needLogRequest = false;
			$this->clearLog();
			return $r;
		}

		function log($var, $varName = '') {
			$type = gettype($var);
			$logStr = '';
			$varName = true ? $this->getVarNamePrefix($var, $varName) : '';

			switch ($type) {
				case 'double':
				case 'integer':
					$logStr = "$varName$var;";
					break;
				case 'boolean':
					$logStr = $varName . ($var ? 'true' : 'false') . ';';
					break;
				case 'string':
					$logStr = $varName . $this->prepareLogString2($var);
					break;
				case 'array':
				case 'object':
					$logStr = $varName . var_export($var, true) . ';';
					break;

				default:
					ob_start();
					var_dump($var);
					$dumps = ob_get_clean();
					$logStr = $this->prepareLogString2("$varName$dumps");

					break;
			}
			$this->logStr = $logStr . PHP_EOL;
			$r = $this->saveLog();
			$this->clearLog();
			return $r;
		}

		function prepareLogString2($str) {
			if(strpos($str, PHP_EOL) !== false){
				$str = "<<<string______________________________________\r\n"
						. "$str\r\n"
						. "string______________________________________;\r\n";
				return $str;
			} else if(strpos($str, "'") !== false){
				$str = str_replace("'", "\\'", $str);
			}
			return "'$str'";
		}

		function getVarNamePrefix($var, $varName = '') {
			$pattern = '/\$?([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/';
			$dollar = strpos($varName, '$') === 0 ? '' : '$';
			if (!preg_match($pattern, $varName)) {
				$varName = gettype($var);
			}
			$varNamePrefix = "$dollar$varName = ";
			return $varNamePrefix;
		}

	}

}


/////////////////////////////////////////////////////
//
//file_put_contents($_SERVER['DOCUMENT_ROOT'].'/dbug.dbug', 'NO_DEBUG');
if (!function_exists('putToDbug')) {

	function putToDbug($str) {
		file_put_contents(DEBUG_FILE, (string) $str);
	}

}
if (!function_exists('clrdump')) {

	function clrdump() {
		file_put_contents(DEBUG_FILE, 'clrdump');
	}

}
if (!function_exists('ddump')) {

	function ddump($var) {
		static $numberCalling = 0;
//		$varet = gettype($var);
		$vare = var_export($var, true) . PHP_EOL;
//		$srt = '<pre>'.$vare.'<br>'.$varet.'</pre>';
		if ($numberCalling === 0) {
			file_put_contents(DEBUG_FILE, $vare);
		} else {
			file_put_contents(DEBUG_FILE, $vare, FILE_APPEND);
		}
		$numberCalling++;
	}

}
if (!function_exists('dump')) {

	function dump(...$vars) {
		echo '<pre>';
		foreach ($vars as $var) {
			var_dump($var);
		}
		echo '</pre>';
	}

}
if (!function_exists('dump2')) {

	function dump2(...$vars) {
		static $numberCalling = 0;
		$numberCalling++;
		$dbug_bt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
		$debug_bt_file = $dbug_bt[0]['file'];
		$debug_bt_line = $dbug_bt[0]['line'];
		ob_start();
		echo PHP_EOL . date('H:i:s d.m.Y') . ' Called from: ' . $debug_bt_file . ' line: ' . $debug_bt_line . PHP_EOL . PHP_EOL;
		foreach ($vars as $var) {
			var_dump($var);
			$methods = get_class_methods($var);
			if (!empty($methods)) {
				var_dump($methods);
			}
		}
		$dumps = ob_get_contents();
		ob_end_clean();
		$fileModifySecAgo = time() - @filemtime(DEBUG_FILE);
		if ($numberCalling > 1 || $fileModifySecAgo < 5) {
			if (file_exists(DEBUG_FILE)) {
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
			' . $dumps . '
			<!-- end_of_file -->
		</pre>
	</body>
</html>';
			file_put_contents(DEBUG_FILE, $htmlTempl);
		}
	}

}
if (!function_exists('dump3')) {

	function dump3(...$vars) {
		if (defined('NO_DEBUG') && NO_DEBUG === true)
			return;
		static $numberCalling = 0;
		$numberCalling++;
		$dbug_bt = debug_backtrace(false, 1);
		$debug_bt_file = $dbug_bt[0]['file'];
		$debug_bt_line = $dbug_bt[0]['line'];
		ob_start();
		echo PHP_EOL . date('H:i:s d.m.Y') . ' Called from: ' . $debug_bt_file . ' line: ' . $debug_bt_line . PHP_EOL . PHP_EOL;
		foreach ($vars as $var) {
			print_r($var);
			$methods = get_class_methods($var);
			if (!empty($methods)) {
				print_r($methods);
			}
		}
		if (defined('SHOW_BACKTRACE') && SHOW_BACKTRACE === true)
			var_dump($dbug_bt);
		$dumps = ob_get_clean();
		$fileModifySecAgo = time() - filemtime(DEBUG_FILE);
		if ($numberCalling > 1 || $fileModifySecAgo < 5) {
			if (file_exists(DEBUG_FILE)) {
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
			' . $dumps . '
			<!-- end_of_file -->
		</pre>
	</body>
</html>';
			file_put_contents(DEBUG_FILE, $htmlTempl);
		}
	}

}

if (!function_exists('dumpClassPath')) {

	function dumpClassPath($class) {
		$reflector = new \ReflectionClass($class);
		dump2($reflector->getFileName());
	}

}
if (!function_exists('accessProtected')) {

	function accessProtected($obj, $propName) {
		$reflection = new ReflectionClass($obj);
		$property = $reflection->getProperty($propName);
		$property->setAccessible(true);
		if ($property->isStatic()) {
			return $property->getValue();
		}
		return $property->getValue($obj);
	}

}
if (!function_exists('dumpCallTrace')) {

	function dumpCallTrace() {
		$e = new Exception();
		$trace = explode("\n", $e->getTraceAsString());
		// reverse array to make steps line up chronologically
		$trace = array_reverse($trace);
		array_shift($trace); // remove {main}
		array_pop($trace); // remove call to this method
		$length = count($trace);
		$result = array();

		for ($i = 0; $i < $length; $i++) {
			$result[] = ($i + 1) . ')' . substr($trace[$i], strpos($trace[$i], ' ')); // replace '#someNum' with '$i)', set the right ordering
		}

		$rerwre = "\r\n\t" . implode("\r\n\t", $result);
		dump2($rerwre);
		return $rerwre;
	}

}

if (!function_exists('isPositiveInt')) {
	function isPositiveInt($var) {
		if (is_integer($var) && $var > 0) return true;
		else if (is_string($var)) {
			$isEqStr = ((string) (int) $var) === ($var);
			if ($isEqStr && (int) $var > 0) return true;
		}
		return false;
	}
}
