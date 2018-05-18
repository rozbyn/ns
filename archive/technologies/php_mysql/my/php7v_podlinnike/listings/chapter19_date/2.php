<?php
echo '<pre>';
$locale = setlocale(LC_ALL, 'RU', 'Russian_Russia.1251');
var_dump($locale);
date_default_timezone_set('Europe/Moscow');

$JDC = GregorianToJD(5, 12, -300); //Преобразует дату в формат JDC
echo $JDC . '<br>';

$date = JDToGregorian($JDC); //Преобразует дату из формата JDC в формат month/day/year
echo $date . '<br>';

echo JDDayOfWeek($JDC, 0), '<br>'; //Возвращает день недели JDC формата (0 - число, № дня)
echo JDDayOfWeek($JDC, 1), '<br>'; //(1 - англ. название дня недели)
echo JDDayOfWeek($JDC, 2), '<br>'; //(2 - сокращенное англ. название дня недели)

var_dump(checkDate(12, 31, 2004)); //Проверяет существует ли дата
var_dump(checkDate(12, 32, 2004)); //Проверяет существует ли дата
var_dump(checkDate(13, 31, 2004)); //Проверяет существует ли дата
var_dump(checkDate(12, 31, 1)); //Проверяет существует ли дата
var_dump(checkDate(12, 31, 0)); //Проверяет существует ли дата
var_dump(checkDate(12, 31, 30000)); //Проверяет существует ли дата

