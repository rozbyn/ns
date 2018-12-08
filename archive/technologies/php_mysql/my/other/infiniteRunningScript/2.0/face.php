<?php
require './sendRequestNoAnsver.php';

$scriptRunning = is_file('0_RUN');
$scriptStopped = is_file('0_STOP');

$arServerVars = [
	'port' =>  in_array($_SERVER['SERVER_PORT'], [80, 443]) ? '' : ':'.$_SERVER['SERVER_PORT'],
	'scheme' => ($_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http',
	'host' => $_SERVER['SERVER_NAME'],
	'path' => $_SERVER['SCRIPT_NAME']
];

$thisScriptUrl = "{$arServerVars['scheme']}://{$arServerVars['host']}{$arServerVars['port']}{$arServerVars['path']}";


function runScript() {
	global $thisScriptUrl;
	sendRequestNoAnswer(dirname($thisScriptUrl) . '/infiniteScript.php?runCount=0');
}


if(isset($_REQUEST['rerun']) && $_REQUEST['rerun'] === 'true'){
	@unlink('0_RUN');
	@unlink('0_STOP');
} else if (isset($_REQUEST['stop']) && $_REQUEST['stop'] === 'true') {
	@touch('0_STOP');
} else if (isset($_REQUEST['run']) && $_REQUEST['run'] === 'true') {
	@touch('0_RUN');
	runScript();
}


?>
<br>
<br>
<div>
	max_execution_time: <?=ini_get('max_execution_time') ?>
</div>
<div>
	<form action="" method="POST">
		<?php if(!is_file('0_RUN') && !is_file('0_STOP')):?>
			<div>Скрипт не запущен</div>
			<button name="run" value="true">Запустить скрипт</button>
		<?php elseif(is_file('0_RUN') && !is_file('0_STOP')): ?>
			<div>Скрипт запущен</div>
			<button name="stop" value="true">Остановить скрипт</button>
		<?php elseif(is_file('0_STOP')): ?>
			<div>Скрипт остановлен</div>
			<button name="rerun" value="true">Сбросить скрипт</button>
		<?php endif ?>
	</form>
</div>