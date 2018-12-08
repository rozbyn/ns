<?php

if(isset($_REQUEST['payload'])){
	$payload = json_decode($_REQUEST['payload'], true);
	file_put_contents('jopz.txt', var_export($_REQUEST, true));
	//dsada
}
