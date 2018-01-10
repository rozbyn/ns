<?php
date_default_timezone_set('Europe/Moscow');

//$myDbObj = connect_DB('test', 'root', '', 'localhost');
//$myDbObj = connect_DB('u784337761_test', 'u784337761_root', 'nSCtm9jplqVA', 'localhost');
echo '1. '.preg_replace('#a.b#', '!', 'ahb acb aeb aeeb adcb axeb') . '<br>';
echo '2. '.preg_replace('#a..a#', '!', 'aba aca aea abba adca abea') . '<br>';
echo '3. '.preg_replace('#ab.a#', '!', 'aba aca aea abba adca abea') . '<br>';

echo '4. '.preg_replace('#ab+a#', '!', 'aa aba abba abbba abca abea') . '<br>';
echo '5. '.preg_replace('#ab*a#', '!', 'aa aba abba abbba abca abea') . '<br>';
echo '6. '.preg_replace('#ab?a#', '!', 'aa aba abba abbba abca abea') . '<br>';
echo '7. '.preg_replace('#(ab)+#', '!', 'ab abab abab abababab abea') . '<br>';

echo '8. '.preg_replace('#a\.a#', '!', 'a.a aba aea') . '<br>';
echo '9. '.preg_replace('#2\+3#', '!', '2+3 223 2223') . '<br>';
echo '10. '.preg_replace('#2\++3#', '!', '23 2+3 2++3 2+++3 345 567') . '<br>';
echo '11. '.preg_replace('#2\+*3#', '!', '23 2+3 2++3 2+++3 445 677') . '<br>';
echo '12. '.preg_replace('#\*q+\+#', '!', '*+ *q+ *qq+ *qqq+ *qqq qqq+') . '<br>';
echo '13. '.preg_replace('#\*q*\+#', '!', '*+ *q+ *qq+ *qqq+ *qqq qqq+') . '<br>';

echo '14. '.preg_replace('#a.+?a#', '!', 'aba accca azzza wwwwa') . '<br>';


?>
<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Регулярные выражения</title>
   
</head>
<body >
	<div class="main">
		<div class="wrapper">

		</div>
	</div>
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/regular/rabota-s-regulyarnymi-vyrazeniyami-v-php-glava-1.html" target="_blank">Страница учебника</a></div>
</body>
</html>