<?php
function SimpleHash($num, $m=10){
	return $num . ': ' . $num % $m;
}
function strHash($str, $m=10){
	$s = 0;
	for($i=0;$i<strlen($str);$i++){
		$s += ord($str[$i]);
	}
	return $str . ': ' . $s % $m;
}
function strToBin($str){
	$arr = str_split($str);
	$retArr = [];
	foreach($arr as $val){
		$retArr[] = base_convert(ord($val), 10, 2);
	}
	return implode('', $retArr);
}
function strHash2($str, $m=10){
	return $str . ': ' . (ord($str[0]) + ord($str[strlen($str)-1])) % $m;
}






echo SimpleHash(mt_rand(1, 100000)) . '<br>';
echo strHash(str_shuffle('qwertyuiop[]asdfghjkl;zxcvbnm,./')) . '<br>';
echo strHash2(str_shuffle('qwertyuiop[]asdfghjkl;zxcvbnm,./')) . '<br>';

echo strToBin(str_shuffle('qwertyuiop')) . '<br>';




?>
<style>
	body{text-align:end;}
</style>