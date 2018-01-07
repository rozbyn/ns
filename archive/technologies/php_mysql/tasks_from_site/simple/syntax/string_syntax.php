<pre>
<?php
echo '<div style="float:left;margin:5px">';
$fdsf = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
$summat = 0;
$j = 0;
foreach ($fdsf as $kof) {
	if ($summat >= 10){
		break;
	} else {
		$summat += $kof;
		$j++;
	}
}
echo $j;

echo floor(20/1.5);

/*РАБОТА СО СТРОКАМИ*/
echo strtolower('sdfsafFDSda') . '<br>';
echo mb_strtolower('ВАЫУАуьлщшзцаУШАЙЦУ') . '<br>';
echo strtoupper('rfhyi;lyrt') . '<br>';
echo mb_strtoupper('вацупкуеурур') . '<br>';
echo str_replace('a', '!', 'abcabc') . '<br>';
echo str_replace(['жопа', 'a', 'b', 'c'], ['счастье', 1, 2, 3], 'abciopcba жопа') . '<br>';
echo strtr('111222', ['1'=>'a', '2'=>'b']) . '<br>';
echo strtr('rfrrgnfnfjrftjr', 'rf', '9G') . '<br>';
echo substr_replace('abcde', '!!!', 1, 3) . '<br>';
echo substr_replace('abcde', '!!!', 1) . '<br>';
echo strpos('abc abc', 'c') . '<br>';
echo strpos('cab abc', 'c', 1) . '<br>';
if(strpos('http://site.ru', 'http://') === 0) {
	echo 'да' . '<br>';
} else {
	echo 'нет' . '<br>';
}
echo strrpos('abc abc', 'a') . '<br>';
echo strstr('site.ru/folder1/folder2/page.html', '/') . '<br>';
$date = '2025-12-31';
$arr = explode('-', $date);//explode разбивает строку в массив по определенному разделителю. 
print_r($arr);
$arr = ['a', 'b', 'c'];
$str = implode('-', $arr);//imp$str = '';
for ($i = 0; $i < 5; $i++){
	$str .= str_repeat($i, $i);
}//м разделителем. 
echo $str . '<br>';;
$num = 12345;	echo array_sum(str_split($num, 1)) . '<br>';// str_split разбивает строку в массив. 
echo(trim(' hello ')) . '<br>'; //trim удаляет пробелы с начала и конца строки.
echo trim('/hello/', '/') . '<br>'; //	Может также удалять другие символы, если их указать вторым параметром.
echo trim('/hello.', '/.') . '<br>';
echo trim('../../hello...', '/.') . '<br>';
echo trim('he6458llo', 'a..z') . '<br>';
echo strrev('12345') . '<br>'; //strrev переворачивает строку так, чтобы символы шли в обратном порядке.
echo str_shuffle('Hello world!') . '<br>'; //str_shuffle переставляет символы в строке в случайном порядке.
echo number_format(1234.567, 2, '.', ' ') . '<br>'; //number_format позволяет форматировать число. 
echo str_repeat('x', 5) . '<br>'; //str_repeat повторяет строку заданное количество раз. 
echo htmlspecialchars('<b>жирный текст</b>') . '<br>'; //htmlspecialchars позволяет вывести теги в 
//браузер так, чтобы он не считал их командами, а выводил как строки. 
$dfssd = 'hello <p><b>world</b></p>';
echo strip_tags($dfssd,'<b>') . '<br>';//Функция strip_tags удаляет HTML теги из строки
$product = 'apple';
$num = 3;
printf ("Товар - [%'.10s], количество - %s", $product, $num);
echo '<br>';
echo '</div>';
echo '<div style="float:left;margin:5px">';
$codes = array_merge(range(65, 90), range(97, 122));
echo chr($codes[array_rand($codes)]) . '<br>';//chr находит символ по его ASCII коду. 
echo ord('W') . '<br>';
echo str_word_count('Hello my world') . '<br>';// str_word_count подсчитывает количество слов в строке. 
echo substr_count('test www test', 'test') . '<br>';//substr_count подсчитывает сколько раз встречается подстрока в строке. 
echo count_chars('dfsgewgerfgerpowjqokqlamcjeqwofqn', 3) . '<br>';//count_chars подсчитывает сколько раз встречаются различные символы в строке. 
echo strchr('site.ru/folder1/folder2/page.html', '/') . '<br>';
echo strrchr('site.ru/folder1/folder2/page.html', '/') . '<br>';
echo substr('asdfghjkl', 0, 5) . '<br>';//asdfg, возвращает часть строки, со 2 парам, длинной 3 парам.















echo '</div>';
?>
</pre>
<div style="position: fixed; top:90%; left:90%; z-index:9; background: #f9f98c;"><a href="http://theory.phphtml.net/books/php/base/rabota-so-strokovymi-funkciyami-v-php.html" target="_blank">Страница учебника</a></div>