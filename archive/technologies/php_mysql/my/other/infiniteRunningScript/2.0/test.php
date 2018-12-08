<?php

$start = -microtime(true);
$maxExTime = ini_get('max_execution_time');

while(true){
	echo 'bob<br>';
	flush();
	ob_flush();
	flush();
	ob_flush();
	usleep(500000);
	if(($maxExTime - (microtime(true) + $start)) < 0.5){
		echo 'end';
		break;
	}
}