<?php
function var_bump(...$a) {
	$str = '<pre>';
	ob_start();
	foreach($a as $v){
		var_dump($v);
	}	
	$temp = ob_get_clean();
	$str .= "$temp" . '</pre>';
	echo $str;
}


function simple ($from = 0, $to = 100) {
	for ($i = $from; $i <= $to; $i++) {
		//echo "Значение: $i" . '<br>';
		yield $i;
	}
}

foreach (simple(1, 9) as $val) {
	//echo "Квадрат:". ($val**2) . '<br>';
}

$collect = function  ($arr, $callback) {
	foreach ($arr as $val) {
		
		echo "collect: $val" . ' ';
		yield $callback($val);
	}
};

$arr1 = range(1, 10);
$arr2 = range(11, 20);
$fr = function ($n) {
	echo "SQUARE: ".$n*$n. ' ';
	return $n * $n;
};
$a = $collect($arr1, $fr);
$b = $collect($arr2, $fr);

foreach ($a as $val) {
	echo "Foreach a: $val" . '<br>';
}

foreach ($b as $val) {
	echo "Foreach b: $val" . '<br>';
}

function square ($val) {
	yield $val**2;
	yield $val**3;
}

function even_square ($arr) {
	foreach ($arr as $val) {
		if ($val % 2 == 0) {
			yield from square($val);
			yield from square($val+10);
		}
	}
}

$arr = range(1,6);
foreach (even_square($arr) as $val) echo $val . '<br>';

function grgrg () {
	yield 1;
	yield from [2,3, 5];
	return 'return 123';
}
$rgrgr = grgrg();
foreach ($rgrgr as $i) echo "$i ";
echo $rgrgr->getReturn();
echo '<br>';

function one1 () {
	while (true) {
		$a = yield 1;
		$b = yield $a . '@@@';
		yield $b . '%%%';
	}
}
function one2 () {
	$i = 0;
	$o1 = '||';
	while (true) {
		$o1 = yield 'key'.$i => 'returned yield №'. $i. ', string: ' .$o1;
		echo 'received yield №'. $i .', string: '.$o1.'<br>';
		$i++;
	}
}


$nsada = one1();
var_bump($nsada->current());
var_bump($nsada->send('Send string1!'));
var_bump($nsada->current());
var_bump($nsada->send('Send string2!'));
var_bump($nsada->current());
var_bump($nsada->send('Send string3!'));
var_bump($nsada->current());
var_bump($nsada->send('Send string4!'));
var_bump($nsada->current());

echo  '<br>';
echo  '<br>';
$asda13 = one2();
var_bump($asda13->current());
var_bump($asda13->send('Send string1!'));
var_bump($asda13->send('Send string2!'));
var_bump($asda13->send('Send string3!'));
var_bump($asda13->send('Send string4!'));
var_bump($asda13->send('Send string5!'));


$nsaddaa = [1,2,3,4,5,6,7,8,9];



$s = serialize($nsaddaa);

//file_put_contents('s', $s);


exit(var_dump(unserialize(file_get_contents('s'))));

































