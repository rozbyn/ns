<?php

$count = 1;
if (isset($_COOKIE['count'])) do {
	$count = $_COOKIE['count'];
	$count++;
} while(0);

setcookie('count', $count);


?>

<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>form1</title>
</head>
<body>
	Вы зашли на сайт <?= $count ?> раз!
	<?='<pre>'.'`php -v`'.PHP_OS.' | '.__FILE__.'</pre>'?>
</body>
</html>