<style>
	* {margin:0;padding:0}
	div {
		float:left;
		margin:5px;
		padding:5px;
		border: 1px solid black;
	}
</style>
<div>
<?php
/*--------------------------------------------------*/
function hello($name) {
		$text = 'Привет, '.$name.'!';
		return $text;
	}
echo hello('Вася') . '<br>';


function kvadr($num){
	return $num*$num;
}
function summ($num1, $num2){
	return $num1 + $num2;
}
function n3($num1,$num2,$num3){
	return ($num1-$num2)/$num3;
}
function dday($num){
	$dw = [1=>'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
	return $dw[$num];
}
echo kvadr(4) . '<br>';
echo summ(4,5) . '<br>';
echo n3(10,4,3) . '<br>';
echo dday(7) . '<br>';
function inArr ($arr, $num){
	foreach($arr as $val){
		if ($val == $num){return 'Да';}
	}
	return 'Нет';
}
$arr2 = [1,5,6,7,3,67,67,7,34,3,3456];
echo inArr($arr2, 9) . '<br>';
echo inArr($arr2, 67) . '<br>';
function isSimple($num){
	for ($i=2;$i<=$num-1;++$i){
		if ($num%$i==0){return 'Да'. $i;}
	}
	return 'Нет';
}
echo isSimple(45) . '<br>';
function twoSame($arr){
	foreach ($arr as $key=>$val){
		if ($key>0 && $val == $arr[$key-1]){
			return 'Да';
		}
	}
	return 'Нет';
}
echo twoSame($arr2) . '<br>';
//логические операции
$a = 4;
$b = 3;
$c = $a > $b;
var_dump($c);
echo '<br>';
$c = $a != 10 || $b == 10;
var_dump($c);
echo '<br>';
function isSame ($num1, $num2){
	return $num1 == $num2;
}
var_dump(isSame(11,11));
echo '<br>';
function isSum10($num1, $num2){
	return ($num1+$num2)>10;
}
var_dump(isSum10(4,7));
echo '<br>';
function isNegative($num){
	return $num<0;
}
var_dump(isNegative(-12));
echo '<br>';










?>
</div>
</pre>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/base/osnovy-raboty-s-polzovatelskimi-funkciyami-v-php.html" target="_blank">Страница учебника</a></div>