
<?php
header('Content-Type: text/html; charset=Windows-1251');
//setlocale(LC_ALL, 'en-US');

$dbTestConnection = new mysqli('1321.17584.7898.846864', 'root', '', 'test');
/*

if (mysqli_connect_errno()){
	printf("Не удалось подключиться: %s\n", mysqli_connect_error());
} else {
	echo 'Подключение с базой данных успешно установлено.';
}
*/
$link = @mysqli_connect('localhost', 'dsa', '', 'test');


if (!$link) {
    die('Connect Erddddror: ' . mysqli_connect_error());
} else {
	echo 'Подключение с базой данных успешно установлено.';
}

?>
