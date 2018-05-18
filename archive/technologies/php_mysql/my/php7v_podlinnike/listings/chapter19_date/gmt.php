<?php
echo '<pre>';
$locale = setlocale(LC_ALL, 'RU', 'Russian_Russia.1251');
date_default_timezone_set('Europe/Moscow');

$getDate = getDate();
echo date('Z') . '<br>';

echo date('H:i:s d.m.Y', time()) . '<br>';
echo gmdate('H:i:s d.m.Y') . '<br>';

$localTsmp = mktime($getDate['hours']);
$gmTsmp =  gmmktime($getDate['hours']);
echo $localTsmp . '<br>';
echo $gmTsmp . '<br>';
$raa = $gmTsmp - $localTsmp;

var_dump($raa);
echo date('Z') . '<br>';

function local2gm ($timestamp = false) {
	if ($timestamp === false) $timestamp = time();
	return $timestamp - date('Z');
}

function gm2local ($GMtimestamp = false, $tzOffset = false) {
	if ($GMtimestamp === false) return time();
	if ($tzOffset === false) $tzOffset = date('Z');
	else $tzOffset *= 3600;
	return $GMtimestamp + $tzOffset;
}
echo date('H:i:s d.m.Y', local2gm()) . '<br>';
echo date('H:i:s d.m.Y', gm2local(local2gm(), 3)) . '<br>';
echo gm2local(local2gm(), 3) . '<br>';