<?php
$str = 'aaaabbbaddaaddasdasdasdasadadasdasdasdasdasdasdasda';
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
				echo '!!!--';
				$palindromeCount++;
			}
			echo $strSUB . ' - '.$left.' : '.$right.' : '.$offset.'<br>';
			$right--;
		}
		$left++;
	}
	return $palindromeCount;
}





echo $str . '<br>';
var_dump(palindromeCount($str));




?>
<style>
	body{text-align:center;}
</style>