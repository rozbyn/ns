<?php
setlocale(LC_ALL, 'ru_RU', 'RU', 'rus');
date_default_timezone_set('Europe/Moscow');

echo getcwd() . '<br>';
chdir('..');
echo getcwd() . '<br>';
chdir('/');
echo getcwd() . '<br>';

chdir(__DIR__);
echo getcwd() . '<br>';

$d = opendir('..');
while(($e = readdir($d)) !== false){
	echo $e . '<br>';
}
echo "<pre>";
$asdasd = glob("E:/*", GLOB_BRACE);
function add_info ($str) {
	return $str . ' UID:' . fileowner($str). ' GID:' . filegroup($str) . 'PERM:' . decoct(fileperms(__FILE__));
}
$asdasd = array_map('add_info', $asdasd);
print_r($asdasd);
chmod(__FILE__, 0777);
$perms = fileperms(__FILE__);
echo $perms, ' ',decbin($perms);
echo  '<br>';
echo decoct($perms);
print_r(stat(__FILE__));
$f = 'temp.txt';
echo 'Размер файла(байты): ' . filesize($f) . '<br>';
echo 'Время последнего изменения файла: ' . date("Y-m-d H:i:s", filemtime($f)) . '<br>';
echo 'Время последнего доступа к файлу: ' . date("Y-m-d H:i:s", fileatime($f)) . '<br>';
echo 'Время последнего изменения атрибутов файла: ' . date("Y-m-d H:i:s", filectime($f)) . '<br>';
touch($f, strtotime('+ 5 years'), strtotime('+ 10 years'));
echo "Меняем время последней модификации и доступа на +5лет и +10лет" . '<br>';

echo 'Время последнего изменения файла: ' . date("Y-m-d H:i:s", filemtime($f)) . '<br>';
echo 'Время последнего доступа к файлу: ' . date("Y-m-d H:i:s", fileatime($f)) . '<br>';


symlink($f, 'asdasdasdadadad');
link($f, 'asdasdasdadadad');

$fasd = [];
$r = exec('php -v', $fasd);
var_dump($fasd);

?>
