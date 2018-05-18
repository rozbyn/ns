<?php
$timer = -microtime(true);
function kshuffle (&$arr) {
	$k = array_keys($arr);
	shuffle($k);
	$arr = array_combine($k, $arr);
}
function prefixStr ($str) {
	return 'img'.$str;
}
echo '<pre>';
$arr2 = $arr1 = range(0, 15);
kshuffle ($arr1);
asort($arr1); 
print_r($arr1);
arsort($arr1, SORT_STRING);
print_r($arr1);

ksort($arr1);
print_r($arr1);
krsort($arr1, SORT_STRING);
print_r($arr1);

$as = array_map('prefixStr', $arr2);
shuffle($as);
print_r($as);
natsort($as);
print_r($as);

echo '</pre>';































printf('[Time => %.2fms]<br>', ($timer + microtime(true)) * 1000) ;