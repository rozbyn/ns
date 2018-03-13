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
function insert(&$arr, $posFrom, $posTo){
	$temp = array_splice($arr, $posFrom, 1);
	//echo 'Ставим ' .$temp[0]. ' в позицию '.$posTo. '<br>';
	array_splice($arr, $posTo, 0, $temp);
}

function selectionSort(&$arr, $DESC=false){
	$O = 0;
	$len = count($arr);
	for($i=0;$i<$len-1;$i++){
		$currentMin = $i;
		for($j=$i+1;$j<$len;$j++){
			$O++;
			if($arr[$currentMin]>$arr[$j]){
				$currentMin = $j;
			}
		}
		swap($arr[$currentMin], $arr[$i]);
		/* echo  $arr[$currentMin] .' swap with '.$arr[$i] . '<br>';
		showArrToOneString($arr);
		echo '<br>'; */
	}
	echo 'O='.$O . '<br>';
}




$unsortArray = [0,1,2,3,4,5,6,7,8,9,10];
shuffle($unsortArray);
//$unsortArray = [1,6,8,7,4,3,9,10,2,5,0];
//$unsortArray = [10,9,8,7,6,5,4,3,2,1,0];
$unsortArray = array_reverse(range(0, 9999));
echo '$unsortArray = array_reverse(range(0, 9999));' . '<br>';
//showArr($unsortArray);
echo  '<br>';
selectionSort($unsortArray, false);
//showArr($unsortArray);
echo  '<br>';
$O = 0;
$unsortArray = range(0, 9999);
shuffle($unsortArray);
echo '$unsortArray = range(0, 9999);<br>shuffle($unsortArray);' . '<br>';
selectionSort($unsortArray);



?>
<style>
	body{
		font-family: monospace;
		font-size: 12px;
	}
</style>