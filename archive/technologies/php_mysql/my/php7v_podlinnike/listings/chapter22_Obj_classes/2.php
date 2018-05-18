<?php
require_once "Math/Complex.php";
require_once "Math/Complex1.php";

$obj = new MathComplex;
$obj->re = 16.7;
$obj->im = 101;

$obj->add(18.09, 303);
echo "({$obj->re}, {$obj->im})" . '<br>';

$obj2 = new MathComplex1;
$obj2->re = 314;
$obj2->im = 101;

$obj3 = new MathComplex1;
$obj3->re = 303;
$obj3->im = 6;

$obj2->add($obj3);

echo $obj2->__toString() . '<br>';
echo $obj2 . '<br>';

