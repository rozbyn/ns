<?php

use RozbynDev\Autoloader;
ini_set('display_errors', 'On');
error_reporting(E_ALL);
require_once __DIR__ . '/lib/Autoloader.php';
require_once __DIR__ . '/lib/Helper/kint.phar';
Autoloader::addBaseDir(__DIR__ . '/');
Autoloader::addBaseDir(__DIR__ . '/lib/');
Autoloader::register();
