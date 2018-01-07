<style>
	* {margin:0;padding:0}
	div {
		float: left;
		margin: 5px;
		padding: 5px;
		border: 1px solid black;
	}
</style>
<div>
<?php

function arrt($arr){
	foreach($arr as $key => $val){
		if (is_array($val)){
			arrt($val);
		} else {
			echo $key . ':' . $val . '<br>';
		}
	}
	}
/*--------------------------------------------------*/
for ($i=1; $i<=100; $i++){
	echo $i . '<br>';
}
echo '</div>';///////////
echo '<div>';////////////
for ($i=0; $i<=100;$i = $i + 2){
	echo $i . '<br>';
}
echo '</div>';///////////
echo '<div>';////////////
$u = 0;
for ($i=1;$i<=100;$i++){
	$u += $i;
}
echo $u . '<br>';

$u = 0;
for($i=1;$i<=15;$i++){
	$u += $i * $i;
}
echo $u . '<br>';

$u = 0;
for($i=1;$i<=100;$i++){
	if($i % 7 == 0){
		$u += $i;
	}
}
echo $u . '<br>';

$u = 0;
for ($i=1;$i<=15;$i++){
	$u += sqrt ($i);
}
echo round($u, 2) . '<br>';
$arr =[];
for ($i = 0; $i<10; $i++){
	$arr[]='x';
}
arrt($arr);

$arr = [];
for ($i = 0; $i < 10; $i++){
	$arr[] = mt_rand(1, 10);
}
arrt($arr);

$str = '';
for ($i = 0; $i < 6; $i++){
	$str .= mt_rand(0,9);
}
echo $str . '<br>';

$arr = str_split('434324231424223423', 1);
$last = '';
$thirdLast = '';
foreach($arr as $key => $val){
	if ($val == $last && $val == $thirdLast){
			echo 'YES' . '<br>';
			break;
	}
	$thirdLast = $last;
	$last = $val;
}
$str = '';
for ($i = 0; $i < 5; $i++){
	$str .= str_repeat($i, $i);
}
echo $str . '<br>';
$arr = [
		0=>['name'=>'Коля', 'salary'=>300],
		1=>['name'=>'Вася', 'salary'=>400],
		2=>['name'=>'Петя', 'salary'=>500],
	];
foreach ($arr as $key => $val){
	echo implode('-', $val) . '<br>';
}
$arr = [];
for ($i = 0; $i <10; $i++){
	for ($j = 0; $j < 10; $j++){
		$arr[$i][] = mt_rand(1,10);
	}
}
arrt($arr);
echo '</div>';///////////
echo '<div>';////////////
function toUpFirst($str){
	echo $str[0]. $str[1] . '<br>';
	echo $str[1] . '<br>';
	$str[0] = mb_strtoupper($str[0]);
	return $str;
}
echo toUpFirst('увыацуп4232') . '<br>';

function reve($str){
	$str2 = '';
	for ($i = -1; abs($i) <= strlen($str); $i--){
		$str2 .= substr($str, $i, 1); 
	}
	return $str2;
}
echo reve('1234567890') . '<br>';
function cAsEtRaNsForM ($str){
	$en = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 1);
	$en2 = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 1);
	$en = array_combine($en, $en2);
	$ru = str_split('абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ', 2);
	$ru2 = str_split('АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя', 2);
	$ru = array_combine($ru, $ru2);
	$repl = array_merge($en, $ru);
	return strtr($str, $repl);
}

echo cAsEtRaNsForM('SAdAаываЫВАЫаы') . '<br>';

$str ='var_text_hello';
function functName($str){
	$arr = explode('_', $str);
	$qwe = array_shift($arr);
	$arr = array_map('ucfirst', $arr);
	$str = $qwe . implode('', $arr);
	return $str;
}
echo functName($str) . '<br>';

$str = '';
for ($i = 1; $i < 10; $i++){
	echo str_repeat($i, $i) . '<br>';
}
$str = '0123456789';
$str2 ='';
$o = strlen($str);
for ($i = $o; $i > 0; $i--){
	$str2 .= substr($str ,0, $i) . '<br>';
}
echo $str2;
$arr =[1,2,3];
foreach ($arr as $val){
	for ($i = 1; $i <= $val; $i++){
		$arr2[] = $val;
	}
}
arrt($arr2);
echo '/////////' . '<br>';
$arr = [1, 2, 3, 4, 5, 6];
$po = 1;
$arr2 = [];
foreach ($arr as $val){
	if ($po % 2 != 0){
		$key = $val;
	} else {
		$arr2[$key] = $val;
	}
	$po++;
}
arrt($arr2);

$str ='1212121212121';
$arr = str_split($str, 1);
for ($i = 1; $i<= count($arr); $i += 2){
	$arr[$i] = '';
}
$str = implode('', $arr);
echo $str . '<br>';




$str ='12345678';

$str2 = '';
$n = strlen($str)-1;
for ($i = 1; $i <= $n; $i += 2){
	$str2 .= $str[$i] . $str[$i-1];
}
echo $str2 . '<br>';

$arr = [1, 1, 1, 2, 3, 3, 4 ,5, 1, 6, 1, 3];
$arr2 = [];
foreach ($arr as $val){
	if (!in_array($val, $arr2)){
		$arr2[] = $val;
	}
}
arrt($arr2);
echo '/////////' .count($arr). '<br>';
$arr2 = [];
$i = 0;
foreach ($arr as $val){
	$t = array_shift($arr);
	if (in_array($t, $arr)){
		$arr2[] = $t;
	}
	$i++;
}
echo $i . '<br>';
arrt($arr2);
echo '/////////' . '<br>';
$num = 13;
function getDivisors($num){
	$arr = [1];
	if ($num < 3){
		return $arr;
	}
	$lastDivider = '';
	for ($i = 2; true; $i++){
		if ($i == $num){
			return $arr;
		}
		if ($i == $num/$i){$arr[] = $i; break;}
		if ($lastDivider == $i){
			break;
		}
		if($num%$i == 0) {
			$arr[] = $i;
			$lastDivider = $num / $i;
			$arr[] = $lastDivider;
		}
	}
	return $arr;
}
if (count(getDivisors($num)) == 1){
		echo 'Число ' . $num . ' - простое.' . '<br>';
}else{
	echo 'Число ' . $num . ' - не простое.' . '<br>';
}
$arr = ['http://Число1', 'Число2', 'Число3', 'http://Число4', 'http://Число5', 'http://Число6', 'Число7', 'http://Число8', 'Число'];
$arr2 = [];
foreach($arr as $val){
	if(substr($val,0,7) == 'http://'){
		$arr2[] = $val;
	}
}
arrt($arr2);

$x = 1;
do {
	echo $x;
}
while ($x++<10);









?>
</div>
</pre>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/practice/praktika-na-otrabotku-ciklov-i-funkcij-php.html" target="_blank">Страница учебника</a></div>