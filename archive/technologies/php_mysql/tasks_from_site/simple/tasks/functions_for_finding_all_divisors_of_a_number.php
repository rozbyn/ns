<?php
$nech = 1100000;
$arr1 = [];

$k = 0;
$iterr = 1;
$divider = 0;
$quotient = 0;
//находит все делители числа(оптимизированный скрипт, в разы меньше итераций)
for ($k = 1; true; $iterr++, $k++){
	if ($nech % $k == 0){
		$divider = $k;
		$quotient = $nech / $k;
		if (end($arr1) == $k || end($arr1) == $quotient){
			break;
		}
		if ($quotient == $k){
			$arr1[] = $divider;
			break;
		}
		$arr1[] = $divider;
		$arr1[] = $quotient;
	}
}

sort($arr1);
echo '<pre>';
print_r($arr1);
echo '/<pre>';
echo $iterr . '<br>';

$arr = [];
$i = 0;
//находит все делители числа (простой перебор)
for ($i = 1; $i <= $nech; $i++) {
	if ($nech % $i == 0) {
		$arr[] = $i;
	}
}

echo '<pre>';
print_r($arr);
echo '/<pre>';
echo $i . '<br>';

?>


<?php if (true){

?>
<h1>HI!</h1>
<?php } ?>
