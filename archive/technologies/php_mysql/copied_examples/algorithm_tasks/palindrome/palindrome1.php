<?php
$t1 = -microtime(true)*1000;
$str = 'aaaabbbaddasddsaddabbbaaaaaaaabbbaddasddsaddabbbaaaaaaaabbbaddasddsaddabbbaaaaaaaabbbaddasddsaddabbbaaaa';
function asd($str, $left='', $right=''){
	$left = ($left=='')?0:$left;
	$right = ($right=='')?strlen($str)-1:$right;
	while($left<=$right){
		if($str[$left]!=$str[$right] || ($right==0)){
			return false;
		}
		$right--;
		$left++;
	}
	return true;
}
function palindromeCount($str){
	$palindromeCount = 0;
	$strLen = strlen($str);
	$left = 0;
	while($left<$strLen){
		$right = $strLen;
		while($left<$right){
			$offset = $right - $left;
			$strSUB = substr($str,$left, $offset);
			if(asd($strSUB)){
				$palindromeCount++;
			}
			$right--;
		}
		$left++;
	}
	return $palindromeCount;
}





echo $str . '<br>';
echo 'Число палиндромов в строке:'. palindromeCount($str).'<br>';
echo sprintf('Время выполнения: %fms', $t1+=microtime(true)*1000) . '<br>';



?>
<style>
	body{text-align:center;}
</style>