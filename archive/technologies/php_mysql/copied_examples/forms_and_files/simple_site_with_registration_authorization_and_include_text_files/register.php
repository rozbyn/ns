<style>
	* {margin:0;padding:0}
	div {
		float:left;
		margin:5px;
		padding:5px;
		border: 1px solid black;
	}
</style>
<?php
$user = '';
$pass = '';
$pass2 = '';
$message = '';
$empt = '';
$formVisibility = 1;
function repl ($a){
	return str_replace([1, 2, 3], ['логин', 'пароль', 'подтверждение пароля'], $a);
}
if (empty($_POST)) {
	$message = 'Заполните форму регистрации.';
} else {
	$user = trim(strip_tags($_POST['user']));
	$pass = trim(strip_tags($_POST['pass']));
	$pass2 = trim(strip_tags($_POST['pass2']));
	if (empty($user)){$empt .= '1';}
	if (empty($pass)){$empt .= '2';}
	if (empty($pass2)){$empt .= '3';}
	switch (strlen($empt)){
		case 3:
			$message = 'Введите ваш логин, пароль и подтверждение пароля.';
			break;
		case 2:
			$message = 'Введите '. repl($empt[0]) . ' и ' . repl($empt[1]) . '.';
			break;
		case 1:
			$message = 'Введите ' . repl($empt[0]) . '.';
			break;
		case 0:
			if (strlen($user)<3 || strlen($user)>12){
				$message = 'Логин должен быть больше 3 символов и меньше 12.';
			} elseif (strlen($pass)<5 || strlen($pass)>9) {
				$message = 'Пароль должен быть больше 5 символов и меньше 9.';
			} elseif ($pass != $pass2){
				$message = 'Пароль и подтверждение пароля должны совпадать';
			} else {
				$message = 'Вы успешно зарегистрированы.';
				$str = "$user:$pass".PHP_EOL;
				file_put_contents('files/loginsAndPassworsd.txt', $str, FILE_APPEND);
			}
			
			
			
	}
}
if ($formVisibility == 1){

?>
<a  href="index.php">На главную</a><br>
<a href="enter.php">Вход</a><br>
<?= $message ?>
<form name="form" action="" method="POST">
	<input type="text" name="user" placeholder="Введите имя" value="<?php echo $user; ?>"><br>
	<input type="password" name="pass" placeholder="Введите пароль" value = "<?php echo $pass; ?>"><br>
	<input type="password" name="pass2" placeholder="Введите пароль" value = "<?php echo $pass2; ?>"><br>
	<input type="submit">
</form>
<?php
} else {
	
 }
echo '<pre>' . '<br>';
echo '<div>' . '<br>';
echo '<br>';
print_r($_POST);
echo '<br>';
print_r($_GET);

?>
</div>
</pre>