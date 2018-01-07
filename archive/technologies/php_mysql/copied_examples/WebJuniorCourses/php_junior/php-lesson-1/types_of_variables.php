<?php
	
	/* типы данных */
	$a = 5; 
	$b = 5.5; 
	$c = true; 
	$name = 'Dmitry'; 
	$town = 'Moscow'; 

	$info = $name . ' ' . $town;
	$info1 = "$name $town";
	
	/* echo 2 + 2 * 2; */
	echo $name . ($a + $b);
	
	$a = 7;
	
	echo "<br>Hello, $name!";
	echo '<br>';
	echo 'Goodbye, $name!';
	
	echo $a;
	echo "<br>$info<br>";
	
	define('PI', 3.14);//константа
	/* define('PI', 3.1428); */

	echo PI;
	$r = function ($dd){echo $dd . '<br>';};
	echo '<br>';
	echo '<br>';
	echo gettype($a) . '<br>';
	echo gettype($b) . '<br>';
	echo gettype($c) . '<br>';
	echo gettype($name) . '<br>';
	echo gettype($town) . '<br>';
	echo gettype($info) . '<br>';
	echo gettype($info1) . '<br>';
	echo gettype(PI) . '<br>';
	echo gettype($r) . '<br>';
	$r('hello');
	$s=$r;
	echo gettype($s) . '<br>';
	$s('foofofo');
?>