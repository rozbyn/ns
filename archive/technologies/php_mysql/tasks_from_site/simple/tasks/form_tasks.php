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
/*--------------------------------------------------*/
$user = '';
$age = '';
$message = '';
$formVisibility = 1;
$warn = '';
$empt = '';
function repl ($a){
	return str_replace([1, 2, 3], ['имя', 'возраст', 'сообщение'], $a);
}

if (empty($_POST)) {
	$warn = 'Заполните форму.';
} else {
	$user = trim(htmlspecialchars($_POST['user']));
	$age = trim(htmlspecialchars($_POST['age']));
	$message = trim(htmlspecialchars($_POST['message']));
	if (empty($_POST['user'])){$empt .= '1';}
	if (empty($_POST['age'])){$empt .= '2';}
	if (empty($_POST['message'])){$empt .= '3';}
	switch (strlen($empt)){
		case 3:
			$warn = 'Введите ваше имя, возраст и ваше сообщение.';
			break;
		case 2:
			$warn = 'Введите '. repl($empt[0]) . ' и ' . repl($empt[1]) . '.';
			break;
		case 1:
			$warn = 'Введите ' . repl($empt[0]) . '.';
			break;
		case 0:
			$warn = '';
			$formVisibility = 0;
	}
}
/*--------------------------------------------------*/
if ($formVisibility == 1){
	if (!empty($warn)) {
		echo $warn;
	}
?>
<form name="form" action="" method="POST">
	<input type="text" name="user" placeholder="Введите имя" value="<?php echo $user; ?>"><br>
	<input type="text" name="age" placeholder="Введите возраст" value = "<?php echo $age; ?>"><br>
	<textarea name="message"><?php echo $message; ?></textarea><br>
	<input type="submit">
</form>

<?php
} else {
	echo "Привет, $user, $age лет! <br>Твое сообщение: $message";
}
echo $empt  . '<br>';
echo '<pre>' . '<br>';
echo '<div>' . '<br>';
echo '<br>';
print_r($_POST);
echo '<br>';
print_r($_GET);
?>
</div>
</pre>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/base/osnovy-raboty-s-formami-v-php.html" target="_blank">Страница учебника</a></div>