<?php
function arrt($arr){
	foreach($arr as $key => $val){
		if (is_array($val)){
			arrt($val);
		} else {
			echo $key . ':' . $val . '<br>';
		}
	}
}

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
echo '<pre>' . '<br>';


if (!empty($_GET['len'])){
	$r = $_GET['len'];
	if (!is_numeric($r)){
		$r = 10;
	}
}
function generatePasswords ($num){
	$str = '1234567890qwertyuiopasdfghjklzxcvbnm-_';
}

function rand30(){ 
	$t = mt_rand(1,100);
	if ($t>69){
		$dar = 'O';
	} else {
		$dar = 'P';
	}
return $dar;
}
$t = [];
for ($i=1; $i <=1000; $i++){
	$t[$i] = rand30();
	$t[$i] .= rand30();
}
$t = array_count_values($t);
ksort($t);
arrt($t);
?>