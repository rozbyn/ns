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
$message = '';
$formVisibility = 1;
$content = file_get_contents('files/loginsAndPassworsd.txt');
$lap = explode(chr(012), $content);
$log = [];
$pas = [];
foreach($lap as $a){
	$log[] = trim(substr($a, 0, strpos($a,':')));
	$pas[] = trim(substr($a, strpos($a,':')+1));
}
$lap = array_combine($log, $pas);
if (empty($_POST)) {
	$message = 'Введите логин и пароль.';
} else {
	$user = trim(strip_tags($_POST['user']));
	$pass = trim(strip_tags($_POST['pass']));
	if (!empty($user) && !empty($pass)){
		if (isset($lap[$user])){
			if ($pass == $lap[$user]){
				$message = 'Доступ разрешен.';
				$formVisibility = 0;
			} else {
				$message = 'Доступ запрещен.';
				$message .= '|' . $lap[$user] . '|' . '<br>';
				$message .= '|' . $pass . '|' . '<br>';
			}
		} else {
			$message = 'Нет такого логина.';
		}
	} elseif (empty($user)) {
		$message = 'Введите логин.';
	} else {
		$message = 'Введите пароль.';
	}
}
if ($formVisibility == 1){

?>
<a  href="index.php">На главную</a><br>
<a  href="register.php">Регистрация</a><br>
<?= $message ?>
<form name="form" action="" method="POST">
	<input type="text" name="user" placeholder="Введите имя" value="<?php echo $user; ?>"><br>
	<input type="password" name="pass" placeholder="Введите пароль" value = "<?php echo $pass; ?>"><br>
	<input type="submit">
</form>
<?php
} else {
	include 'index.php';
 }
echo '<pre>' . '<br>';
echo '<div>' . '<br>';
echo '<br>';
print_r($_POST);
echo '<br>';
print_r($_GET);
print_r($lap);

echo chr(012) . '<br>';
echo chr(012) . '<br>';
echo chr(012) . '<br>';
?>
</div>
</pre>