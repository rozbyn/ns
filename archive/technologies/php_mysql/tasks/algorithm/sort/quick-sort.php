<?php
function showArr($arr){
	foreach($arr as $key=>$val){
		echo "$key => $val" . '<br>';
		
	}
	echo  '<br>';
}
function showArrToOneString($arr){
	$str = '[';
	foreach($arr as $key=>$val){
		$str .=   "$val" . '|';
		
	}
	$str = ($str[strlen($str)-1] === '|')?substr($str,0,-1):$str;
	$str .=   ']';
	echo $str;
}
function swap(&$a, &$b){
	$c = $b;
	$b = $a;
	$a = $c;
	unset($c);
}
$O = 0;



function quickSort(&$arr, $lIndex=0, $rIndex=0){
	global $O;
	$O++;
	$i = ($lIndex)?:0;
	$j = ($rIndex)?$rIndex-1:count($arr)-2;
	$rIndex = $j+1;
	$pivotpos = $rIndex;
	$pivot = $arr[$pivotpos];
	if($rIndex-$lIndex<1){
		return;
	}
/* 	echo 'Сортируем '.$lIndex .':'.$rIndex .' PivotPos - '. $pivotpos . '<br>';
	showArrToOneString($arr);
	echo '<br>'; */
	$iStopped = false;
	$jStopped = false;
	$IterrCount = 0;
	while($i<$j){
		$O++;
		//echo 'Сравниваем '.$arr[$i].' и '. $pivot . '<br>';
		if($arr[$i]<=$pivot){
			//echo $arr[$i]. ' < '. $pivot . '<br>';
			$i++;
		} else {
			//echo $arr[$i]. ' > '. $pivot . ' Остановка!<br>';
			$iStopped = true;
		}
		//echo 'Сравниваем '.$arr[$j].' и '. $pivot . '<br>';
		if($arr[$j]>$pivot){
			//echo $arr[$j]. ' > '. $pivot . '<br>';
			$j--;
		} else {
			//echo $arr[$j]. ' <= '. $pivot . ' Остановка!<br>';
			$jStopped = true;
		}
		if($iStopped && $jStopped){
			/* echo 'Меняем позиции '. $i.' и '. $j . '<br>'; */
			swap($arr[$i], $arr[$j]);
			$iStopped = false;
			$jStopped = false;
		}
	}
	if($i>$j){
		$i--;
		$j++;
	}
	if($arr[$j]>$arr[$pivotpos]){
		/* echo 'Меняем PivotPos:'. $pivotpos.' и позицию:'. $j . '<br>'; */
		swap($arr[$pivotpos], $arr[$j]);
	}
/* 	showArrToOneString($arr);
	echo  '<br>';
	echo $lIndex .':'.$i.' - '. ($j+1) .':'.$rIndex . '<br>'; */
	if($i>$lIndex){
		quickSort($arr, $lIndex, $i);
	}
	if($j<$rIndex){
		quickSort($arr, $j+1, $rIndex);
	}
}





//$unsortArray = [0,1,2,3,4,5,6,7,8,9,10];
//shuffle($unsortArray);

$unsortArray = array_reverse(range(0, 9999));
echo '$unsortArray = array_reverse(range(0, 9999));' . '<br>';
/* $unsortArray = [1,6,8,7,4,3,9,10,2,5,0];
showArrToOneString($unsortArray);
echo  '<br>';
echo  '<br>'; */
quickSort($unsortArray);
//showArrToOneString($unsortArray);
//echo  '<br>';
echo 'O='.$O . '<br>';

echo  '<br>';
$O = 0;
$unsortArray = range(0, 9999);
shuffle($unsortArray);
echo '$unsortArray = range(0, 9999);<br>shuffle($unsortArray);' . '<br>';
quickSort($unsortArray);
echo 'O='.$O . '<br>';
?>
<style>
	body{
		font-family: monospace;
		font-size: 12px;
	}
</style>