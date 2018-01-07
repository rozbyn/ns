<?php


$arr=[2,5,9,15,0,4,-10,-5,-7,-6,-15,100];
$summ = 0;
foreach($arr as $num){
	$summ++;
	if ($num==4){echo 'ЕСТЬ!';break;}
	
}
echo $summ . '<br>';
$srfe = ['10', '20', '30', '50', '235', '3000'];
foreach ($srfe as $el){
	if ($el[0]==1 || $el[0]==2 || $el[0]==5){echo $el .'<br>';}
}

$are = [1,2,3,4,5,6,7,8,9];
foreach ($are as $nuum){
	echo "-$nuum";
}
echo '-<br>';


$arye =[];
for ($i=1; $i<=100; ++$i){
	$arye[]=$i; 
}
echo '<pre>';
print_r($arye);
echo '</pre>';

$num = 1000;
$m = 0;
while ($num >= 50){
	$num /= 2;
	$m++;
	echo $m . '<br>';
}
for ($num = 1000; $num >=50; $num /= 2){
	echo $num . '<br>';
}
echo abs(-145654) .'<br>';
echo sqrt(81) .'<br>';
echo pow (4,4) .'<br>';
echo round (4.6) .'<br>';
echo round (4.5) .'<br>';
echo round (4.4) .'<br>';
echo round (4.46548974987, 2) .'<br>';
echo round (4.4867654646, 3) .'<br>';
echo ceil (4.00000000001) .'<br>';
echo floor (4.999999999999) .'<br>';
echo floor (4.999999999999) .'<br>';
echo min (1,2,3,4,5,6,7,8,9,10) .'<br>';
echo min ([11,2,3,4,5,6,7,8,9,10]) .'<br>';
echo max (1,2,3,4,5,6,7,8,9,10) .'<br>';
echo max ([11,2,3,4,5,6,7,8,9,10]) .'<br>';
echo mt_rand (-500,500) .'<br>';

?>


<?php if (true){
?>
<h1>HI!</h1>
<?php } ?>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/base/rabota-s-matematicheskimi-funkciyami-v-php.html" target="_blank">Страница учебника</a></div>