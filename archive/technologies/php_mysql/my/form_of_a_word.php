<?php
	date_default_timezone_set('Europe/Moscow');
	$s = date('s');
	$m = date('i');
	$h = date('H');
	$ho = 'ов';
	$so = '';
	$mo = '';
	$img = $s / 6 % 4;
	if ($s >= 11 && $s <= 20) { //Для секунд.
		$so = '';
	} elseif (($s-1)%10==0){
		$so = 'а';
	} elseif ($s % 10 <= 4 && $s % 10 > 1){
		$so = 'ы';
	}
	
	if ($m >= 11 && $m <= 20) { //То же самое для минут, 
		$mo = '';               //с измененными переменными.
	} elseif (($m-1)%10==0){
		$mo = 'а';
	} elseif ($m % 10 <= 4 && $m % 10 > 1){
		$mo = 'ы';
	}
	
	if ($h >= 11 && $h <= 20) { //То же самое для часов, 
		$ho = 'ов';             //с измененными переменными и окончаниями.
	} elseif (($h-1)%10==0){
		$ho = '';
	} elseif ($h % 10 <= 4 && $h % 10 > 1){
		$ho = 'а';
	}
	
	echo "Сейчас $h час$ho, $m минут$mo,  $s секунд$so";	
	echo '<hr>';
function skloneniye ($number, $word_0="Товаров",$word_1 = "Товар", $word_2_4 = "Товара"){
	$f10 = $number % 10;
	$f100 = $number % 100;
	if ($f10==1 && $f100!=11){
		return $word_1;
	} elseif ( ($f10 >= 2 && $f10 <=4) && ($f100>20 || $f100 <= 10) ) {
		return $word_2_4;
	} else {
		return $word_0;
	}
}
	echo 10 % 12 . '<br>';
	$x=0;
	while($x <= 100){
			echo $x . ' ' . skloneniye($x) . '<br>';
			$x++;
		}

	
?>
<!doctype html>
<html>
	<head>
		<style>
			body {
				background: url(img/<?php echo $img;?>.jpg) no-repeat;
				background-size: cover;
				color : #00f;
			}
		</style>
	</head>
	<body>
	
	</body>
</html>
	
