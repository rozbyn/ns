<?php
//$a = file_get_contents('https://www.gismeteo.ru/weather-novocheboksarsk-12890/');

//https://www.gismeteo.ru/weather-athens-3673/3-day/
$conn = curl_init();
$encoding = 'Accept-Encoding: identity';
$encoding = 'Accept-Encoding: gzip, deflate, br';
$options = [
	CURLOPT_HTTPHEADER => [
		'Host: vk.com',
		'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0',
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
		'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
		$encoding,
		'Cookie: remixlang=0; remixstid=971190698_7d8202b7b30eb89802; remixflash=29.0.0; remixscreen_depth=24; remixdt=0; remixrefkey=4a0543cc2f032e2536; remixttpid=641d4138e0ea2de62e725a7e86ea09171dd25ac97a; remixsid=b51d1202c17feb2c4cf916099dd81aa3c2291a7dcd5c36ba7f054; remixseenads=2; remixgp=2580e3017a8a688524da8836c828cb09; remixfeed=*.*.*.*.*.fr.*.photos%2Cvideos%2Cfriends%2Cgroups%2Clikes%2Cwc2018%2Ce3',
		'DNT: 1',
		'Connection: keep-alive',
		'Upgrade-Insecure-Requests: 1',
		'Pragma: no-cache',
		'Cache-Control: no-cache',
	],
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_URL => 'https://vk.com/fave?section=likes_video',
	CURLOPT_HEADER => true,
	
	
];
curl_setopt_array($conn, $options);
$a = (curl_exec($conn));
$conn_info = curl_getinfo($conn);
curl_close($conn);
list($headers, $content) = explode("\r\n\r\n", $a);
$content = gzdecode($content);
file_put_contents('test231.txt', $headers . "\r\n\r\n" . $content);
echo $content;