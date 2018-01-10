<?php
date_default_timezone_set('Europe/Moscow');

//$myDbObj = connect_DB('test', 'root', '', 'localhost');
//$myDbObj = connect_DB('u784337761_test', 'u784337761_root', 'nSCtm9jplqVA', 'localhost');
$i = 0;
echo ++$i.'. '. preg_replace('#ab{2,4}a#', '!', 'aa aba abba abbba abbbba abbbbba') . '<br>';
echo ++$i.'. '. preg_replace('#ab{0,3}a#', '!', 'aa aba abba abbba abbbba abbbbba') . '<br>';
echo ++$i.'. '. preg_replace('#ab{4,}a#', '!', 'aa aba abba abbba abbbba abbbbba') . '<br>';
echo '<br>';
echo ++$i.'. '. preg_replace('#a\da#', '!', 'a1a a2a a3a a4a a5a aba aca') . '<br>';
echo ++$i.'. '. preg_replace('#a\d+a#', '!', 'a1a a22a a333a a4444a a55555a aba aca') . '<br>';
echo ++$i.'. '. preg_replace('#a\d*a#', '!', 'aa a1a a22a a333a a4444a a55555a aba aca') . '<br>';
echo ++$i.'. '. preg_replace('#a\Db#', '!', 'avb a1b a2b a3b a4b a5b abb acb') . '<br>';
echo ++$i.'. '. preg_replace('#a\Wb#', '!', 'ave a#b a2b a$b a4b a5b a-b acb') . '<br>';
echo ++$i.'. '. preg_replace('#\s#', '!', 'ave a#a a2a a$a a4a a5a a-a aca') . '<br>';
echo '<br>';
echo ++$i.'. '. preg_replace('#a[bex]a#', '!', 'aba aea aca aza axa') . '<br>';
echo ++$i.'. '. preg_replace('#a[+.b]a#', '!', 'aba aea aca aza axa a.a a+a a*a') . '<br>';
echo ++$i.'. '. preg_replace('#a[3-7]a#', '!', 'aba aea aca aza axa a.a a+a a*a') . '<br>';
echo ++$i.'. '. preg_replace('#a[a-g]a#', '!', 'aba aea aca aza axa a.a a+a a*a') . '<br>';
echo ++$i.'. '. preg_replace('#a[a-fj-z]a#', '!', 'aba aea aca aza axa a.a a+a a*a') . '<br>';
echo ++$i.'. '. preg_replace('#a[a-fA-Z]a#', '!', 'aba aea aca aza axa a.a a+a a*a') . '<br>';
echo ++$i.'. '. preg_replace('#a[^ex\s]a#', '!', 'aba aea aca aza axa a-a a#a') . '<br>';
echo ++$i.'. '. preg_replace('#w[а-яА-ЯЁё]w#u', '!', 'wйw wяw wёw wqw') . '<br>';
echo '<br>';
echo ++$i.'. '. preg_replace('#a[a-z]+a#', '!', 'aAXa aeffa aGha aza ax23a a3sSa') . '<br>';
echo ++$i.'. '. preg_replace('#a[a-zA-Z]+a#', '!', 'aAXa aeffa aGha aza ax23a a3sSa') . '<br>';
echo ++$i.'. '. preg_replace('#a[a-z0-9]+a#', '!', 'aAXa aeffa aGha aza ax23a a3sSa') . '<br>';
echo ++$i.'. '. preg_replace('#[а-яА-ЯЁё]+#u', '!', 'ааа ббб ёёё ззз ййй ААА БББ ЁЁЁ ЗЗЗ ЙЙЙ') . '<br>';
echo '<br>';
echo ++$i.'. '. preg_replace('#^aaa#', '!', 'aaa aaa aaa') . '<br>';
echo ++$i.'. '. preg_replace('#aaa$#', '!', 'aaa aaa aaa') . '<br>';
echo '<br>';
echo ++$i.'. '. preg_replace('#ae+a|ax+a#', '!', 'aeeea aeea aea axa axxa axxxa') . '<br>';
echo ++$i.'. '. preg_replace('#a(ee|x+)a#', '!', 'aeeea aeea aea axa axxa axxxa') . '<br>';
echo '<br>';
echo ++$i.'. '. preg_replace('#\b#', '!', 'xbx aca aea abba adca abea') . '<br>';
echo '<br>';
echo ++$i.'. '. preg_replace('#a\\\\a#', '!', 'a\a abc') . '<br>';
echo ++$i.'. '. preg_replace('#a\\\\{3}a#', '!', 'a\\a a\\\\a a\\\\\\a') . '<br>';
echo '<br>';
echo ++$i.'. '. preg_replace('#/[a-z]+\\\\#', '!', 'bbb /aaa\\ bbb /ccc\\') . '<br>';
echo ++$i.'. '. preg_replace('#<b>[a-z\s]+</b>#', '!', 'bbb <b> hello </b>, <b> world </b> eee') . '<br>';
echo ++$i.'. '. preg_replace('#<b>(.+?)</b>#', '!', 'bbb <b> hello </b>, <b> world </b> eee') . '<br>';





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
	<div style="position: fixed; top:90%; left:80%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/tasks/php/regular/rabota-s-regulyarnymi-vyrazeniyami-v-php-glava-2.html" target="_blank">Страница учебника</a></div>
</body>
</html>