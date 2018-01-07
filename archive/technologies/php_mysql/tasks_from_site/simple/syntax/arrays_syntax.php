<pre>
<style>
	div {
		float:left;
		margin:5px;
		padding:5px;
		border: 1px solid black;
	}
</style>
<?php
echo '<div>';
$arr = [5,6,7,43,34,5345,34,345];/*Есть ли в массиве?*/print_r(in_array(43,$arr));
$arr = ['a', 'b', 'c', 'd'];/*Сколько элементов массива?*/echo count($arr) . '<br>';
$arr = [1, 2, 3, 4, 5];/*Сумма всех элементов массива*/echo array_sum($arr) . '<br>';
$arr = [1, 2, 3, 4, 5];/*Произведение всех элементов*/echo array_product($arr) . '<br>';
$arr = range(1, 5);/*Создает массив от и до, +шаг*/print_r($arr);
$arr = range('z', 'f',2);/*Создает массив от и до, +шаг*/print_r($arr);
$arr = range(0, 10, 2);/*Создает массив от и до, +шаг*/print_r($arr);

$arr1 = [1, 2, 3];
$arr2 = ['a', 'b', 'c'];
$res = array_merge($arr1, $arr2);//сливает два и более массивов вместе. 
print_r($res);
$arr = ['a'=>1, 'b'=>2, 'c'=>3, 'd'=>4, 'e'=>5];
echo '!!!!!!!!!' . '<br>';
print_r(array_slice($arr, 0, 3, false));//отрезает и возвращает часть массива.
echo '!!!!!!!!!' . '<br>';
print_r(array_splice($arr, -2, 2));//Удаляет и возвращает удаленную часть массива.
echo '</div>';
echo '<div>';
print_r($arr);//Оставшаяся часть массива.
array_splice($arr, 1, 0, [1, 2, 3]);//Можно просто вставить массив
print_r($arr);                       //с определенного элемента в массив.
print_r(array_keys($arr));//Получает ключи массива и записывает их в новый массив.
print_r(array_values($arr));//Получает значения массива и записывает их в новый массив.
$keys = ['green' ,'blue' ,'red'];
$elems = ['зеленый', 'голубой', 'красный'];
$arr = array_combine($keys, $elems);//Осуществляет слияние двух массивов в один ассоциативный. 
print_r($arr);
print_r(array_flip($arr));//Меняет местами ключи и элементы массива.
print_r(array_reverse($arr,true)); //Делает массив в обратном порядке.
var_dump (array_search('голубой', $arr)) . '<br>'; //Ищет в элементах массива совпадение, если есть показывает индекс элемента.
echo '</div>';
echo '<div>';
print_r(array_replace($arr, [0=>'!', 2=>'!!']));//Меняет значения массива по ключам.Или добавляет.
$arr = ['a', 'a', 'a', 'b', 'b', 'c'];
print_r(array_count_values($arr));//Считает сколько одинаковых значений в массиве.
print_r(array_rand($arr,3));//Возвращает случайный ключ(и) из массива.
$arr = ['a'=>1, 'b'=>2, 'c'=>3, 'h'=>3, 'd'=>4, 'g'=>4, 'e'=>5, 'x'=>5];
shuffle($arr);//перемешивает массив.
print_r($arr);
print_r(array_unique($arr));//Удаляет повторения элементов массива и возвращает новый.
print_r(array_shift($arr));//Вырезает и возвращает первый элемент массива.
print_r(array_pop($arr));//Вырезает и возвращает последний элемент массива.
print_r($arr);
$num = array_unshift($arr, 'a', 'b'); //Добавляет элементы в начало массива, возвращает новое количество элементов.
echo '</div>';
echo '<div>';
print_r($arr);
echo $num . '<br>';
$num = array_push($arr, 'ж', 'Щ');//Добавляет элементы в конец массива, возвращает новое количество элементов.
print_r($arr);
echo $num . '<br>';
$arr = [1, 2, 3];
$arr = array_pad($arr, 5, 0);//дополняет массив определенным значением до заданного размера с конца.
print_r($arr);
$arr = array_pad($arr, -10, 1);//дополняет массив определенным значением до заданного размера с начала.
print_r($arr);
$arr = array_fill(0, 5, 'x');//Создает массив, заполненный элементами с опред. знач.
print_r($arr);
$arr = array_fill(0, 5, array_fill(0,3,'x'));//Создает массив, заполненный элементами с опред. знач.
echo '</div>';
echo '<div>';
print_r($arr);
//Создает массив, заполненный элементами, но с определенными ключами, которые передаются 
print_r(array_fill_keys(['a', 'b', 'c', 'd', 'e'], 'x'));
//в виде массива первым параметром.
$arr = ['a', 'b', 'c', 'd', 'e'];
echo '</div>';
echo '<div>';
print_r(array_chunk($arr, 2));//Разбивает массив на двумерный по кол-ву элементов в одном подмассиве.
$arr = ['a', 'a', 'a', 'b', 'b', 'c'];
print_r(array_count_values($arr));//Считает сколько раз элемент встречается в массиве
//Возвращает ассоциативный массив в котором ключи это элементы, а значение - количество повторений.
$arr = [1, 4, 9];
$result = array_map('sqrt', $arr);//Применяет ко всем элементам массива функцию и возвращает измененный массив.
print_r($result);
$result = [];
$arr4 = [4, 2, 3, 5, 1];
$arr2 = [3, 4, 5, 1, 7];
$arr3 = [3, 4, 1, 2, 9];
$arr1 = [1, 10, 4, 7, 6];
$result = array_intersect($arr1, $arr2, $arr3, $arr4);//Возвращает массив значений встречающихся во всех массивах.
print_r($result);
$result = array_diff($arr1, $arr2, $arr3, $arr4);//Возвращает массив уникальных для всех массивов значений.
print_r($result);








echo '</div>';
?>
</pre>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/books/php/base/rabota-s-funkciyami-dlya-massivov-v-php.html" target="_blank">Страница учебника</a></div>