<?php
function mbStringToArray ($string) {
    $strlen = mb_strlen($string);
    while ($strlen) {
        $array[] = mb_substr($string,0,1,"UTF-8");
        $string = mb_substr($string,1,$strlen,"UTF-8");
        $strlen = mb_strlen($string);
    }
    return $array;
} 
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
	$arr = mbStringToArray($str);
	var_dump($arr);
	echo  '<br>';
	$retArr = [];
	foreach($arr as $val){
		$a = ord($val);
		echo $a . '<br>';
		$retArr[] = base_convert($a, 10, 2);
	}
	return implode('', $retArr);
}
function strHash2($str, $m=256){
	return '"'.$str . '"!!: ' . (ord($str[0]) + ord($str[strlen($str)-1])) % $m;
}
function sqrMethod($num, $m=256){
	$num2 = $num*$num;
	echo decbin($num) . '<br>';
	echo decbin($num2) . '<br>';
	$num2 = $num2 >> 11;
	echo $num2 . '<br>';
	echo decbin($num2) . '<br>';
	echo $num2 % 512 . '<br>';
	echo decbin($num2 % 512) . '<br>';
	return $num . ': '.$num2 % 512;
}



echo ord('Ж') . '<br>';

echo SimpleHash(mt_rand(1, 200000)) . '<br>';
echo strHash(str_shuffle('qwertyuiop[]asdfghjkl;zxcvbnm,./')) . '<br>';
echo strHash2(str_shuffle('qwertyuiop[]asdfghjkl;zxcvbnm,./')) . '<br>';
echo strHash2(' zzd ') . '<br>';
echo sqrMethod(302) . '<br>';
$n = 65416;
echo decbin($n) . '<br>';
echo decbin($n-1) . '<br>';

var_dump((($n & ($n-1)) == 0));




echo '///////////////////////////' . '<br>';
$h = 999;
$n = 999;
$e = 2;
$x = 1;
$sum = 0;
$i = 0;
do{
	$i++;
	$sum += $i;
}while($sum<$h);
echo $sum . '<br>';
echo $i . '<br>';


$x = $i;
$NX = NULL;
$lastChecked = 0;

$j=0;
$i=0;
while($j<$n && $x>=0){
	$lastChecked = $j;
	$i++;
	$j = $j+$x;
	$x--;
	echo 'Этап '.$i.'. Этаж: '.$j . '. Шаг: '. $x. '<br>';
	if($j>=$n){
		echo 'Яйцо-1 Разбито! Последний безопасный этаж: '.$lastChecked . '<br>';
		break;
	}
	if($h-1 == $j){
		$NX = $h;
		echo "Все яйца целы! N равно $NX" . '<br>';
		break;
	}
}


if(!$NX){
	
	do {
		if($j-1 == $lastChecked){
			$lastChecked++;
			echo 'Яйцо-2 цело! N = '.$lastChecked . '<br>';
			break;
		}
		$lastChecked++;
		$i++;
		echo "Этап: $i. Этаж: ".$lastChecked . '.<br>';
		if($lastChecked==$n){
			echo 'Яйцо-2 разбито! N = '.$lastChecked . '<br>';
			break;
		}
	} while (true);
	echo "Всего этапов: $i" . '<br>';
}









?>
<style>
	body{text-align:end;}
</style>