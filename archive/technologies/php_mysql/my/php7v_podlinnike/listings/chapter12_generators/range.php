<?php
echo '<pre>';
$time = -microtime(true);
// class RunningTime 
// {
	// private static $start = .0;
	// public static function start() 
	// {
		// self::$start = microtime(true);
	// }
	// public static function finish() {
		// return sprintf('%.5f', microtime(true) - self::$start);
	// }
	
// }
//$t = new RunningTime;
//$t->start();


// function olo ($size) {
	// $arr = [];
	// for ($i = 0; $i < $size; $i++) {
		// $arr[] = $i;
	// }
	// return $arr;
// }
// $range = olo(1024000);
// foreach ($range as $i) echo "$i ";
// echo '<br>';
// echo memory_get_usage() . '<br>';


// function olo1 ($size) {
	// for ($i = 0; $i < $size; $i++) {
		// yield $i;
	// }
// }
// $range2 = olo1(1024000);
// foreach ($range2 as $i) echo "$i ";

// echo '<br>';
// echo memory_get_usage() . '<br>';
for ($i = 0; $i < 1024000; $i++) {
	echo $i. ' '. PHP_EOL;
}
echo '<br>';
// echo 'memory_get_usage()' . memory_get_usage() . '<br>';
echo sprintf('%.3f', $time+microtime(true)) . '<br>';
//echo $t->finish() . 'секунд <br>';