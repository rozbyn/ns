<?php
setlocale(LC_ALL, 'ru_RU', 'RU', 'rus');
date_default_timezone_set('Europe/Moscow');


$date = new DateTime();
echo $date->format('H:i:s d-m-Y') . '<br>';

echo  '<br>';
$date = new DateTime('2000-01-01 0:0:0');
$nowDate = new DateTime();
$interval = $nowDate->diff($date);

echo 'Date №1: '.$date->format('H:i:s d-m-Y') . '<br>';
echo 'Date №2: '.$nowDate->format('H:i:s d-m-Y') . '<br>';
echo  '<br>';
echo  $interval->format('Difference : %h hours, %i minutes, %s seconds, %d days, %m months, %y years<br>');
echo 'Days TOTAL: '. $interval->days . '<br>';
$IntervalFormat = 'P4Y10M21DT23H51M49S';
$myInterval = new DateInterval($IntervalFormat);
echo $IntervalFormat . '<br>';
echo  $myInterval->format('%h hours, %i minutes, %s seconds, %d days, %m months, %y years<br>');

$step = new DateInterval('P2M');
$period = new DatePeriod($nowDate, $step, 5);

foreach ($period as $datetime) {
	echo $datetime->format('Y-m-d') . '<br>';
}
