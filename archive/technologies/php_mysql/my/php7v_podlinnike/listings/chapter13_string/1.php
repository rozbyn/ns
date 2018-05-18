<?php
$timer = -microtime(true);
$str1 = 'Привет, мирок!';
echo strlen($str1) . ' ';
echo mb_strlen($str1) . '~';

$str2 = '1Привет, Мирок!фывфв';

echo (strcmp($str1, $str2)) . ' ';
echo (strcasecmp($str1, $str2)) . '~';
$str3 = 'Hello, world!';
echo substr($str3, -1) . '~';
echo substr($str3, -3) . '~';
echo substr($str3, -5, -4) . '~';
echo substr_replace($str3, 'Yo', -5, -4) . '~';
echo strtr($str3, 'H!', '!)') . '~';
echo str_replace(['H', '!'], ['!', '@'], $str3) . '<br>';
$url1 = 'http://test.r:81/chapter13_string/1.php?123s=dasdasd';

echo urlencode($url1) . '<br>';
$text = <<<lololool0lollol
<?php

  $str1 = 'Привет, мирок!';
  echo strlen($str1) . ' ';
  echo mb_strlen($str1) . '~';
  
  $str2 = '1Привет, Мирок!фывфв';
  
  echo (strcmp($str1, $str2)) . ' ';
  echo (strcasecmp($str1, $str2)) . '~';
  $str3 = 'Hello, world!';
  echo substr($str3, -1) . '~';
  echo substr($str3, -3) . '~';
  echo substr($str3, -5, -4) . '~';
  echo substr_replace($str3, 'Yo', -5, -4) . '~';
  echo strtr($str3, 'H!', '!)') . '~';
  echo str_replace(['H', '!'], ['!', '@'], $str3) . '<br>';
  $url1 = 'http://test.r:81/chapter13_string/1.php?123s=dasdasd';
  '&&&&&&&&&&&&&&&&&&&&&&&&&&&&&'
  echo urlencode($url1) . '<br>';
?>
lololool0lollol;
echo '<pre>' . htmlspecialchars($text) . '</pre>';

$moneyl = 68.75;
$money2 = 54.35;
$money = $moneyl + $money2;
$mNmae = 'Vasya';
echo "$money<br>"; 
echo sprintf ('[%2$-\'\\10.4s] должен мне [%1$\'o11.4f] ру\'бля<br>', $money, $mNmae); 
$i = 0;
while ($i<1000000) $i++;
echo number_format(21312313131.123123131231231, 5, ',', ' ') . '<br>';
echo number_format(21312313131.123123131231231) . '<br>';
echo number_format(131.77777777777, 3, ',', ' ') . '<br>';
function cite($ourText, $maxlen = 60, $prefix = "> ") {
	$st= wordwrap($ourText, $maxlen - strlen($prefix), "\n");
	$st= $prefix.str_replace("\n", "\n$prefix", $st);
	return $st;
}
echo "<pre>";
echo cite("The first Matrix I designed was quite naturally
perfect, it was a work of art - flawless, sublime. A triurrph
equalled only by its monumental failure. The inevitability
of its doom is apparent to me now as a consequence of the
imperfection inherent in every human being. Thus, I
redesigned it based on your history to more accurately reflect
the varying grotesqueries of your nature. However, I was again
frustrated by failure.", 20);
echo "</pre>";












printf('[Time => %.2fms]<br>', ($timer + microtime(true)) * 1000) ;