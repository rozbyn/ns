<style>
	* {margin:0;padding:0}
	div {
		float:left;
		margin:5px;
		padding:5px;
		border: 1px solid black;
	}
</style>
<div>
<?php
/*--------------------------------------------------*/
for ($i = 1; $i <= 9; $i++) {
	for ($j = 1; $j <= 3; $j++) {
		echo $i; //выводит '111', потом '222', потом '333' и так далее
	}
}
echo '<br>';
$str = '';
for ($i=0;$i<10;++$i){
	$str .= 'x';
}
echo $str . '<br>';
$str = '';
for ($i=0;$i<10;++$i){
	$str .= 'x';
	echo $str . '<br>';
}
for ($i = 1; $i <= 9; $i++) {
	for ($j = 1; $j <= 3; $j++) {
		echo $i; //выводит '111', потом '222', потом '333' и так далее
	}
	echo '<br>';
}
$str = '';
for ($i=1;$i<10;++$i){
	for ($j=0;$j<$i;++$j){
		echo $i;
	}
	echo '<br>';
}
$num = 2048;
while ($num>10){
	$num = $num /2;
}
echo $num . '<br>';
for ($num = 5628; $num > 10; $num = $num / 2);
echo $num . '<br>';
$str = '';
for ($i=1;$i<10;++$i){
	$str .= $i;
}
echo $str . '<br>';
$str = '';
for ($i=9;$i>0;--$i){
	$str .= $i;
}
echo $str . '<br>';
$str = '';
for ($i=1;$i<10;++$i){
	$str .= '-' . $i;
}
$str .= '-';
echo $str . '<br>';
$str = '';
$str2 = '';
for ($i=1;$i<21;++$i){
	$str .= 'x';
	$str2 .= $str . '<br>';
}
echo $str2;
for ($i=1;$i<=9;++$i){
	for ($j=1;$j<=$i;++$j){
		echo $i;
	}
	echo '<br>';
}
$str = '';
for ($i=0;$i<21;$i++){
	$str .= 'xx';
	echo $str . '<br>';
}
?>
</div>
</pre>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/books/php/base/rabota-s-ciklami-foreach-for-while-v-php.html" target="_blank">Страница учебника</a></div>