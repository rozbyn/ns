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

function dArr ($arr){
	foreach ($arr as $key => $val){
		echo $key . '=>' . $val . '<br>';
	}
}
function dArrVal($arr){
	$str = '[';
	foreach($arr as $key => $val){
		$str .= '\'' . $val . '\', ';
	}
	$str .= ']';
	echo $str . '<br>';
}


/*--------------------------------------------------*/
function toTranslit($ruStr){
	$ru = ['а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'];
	$en =['a', 'b', 'v', 'g', 'd', 'e', 'yo', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'shh', '\'\'', 'y', '\'', 'e\'', 'yu', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'YO', 'ZH', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'CH', 'SH', 'SHH', '\'\'', 'Y', '\'', 'E\'', 'YU', 'YA'];
	return str_replace($ru, $en, $ruStr);
}
echo toTranslit('Транслит это очень хорошо, наверное...') . '<br>';
function skloneniye ($number, $word_0="Товаров",$word_1 = "Товар", $word_2_4 = "Товара"){
	$f10 = $number % 10;
	$f100 = $number % 100;
	if ($f10==1 && $f100!=11){
		return $word_1;
	} elseif ( ($f10 >= 2 && $f10 <=4) && ($f100>20 || $f100 <= 10) ) {
		return $word_2_4;
	} else {
		return $word_0;
	}
}
for ($i = 0; $i < 2; $i++){
	echo $i . ' ' . skloneniye($i, 'Яблок', 'Яблоко' ,'Яблока') . '<br>';
}
function happyTickets (){
	$arr = [];
	for ($i = 0; $i < 1000000; $i++){
		$arr1 = str_split($i, 1);
		if (count($arr1)<6){
			$arr1 = array_pad($arr1, -6, 0);
		}
		$sum1 = $arr1[0]+$arr1[1]+$arr1[2];
		$sum2 = $arr1[3]+$arr1[4]+$arr1[5];
		if ($sum1 == $sum2){
			$arr[] = implode('', $arr1);
		}
	}
	return $arr;
}
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
function frendlyNumbers(){
	$arr = [];
	$arr1 = [];
	for ($i=3; $i<100; $i++){
		$div1 = getDivisors($i);
		$arr[$i] = array_sum($div1);
	}
	foreach ($arr as $key => $val){
		if (isset($arr[$val])){
			if ($arr[$val] == $key){
				if (!isset($arr1[$val]))
					$arr1[$key] = $val;
			}
		}
	}
	return $arr1;
}
$arrd = frendlyNumbers();
dArr($arrd);

echo '</div>';
echo '<div>';
function cut($str, $numOfDigits = 10){
	return substr($str, 0, $numOfDigits);
}
echo cut('asdfghjklqwertyuiop', 5) . '<br>';
$arr = [1, 2, 3, 4, 5, 6, 7, 8, 9];
function printArr($arr)
{
	echo array_shift($arr) . '<br>';
	if (!empty($arr)) {
		printArr($arr);
	}
}
printArr($arr);
echo '<br>';
function sumDigits($num){
	$arr = str_split($num, 1);
	$sum = array_sum($arr);
	echo $sum . '<br>';
	if ($sum>9){
		$sum = sumDigits($sum);
	}
	return $sum;
}
sumDigits(946898768769089878953423423423264236338);

?>
</div>
</pre>

<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/base/praktika-na-rabotu-s-polzovatelskimi-funkciyami-php.html" target="_blank">Страница учебника</a></div>
<div style="position: fixed; top:80%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/base/prodvinutaya-rabota-s-polzovatelskimi-funkciyami-v-php.html" target="_blank">Страница учебника</a></div>