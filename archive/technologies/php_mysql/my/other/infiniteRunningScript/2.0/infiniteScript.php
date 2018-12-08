<?php
require_once './sendRequestNoAnsver.php';
$unlinkThisFile = (basename(__FILE__) === 'infiniteScript.php') ? '' : __FILE__;

if(!isset($_REQUEST['runCount']) || !is_file('0_RUN') || is_file('0_STOP')) return @unlink($unlinkThisFile);



$arServerVars = [
	'port' =>  in_array($_SERVER['SERVER_PORT'], [80, 443]) ? '' : ':'.$_SERVER['SERVER_PORT'],
	'scheme' => ($_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http',
	'host' => $_SERVER['SERVER_NAME'],
	'path' => $_SERVER['SCRIPT_NAME']
];
$thisScriptUrl = "{$arServerVars['scheme']}://{$arServerVars['host']}{$arServerVars['port']}{$arServerVars['path']}";

//$maxExTime = ini_get('max_execution_time');
$maxExTime = 10;

$count = $_REQUEST['runCount'];
$nxtCount = $count+1;

$thisFileRecdFilename = "0_RECD_$count";
if(is_file($thisFileRecdFilename)) return @unlink($unlinkThisFile);

touch($thisFileRecdFilename);


$newFileName = "0_SCRIPT_NUMBER_$nxtCount.php";
$newFileContent = file_get_contents(__FILE__);
$newFileUrl = dirname($thisScriptUrl) . "/$newFileName?runCount=$nxtCount";




sleep($maxExTime - 4);
if(is_file('0_STOP')) exitScript();
if(!file_put_contents($newFileName, $newFileContent)) return exitScript();


while (!is_file("0_RECD_$nxtCount")) {
	sendRequestNoAnswer($newFileUrl);
	usleep(500000);
	
}
exitScript();


function exitScript() {
	global $thisFileRecdFilename, $unlinkThisFile;
	@unlink($thisFileRecdFilename);
	@unlink($unlinkThisFile);
	exit;
}