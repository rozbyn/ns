<?php
$t1 = -microtime(true)*1000;
$str ='aaaabbbaddasddsaddabbbaaaaaaaabbbaddasddsaddabbbaaaaaaaabbbaddasddsaddabbbaaaaaaaabbbaddasddsaddabbbaaaa';
function palindromeCount($str){
	$palindromeCount = 0;
	$strLen = strlen($str);
	for($middle=0;$middle<$strLen;$middle++){
		$left = $middle;
		$right = $middle+1;
		while($left>=0 && $right<$strLen && $str[$left]==$str[$right]){
			$palindromeCount++;
			$left--;
			$right++;
		}
	}
	for($middle=0;$middle<$strLen;$middle++){
		$left = $middle-1;
		$right = $middle+1;
		while($left>=0 && $right<$strLen && $str[$left]==$str[$right]){
			$palindromeCount++;
			$left--;
			$right++;
		}
	}
	return $palindromeCount;
}

echo $str . '<br>';
echo 'Число палиндромов в строке: '. palindromeCount($str).'<br>';
echo sprintf('Время выполнения: %fms', $t1+=microtime(true)*1000) . '<br>';
/* 
$t2 = microtime();
echo 'Начало сек:'.substr($t1,11).', мсек:'. substr($t1,0,10) . '<br>';
echo 'Конец сек:'.substr($t2,11).', мсек:'. substr($t2,0,10) . '<br>';
$runTimeSec = substr($t2,11)-substr($t1,11);
$runTimeMSec = (substr($t2,0,10)-substr($t1,0,10))*1000;
echo "Прошло $runTimeSec секунд, $runTimeMSec миллисекунд" . '<br>';
$ty1 += microtime(true);
echo sprintf('%f', $ty1) . '<br>';
echo (float)$ty1 . '<br>';
 */
//0.74628900 1518947549

?>
<style>
	body{text-align:center;}
</style>