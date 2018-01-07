<?php
date_default_timezone_set('Europe/Moscow');
include('mysql_function.php');
header('Content-Type: text/html; charset=utf-8');
$myDbObj = connect_DB('test2', 'root', '', 'localhost');
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