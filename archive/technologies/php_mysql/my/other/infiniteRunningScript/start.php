<?php
require '__functions.php';

if(isset($_REQUEST['run']) && $_REQUEST['run'] === 'true'){
	if(!empty($_REQUEST['scriptUrl'] && filter_var($_REQUEST['scriptUrl'], FILTER_VALIDATE_URL))){
		$arrRunOpt = [
			'scriptUrl' => $_REQUEST['scriptUrl'],
			'data' => '',
			'runCount' => 0
		];
		$runningCode = <<<'PHP_CODE'
<?php
require '__functions.php';
define('START_TIME_MSEC', microtime(true));
if(isset($_REQUEST['RUNNING']) && $_REQUEST['RUNNING'] = 'da'){
	$arrRunOpt = include('0_RUN');
	$oldFileName = ($arrRunOpt['runCount'] - 1) . '.php';
	if(is_file($oldFileName)){
		unlink($oldFileName);
	}
	if(is_file('0_STOP')){
		endConnect('script Ended!');
		unlink(__FILE__);
		unlink('0_STOP');
		unlink('0_RUN');
	} elseif(is_file('0_RUN')){
		$newFileData = file_get_contents(__FILE__);
		$arrRunOpt['runCount']++;
		$newFileName = ($arrRunOpt['runCount']) . '.php';
		endConnect('gotcha!');
		file_put_contents($newFileName, $newFileData);
		$requestTime = -microtime(true);
		$res = sendBaseRequest($arrRunOpt['scriptUrl'], $arrRunOpt);
		$requestTime += microtime(true);
		$arrRunOpt['data'] = $res['data'];
		file_put_contents('0_RUN', "<?php\r\nreturn ".var_export($arrRunOpt, true) . ';');
		$sleepTime = (($res['maxExTime'] - $requestTime) - 5) * 1000000;
		@usleep($sleepTime);
		$rez = sendBaseRequest(dirname(getSelfAddres())."/$newFileName", ['RUNNING'=>'da']);
		file_put_contents('dbug.dbug', $arrRunOpt['runCount'] ."\r\n" . var_export($rez, true) . "\r\n" );
		if(is_file('0_STOP'))unlink(__FILE__);
	}
}
?>
PHP_CODE;
		
		file_put_contents('0_RUN', "<?php\r\nreturn ".var_export($arrRunOpt, true) . ';');
		$newFileName = ($arrRunOpt['runCount']).'.php';
		file_put_contents($newFileName, $runningCode);
		$rez = sendBaseRequest(dirname(getSelfAddres())."/$newFileName", ['RUNNING'=>'da'], true);
		header('Location: '. basename(__FILE__));
	}
} elseif(isset($_REQUEST['stop']) && $_REQUEST['stop'] === 'true'){
	file_put_contents("0_STOP", "");
	header('Location: '. basename(__FILE__));
} elseif(isset($_REQUEST['rerun']) && $_REQUEST['rerun'] === 'true'){
	if(is_file('0_STOP')){
		unlink('0_STOP');
	}
	if(is_file('0_RUN')){
		unlink('0_RUN');
	}
	header('Location: '. basename(__FILE__));
}



?>
<div>
	<div>max_execution_time: <?=ini_get('max_execution_time') ?></div>
</div>
<form action="" method="POST">
	<?php if(!is_file('0_RUN') && !is_file('0_STOP')):?>
	<?php // echo dirname(getSelfAddres()).'/sadadasd.php' ?>
	<?php // echo __FILE__ ?>
		<div>Скрипт не запущен</div>
		<label>URL<input type="text" name="scriptUrl"></label>
		<button name="run" value="true">Запустить скрипт</button>
	<?php elseif(is_file('0_RUN') && !is_file('0_STOP')): ?>
		<div>Скрипт запущен</div>
<pre>
<?php
$arrRunOpt = include('0_RUN');
echo "Выполнен: {$arrRunOpt['runCount']} раз\r\n";
echo "URL: {$arrRunOpt['scriptUrl']}\r\n";
echo "Последние данные: \r\n{$arrRunOpt['data']}\r\n";
?>
</pre>
		<button name="stop" value="true">Остановить скрипт</button>
	<?php elseif(is_file('0_STOP')): ?>
		<div>Скрипт остановлен</div>
		<button name="rerun" value="true">Сбросить скрипт</button>
	<?php endif ?>
</form>


