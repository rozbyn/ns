<?php
//$f = fopen('../explorer.php', 'r+t') or die("Ошибка!");
//$f = fopen("http://www.php.net/", 'rt') or die("Ошибка!");
//$f = fopen("ftp://u784337761:vWJG3oCVBK@ftp.rozbyn.esy.es/public_html/robots.txt", 'rt') or die("Ошибка!");

function makeHEX ($str) {
	for ($i = 0; $i < strlen($str); $i++) {
		$hex[] = sprintf('%02X', ord($str[$i]));
	}
	return implode(' ', $hex);
}

$f = fopen(__FILE__, 'rb') or die("Ошибка!");
echo makeHEX(fgets($f, 100)) . "<br>\n";
$f = fopen(__FILE__, 'rt') or die("Ошибка!");
echo makeHEX(fgets($f, 100)) . "<br>\n";

$f = fopen('temp.txt', 'r+t') or die("Ошибка!");



$i = 0;
while ($p = fread($f, 100)) {
	echo strlen($p) . "=> $p<br>";
	$i++;
}
fseek($f, 0, SEEK_END);
fwrite($f,'ROZBYN>ESY>ES> ');
rewind($f);
echo '<br>';
while ($p = fgets($f, 10000)) {
	echo strlen($p) . "=> $p<br>";
}



fclose($f);





?>