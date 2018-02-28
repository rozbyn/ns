<?php
function showArr($arr){
	foreach($arr as $key=>$val){
		echo "$key => $val" . '<br>';		
	}
}
function bubbleSort(&$arr, $DESC=false){
	if($DESC){
		//echo 'По убыванию' . '<br>';
	} else {
		//echo 'По возрастанию' . '<br>';
	}
	$O = 0;
	$j = 0;
	do{
		$i = count($arr)-1;
		$swapCount = 0;
		for(;$i>$j;$i--){
			$O++;
			$cond = ($DESC)?($arr[$i]>$arr[$i-1]):($arr[$i]<$arr[$i-1]);
			if($cond){
				//echo $i . ':' . $arr[$i].' - '. ($i-1) .':'.$arr[$i-1]. '&#9;swap<br>';
				swap($arr[$i], $arr[$i-1]);
				$swapCount++;
			} else {
				//echo $i . ':' . $arr[$i].' - '. ($i-1) .':'.$arr[$i-1]. '&#9;noswap<br>';
			}
			
		}
		$j++;
	}while($swapCount!==0);
	echo 'O='.$O . '<br>';
}


function swap(&$a, &$b){
	$c = $b;
	$b = $a;
	$a = $c;
	unset($c);
}

$unsortArray = [0,1,2,3,4,5,6,7,8,9];
shuffle($unsortArray);
$unsortArray = array_reverse(range(0, 9999));
echo '$unsortArray = array_reverse(range(0, 999));' . '<br>';
//showArr($unsortArray);
echo  '<br>';
bubbleSort($unsortArray, false);
//showArr($unsortArray);
$O = 0;
$unsortArray = range(0, 9999);
shuffle($unsortArray);
echo '$unsortArray = range(0, 9999);<br>shuffle($unsortArray);' . '<br>';
bubbleSort($unsortArray);



?>
<style>
	body{
		font-family: monospace;
		font-size: 12px;
	}
</style>