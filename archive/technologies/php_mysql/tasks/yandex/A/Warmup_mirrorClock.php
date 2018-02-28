<?php
/* $file = file_get_contents('input.txt');
$array = explode(' ', $file);
if($array[0] != 0){
	$array[0] = 12-$array[0];
}
if($array[1] != 0){
	$array[1] = 60-$array[1];
}
file_put_contents('output.txt', $array[0].' '.$array[1]);


echo $file . '<br>';
var_dump($array) . '<br>'; */

$h = mt_rand(0,11);
$s = mt_rand(0,59);
$array = array($h,$s);
if($array[0] != 0){
	$array[0] = 12-$array[0];
}
if($array[1] != 0){
	$array[1] = 60-$array[1];
}
echo $h.':'.$s.' => '.$array[0].' '.$array[1];


/*
function mirrorClock($hours, $seconds){
	if($hours != 0){
		$hours = 12-$hours;
	}
	if($seconds != 0){
		$seconds = 60-$seconds;
	}
	return "$hours:$seconds";
}
 echo "0:0 => ".mirrorClock(0,0) . '<br>';
echo "11:59 => ".mirrorClock(11,59) . '<br>';
echo "6:30 => ".mirrorClock(6,30) . '<br>';
echo "5:40 => ".mirrorClock(5,40) . '<br>';
echo "3:45 => ".mirrorClock(3,45) . '<br>';
echo "9:15 => ".mirrorClock(9,15) . '<br>';
echo "9:45 => ".mirrorClock(9,45) . '<br>';
echo "3:15 => ".mirrorClock(3,15) . '<br>'; */




?>