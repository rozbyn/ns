<?php 

require 'application/lib/Dev.php';

use application\core\Router;

$bDir = 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$basePath = rtrim(dirname($_SERVER['PHP_SELF']));

spl_autoload_register(function($class){
	$path = str_replace('\\', '/', $class . '.php');
	if (file_exists($path)) {
		require $path;
	}
});
/* spl_autoload_extensions(".php");
spl_autoload_register(); */



session_start();


$router = new Router;
$router->run();









