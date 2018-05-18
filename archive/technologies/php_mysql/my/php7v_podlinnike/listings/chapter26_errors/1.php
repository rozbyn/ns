<?php
error_reporting(E_ALL|E_STRICT);

set_error_handler('eror');
function eror (...$a) {
	if (error_reporting() == 0) return;
	echo '<div style="border: 2px solid; margin: 10px">';
	echo "Ошибочка!" . '<br>';
	echo "Код ошибочки: " . $a[0]. '<br>';
	echo "Файл: " . $a[2]. '<br>';
	echo "Строка: " . $a[3]. '<br>';
	echo "Текст ошибочки: " . $a[1]. '<br>';
	echo '</div>';
	return true;
}

file_get_contents('asdad');// ++
//if // --
$as = '';
//$as[] = 0;// --
substr(); // ++

function print_age ($n) {
	$n = intval($n);
	if ($n < 0) trigger_error('Функция print_age(): возраст не может быть отрицательным!'); // ++
	echo 'Возраст составляет: '. $n . '<br>';
}
print_age(-10);
error_log('Пошёл нахой!', 0);
error_log('Пошёл нахой!', 0);

function inner ($a) {
	echo '<pre>'; print_r(debug_backtrace()); echo'<pre>';
}

function outer ($x) {
	inner($x * $x);
}

outer(3);