<pre>
<style>
	div {
		float:left;
		margin:5px;
	}
</style>
<?php
echo '<div>' . '<br>';
echo strtoupper('minsk') . '<br>';
echo mb_strtoupper('минск') . '<br>';
echo ucfirst(strtolower('MINSK'));
$date = '31-12-2030';
$arr = explode('-', $date);
echo $arr[2] . '.' . $arr[1] . '.' . $arr[0] . '<br>';
$password = '312313132в';
if (strlen($password)>5 && strlen($password)<10){
	echo 'Пароль подходит.' . '<br>';
} else {
	echo 'Пароль не подходит!' . '<br>';
}
echo substr('html css php',0,4) . '<br>';
echo substr('html css php',5,3) . '<br>';
echo substr('html css php',9,3) . '<br>';
echo substr('kdsiofjeiuw',-3) . '<br>';
$str23 = '1234567890132456';
if (strlen($str23)>5){
	$str23 = substr($str23,5);
	echo $str23 . '...' . '<br>';
}else{
	echo $str23 . '<br>';
}
echo str_replace('-','.','31.12.2013') . '<br>';

echo str_replace('a', '!', 'abcabc') . '<br>';
$str4 = 'dsadaaawefqwqw';
echo str_replace(['a','d','w'],[1,2,3],$str4) . '<br>';
$str4 = '1a2b3c4b5d6e7f8g9h0';
echo str_replace([1,2,3,4,5,6,7,8,9,0],'',$str4) . '<br>';
$str4 = 'dsadaaawefqwqw';
echo strtr($str4,['a'=>0,'d'=>'O','fq'=>'69']) . '<br>';
echo strtr($str4,'adw',123) . '<br>';
$str = '1234567890';
echo substr_replace($str, '!!!', 3, 5) . '<br>';
$fgdg= 'abc abc abc';
echo strpos($fgdg,'b',0) . '<br>';
echo strrpos($fgdg,'b',0) . '<br>';
echo strpos($fgdg,'b',3) . '<br>';
$fgdg= 'aaa aaa aaa aaa aaa';
echo strpos($fgdg,' ',4) . '<br>';
$fgdg= 'aaa a..aa aaa aaa aaa';
if (strpos($fgdg,'..',0) !== false){echo 'Есть!' . '<br>';}
else{echo 'Нет!' . '<br>';}
$fgdg= 'ht0tp://aaa a..aa aaa aaa aaa';
if (strpos($fgdg,'http://',0) === 0){echo 'Есть!' . '<br>';}
else{echo 'Нет!' . '<br>';}
$fgdg= 'html css php';
$arraar = explode(' ',$fgdg);
print_r($arraar);
$astr = ['html','css','php'];
echo implode(', ',$astr) . '<br>';
$astr = '2013-12-31';
print_r(str_split('1234567890',2));
print_r(str_split('1234567890',1));
$fg = str_split('1234567890',2);
echo(implode('-',$fg)) . '<br>';
$str = 'слова слова слова';

echo rtrim($str, '.').'.' . '<br>';
$fdf = 'level';
if (strrev($fdf)==$fdf){echo 'ДА' . '<br>';}else{echo 'НЕТ' . '<br>';}
echo '</div>' . '<br>';
echo '<div>' . '<br>';
for ($i=1,$str='x';$i<10;$i++){
	echo str_repeat($str,$i)  . '<br>';
}
for ($i=1;$i<10;$i++){
	echo str_repeat($i,$i)  . '<br>';
}
echo strip_tags('html, <b>php</b>, js') . '<br>';
echo strip_tags('html, <b>php</b>, js','<b><i>') . '<br>';
echo htmlspecialchars('html, <b>php</b>, js') . '<br>';
echo ord('a') . '<br>';
echo ord('b') . '<br>';
echo ord('c') . '<br>';
echo ord(' ') . '<br>';
echo chr(33) . '<br>';
$str = chr(mt_rand(65,90));
echo $str . '<br>';
$str = '';
$len = 10;
for ($i = 0; $i<$len; $i++){
	$str .= chr(mt_rand(97,122));
}
echo $str . '<br>';
$str = 'rwar_HGest_theDSADxt';
$arr = explode('_',$str);
$result = '';
foreach($arr as $key=>$val){
	$val = strtolower($val);
	if ($key===0){
		$result .= $val;
	} else {
		$result .= ucfirst($val);
	}
}
echo $result . '<br>';
$arrra =[];
for ($i=0;$i<50;++$i){
	$arrra[] = mt_rand(100,1000);
}

foreach($arrra as $val){
	if (strpos($val,'3') !== false){
		echo $val . '<br>';
	} 
}


$top = 0;
foreach($arrra as $val){
	if (substr_count($val,'3') !=0){
		$top++;
	} 
}
echo $top . '<br>';
echo '</div>' . '<br>';
?>
</pre>

<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/base/rabota-so-strokovymi-funkciyami-v-php.html" target="_blank">Страница учебника</a></div>
