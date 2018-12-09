<?php
'https://raw.githubusercontent.com/rozbyn/ns/master/archive/technologies/php_mysql/copied_examples/Design%20Patterns/adapter.php';
//privet
require_once '../getContentsAsync/getContentsAsynch.php';
require_once './functions.php';

$ghPrefix = 'https://raw.githubusercontent.com/rozbyn/ns/master/';
$thisServerRootFolder = $_SERVER['DOCUMENT_ROOT'] === 'E:/site/' ? 'E:/site/ns' : $_SERVER['DOCUMENT_ROOT'];



if(!isset($_REQUEST['payload'])) exit;
$payload = json_decode($_REQUEST['payload'], true);
$arAdded = $arLocalAdd = $arRemoved = $arLocalRmove = [];

dump2($payload);

$commits = $payload['commits'];

foreach ($commits as $commit) {
	$commTsmp = strtotime($commit['timestamp']);
	
	foreach ($commit['added'] as $addedFile) {
		$rawFileUrl = $ghPrefix.$addedFile;
		if(isset($arAdded[$rawFileUrl])){
			$arAdded[$rawFileUrl] = $commTsmp > $arAdded[$rawFileUrl] ? $commTsmp : $arAdded[$rawFileUrl];
		} else {
			$arAdded[$rawFileUrl] = $commTsmp;
		}
		$arLocalAdd[$rawFileUrl] = $addedFile;
	}
	
	foreach ($commit['modified'] as $addedFile) {
		$rawFileUrl = $ghPrefix.$addedFile;
		if(isset($arAdded[$rawFileUrl])){
			$arAdded[$rawFileUrl] = $commTsmp > $arAdded[$rawFileUrl] ? $commTsmp : $arAdded[$rawFileUrl];
		} else {
			$arAdded[$rawFileUrl] = $commTsmp;
		}
		$arLocalAdd[$rawFileUrl] = $addedFile;
	}
	
	foreach ($commit['removed'] as $removedFile) {
		$rawFileUrl = $ghPrefix.$removedFile;
		if(isset($arAdded[$rawFileUrl])){
			if($commTsmp > $arAdded[$rawFileUrl]){
				unset($arAdded[$rawFileUrl]);
			} else {
				continue;
			}
		}
		$arRemoved[$rawFileUrl] = $commTsmp;
		$arLocalRmove[] = $removedFile;
	}
}


dump2(array_keys($arAdded));

$arNewContents = getContentsAsync(array_keys($arAdded));

dump2($arNewContents);

foreach ($arLocalRmove as $localPath) {
	$localP = "$thisServerRootFolder/$localPath";
	if(is_file($localP)) unlink ($localP);
	else if (is_dir($localP)) rmdir ($localP);
}

foreach ($arNewContents as $rawUrl => $rawContent) {
	$localPa = $arLocalAdd[$rawUrl];
	$localP = "$thisServerRootFolder/$localPa";
	file_put_contents($localP, $rawContent["content"]);
}

$log = ['removed'=>$arLocalRmove, 'updated'=>$arLocalAdd];
//vova g