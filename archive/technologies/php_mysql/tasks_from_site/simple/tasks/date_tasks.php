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
echo time() . '<br>';
echo mktime(0,0,0,3,1,2025) . '<br>';
echo mktime(0,0,0,12,31) . '<br>';
echo time() - mktime(13,12,59,3,15,2000) . '<br>';
echo floor((time() - mktime(7,23,48))/3600) . '<br>';
echo date('Y.m.d. H:i:s') . '<br>';
echo date('d.m.Y', mktime(0,0,0,2,12,2025)) . '<br>';
$week = ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'];
echo $week[date('w')] . '<br>';
echo $week[date('w', mktime(0,0,0,06,06,2006))] . '<br>';
echo $week[date('w', mktime(0,0,0,06,19,1991))] . '<br>';
$month = [1=>'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
echo $month[date('n')] . '<br>';
echo date('n') . '<br>';
echo date('t') . '<br>';
echo '</div>';
echo '<div>';
$year = '';
$date = '';
$date1 = '';
$date2 = '';
$date3 = '';
$r1 = '';
$r2 = '';

if (!empty($_GET['year'])) {
	if (is_numeric($_GET['year']) && strlen($_GET['year']) == 4){
		$year = $_GET['year']; 
		if (date('L', mktime(0, 0, 0, 1, 1, $year)) == 1) {
			echo 'год високосный' . '<br>';
		} else {
			echo 'год не високосный' . '<br>';
		}
	}
}

if (!empty($_GET['date'])){
	$r = strtotime($_GET['date']);
	$date = $_GET['date'];
	echo $week[date('w',$r)] . '<br>';
	echo $month[date('n',$r)] . '<br>';
}
if (!empty($_GET['date1']) && !empty($_GET['date2'])){
	$r1 = $_GET['date1'];
	$r2 = $_GET['date2'];
	$r11 = strtotime($r1);
	$r22 = strtotime($r2);
	if ($r11>$r22){
		echo date('d.m.Y', $r11) . '<br>';;
	} else {
		echo date('d.m.Y', $r22) . '<br>';;
	}
}
if (!empty($_GET['date3'])){
	$r = strtotime($_GET['date3']);
	$date3 = $_GET['date3'];
	echo date('H:i:s d.m.Y', $r) . '<br>';
}

echo '<form action="" method="GET"><input type="text" name="year" value="'. $year .'"><input type="submit">' . '<br>';
echo '<input type="text" name="date" value="'. $date .'"><input type="submit">' . '<br>';
echo '<input type="text" name="date1" value="'. $r1 .'"><input type="submit">' . '<br>';
echo '<input type="text" name="date2" value="'. $r2 .'"><input type="submit">' . '<br>';
echo '<input type="text" name="date3" value="'. $date3 .'"><input type="submit"></form>' . '<br>';
$date = '2025-12-31';
$p = date_create($date);
date_modify($p, '2 days');
echo date_format($p, 'd.m.Y') . '<br>';
date_modify($p, '1 month  3 days');
echo date_format($p, 'd.m.Y') . '<br>';
date_modify($p, '1 year');
echo date_format($p, 'd.m.Y') . '<br>';
date_modify($p, '-3 days');
echo date_format($p, 'd.m.Y') . '<br>';

echo floor(((mktime(23,59,59,12,31)+1) - time())/86400) . '<br>';

$year1 = '';

if (!empty($_GET['year1'])){
	$year1 = $_GET['year1'];
	$pt13 = [];
	for ($i=1; $i<=12; ++$i){
		if (date('w', mktime(0,0,0,$i,13,$year1)) == 5){
			$pt13[] = date('d.m.Y', mktime(0,0,0,$i,13,$year1));
		}
	}
	
}
echo '<form action="" method="GET"><input type="text" name="year1" value="'. $year1 .'"><input type="submit"></form>';
print_r($pt13);
echo '<br>';
echo date('d.m.Y', time() - 8640000) . '<br>';





?>
</div>





<script>
var t = [1,4,5,6,[99,999,9999],42,4243,5343];
function arrToList (arr){
	var list = new Object();
	var p = arr.shift();
	if (Array.isArray(p)){
		list.value = arrToList(p);
	} else {
		list.value = p;
	}
	if (arr.length !== 0){
		list.next = arrToList(arr);
		
	} else {
		list.next = null;
	}
	return list;

}
var list = arrToList(t);
console.log(list);

</script>






<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/base/rabota-s-datami-v-php.html" target="_blank">Страница учебника</a></div>