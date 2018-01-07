
<pre>

<?php
//функция создания массива из структуры локальной папки 
$dir = 'files';
function dirToArray ($dir){
	$result = [];
	$cdir = scandir($dir);
	foreach ($cdir as $key => $value){
		if ($value != '.' && $value != '..'){
			if (is_dir($dir . '//' . $value)){
				$result[$value] = dirToArray($dir . '//' . $value);
			} else {
				$result[] = $value;
			}
		}
	}
	return $result;
}

print_r($dir . '<br>');
$dirArray = dirToArray($dir);
print_r($dirArray);
//функция представления массива строкой с переносами и табуляцией
function massArrToString($arr, $vgf = 0, $resStr = ''){
	if ($vgf == 0){
			$resStr = 'Исходный массив' . '<br>';
		}
		foreach($arr as $key => $value){
			$resStr .= str_repeat('|&#9;',$vgf);
			if (is_array($value)){
				$vgf++;
				$resStr .= '|->' . $key . '<br>';
				$resStr = massArrToString($arr[$key], $vgf, $resStr);
				--$vgf;
			} else {
				$resStr .= '|' . $value . '<br>';
			}
			
		}
	return $resStr;
}

echo massArrToString($dirArray) . '<br>';


//функция создания ссылок на файлы в папке
function dirToLinks ($dir, $resStr = ''){
	$cdir = scandir($dir);
	foreach ($cdir as $key => $value){
		if ($value != '.' && $value != '..'){
			if (is_dir($dir . '/' . $value)){
				$resStr = dirToLinks("$dir/$value", $resStr);
			} else {
				$resStr .= "<a href=\"$dir/$value\" >$dir/$value</a><br>";
			}
		}
	}
	return $resStr;
}

//echo str_replace('E:\Program Files\xampp\htdocs', '', dirToLinks($dir)) . '<br>';
echo dirToLinks($dir) . '<br>';
echo '&#9;';//десятичный код символа табуляции HTML


?>
</pre>









