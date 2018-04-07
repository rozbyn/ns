<?php
$errorMessage = '';
function myHandler($level, $message, $file, $line, $context) {
	global $errorMessage;
	$errorMessage = $message;
	return true;
}
set_error_handler('myHandler', E_ALL);

function getExtension($str){
	return substr($str, strrpos($str,'.')+1);
}
function getFileNameFromUrl($str){
	return substr($str, strrpos($str,'/')+1);
}
function getFileName($str){
	return substr($str, 0, strrpos($str,'.'));
}

function getFontFaceLinks($str){
	$matches = [];
	$matches2 = [];
	$matches3 = [];
	$re = '#@font-face *?{[^}]*}#s';
	preg_match_all($re, $str, $matches, PREG_SET_ORDER|PREG_OFFSET_CAPTURE);
	$re = '#(?<=\'|"|\()(?:https?:\/\/.*?)(?=\'|"|\))#s';
	$i = 0;
	foreach($matches as $a){
		preg_match_all($re, $a[0][0], $matches2, PREG_SET_ORDER|PREG_OFFSET_CAPTURE);
		foreach($matches2 as $key=>$d){
			$matches3[$i][0] = $d[0][0];
			$matches3[$i][1] = $a[0][1] + $d[0][1];
			++$i;
		}
	}
	return $matches3;
}
$dir = '.';
$arrOfCssFiles = [];
$cdir = scandir($dir);
unset($cdir[0], $cdir[1]);
foreach($cdir as $elem){
	$extension = getExtension($elem);
	if($extension === 'css'){
		if(is_file($elem)){
			
			$arrOfCssFiles[] = $elem;
			
		}
	}
}
$cssFilesContents = [];
$FFLinks = [];
foreach($arrOfCssFiles as $cssFile){
	$cssFilesContents[$cssFile] = file_get_contents($cssFile);
}
foreach($cssFilesContents as $key=>$cssFile){
	$FFLinks[$key] = getFontFaceLinks($cssFile);
}
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);
if(true){
	foreach($FFLinks as $key=>$file){
		$dirName = getFileName($key);
		if(!is_dir($dirName)){
			mkdir($dirName, 0777, true);
		}
		$diff = 0;
		
		foreach($file as $fontLink){
			$fileName = $dirName . '/' . getFileNameFromUrl($fontLink[0]);
			$fileName2 = getFileNameFromUrl($fontLink[0]);
			if(!is_file($fileName) || filesize($fileName) == 0){
				echo 'Пытаюсь записать файл: '. $fileName . ': ';
				if($fontFile = file_get_contents($fontLink[0], false, stream_context_create($arrContextOptions))){
					file_put_contents($fileName, $fontFile);
					echo 'Успех' . '<br>' . PHP_EOL;
					
					$cssFilesContents[$key] = substr_replace($cssFilesContents[$key], $fileName2, $fontLink[1]+$diff, strlen($fontLink[0]));
					$diff += strlen($fileName2) - strlen($fontLink[0]);
					
				} else {
					echo 'Ошибка! ' . $errorMessage. '<br>' . PHP_EOL;
				}
			} else {
				$cssFilesContents[$key] = substr_replace($cssFilesContents[$key], $fileName2, $fontLink[1]+$diff, strlen($fontLink[0]));
				$diff += strlen($fileName2) - strlen($fontLink[0]);
			}
		}
		file_put_contents($dirName . '/' .$key, $cssFilesContents[$key]);
	}
}



?>