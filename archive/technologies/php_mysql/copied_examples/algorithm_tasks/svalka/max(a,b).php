<?php
/* Отражаем 1 в 0 и 0 в 1 */
function flip($bit) {
    return 1 ^ $bit;
}
 
/* Возвращаем 1, если число положительное, и 0, если отрицательное*/
function sign($a) {
	echo 'Разница('.$a.') в двоичной форме<br> '.decbin($a) . '<br>';
	$c1 = $a >> 31;
	echo 'Результат('.$c1.') смещения 31 бита в право: <br>'.decbin($c1) . '<br>';
	$c2 = $c1 & 0b1;
	echo "Результат операции $c1 & 1 = $c2" . '<br>';
	$c3 = flip($c2);
	echo "Инвертируем: $c3" . '<br>';
    return $c3;
}
 
function getMaxNaive($a, $b) {
	echo "Первое число $a, второе $b" . '<br>';
    $k = sign($a - $b);
    $q = flip($k);
	echo "Вычисляем $a*$k+$b*$q". '<br>';
    return $a * $k + $b * $q;
}
echo getMaxNaive(-4294967296546546546546546545, -4294967296);
for($i=0; $i<10; $i++){
	echo '<br><br>';
	echo getMaxNaive(mt_rand(-10000,10000), mt_rand(-10000,10000));
}

?>
<style>
	body{
		font-family: monospace;
	}
</style>
