<?php
echo  '<pre>';
if (preg_match ('&path/to/file&i', "path/to/file"))
echo "Совпадение!";
$file = file_get_contents(__FILE__);
$text = htmlspecialchars($file);
$html = preg_replace('#(\$[a-z]\w*(?:\[\'?\w+\'?\])*)#is', '<b>$1</b>', $text);
//echo '<pre>' . $html . '</pre>';

preg_match('#<(\w+) [^>]* > (.*?) </\1>#xs', $html, $matches);
var_dump(htmlspecialchars($matches[0]));
var_dump(htmlspecialchars($matches[1]));
var_dump(htmlspecialchars($matches[2]));
$asdasd  = <<<dddadadadaadasdasd
$matches[0]['alpha']['betta'][100]
dddadadadaadasdasd;
$date = '19.12.2004';
$re = '#(?<day>\d{2})[[:punct:]](?<month>\d{2})[[:punct:]](?<year>\d{4})#';
preg_match($re, $date, $matches);
var_dump($matches);
$str = '<hTmL><bOdY style="background: white;">Hello world!</bOdy></html>';
$str = preg_replace_callback(
	/*'{(?<btag></?)(?<content>\w+)(?<etag>.*?>)}s',*/
	'{(</?)(\w+)(.*?>)}s',
	function ($m) {return $m['1'].strtoupper($m[2]).$m['3'];/*return var_dump($m); *//*return $m['btag'].strtoupper($m['content']).$m['etag'];*/ },
	$str);
echo htmlspecialchars($str);
echo '<br>';

$str = '<hTmL><bOdY>Hello world!</bOdY>dsafdfsfsf</html>';
$str = preg_replace_callback_array(
	[
		'{(?<btag></?)(?<content>\w+)(?<etag>.*?>)}s' => function($m) {
		return $m['btag'].strtoupper($m['content']).$m['etag'];
		},
		'{(?<=>)([^<>]+?)(?=<)}s' => function($m){ return "<strong>$m[1]</strong>"; }
	],
	$str);
echo htmlspecialchars($str);
echo  '<br>';
  // Эта функция выделяет из текста в $text все уникальные слова и
  // возвращает их список. В необязательный параметр $nOrigWords 
  // помещается исходное число слов в тексте, которое было до 
  // "фильтрации" дубликатов.
  function getUniques($text, &$nOrigWords = false)
  { 
    // Сначала получаем все слова в тексте.
    $words = preg_split("/([^[:alnum:]]|['-])+/s", $text);
    $nOrigWords = count($words);
    // Затем приводим слова к нижнему регистру.
    $words = array_map("strtolower", $words);
    // Получаем уникальные значения.
    $words = array_unique($words);
    return $words;
  }
  // Пример применения функции.
  setlocale(LC_ALL, 'ru_RU.UTF-8');
  $fname = "largetextfile.txt";
  $text = file_get_contents($fname);
  $uniq = getUniques($text, $nOrig);
  echo "Было слов: $nOrig<br />";
  echo "Стало слов: ".count($uniq)."<hr />";
  echo join(" ", $uniq);