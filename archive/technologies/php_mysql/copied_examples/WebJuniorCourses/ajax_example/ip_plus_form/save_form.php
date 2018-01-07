<?php 
	$email = trim($_POST['email']);
	$phone = trim($_POST['phone']);
	$name = trim($_POST['name']);
	$dt = date('Y-m-d H:i:s');
	
	if($email == '' || $phone == '' || $name == ''){
		echo 'Заполните все поля!';
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		echo 'Введите корректный адрес почты!';
	} else {
		file_put_contents ('form_data.txt', "$dt $email $phone $name" . PHP_EOL, FILE_APPEND);
		echo '1';
	}