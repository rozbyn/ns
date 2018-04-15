<h3>Вход</h3>

<form action="<?=$GLOBALS['bDir'] ?>/account/login" method="POST">
	<p>Логин</p>
	<p><input name="log"></p>
	<p>Пароль</p>
	<p><input type="password" name="pas"></p>
	<input type="hidden" name="send" value="1">
	<p><button type="submit" >Вход</button></p>
</form>