<?php
function showArr($arr){
	foreach($arr as $key=>$val){
		echo "$key => $val" . '<br>';
		
	}
	echo  '<br>';
}
function insert(&$arr, $posFrom, $posTo){
	$temp = array_splice($arr, $posFrom, 1);
	//echo 'Ставим ' .$temp[0]. ' в позицию '.$posTo. '<br>';
	array_splice($arr, $posTo, 0, $temp);
}

function insertSort(&$arr, $DESC=false){
	$O = 0;
	$len = count($arr);
	for($i=1;$i<$len;$i++){
		//echo 'Сравниваем позиции '.$i. ' и '. ($i-1) . '('.$arr[$i].' и '.$arr[$i-1].')'.'<br>';
		$cond = ($DESC)?($arr[$i]>$arr[$i-1]):($arr[$i]<$arr[$i-1]);
		if($cond){
			//echo $arr[$i].' меньше '.$arr[$i-1] . '<br>';
			for($j=$i-1;$j>=0;$j--){
				//echo 'Ищем позицию для вставки '. $arr[$i] ."($j)". '<br>';
				$O++;
				$cond2 = ($DESC)?($arr[$i]<=$arr[$j]):($arr[$i]>=$arr[$j]);
				if($cond2){
					insert($arr, $i, $j+1);
					break;
				} elseif($j==0) {
					insert($arr, $i, $j);
					break;
				}
			}
		}
	}
	echo 'O='.$O . '<br>';
}




$unsortArray = [0,1,2,3,4,5,6,7,8,9,10];
shuffle($unsortArray);
$unsortArray = [1,6,8,7,4,3,9,10,2,5,0];
//$unsortArray = [10,9,8,7,6,5,4,3,2,1,0];
//showArr($unsortArray);
$unsortArray = array_reverse(range(0, 9999));
echo '$unsortArray = array_reverse(range(0, 9999));' . '<br>';
echo  '<br>';
insertSort($unsortArray, false);
//showArr($unsortArray);
$O = 0;
$unsortArray = range(0, 9999);
shuffle($unsortArray);
echo '$unsortArray = range(0, 9999);<br>shuffle($unsortArray);' . '<br>';
insertSort($unsortArray);



?>
<style>
	body{
		font-family: monospace;
		font-size: 12px;
	}
</style>