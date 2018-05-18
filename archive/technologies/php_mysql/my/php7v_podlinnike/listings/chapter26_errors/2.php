<?php

try {
	$str = "Hello world!";
	//echo new Stdclass . '<br>';
	//$str[] = 9999**9999; //++
	//$str = 7/0;
	eval('sdjf90we78hf0842gh02348h'); //++
	sadadahid;
} catch (Error $e) {
	echo 'Обнаружена ошибка: '.$e->getMessage().'<br>';
}

function ex () {
	try {
		echo 'Enter function ex()' . '<br>';
		echo 'throwing...' . '<br>';
		//throw new Exception('exddddddddddd');
		echo 'last action ex()' . '<br>';
	} finally {
		echo 'guaranteed last action ex()' . '<br>';
	}
}

try {
	echo '1' . '<br>';
	ex();
	echo '2' . '<br>';
	throw new Exception('wwww');
	echo '3' . '<br>';
	echo '4' . '<br>';
} catch (Exception $e) {
	echo 'Exception: ' .$e. '<br>';
}
echo "Block" . '<br>';