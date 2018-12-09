<?php
'https://raw.githubusercontent.com/rozbyn/ns/master/archive/technologies/php_mysql/copied_examples/Design%20Patterns/adapter.php';
//privet
require_once '../getContentsAsync/getContentsAsynch.php';

$ghPrefix = 'https://raw.githubusercontent.com/rozbyn/ns/master/';
$thisServerRootFolder = $_SERVER['DOCUMENT_ROOT'] === 'E:/site/' ? 'E:/site/ns' : $_SERVER['DOCUMENT_ROOT'];


echo '<br>';
echo strtotime('2018-12-08T21:39:09+03:00');
echo '<br>';
echo strtotime('2018-12-08T21:38:54+03:00');
echo '<br>';
echo strtotime('2018-12-08T21:39:09+03:00') - strtotime('2018-12-08T21:38:54+03:00');

if(!isset($_REQUEST['payload'])) exit;
$payload = json_decode($_REQUEST['payload'], true);
//file_put_contents('jopz.txt', var_export($payload, true));
$arAdded = $arLocalAdd = $arRemoved = $arLocalRmove = [];

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


$arNewContents = getContentsAsync(array_keys($arAdded));

foreach ($arLocalRmove as $localPath) {
	$localP = "$thisServerRootFolder/$localPath";
	if(is_file($localP)) unlink ($localP);
	else if (is_dir($localP)) rmdir ($localP);
}

foreach ($arNewContents as $rawUrl => $rawContent) {
	$localPa = $arLocalAdd[$rawUrl];
	$localP = "$thisServerRootFolder/$localPa";
	file_put_contents($localP, $rawContent);
}

$log = ['removed'=>$arLocalRmove, 'updated'=>$arLocalAdd];
file_put_contents('lastCommit.txt', var_export($log, true));




