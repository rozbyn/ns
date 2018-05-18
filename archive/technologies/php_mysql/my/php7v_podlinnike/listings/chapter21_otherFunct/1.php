<?php
$id = uniqid('Fuuu');
echo $id . '<br>';
function a ($as = 0) {
	echo $as . '<br>';
}
a();



$d = @create_function('$a = 123, $b = 4321', 'return $a/3*$b;');

echo $d . '<br>';
echo $d(9, 5) . '<br>';


usleep(1000000);