<?php
date_default_timezone_set('Europe/Moscow');
$i=0;
echo ++$i.'. '. preg_replace('#([a-z]+):(\d+)#', '$2:$1', 'aaaaaa:444 kkk:333333') . '<br>';
echo ++$i.'. '. preg_replace('#(\d)\1#', '!', '332 441 550') . '<br>';
$i=0;
echo '<br>';
echo ++$i.'. '. preg_replace('#([a-z0-9]+)@([a-z0-9]+)#', '$2@$1', 'aaa@bbb eee7@kkk') . '<br>';
echo ++$i.'. '. preg_replace('#\d#', '$0$0', 'a1b2c3') . '<br>';

echo ++$i.'. '. preg_replace('#([a-z0-9])\1#', '!', 'aae xxz 33a') . '<br>';
echo ++$i.'. '. preg_replace('#([a-z])\1+#', '!', 'aaa bcd xxxxxx efg') . '<br>';


$a = ['mymail@mail.ru', '-my.mail@mail.ru', '-my-mail@mail.ru', 'my_mail@mail.ru', 'mail@mail.com', 'mail@mail.by', 'mail@yandex.ru', 'sdadas', 'sdadas', 'sdadas', 'sdadas', 'sdadas', 'sdadas', 'sdadas'];
$b = mt_rand(0,count($a)-1);
$str = $a[$b];
echo ++$i.'. '.$str. ' - '. preg_match('#^[a-z]{1}[a-zA-Z-._]+@[a-z]+\.[a-z]{2,3}$#', $str) . '<br>';

$str = implode('dsajdo',$a);
echo ++$i.'. '. preg_match_all('#[a-z]{1}[a-zA-Z-._]+@[a-z]+\.[a-z]{2,3}#', $str, $matches) . '<br>';
var_dump($matches);
echo '<br>';
$str = 'my-site123.com';
echo ++$i.'. '.$str. ' - '. preg_match_all('#^[a-z0-9]{1}[a-z0-9-._]+\.[a-z]{2,3}$#', $str, $matches) . '<br>';
$str = '000hel-lo.my-site.coeam';
echo ++$i.'. '.$str. ' - '. preg_match_all('#[a-z0-9]{1}[a-z0-9-_]+\.[-a-z0-9_]+\.[a-z]{2,}#', $str, $matches) . '<br>';
$str = 'http://000hel-lo.my-site.coeam';
echo ++$i.'. '.$str. ' - '. preg_match_all('#^https?://[a-z0-9]{1}[a-z0-9-_]+\.[-a-z0-9_]+\.[a-z]{2,}#', $str, $matches) . '<br>';
$str = 'http://000hel-ltyo.my-site.coeam';
echo ++$i.'. '.$str. ' - '. preg_match_all('#^https?://[a-z0-9]{1}[a-z0-9-_]+\.[-a-z0-9_]+\.[a-z]{2,}/?$#', $str, $matches) . '<br>';
$str = 'httpsasdasdasdasdasdsadasdnjiodawj0id-0U)_JIwh-';
echo ++$i.'. '.$str. ' - '. preg_match_all('#^https?#', $str, $matches) . '<br>';
$str = 'httpsasdasdasdasdasdsadasdnjiodawj0id-0U)_JIwh-.html';
echo ++$i.'. '.$str. ' - '. preg_match_all('#[\.txt|\.html|\.php]$#', $str, $matches) . '<br>';
$str = 'httpsasdasdasdasdasdsadasdnjiodawj0id-0U)_JIwh-.jpg';
echo ++$i.'. '.$str. ' - '. preg_match_all('#\.jpe?g$#', $str, $matches) . '<br>';
$str = '65469484';
echo ++$i.'. '.$str. ' - '. preg_match_all('#^\d{1,12}$#', $str, $matches) . '<br>';
$str = 'da y809 aytsyd09as9 0yd07987 y6a0sy 8a9g t91';
echo ++$i.'. '.$str. ' - '. preg_match_all('#\d#', $str, $matches) . '<br>';
echo array_sum($matches[0]) . '<br>';
$str = '31-12-2014';
echo ++$i.'. '.$str. ' - '. preg_replace('#^(\d\d)-(\d\d)-(\d{4})$#', '$3.$2.$1', $str) . '<br>';
$str = 'http://site.ru, http://site.com, https://site.info';
echo ++$i.'. '.$str. ' - '. preg_replace('#https?://([a-z0-9]+\.[a-z]{2,})#', '<a href="$0">$1</a>', $str) . '<br>';


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
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/regular/rabota-s-regulyarnymi-vyrazeniyami-v-php-glava-3.html" target="_blank">Страница учебника</a></div>
</body>
</html>