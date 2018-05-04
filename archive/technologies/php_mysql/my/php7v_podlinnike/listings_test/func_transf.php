<?php 
$g = function ($a) {echo 'FUNCTION A: '.$a . "<br>".PHP_EOL;};
function B ($a) {echo 'FUNCTION B: '.$a . "<br>".PHP_EOL;}
function C (...$a) {
	foreach($a as $v) {
		echo 'FUNCTION C: '.$v . "<br>".PHP_EOL;
	}
}
		
$f = 'C';
$f(654, 23,1,123,12,3,123,13,13);
var_dump($f);
echo '<br>';
var_dump($g);
echo '<br>';
$g(12312312);

call_user_func('B', 44, 'asda', '321');
call_user_func_array('C', [44, 'asda', '321']);