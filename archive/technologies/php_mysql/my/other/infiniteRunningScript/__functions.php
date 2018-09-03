<?php
//функция которая запустится по окончании выполнения всего кода
function shutdown() {
    $error = error_get_last();
    if (
        // если в коде была допущена ошибка
        is_array($error) 
		// и это одна из фатальных ошибок
		// && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])
    ) {
        // очищаем буфер вывода (о нём мы ещё поговорим в последующих статьях)
		$content = '';
        while (ob_get_level()) {
			$content .= ob_get_contents();
            ob_end_clean();
        }
        // выводим описание проблемы
		file_put_contents('fatal_err', "$content " . var_export($error, true));
    }
}
// регистрируем функцию которая запустится по завершению скрипта
register_shutdown_function('shutdown');


function getSelfAddres (){
	return "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
}

function endConnect ($mess) {
	ob_implicit_flush(1);
	session_write_close();
	ignore_user_abort(true);
	header("Content-Encoding: none");
	header('Connection: close');
	header("Content-Length: " . strlen($mess));
	echo $mess;
	ob_end_flush();
	flush();
	ob_flush();
	flush();
	ob_flush();
}

function sendBaseRequest ($url = '', $dataArr = [], $noAnsver = false, $onlyHeaders = false) {
	if(defined('START_TIME_MSEC')){
		$startExTime = START_TIME_MSEC;
	} else {
		$startExTime = microtime(true);
	}
	if(!function_exists('getTimeout')){
		function getTimeout ($startExTimeMicrotime, $maxExTime = NULL) {
			$maxExTime = $maxExTime?:ini_get('max_execution_time');
			$currExTime = microtime(true) - $startExTimeMicrotime;
			$currTimeout = ((int)$maxExTime - $currExTime) - 2;
			if($currTimeout < 0) return false;
			$retArr = [
				'sec' => (int)$currTimeout,
				'microsec' => round($currTimeout - (int)$currTimeout, 6) * 1000000
			];
			
			return $retArr;
		}
	}
	if(!function_exists('setConnectTimeout')){
		function setConnectTimeout ($fp, $startExTime, $maxExTime) {
			$currTimeout = getTimeout($startExTime, $maxExTime);
			if($currTimeout === false) return false;
			return [
				stream_set_timeout($fp, $currTimeout['sec'], $currTimeout['microsec']),
				$currTimeout
			];
		}
	}
	
	$urlParts = parse_url($url);
	$method = !empty($dataArr) ? 'POST' : 'GET';
	$transport = ($urlParts['scheme'] == 'https') ? 'ssl' : 'tcp';
	$port = ($urlParts['scheme'] == 'https') ? 443 : 80;
	$query = isset($urlParts['query']) ? "?{$urlParts['query']}" : '';
	$maxExTime = (int)ini_get('max_execution_time');
	$connection_time = -microtime(true);
	$fp = @stream_socket_client(
		$transport."://".$urlParts['host'].":".$port, 
		$erCode, 
		$erMess, 
		(float)(($tOut = getTimeout($startExTime, $maxExTime))['sec'] .'.'. $tOut['microsec'])
	);
	$connection_time += microtime(true);;
	$returnArray = [
		'rawdata' => '',
		'data' => '',
		'headers' => [],
		'erCode' => $erCode,
		'erMess' => $erMess,
		'maxExTime' => $maxExTime,
		'connection_result' => ($fp !== false),
		'write_result' => false,
		'read_result' => false,
		'connection_timeouted' => $erCode !== 0,
		'write_timeouted' => false,
		'read_timeouted' => false,
		'connection_time' => $connection_time,
		'write_time' => 0,
		'read_time' => 0
	];
	if (!($fp)) {
		return $returnArray;
	} else {
		if(($tOut = setConnectTimeout($fp, $startExTime, $maxExTime))[0] === false) {
			// echo "$tOut = false <br>";
			$returnArray['connection_timeouted'] = true;
			return $returnArray;
		}
		// echo "before write: {$tOut[1]['sec']} - {$tOut[1]['microsec']}<br>";
		$data = http_build_query($dataArr);
		$headers = $method. " ".$urlParts['path'].$query." HTTP/1.0\r\n"
		 . "Host: ".$urlParts['host']."\r\n"
		 // . "Accept: */*\r\n"
		 . "Content-Type: application/x-www-form-urlencoded\r\n"
		 . "Content-length: ".(mb_strlen($data))."\r\n"
		 // . "Connection: Close\r\n"
		 . "\r\n";
		 
		$returnArray['write_time'] = -microtime(true);
		$wrResult = fwrite($fp, $headers . $data . "\r\n\r\n");
		$returnArray['write_time'] += microtime(true);
		if(stream_get_meta_data($fp)['timed_out']) {
			$returnArray['write_timeouted'] = true;
			return $returnArray;
		}
		$returnArray['write_result'] = ($wrResult !== false);
		if($noAnsver){
			fclose($fp);
			return $returnArray;
		}
		$contentLenght = NULL;
		$isBodyReading = false;
		$headers = '';
		$body = '';
		$bodyLen = 0;
		$lineLen = 8192;
		for($i = 0, $rd = ''; (!feof($fp) && $i < 100); $i++){
			if(($tOut = setConnectTimeout($fp, $startExTime, $maxExTime))[0] === false) {
				$returnArray['connection_timeouted'] = true;
				break;
			}
			
			if($contentLenght !== NULL && $lineLen>$contentLenght){
				$lineLen = $contentLenght + 1;
			}
			
			// echo "before read: {$tOut[1]['sec']}.{$tOut[1]['microsec']} = ".(microtime(true) - $startExTime)." ";
			$readTime = -microtime(true);
			$line = fgets($fp, $lineLen);
			$readTime += microtime(true);
			
			
			
			$rd .= $line;
			if($isBodyReading){
				$body .= $line;
			} else {
				$headers .= $line;
			}
			$returnArray['read_time'] += $readTime;
			$returnArray['rawdata'] .= $line;
			if($contentLenght === NULL && strpos($line, 'Content-Length:') !== false){
				$contentLenght = intval(trim(substr($line, 15)));
				// echo "Content-Length: $contentLenght<br>";
			}
			
			// echo "'$line'<br>";
			if($contentLenght !== NULL && $isBodyReading){
				$bodyLen += strlen($line);
			}
			if ($isBodyReading && $contentLenght !== NULL){
				$lineLen = ($contentLenght+1) - $bodyLen;
				if($lineLen <= 1){
					$lineLen = 2;
				}
				// echo "'$line': ".strlen($line) . ", \$bodyLen: $bodyLen, \$lineLen: $lineLen<br>";
			}
			if($contentLenght !== NULL && strlen($body) >= $contentLenght){
				// echo "Content-Length: $contentLenght, " . 'end Read: '.strlen($body);
				break;
			}
			if($line === "\r\n"){
				$isBodyReading  = true;
				if($onlyHeaders){
					break;
				}
			}
			if(stream_get_meta_data($fp)['timed_out']){
				$returnArray['read_timeouted'] = true;
				break;
			}
		}
		
		foreach (explode("\r\n",$headers) as $val) {
			if(!empty($val)){
				@list($headerName, $headerVal) = explode(':',  $val);
				$returnArray['headers'][$headerName] = trim($headerVal);
			}
		}
		if(!$returnArray['read_timeouted']){
			$returnArray['read_result'] = true;
		}
		$requestBody = $body;
		$jsonArr = json_decode($requestBody, true);
		if($jsonArr === null){
			$returnArray['data'] = $requestBody;
		} else {
			$returnArray['data'] = $jsonArr;
		}
		return $returnArray;
	}
}

// $url = 'http://test.r/ns/archive/technologies/php_mysql/my/other/infiniteRunningScript/a.php';
// echo "<pre>";
// $rez = sendBaseRequest($url, [], false);
// echo "</pre>";
// var_dump($rez);
?>