<?php

class d 
{
	
}

$wer = new d;
$key = 'test';
$wer->$key = 314;

var_dump($wer);
echo  '<br>';

class Couter
{
	private static $count = 0;
	public function __construct ()
	{
		self::$count++;
	}
	public function __destruct ()
	{
		self::$count--;
	}
	public static function getCount ()
	{
		return self::$count ;
	}
}
for ($objs = [], $i = 0; $i <6; $i++) {
	$objs[] = new Couter;
}

echo "Сейчас существует {$objs[0]->getCount()} объектов" . '<br>';
$objs[5] = null;
echo "А теперь существует {$objs[0]->getCount()} объектов" . '<br>';

class FileLogger
{
	static private $loggers = [];
	private $time;
	private function __construct ()
	{
		$this->time = microtime(true);
	}
	public static function create ($fname)
	{
		if (isset(self::$loggers[$fname])) {
			return self::$loggers[$fname];
		}
		return self::$loggers[$fname] = new FileLogger;
	}
	public function getTime ()
	{
		return $this->time;
	}
}
//$logger = @new FileLogger;
$logger1 = FileLogger::create('file.log');
sleep(1);
$logger2 = FileLogger::create('file.log');

echo "{$logger1->getTime()}, {$logger2->getTime()}" . '<br>';