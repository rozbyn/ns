<?php 
$dbConfigFilePath = $_SERVER['DOCUMENT_ROOT'] . '/Config/dbConfig.php';
if(!is_file($dbConfigFilePath)){
	exit('no db config');
}
$dbConfig = require_once $dbConfigFilePath;
return $dbConfig;