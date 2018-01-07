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
echo '<div>' . '<br>';
/*--------------------------------------------------*/

$arr = [4,5,32,1,7,9,5,4];
echo array_sum($arr)/count($arr) . '<br>';
echo array_sum(range(1,100)) . '<br>';
$arr = range(1,100);
$str = implode('<br>',$arr);
echo implode('<br>',$arr) . '<br>';
echo '</div>';
echo '<div>';
print_r(array_fill(0, 10, 'x'));
$arr = range(1,10);
shuffle($arr);
print_r($arr);
$per = 10;
echo array_product(range(1,$per)) . '<br>';
$per = 'kjefhiwer';
print_r(array_sum(str_split($per)));
echo '<br>';
$per[strlen($per)-1] = strtoupper($per[strlen($per)-1]);
echo $per . '<br>';
$per = strrev($per);
$per = ucfirst($per);
$per = strrev($per);
echo $per . '<br>';
$per = '1234567890';
$arr = str_split($per,2);
echo array_sum($arr) . '<br>';
echo '</div>' . '<br>';
?>
</pre>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/base/praktika-na-kombinacii-standartnyh-funkcij-php.html" target="_blank">Страница учебника</a></div>