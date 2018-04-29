<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

function endConnection ($str = '') {
	header("Connection: close\r\n");
	header("Content-Encoding: none\r\n");
	echo $str;
	ignore_user_abort(true); // optional
	$size = ob_get_length();
	header("Content-Length: $size");
	ob_end_flush();     // Strange behaviour, will not work
	flush();            // Unless both are called !
}

function debug ($variable) {
	echo '<pre>';
	var_dump($variable);
	echo '</pre>';
	exit();
}
