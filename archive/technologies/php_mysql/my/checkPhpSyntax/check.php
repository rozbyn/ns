<?php
$fileWithErrorPath = __DIR__ . '/fileWithError.php';
$fileWithNoErrorPath = __DIR__ . '/fileWithNoError.php';




checkValidPhpFile($fileWithErrorPath);
checkValidPhpFile($fileWithNoErrorPath);



function checkValidPhpFile($filePath) {
	if(!is_file($filePath)){
		return false;
	}
	$r = shell_exec("php -l -f $filePath");
	var_dump($r);
}


