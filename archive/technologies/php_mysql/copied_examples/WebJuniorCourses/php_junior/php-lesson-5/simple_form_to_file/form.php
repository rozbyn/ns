<?php
	$name='';
	$phone='';
	if(count($_POST) > 0){
		$dt = date("Y-m-d H:i:s");
		$name = trim($_POST['name']);
		$phone = trim($_POST['phone']);
		
		if($name == '' || $phone == ''){
			$msg = 'Эй, данные введи!';
		}
		elseif (strlen($name)<3){
			$msg ='Имя не короче 2 символов';
		}
		elseif (!ctype_digit($phone) || strlen($phone)<8){
			$msg ='телефон только из цифр, не короче 7 символов';
		}
		else{
			$str = "$dt $name $phone".PHP_EOL;
			file_put_contents('saved_from_form.txt', $str, FILE_APPEND);
			
			mail('info@ntschool', "Эй, админ, звони!", "$dt<br>$name<br>$phone");

			$msg = 'Всё ок, скоро позвоним!';
		}
	}
	else{
		$msg = 'Введите данные и нажмите кнопку';
	}
	
	// а на форме сохранить данные в случае ошибки!
?>

<form method="post">
	Имя<br>
	<input type="text" name="name" value="<?php echo $name?>"><br>
	Телефон<br>
	<input type="text" name="phone" value="<?php echo $phone?>"><br>
	<input type="submit" value="Заказать звонок">
</form>
<?php echo $msg; ?>