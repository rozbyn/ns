<?php
date_default_timezone_set('Europe/Moscow');
header('Content-Type: text/html; charset=utf-8');
//Подключение к БД++++++++++++++++++++
if($_SERVER['DOCUMENT_ROOT'] === '/home/u784337761/public_html'){
	$myDbObj = new mysqli('localhost', 'u784337761_root', 'nSCtm9jplqVA', 'u784337761_test');
} elseif($_SERVER['DOCUMENT_ROOT'] === '/storage/ssd3/266/4204266/public_html'){
	$myDbObj = new mysqli('localhost', 'id4204266_root', 'asdaw_q32d213e', 'id4204266_test');
} else {
	$myDbObj = new mysqli('localhost', 'root', '', 'test2');
}
$myDbObj->set_charset("utf8");
//++++++++++++++++++++++++++++++++++++
$query = 'SELECT * FROM customers JOIN orders ON (customers.id = orders.userid)';
/*
SELECT * FROM customers JOIN adresses ON (customers.id = adresses.userid) WHERE customers.id = 1;
SELECT * FROM customers JOIN orders ON (customers.id = orders.userid) WHERE customers.id = 1;
SELECT поля FROM левая_таблица 
LEFT JOIN правая_таблица 
ON левая_таблица.поле_связи = правая_таблица.поле_связи;

SELECT CONCAT ('Пользователь: ', firstname, ' ', secondname, ' , телефон: ', telephone) FROM Customers;

SELECT CONCAT_WS(',', *) FROM Customers;


*/
$k = $myDbObj->query($query);
for ($res = []; $row = $k->fetch_assoc(); $res[] = $row);
echo '<pre>';
print_r($res);
echo '</pre>';
$str = '10.10.1200';
$tr = preg_match('/\d{2}\.\d{2}\.(12|\d{4})$/',$str);
var_dump($tr);




?>