<?php 
if($_SERVER['DOCUMENT_ROOT'] === '/home/u784337761/public_html'){
	return [
		'host' => 'localhost',
		
		'name' => 'u784337761_test',
		
		'user' => 'u784337761_root',
		
		'password' => 'nSCtm9jplqVA'
		
	];
	
} elseif ($_SERVER['DOCUMENT_ROOT'] === '/storage/ssd3/266/4204266/public_html') {
	return [
		'host' => 'localhost',
		
		'name' => 'id4204266_test',
		
		'user' => 'id4204266_root',
		
		'password' => 'asdaw_q32d213e'
		
	];
} elseif($_SERVER['DOCUMENT_ROOT'] === '/home/x/x905346n/x905346n.beget.tech/public_html') {
	return [
		'host' => 'localhost',
		
		'name' => 'x905346n_main',
		
		'user' => 'x905346n_main',
		
		'password' => 'z*7WK4qG'
		
	];
} elseif($_SERVER['DOCUMENT_ROOT'] === '/storage/ssd5/250/7376250/public_html') {
	return [
		'host' => 'localhost',
		
		'name' => 'id7376250_test',
		
		'user' => 'id7376250_root',
		
		'password' => 'jasd07ag'
		
	];
} else {
	return [
		'host' => 'localhost',
		
		'name' => 'test2',
		
		'user' => 'root',
		
		'password' => ''
		
	];
}