<?php 
$commands = [
	'open',
	'ftp.rozbyn.esy.es',
	'u784337761',
	'vWJG3oCVBK',
	'lcd E:\\',
	'get',
	'favicon.ico',
	'asdasdasda.ico',
	'close',
	'quit',
];
$commands2 = [
	'open ftp.rozbyn.esy.es',
	'u784337761',
	'vWJG3oCVBK',
	'lcd E:\\',
	'get',
	'favicon.ico',
	'asdasdasda.ico',
	'close',
	'quit',
];

$gpuZ = '"E:\install\prog\GPU-Z.2.1.0.exe"';

$fp = popen('"C:\Windows\System32\ftp.exe"', 'wb');

foreach($commands as $com) {
	fwrite($fp, $com);
}
pclose ($fp);
// fwrite($fp, $comm1);
// fwrite($fp, $imagickImagePath);
// fwrite($fp, $imagickOutput);
