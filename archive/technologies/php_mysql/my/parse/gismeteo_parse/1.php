<?php

//$a = file_get_contents('https://www.gismeteo.ru/weather-novocheboksarsk-12890/');

//https://www.gismeteo.ru/weather-athens-3673/3-day/
$conn = curl_init();
$encoding = 'Accept-Encoding: identity';
$encoding = 'Accept-Encoding: gzip, deflate, br';
$options = [
	CURLOPT_HTTPHEADER => [
		'Host: www.gismeteo.ru',
		'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0',
		'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
		'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
		$encoding,
		'DNT: 1',
		'Connection: keep-alive',
		'Upgrade-Insecure-Requests: 1',
		'Cache-Control: max-age=0',
	],
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_URL => 'https://www.gismeteo.ru/weather-novocheboksarsk-12890/',
	CURLOPT_HEADER => false,
	
	
];
curl_setopt_array($conn, $options);
$a = gzdecode(curl_exec($conn));
$conn_info = curl_getinfo($conn);
curl_close($conn);
file_put_contents('test231.txt', $a);

$doc = new DOMDocument;
$r = error_reporting(E_ERROR | E_PARSE);
$res  =  $doc->loadHTML($a);
error_reporting($r);
$xpath = new DOMXpath($doc);
$elements = $xpath->query("/html/body/section/div/div/div[1]/div/div[2]/div[1]/div[2]/div/div[1]/div/div[3]/div/div/div/div");
foreach ($elements as $element) {
    echo $element->nodeValue . "\n<br>";
	foreach($element->attributes as $attrr){
		var_dump($attrr);
	}
}



?>