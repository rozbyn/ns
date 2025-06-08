<?php
// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "../vendor/autoload.php";
require_once "./src/Product.php";

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/src'],
    isDevMode: true,
);
// or if you prefer XML
// $config = ORMSetup::createXMLMetadataConfiguration(
//    paths: [__DIR__ . '/config/xml'],
//    isDevMode: true,
//);

// configuring the database connection
$connection = DriverManager::getConnection([
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'user'     => 'root',
    'password' => 'Olopol45!',
    'dbname'   => 'ns',
], $config);

// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);
