<?php

function add($a, $b){
	if ($b == 0) return $a;
	echo sprintf('Первое число:<br>%1$032d %2$d', decbin($a), $a) . '<br>';
	echo sprintf('Второе число:<br>%1$032d %2$d', decbin($b), $b) . '<br>';
	$sum = $a ^ $b;			// добавляем без переноса
	echo sprintf("$a ^ $b:<br>".'%1$032d %2$d', decbin($sum), $sum) . '<br>';
	$carry = ($a & $b) << 1;	// перенос без суммирования
	echo sprintf("$a & $b:<br>".'%1$032d %2$d', decbin($a & $b), $a & $b) . '<br>';
	echo sprintf("($a & $b) << 1:<br>".'%1$032d %2$d', decbin(($a & $b)<<1), ($a & $b)<<1) . '<br><br>';
	return add($sum, $carry);		// рекурсия
}

echo 'ОТВЕТ: '.add(106,1005) . '<br>';

?>
<style>
	body{
		font-family: monospace;
	}
</style>