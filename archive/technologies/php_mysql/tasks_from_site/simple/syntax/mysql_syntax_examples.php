<style>
	* {margin:0;padding:0}
	div {
		float: left;
		margin: 5px;
		padding: 5px;
		border: 1px solid black;
	}
</style>
<?php
function arrt($arr){
	foreach($arr as $key => $val){
		if (is_array($val)){
			arrt($val);
		} else {
			echo $key . ':' . $val . '<br>';
		}
	}
	}
/*--------------------------------------------------*/

header('Content-Type: text/html; charset=utf-8');

echo '<div>';////////////



$dbConfigFilePath = $_SERVER['DOCUMENT_ROOT'] . '/config/dbConfig.php';
if(!is_file($dbConfigFilePath)){
	exit('no db config');
}
$dbConfig = require_once $dbConfigFilePath;


$dbTestConnection = new mysqli($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
$dbTestConnection -> set_charset("utf8");
if (mysqli_connect_errno()){
	printf("Не удалось подключиться: %s\n", mysqli_connect_error());
	exit();
} else {
	echo 'Соединение с базой успешно установлено' . '<br>';
}
/*

$query = 'CREATE TABLE pages(
	id int(11) NOT NULL AUTO_INCREMENT,
	athor varchar(25) NOT NULL,
	article varchar(255) NOT NULL,
	PRIMARY KEY (id)
)';






$query = 'INSERT INTO workers (name, age, salary) VALUES
						("Дима", 23, 400),
						("Петя", 25, 500), 
						("Вася", 23, 500), 
						("Коля", 30, 1000), 
						("Иван", 27, 500), 
						("Кирилл", 28, 1000)';
$query = 'INSERT INTO pages (athor, article) VALUES
						("Петров", "В своей статье рассказывает о машинах."),
						("Иванов", "Написал статью об инфляции."), 
						("Сидоров", "Придумал новый химический элемент."), 
						("Осокина", "Также писала о машинах."), 
						("Ветров", "Написал статью о том, как разрабатывать элементы дизайна.")';




$query = "SELECT * FROM workers WHERE id > 0";
$query = "SELECT * FROM workers WHERE id != 2";
$query = "SELECT * FROM workers WHERE name='Дима'";
$query = "SELECT * FROM workers WHERE salary=500 AND age=23";
$query = "SELECT * FROM workers WHERE age>=23 AND age<=27";
$query = "SELECT * FROM workers WHERE (age>20 AND age<27) OR (salary>300)";
$query = "SELECT name, age FROM workers WHERE id>0";
$query = "INSERT INTO workers SET name='Гена', age=30, salary=1000";
$query = 'INSERT INTO workers (name, age, salary) VALUES ("Григорий", 30, 1000)';
$query = 'INSERT INTO workers (name, age, salary) 
			VALUES ("Гена", 30, 1000), ("Вася", 25, 500), ("Иван", 27, 1500)' 
$query = "DELETE FROM workers WHERE id=6";
$query = "UPDATE workers SET salary=1000 WHERE name='Дима'";
$query = "UPDATE workers SET salary=1000, age=20 WHERE name='Дима'";



!!!!!!!!ORDER BY, LIMIT, COUNT, LIKE!!!!!
$query = "SELECT * FROM workers WHERE id>0 ORDER BY age";
$query = "SELECT * FROM workers WHERE id>0 ORDER BY age DESC";
$query = "SELECT * FROM workers WHERE id>0 LIMIT 2";
$query = "SELECT * FROM workers WHERE id>0 LIMIT 2,5";
$query = "SELECT * FROM workers WHERE id>0 ORDER BY id DESC LIMIT 2,5";
$query = "SELECT COUNT(*) as count FROM workers WHERE id>0"; 
$query = "SELECT * FROM workers WHERE name LIKE '%я'";
$query = 'SELECT * FROM workers WHERE name LIKE "___я"';
$query = "SELECT * FROM `from`";

*/



$query = 'SELECT * FROM workers WHERE name LIKE "%я"';
$result = $dbTestConnection->query($query);
if (is_object($result)){
	for ($res = []; $row = $result->fetch_assoc(); $res[] = $row);
	echo '<pre>';
	print_r($res);
	echo '</pre>';
} elseif ($result === true){
	echo 'Запрос успешно выполнен' . '<br>';
} else {
	echo 'Запрос НЕ ВЫПОЛНЕН!!!' . '<br>';
	echo $dbTestConnection->error;
}

echo '</div>';///////////
echo '<div>';////////////














?>
