<?php
function showArr($arr){
	foreach($arr as $key=>$val){
		echo "$key => $val" . '<br>';
		
	}
	echo  '<br>';
}
function showArrToOneString($arr){
	echo '|';
	foreach($arr as $key=>$val){
		echo  "$val" . '|';
		
	}
	echo  '<br>';
}
function swap(&$a, &$b){
	$c = $b;
	$b = $a;
	$a = $c;
	unset($c);
}
$O = 0;
function merge2SortedArr($arr1, $arr2){
	global $O;
	$tempArr = [];
	while(!empty($arr1) && !empty($arr2)){
		$O++;
		$tempArr[] = ($arr1[0]>=$arr2[0])? array_shift($arr2) : array_shift($arr1);
	}
	if(empty($arr1)){
		$tempArr = array_merge($tempArr, $arr2);
	} elseif(empty($arr2)){
		$tempArr = array_merge($tempArr, $arr1);
	}
	return $tempArr;
}
function mergeSort(&$arr){
	global $O;
	$len = count($arr);
	$tmpArr = [];
	for($i=0;$i<$len;$i+=2){
		$O++;
		if(isset($arr[$i+1])){
			$tmpArr[] = ($arr[$i]>=$arr[$i+1])? [$arr[$i+1], $arr[$i]] : [$arr[$i], $arr[$i+1]];
		} else {
			$tmpArr[] = merge2SortedArr([$arr[$i]], array_pop($tmpArr));
		}
	}
	do{
		$O++;
		$tmpArr2 = [];
		for($j=0;$j<count($tmpArr);$j+=2){
			$O++;
			if(isset($tmpArr[$j+1])){
				$tmpArr2[] = merge2SortedArr($tmpArr[$j], $tmpArr[$j+1]);
			} else {
				$tmpArr2[] = merge2SortedArr($tmpArr[$j], array_pop($tmpArr2));
			}
		}
		$tmpArr = $tmpArr2;
	}while(count($tmpArr)>=2);
	$arr = $tmpArr[0];
}



/* $arr1 = [1];
$arr2 = [0];
$arr3 = merge2SortedArr($arr1, $arr2);
var_dump($arr3); */


//$unsortArray = [0,1,2,3,4,5,6,7,8,9,10];
//shuffle($unsortArray);

$unsortArray = array_reverse(range(0, 9999));
echo '$unsortArray = array_reverse(range(0, 9999));' . '<br>';
//$unsortArray = [1,6,8,7,4,3,9,10,2,5,0];
//showArr($unsortArray);
echo  '<br>';
mergeSort($unsortArray);
//showArr($unsortArray);
echo 'O='.$O . '<br>';
echo  '<br>';
$O = 0;
$unsortArray = range(0, 9999);
shuffle($unsortArray);
echo '$unsortArray = range(0, 9999);<br>shuffle($unsortArray);' . '<br>';
mergeSort($unsortArray);
echo 'O='.$O . '<br>';

?>
<style>
	body{
		font-family: monospace;
		font-size: 12px;
	}
</style>