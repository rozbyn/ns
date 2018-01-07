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
$arr = ['a', 'b', 'c', 'a', 'a', 'b'];
$count = [];
foreach($arr as $key=>$val){
	if (isset($count[$val])){
		$count[$val]++;
	} else {
		$count[$val] = 1;
	}
}
print_r($count);
echo '<br>';
function revArr($arr){
	$len = count($arr);
	$revArray = [];
	for ($i = $len-1;$i>=0;$i--){
		$revArray[]=$arr[$i];
	}
	return $revArray;
}
$arr = [4,5,7,8,4];
print_r($arr);
echo '<br>';
print_r(revArr($arr));
echo '<br>';
$arr = [[1, 2, 3, 4, ['y','df', '4fg']], 99, 999, 88, 888, [6, 7, 8], 66, 6, 666, 7, 777, 77, [9, 10]];
function displArrElem($arr){
	$str = '';
	foreach ($arr as $key=>$val){
		if (is_array($val)){
			$str .= displArrElem($val);
		} else {
			$str .= $val . '<br>';
		}
	}
	return $str;
}
echo displArrElem($arr) . '<br>';


echo '</div>';
echo '<div>';
$arr = [];
$str = '';
for ($i=0; $i<10;$i++){
	$str .= 'x';
	$arr[] = $str;
}
print_R($arr);

echo '</div>';
echo '<div>';
$arr = [];
$str = '';
for($i = 1; $i < 10; $i++){
	$str = '';
	for ($j = 1; $j <= $i; $j++){
		$str .= $i;
	}
	$arr[] = $str;
}
print_R($arr);
echo '</div>';
echo '<div>';
function arrayFill ($val, $count){
	$arr = [];
	for ($i = 0; $i <= $count; $i++){
		$arr[] = $val;
	}
	return $arr;
}
print_R(arrayFill('x',9));

$arr = [1, 1, 1, 1, 5, 1, 10, 11];
$i = 0;
$o = 0;
foreach ($arr as $val){
	if ($o>=10){
		echo $i . '<br>';
		break;
	} else {
		$o += $val;
		$i++;
	}
}
$arr =[[[1, 2], [3, 4]], [[5, 6], [7, 8]]];
function sumArr($arr){
	$sum = 0;
	foreach ($arr as $key => $val){
		if (is_array($val)){
			$sum += sumArr($val);
		} else {
			$sum += $val;
		}
	}
	return $sum;
}
echo sumArr($arr) . '<br>';
$arr = [];

$u = 0;
for ($i=0; $i<3; $i++){
	for ($j=0; $j<3; $j++){
		$u++;
		$arr[$i][$j] = $u;
	}
}
print_r($arr);
echo '<br>';
$arr = [19, 55, 45, 33, 11111, 22222, 222111, 22222222];
function wat($arr){
	$farr = [];
	foreach ($arr as $val){
		$sum = 0;
		$len = strlen($val)-1;
		for ($i = 0; $i <= $len; $i++){
			$val = strval($val);
			$sum += $val[$i];
		}
		if ($sum<10 && $sum>0){
			$farr[] = $val;
		}
	}
	return $farr;
}
print_r(wat($arr));
echo '<br>';
$arr = [19, 55, 45, 33, 11111, 22222, 222111, 22222222];
function getDigits($num){
	return str_split($num,1);
}
function inRange_1_9($num){
	$sum = array_sum(getDigits($num));
	return $sum>0 && $sum<10;
}
function fromArrtoArr ($arr){
	$farr = [];
	foreach ($arr as $val){
		if (inRange_1_9($val)){
			$farr[] = $val;
		}
	}
	return $farr;
}
print_r (fromArrtoArr($arr));
$arr = [19, 55, 45, 33, 11111, 22222, 222111, 22222222];
function summAllDigits($arr){
	$sum = 0;
	foreach ($arr as $val){
		$sum += array_sum(getDigits($val));
	}
	return $sum;
}
echo summAllDigits($arr) . '<br>';
function isPositive ($num){
	return 0<=$num;
}
function onlyPositive($arr){
	foreach($arr as $val){
		if (isPositive($val)){
			$arr2[]=$val;
		}
	}
	return $arr2;
}
$arr = [-1, 10, -5, 0, 4, -3.5, 2.6];
print_r(onlyPositive($arr));
function isNumberInRange($num){
	return $num > 0 && $num < 10;
}
$num = 1;
var_dump(isNumberInRange($num));
$arr = [1, 3, 5, 6, 9, 11, 15, 30];
$arr2 = [];
foreach($arr as $val){
	if (isNumberInRange($val)){
		$arr2[] = $val;
	}
}
print_r($arr2);
$num = 12345;
function getDigitSum($num){
	return array_sum(str_split($num,1));
}
echo getDigitSum($num) . '<br>';
$yearEq13 = '';
for ($i=1900; $i<=2100; $i++){
	if (getDigitSum($i) == 13){
		$yearEq13 .= $i . ', ';
	}
}
echo $yearEq13 . '<br>';
function isEven($num){
	return $num%2 == 0;
}
$num = 6;
var_dump(isEven($num));
$arr = [1, 2, 4, 6, 3, 5, 6, 9, 11, 15, 30];
$arr2 = [];
foreach($arr as $arr){
	if(isEven($arr)){
		$arr2[] = $arr;
	}
}
print_r($arr2);
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
$arr =[];
echo  '<br>';
echo  '<br>';
print_r(getDivisors(840));
echo '++++++++++++++++++++++++++++++++<br>';
print_r(count(getDivisors(840)));
echo  '<br>';
for ($i = 2; $i<=1000; $i++){
	$div = count(getDivisors($i));
	if ($div>25){
		$arr[$i] = $div;
	}
}
echo  '<br>';
print_r ($arr);
echo  '<br>';
print_r (max($arr));
function getCommonDivisors ($num1, $num2){
	return array_intersect(getDivisors($num1), getDivisors($num2));
}
print_r (getCommonDivisors (12, 14));

?>
</div>
</pre>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/base/priemy-raboty-s-massivami-na-php.html" target="_blank">Страница учебника</a></div>