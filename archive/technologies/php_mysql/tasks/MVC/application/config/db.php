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
} else {
	return [
		'host' => 'localhost',
		
		'name' => 'test2',
		
		'user' => 'root',
		
		'password' => ''
		
	];
}