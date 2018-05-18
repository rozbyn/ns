<?php
echo '<pre>';
$locale = setlocale(LC_ALL, 'RU', 'Russian_Russia.1251');
var_dump($locale);
date_default_timezone_set('Europe/Moscow');

function strftime_utf8 ($format, $tmstmp = false, $charset = 'cp1251') {
	if ($tmstmp == false) {
		$tmstmp = time();
	}
	$format = iconv('utf-8', $charset, $format);
	$str = strftime($format, $tmstmp);
	$str = iconv($charset,'utf-8', $str);
	return $str;
}


$tme = strtotime('10 September 2000');
echo date('H:i:s d.m.Y', $tme);
echo '<br>';
echo strftime_utf8('День: %a, %A, %d, %e, %u, %w, %j<br>');
echo strftime_utf8('Неделя: %U, %V, %W<br>');
echo strftime_utf8('Месяц: %b, %B, %h, %m<br>');
echo strftime_utf8('Год: %C, %g, %G, %y, %Y<br>');
$time = explode(',', '%H,%k,%I,%l,%M,%p,%P,%r,%R,%S,%T,%X,%z,%Z');
foreach ($time as $t) {
	echo $t . '	 Время: ' . strftime_utf8($t) . '<br>';
}
$date_time = explode(',', '%c,%D,%F,%s,%x');
foreach ($date_time as $t) {
	echo $t . '	 Метки даты и времени: ' . strftime_utf8($t) . '<br>';
}

var_dump(getdate(time()));
