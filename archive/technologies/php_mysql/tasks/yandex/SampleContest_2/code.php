<?php
function sum($str){
	return array_sum(explode(' ', $str));
}
$input = file_get_contents('php://stdin');
$output = sum($input);
file_put_contents('php://stdout', $output);