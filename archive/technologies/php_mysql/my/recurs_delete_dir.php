<?php


define('DELETE_DIR', 'no_such_dir');

function recurse_delete ($dir) {
	static $f = 0;
	static $d = 0;
	if (is_dir($dir)) {
		$dir_content = array_diff(scandir($dir), array('.','..'));
		if (!empty($dir_content)) {
			foreach ($dir_content as $elem) {
				$elem = $dir . DIRECTORY_SEPARATOR . $elem;
				if (is_file($elem)) {
					unlink($elem);
					$f++;
				} elseif (is_dir($elem)) {
					recurse_delete($elem);
				}
			}
			rmdir($dir);
			$d++;
		} else {
			rmdir($dir);
			$d++;
		}
	}
	return [$f, $d];
	
}
$a = recurse_delete(DELETE_DIR);

echo 'Удалено' . '<br>';
echo $a[0]. " файлов" . '<br>';
echo $a[1]. " папок" . '<br>';