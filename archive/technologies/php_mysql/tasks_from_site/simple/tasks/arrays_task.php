<pre>
<style>
	* {margin:0;padding:0}
	div {
		float:left;
		margin:5px;
		padding:5px;
		border: 1px solid black;
	}
</style>
<?php
echo '<div>';
$arr = range(1, 100);
echo array_sum(range(1, 100)) . '<br>';;
$arr = ['a', 'b', 'c', 'd', 'e'];
$arr = array_map('strtoupper', $arr);
print_r($arr);
echo count($arr) . '<br>';
echo $arr[count($arr) - 1] . '<br>';
$arr = array_fill(0, 5, 100);
function rand1(){return mt_rand(1,100);}
$arr = array_map('rand1', $arr);
if (in_array(3, $arr)){echo 'Есть' . '<br>';} else {echo 'Нет' . '<br>';}
echo array_sum($arr) . '<br>';
echo array_product($arr) . '<br>';
echo (array_sum($arr)/(count($arr)-1)) . '<br>';
echo implode('-', range(1,9)) . '<br>';
echo array_sum(range(1,100)) . '<br>';
echo array_product(range(1,10)) . '<br>';
$arr1 = [1,2,3];
$arr2 = ['a', 'b', 'c'];
$arr = array_merge($arr2,$arr1);
print_r($arr);
$arrt = array_slice($arr, 1, 4);
print_r($arrt);
$arr = [1, 2, 3, 4, 5];
$rez = array_splice($arr, 1, 2);
print_r($arr);
$arr = [1, 2, 3, 4, 5];
$rez = array_splice($arr, 1, 3);
print_r($rez);
$arr = [1, 2, 3, 4, 5];
array_splice($arr,3,0,['a', 'b', 'c']);
print_r($arr);
echo '</div>';
echo '<div>';
$arr = [1, 2, 3, 4, 5];
array_splice($arr, 1, 0, ['a', 'b']);
array_splice($arr, 6, 0, ['c']);
array_splice($arr, 8, 0, ['e']);
print_r($arr);
$arr = ['a'=>1, 'b'=>2, 'c'=>3];
$keys = array_keys($arr);
$values = array_values($arr);
print_r($keys);
print_r($values);
$arr = array_combine($keys, $values);
print_r($arr);
$arr = ['a', '-', 'b', '-', 'c', '-', 'd'];
echo array_search('-',$arr) . '<br>';
array_splice($arr,array_search('-',$arr),1);
print_r($arr);
$arr = array_replace($arr,[0=>'!!', 3=>'!!!']);
print_r($arr);
echo '</div>';
echo '<div>';
echo 'Сортировка' . '<br>';;
$arr =['3'=>'a', '1'=>'c', '2'=>'e', '4'=>'b'];
sort($arr);
print_r($arr);
$arr =['3'=>'a', '1'=>'c', '2'=>'e', '4'=>'b'];
rsort($arr);
print_r($arr);
$arr =['3'=>'a', '1'=>'c', '2'=>'e', '4'=>'b'];
asort($arr);
print_r($arr);
$arr =['3'=>'a', '1'=>'c', '2'=>'e', '4'=>'b'];
arsort($arr);
print_r($arr);
$arr =['3'=>'a', '1'=>'c', '2'=>'e', '4'=>'b'];
ksort($arr);
print_r($arr);
$arr =['3'=>'a', '1'=>'c', '2'=>'e', '4'=>'b'];
krsort($arr);
print_r($arr);
echo '</div>';
echo '<div>';
$arr = ['a'=>1, 'b'=>2, 'c'=>3];
$key = array_rand($arr);
echo $key . '<br>';
echo $arr[$key] . '<br>';
$arr = [1, 2, 3, 4, 5];
shuffle($arr);
print_r($arr);
$arr = range(1, 10);
shuffle($arr);
print_r($arr);
$arr = range('a', 'z');
shuffle($arr);
print_r($arr);
$str = implode('', $arr);
echo substr($str, 0, 6) . '<br>';
$arr = ['a', 'b', 'c', 'b', 'a'];
print_r(array_unique($arr));
echo '</div>';
echo '<div>';
$arr = [1, 2, 3, 4, 5];
echo array_shift($arr) . '<br>';
echo array_pop($arr) . '<br>';
print_r($arr);
$arr = [1, 2, 3, 4, 5];
array_unshift($arr, 0);
array_push($arr, 6);
print_r($arr);
echo  '<br>';
$arr = range(1,100);
$k = 0;

$time_start1 = microtime(true);//Время начала скипта в сек.мсек
 for ($i=0;$i<100;$i++){
	array_shift($arr);
	array_pop($arr);
	$k++;
}
$time_end1 = microtime(true);
$time = ($time_end1 - $time_start1);//Время выполнения скрипта
echo '<br>';
echo $time . '<br>';
echo '<br>';
$arr = ['a', 'b', 'c'];
$arr = array_pad($arr, 6, '-');
print_r($arr);
$arr = array_fill(0, 10, 'x');
print_r($arr);
echo '</div>';
echo '<div>';
$arr = range(1,20);
$arr = array_chunk($arr,4);
print_r($arr);
$arr = ['a', 'b', 'c', 'b', 'a'];
print_r(array_count_values($arr));
$arr = [1, 2, 3, 4, 5];
$arr = array_map('pow2',$arr);
print_r($arr);
echo '</div>';
echo '<div>';
function pow2($a){
	return pow($a,2);
}
$arr = ['<b>php</b>', '<i>html</i>'];
$arr1 = array_map('strip_tags', $arr);
print_r($arr1);
$arr = [' a ', ' b ', ' c '];
$arr1 = array_map('trim', $arr);
print_r($arr1);
$arr = [1, 2, 3, 4, 5];
$arr1 = [3, 4, 5, 6, 7];
$rez = array_intersect($arr, $arr1);
print_r($rez);
$rez = array_diff($arr, $arr1);
array_push($rez, array_diff($arr1, $arr));
print_r($rez);
$str = '1234567890';
$arr = str_split($str);
$str = array_sum($arr);
echo $str . '<br>';
$arr1 = range(1,26);
$arr2 = range('a','z');
$arr = array_combine($arr2, $arr1);
print_r($arr);
echo '</div>';
echo '<div>';
print_r(array_chunk(range(1,9),3));
$arr = [1, 2, 3, 4, 5, 5];
array_unique($arr);
rsort($arr);
echo $arr[1] . '<br>';













echo '</div>';
?>
</pre>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/base/rabota-s-funkciyami-dlya-massivov-v-php.html" target="_blank">Страница учебника</a></div>