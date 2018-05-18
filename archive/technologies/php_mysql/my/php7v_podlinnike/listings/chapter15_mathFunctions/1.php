<?php 
$b = sqrt ( -1);
var_dump($b);
var_dump(is_nan($b));
$inf = pow(0, -1);
var_dump($inf);
var_dump(-$inf);
var_dump(is_infinite(pow(0, -1)));
mt_srand(-10);
var_dump(mt_rand());
echo random_int(PHP_INT_MIN, PHP_INT_MAX);