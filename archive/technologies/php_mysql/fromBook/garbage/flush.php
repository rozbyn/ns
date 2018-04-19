<?php 
	$x = <<<xyi
dadqwoiemfd230ij019 098213987g*&YT&EG@#80QYGb187rg102378t26g"""DA:LDA"S"DASK'''';aksd;aljpja8j39rg27
adkqw9j2080322k
sdfrwefw09jh89908h4398h-(*HR(#R(_!H#_(*\$H@!#\$_(*!#(*_!#$&Y#)*&^!)($&!)(&%876)_+|_)|+#@!)|#+!(#)@|+)!~!(~)J~()			_+I)+(I@!)(U#!@_#U_
d'wad=-;=do01k2-93`~~~``193982u8u?DASD¦v”¥j
xyi;


echo __FILE__ . '<br>';
echo __LINE__ . '<br>';
echo PHP_OS . '<br>';
echo PHP_VERSION . '<br>';
for($i=0;$i<10;$i++){
	echo "Строка номер $i" . '<br>';
	flush();
	ob_flush();
	sleep(1);
}
$x = false;
echo gettype($x) . '<br>';
echo (bool) $x . '<br>';
var_dump((object) $x);
echo gettype($x) . '<br>';

$u = ['first'=>1,'second'=>2,3,4];
echo gettype($u) . '<br>';
var_dump((object) $u);
echo gettype($u) . '<br>';
$d = "\40\x20";// \10 восмиричный номер символа. \x20 -  шестнадцатиричный
$g = [1,2,3,4,5,6,7,8,9];
list ($var1, $var2, $var3, $var4) = $g;

var_dump($var1, $var2, $var3);
echo'<br>';
echo'<br>';

$u = ['first'=>1,'second'=>2,3,4];
for(end($u); $key=key($u); prev($u)){
	echo $key. ' =&gt; ' . $u[$key] . '<br>';
}
?>
