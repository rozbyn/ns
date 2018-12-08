<?php


function sendRequestNoAnswer($url) {
	$erCode = $erMess = 0;
	
	$urlParts = parse_url($url);
	$method = 'GET';
	$transport = ($urlParts['scheme'] == 'https') ? 'ssl' : 'tcp';
	$port = ($urlParts['scheme'] == 'https') ? 443 : 80;
	$query = isset($urlParts['query']) ? "?{$urlParts['query']}" : '';
	$path = isset($urlParts['path']) ? $urlParts['path'] : '/';
	
	$remSocket = $transport."://".$urlParts['host'].":".$port;
	
	$fp = stream_socket_client($remSocket, $erCode, $erMess);
	if (!($fp)) return false;
	$headers = $method. " ".$path.$query." HTTP/1.0\r\n"
		. "Host: ".$urlParts['host']."\r\n"
		. "Content-length: 0\r\n"
		. "Connection: Close\r\n"
		. "\r\n";
	$wrResult = fwrite($fp, $headers);
	return $wrResult;
}