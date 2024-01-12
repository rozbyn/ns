<?php
function sum($str){
	return array_sum(explode(' ', $str));
}
$input = file_get_contents('input.txt');
$output = sum($input);
file_put_contents('output.txt', $output . '\r\n');