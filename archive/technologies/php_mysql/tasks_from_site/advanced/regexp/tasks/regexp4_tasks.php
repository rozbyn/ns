<?php
date_default_timezone_set('Europe/Moscow');

echo preg_replace('#(?<=z)yy#i', '!', 'zyy ayy').'<br>';
echo preg_replace_callback('#\d+#', function($m){return $m[0]*$m[0]*$m[0];}, 'a11b2c3').'<br>';
echo preg_replace_callback('#(\d+)#', 'cube', 'a11b2c3').'<br>';
function cube($matches)
{
	$result = pow($matches[0], 3); //$matches[0] - это найденное число
	return $result;
}
$str = 'baaa naaa hbaaa heybaaa';
echo '1. '.preg_replace('#(?<=b)aaa#', '!', $str).'<br>';
$str = 'baaa naaa hbaaa heybaaa haaah sdaaa';
echo '2. '.preg_replace('#(?<!b)aaa#', '!', $str).'<br>';
$str = 'aaab aaan faaab';
echo '3. '.preg_replace('#aaa(?=b)#', '!', $str).'<br>';
$str = 'aaab aaan faaadb';
echo '4. '.preg_replace('#aaa(?!b)#', '!', $str).'<br>';
$str = 'aaa * bbb ** eee * **';
echo '5. '.preg_replace('#(?<!\*)\*(?!\*)#', '!', $str).'<br>';
$str = 'aaa * bbb ** eee *** kkk ****';
echo '6. '.preg_replace('#(?<!\*)\*\*(?!\*)#', '!', $str).'<br>';
$str = 'aabbccdefffgh';
echo '7. '.preg_replace('#([a-z])(?=\1)#', '!', $str).'<br>';
$str = 'aabbccdefffgh';
echo '8. '.preg_replace('#(?<=([a-z]))\1#', '!', $str).'<br>';
$str = "123456789";
echo '9. '.preg_replace_callback("#\d#", function($m){return $m[0]*$m[0];}, $str).'<br>';
$str = "2aaa'3'bbb'4'";
echo '10. '.preg_replace_callback("#(?<=')\d+(?=')#", function($m){return $m[0]*2;}, $str).'<br>';


echo '*2. '.preg_match('#^(?:https?://)?(?:www\.)?[-a-z_0-9]+\.[a-z]{2,}$#', 'http:site.ru').'<br>';
echo '*3. '.preg_replace('#(\d)\1#', '!', "12ee2333445").'<br>';
echo '*4. '.preg_match('#^(?:(?:[01]\d)|(?:2[0-3])):[0-5]\d$#', '00:12').'<br>';
echo '*5. '.preg_match('#198[3-9]|199\d|20[0-1]\d|202[0-4]#', '1983').'<br>';
echo '*6. '.preg_replace('#(?<!\*)\*(?!\*)(.+?)(?<!\*)\*(?!\*)#', '<em>$1</em>','This text has *two* *italic* bits').'<br>';
echo '*7. '.preg_replace('#\s\w*(?=(\w)\1)\w*|(?=(\w)\2)\w*\s#', '','wword word word wordd word worrd word worrd word word word woord wword word word').'<br>';
echo '*7. '.preg_replace('#\b\w*(\w)\1\w*\b\s*|\s*\b\w*(\w)\2\w*\b#', '','wword word word wordd word worrd word worrd word word word woord wword word word').'<br>';
echo '*7. '.preg_replace('#\b[a-z]*?([a-z])\1[a-z]*?\b\s|\s\b[a-z]*?([a-z])\2[a-z]*?\b#', '','wword word word wordd word worrd word worrd word word word woord wword word word').'<br>';
echo '<pre>';
echo '*8. '.preg_replace('#(\w+)\s+\1#', '$1','fd    hello world world hello world   world hello hello world hello my my world').'<br>';
echo '*8. '.preg_replace('#(\w+)\s+(?=\1)#', '','hello world world hello world   world hello hello world hello my my world').'<br>';
echo '</pre>';
echo '*9. '.preg_replace('#(\w+)\s+(?=\1)#', '','hello world world hello world   world hello hello hello world world world hello my my my my my world').'<br>';
$str = 'test123@email.my-site.ru';
echo '*10. '.preg_match('#^[^.;](?:[\w0-9-.!\#$%&\'*+\-\/=?^_`{|}~](?!\.{2,})){0,62}[^.;]@[^.;](?:[\w0-9-.](?!\.{2,}))+\.[a-zа-яё]{2,}$#', $str).'<br>';
echo '*11. '.preg_replace('#\[(b|em|i)\](.*)\[\/\1\]#','<$1>$2</$1>', 'hello [b]world[/b] test hello [em][i]world[/i] test hello world[/em] test').'<br>';
echo '*12. '.preg_replace('#(?<!\*)\*(?!\*)#','!', '*www * eee ** ggg*').'<br>';
echo '*13. '.preg_replace('#(?<!\*)\*\*(?!\*)#','!', 'www **** eee ***** rrr ****** ggg**').'<br>';
echo '*14. '.preg_match('#^[1-9]+[02468]$|^[2468]$#', '4656893210').'<br>';
echo '*15. '.preg_replace('#^(?:https?:\/\/)?([\w.-]+).*$#','$1', 'https://sub.site.ru/folder/page.html').'<br>';
echo '*16. '.preg_replace('#\$(?:[a-z]+\w*(?:\[[\'"\w\$\-!\\\[\]]+\])*)#','<b>$0</b>', 'текст $var1["key1"] + $var2["key2"] текст').'<br>';





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
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/books/php/regular/rabota-s-regulyarnymi-vyrazeniyami-v-php-glava-4.html" target="_blank">Страница учебника</a></div>
</body>
</html>