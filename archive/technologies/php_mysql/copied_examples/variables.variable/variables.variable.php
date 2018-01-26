<?php
class foo {
    var $bar = 'I am bar.';
    var $arr = array('I am A.', 'I am B.', 'I am C.');
    var $r   = 'I am r.';
}

$foo = new foo();
$bar = 'bar';
$baz = array('foo', 'bar', 'arr', 'quux');
echo $foo->$bar . "\n";
echo $foo->{$baz[2]}[2] . "\n";

$start = 'b';
$end   = 'ar';
echo $foo->{$start . $end} . "\n";

$arr = 'arr';
echo $foo->{$arr[2]} . "\n";
echo '<br>';


$Bar = "a";
$Foo = "Bar";
$World = "Foo";
$Hello = "World";
$a = "Hello";
echo $a . '<br>'; //Returns Hello
echo $$a . '<br>'; //Returns World
echo $$$a . '<br>'; //Returns Foo
echo $$$$a . '<br>'; //Returns Bar
echo $$$$$a . '<br>'; //Returns a


echo $$$$$$a . '<br>';
echo $$$$$$$a . '<br>';
echo $$$$$$$$a . '<br>';
echo $$$$$$$$$a . '<br>';
echo $$$$$$$$$$a . '<br>';
echo $$$$$$$$$$$a . '<br>';
echo $$$$$$$$$$$$a . '<br>';
echo $$$$$$$$$$$$$a . '<br>';
echo $$$$$$$$$$$$$$a . '<br>';
echo $$$$$$$$$$$$$$$a . '<br>';


?>