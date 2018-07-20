<?php
$val = $_POST['test'] ?? '';
?>
<!DOCTYPE html>

<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Test22</title>
		<script src="/jquery-3.3.1.js"></script>
		<script src="/jquery.inputmask.bundle.js"></script>
		<script src="/script.js"></script>
		<script src="script2.js"></script>
    </head>
	<body>
		<form id="test_form" action="" method="POST">
			<input name="test" id="test" value="<?=$val?>">
			<input type="submit">
		</form>
		<?=$val?>
	</body>
</html>