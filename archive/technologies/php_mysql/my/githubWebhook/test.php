<?php


'https://raw.githubusercontent.com/rozbyn/ns/master/archive/technologies/php_mysql/copied_examples/Design%20Patterns/adapter.php';


if(isset($_REQUEST['payload'])){
	$payload = json_decode($_REQUEST['payload'], true);
	file_put_contents('jopz.txt', var_export($payload, true));
	
}
